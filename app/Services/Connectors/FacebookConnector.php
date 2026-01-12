<?php

namespace App\Services\Connectors;

use App\Contracts\SocialPlatformConnector;
use App\Models\ContentItem;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Exception;

class FacebookConnector implements SocialPlatformConnector
{
    protected string $clientId;
    protected string $clientSecret;
    protected string $redirectUri;
    protected string $graphVersion = 'v18.0';

    public function __construct()
    {
        $this->clientId = config('services.facebook.client_id');
        $this->clientSecret = config('services.facebook.client_secret');
        $this->redirectUri = config('services.facebook.redirect_uri');
    }

    public function getPlatformName(): string
    {
        return 'facebook';
    }

    public function getRequiredScopes(): array
    {
        return [
            'pages_manage_posts',
            'pages_read_engagement',
            'pages_show_list',
        ];
    }

    public function getAuthorizationUrl(string $state): string
    {
        $params = http_build_query([
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => implode(',', $this->getRequiredScopes()),
            'state' => $state,
        ]);

        return "https://www.facebook.com/{$this->graphVersion}/dialog/oauth?" . $params;
    }

    public function handleCallback(string $code): array
    {
        $response = Http::get("https://graph.facebook.com/{$this->graphVersion}/oauth/access_token", [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'code' => $code,
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to exchange code for tokens: ' . $response->body());
        }

        $data = $response->json();

        // Get long-lived token
        $longLivedResponse = Http::get("https://graph.facebook.com/{$this->graphVersion}/oauth/access_token", [
            'grant_type' => 'fb_exchange_token',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'fb_exchange_token' => $data['access_token'],
        ]);

        if ($longLivedResponse->successful()) {
            $longLivedData = $longLivedResponse->json();
            return [
                'access_token' => $longLivedData['access_token'],
                'refresh_token' => null,
                'expires_in' => $longLivedData['expires_in'] ?? 5184000,
                'token_type' => 'Bearer',
            ];
        }

        return [
            'access_token' => $data['access_token'],
            'refresh_token' => null,
            'expires_in' => $data['expires_in'] ?? 3600,
            'token_type' => 'Bearer',
        ];
    }

    public function refreshAccessToken(SocialAccount $account): array
    {
        $response = Http::get("https://graph.facebook.com/{$this->graphVersion}/oauth/access_token", [
            'grant_type' => 'fb_exchange_token',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'fb_exchange_token' => $account->enc_access_token,
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to refresh access token: ' . $response->body());
        }

        $data = $response->json();

        $account->update([
            'enc_access_token' => $data['access_token'],
            'token_expires_at' => now()->addSeconds($data['expires_in'] ?? 5184000),
        ]);

        return [
            'access_token' => $data['access_token'],
            'expires_in' => $data['expires_in'] ?? 5184000,
        ];
    }

    public function getUserProfile(string $accessToken): array
    {
        // Get Facebook Pages
        $pagesResponse = Http::get("https://graph.facebook.com/{$this->graphVersion}/me/accounts", [
            'access_token' => $accessToken,
            'fields' => 'id,name,access_token,picture',
        ]);

        if ($pagesResponse->failed()) {
            throw new Exception('Failed to get Facebook pages: ' . $pagesResponse->body());
        }

        $pages = $pagesResponse->json()['data'] ?? [];

        if (empty($pages)) {
            throw new Exception('No Facebook Pages found. You need a Facebook Page to post.');
        }

        // Use the first page (you could let user choose)
        $page = $pages[0];

        return [
            'platform_user_id' => $page['id'],
            'name' => $page['name'],
            'avatar_url' => $page['picture']['data']['url'] ?? null,
            'page_access_token' => $page['access_token'], // Store this for posting
        ];
    }

    public function supportsContentType(string $contentType): bool
    {
        return in_array($contentType, ['post', 'reel', 'youtube_video']);
    }

    public function publish(ContentItem $content, SocialAccount $account): array
    {
        $pageId = $account->platform_user_id;
        $accessToken = $account->enc_access_token;

        // Get media file
        $filePath = $content->media_path;
        $disk = Storage::disk('r2');

        $isVideo = false;
        $mediaUrl = null;

        if ($filePath && $disk->exists($filePath)) {
            $mediaUrl = $disk->temporaryUrl($filePath, now()->addHour());
            $isVideo = str_contains($disk->mimeType($filePath) ?? '', 'video');
        }

        if ($isVideo) {
            return $this->publishVideo($pageId, $accessToken, $mediaUrl, $content);
        } elseif ($mediaUrl) {
            return $this->publishPhoto($pageId, $accessToken, $mediaUrl, $content);
        } else {
            return $this->publishText($pageId, $accessToken, $content);
        }
    }

    protected function publishText(string $pageId, string $accessToken, ContentItem $content): array
    {
        $response = Http::post("https://graph.facebook.com/{$this->graphVersion}/{$pageId}/feed", [
            'access_token' => $accessToken,
            'message' => $content->caption ?? $content->title ?? '',
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to post to Facebook: ' . $response->body());
        }

        $postId = $response->json()['id'];

        return [
            'external_post_id' => $postId,
            'external_url' => "https://www.facebook.com/{$postId}",
        ];
    }

    protected function publishPhoto(string $pageId, string $accessToken, string $photoUrl, ContentItem $content): array
    {
        $response = Http::post("https://graph.facebook.com/{$this->graphVersion}/{$pageId}/photos", [
            'access_token' => $accessToken,
            'url' => $photoUrl,
            'caption' => $content->caption ?? '',
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to post photo to Facebook: ' . $response->body());
        }

        $postId = $response->json()['post_id'] ?? $response->json()['id'];

        return [
            'external_post_id' => $postId,
            'external_url' => "https://www.facebook.com/{$postId}",
        ];
    }

    protected function publishVideo(string $pageId, string $accessToken, string $videoUrl, ContentItem $content): array
    {
        $response = Http::post("https://graph.facebook.com/{$this->graphVersion}/{$pageId}/videos", [
            'access_token' => $accessToken,
            'file_url' => $videoUrl,
            'title' => $content->title ?? '',
            'description' => $content->caption ?? '',
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to post video to Facebook: ' . $response->body());
        }

        $videoId = $response->json()['id'];

        return [
            'external_post_id' => $videoId,
            'external_url' => "https://www.facebook.com/{$videoId}",
        ];
    }
}
