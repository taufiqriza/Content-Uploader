<?php

namespace App\Services\Connectors;

use App\Contracts\SocialPlatformConnector;
use App\Models\ContentItem;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Exception;

class InstagramConnector implements SocialPlatformConnector
{
    protected ?string $clientId;
    protected ?string $clientSecret;
    protected ?string $redirectUri;
    protected string $graphVersion = 'v18.0';

    public function __construct()
    {
        $this->clientId = config('services.instagram.client_id');
        $this->clientSecret = config('services.instagram.client_secret');
        $this->redirectUri = config('services.instagram.redirect_uri');
    }

    protected function ensureConfigured(): void
    {
        if (empty($this->clientId) || empty($this->clientSecret)) {
            throw new Exception('Instagram API not configured. Please set INSTAGRAM_CLIENT_ID and INSTAGRAM_CLIENT_SECRET in your .env file.');
        }
    }

    public function getPlatformName(): string
    {
        return 'instagram';
    }

    public function getRequiredScopes(): array
    {
        return [
            'instagram_basic',
            'instagram_content_publish',
            'pages_read_engagement',
        ];
    }

    public function getAuthorizationUrl(string $state): string
    {
        $this->ensureConfigured();
        
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
        // Exchange code for access token
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
                'refresh_token' => null, // Facebook uses long-lived tokens
                'expires_in' => $longLivedData['expires_in'] ?? 5184000, // ~60 days
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
        // Facebook long-lived tokens can be refreshed
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
        // Get Instagram Business Account ID through Facebook Pages
        $pagesResponse = Http::get("https://graph.facebook.com/{$this->graphVersion}/me/accounts", [
            'access_token' => $accessToken,
            'fields' => 'id,name,instagram_business_account',
        ]);

        if ($pagesResponse->failed()) {
            throw new Exception('Failed to get Facebook pages: ' . $pagesResponse->body());
        }

        $pages = $pagesResponse->json()['data'] ?? [];
        
        foreach ($pages as $page) {
            if (isset($page['instagram_business_account'])) {
                $igAccountId = $page['instagram_business_account']['id'];
                
                // Get Instagram account details
                $igResponse = Http::get("https://graph.facebook.com/{$this->graphVersion}/{$igAccountId}", [
                    'access_token' => $accessToken,
                    'fields' => 'id,username,profile_picture_url',
                ]);

                if ($igResponse->successful()) {
                    $igData = $igResponse->json();
                    return [
                        'platform_user_id' => $igData['id'],
                        'name' => '@' . ($igData['username'] ?? 'instagram'),
                        'avatar_url' => $igData['profile_picture_url'] ?? null,
                    ];
                }
            }
        }

        throw new Exception('No Instagram Business Account found. Make sure your Instagram is connected to a Facebook Page.');
    }

    public function supportsContentType(string $contentType): bool
    {
        return in_array($contentType, ['post', 'reel', 'story']);
    }

    public function publish(ContentItem $content, SocialAccount $account): array
    {
        $accessToken = $account->enc_access_token;
        $igAccountId = $account->platform_user_id;

        // Get media file
        $filePath = $content->media_path;
        $disk = Storage::disk('r2');

        if (!$filePath || !$disk->exists($filePath)) {
            throw new Exception('Media file not found');
        }

        // Get temporary public URL for Instagram to fetch
        $mediaUrl = $disk->temporaryUrl($filePath, now()->addHour());
        $isVideo = str_contains($disk->mimeType($filePath) ?? '', 'video');

        if ($content->content_type === 'reel' || $isVideo) {
            return $this->publishReel($igAccountId, $accessToken, $mediaUrl, $content->caption);
        } else {
            return $this->publishImage($igAccountId, $accessToken, $mediaUrl, $content->caption);
        }
    }

    protected function publishImage(string $igAccountId, string $accessToken, string $imageUrl, ?string $caption): array
    {
        // Step 1: Create media container
        $containerResponse = Http::post("https://graph.facebook.com/{$this->graphVersion}/{$igAccountId}/media", [
            'access_token' => $accessToken,
            'image_url' => $imageUrl,
            'caption' => $caption ?? '',
        ]);

        if ($containerResponse->failed()) {
            throw new Exception('Failed to create media container: ' . $containerResponse->body());
        }

        $containerId = $containerResponse->json()['id'];

        // Step 2: Publish the container
        $publishResponse = Http::post("https://graph.facebook.com/{$this->graphVersion}/{$igAccountId}/media_publish", [
            'access_token' => $accessToken,
            'creation_id' => $containerId,
        ]);

        if ($publishResponse->failed()) {
            throw new Exception('Failed to publish media: ' . $publishResponse->body());
        }

        $mediaId = $publishResponse->json()['id'];

        return [
            'external_post_id' => $mediaId,
            'external_url' => "https://www.instagram.com/p/{$mediaId}/",
        ];
    }

    protected function publishReel(string $igAccountId, string $accessToken, string $videoUrl, ?string $caption): array
    {
        // Step 1: Create video container
        $containerResponse = Http::post("https://graph.facebook.com/{$this->graphVersion}/{$igAccountId}/media", [
            'access_token' => $accessToken,
            'video_url' => $videoUrl,
            'caption' => $caption ?? '',
            'media_type' => 'REELS',
        ]);

        if ($containerResponse->failed()) {
            throw new Exception('Failed to create reel container: ' . $containerResponse->body());
        }

        $containerId = $containerResponse->json()['id'];

        // Step 2: Wait for video processing (poll status)
        $maxAttempts = 30;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            sleep(10); // Wait 10 seconds between checks

            $statusResponse = Http::get("https://graph.facebook.com/{$this->graphVersion}/{$containerId}", [
                'access_token' => $accessToken,
                'fields' => 'status_code',
            ]);

            if ($statusResponse->successful()) {
                $status = $statusResponse->json()['status_code'] ?? '';

                if ($status === 'FINISHED') {
                    break;
                } elseif ($status === 'ERROR') {
                    throw new Exception('Video processing failed');
                }
            }

            $attempt++;
        }

        if ($attempt >= $maxAttempts) {
            throw new Exception('Video processing timed out');
        }

        // Step 3: Publish the container
        $publishResponse = Http::post("https://graph.facebook.com/{$this->graphVersion}/{$igAccountId}/media_publish", [
            'access_token' => $accessToken,
            'creation_id' => $containerId,
        ]);

        if ($publishResponse->failed()) {
            throw new Exception('Failed to publish reel: ' . $publishResponse->body());
        }

        $mediaId = $publishResponse->json()['id'];

        return [
            'external_post_id' => $mediaId,
            'external_url' => "https://www.instagram.com/reel/{$mediaId}/",
        ];
    }
}
