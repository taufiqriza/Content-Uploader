<?php

namespace App\Services\Connectors;

use App\Contracts\SocialPlatformConnector;
use App\Models\ContentItem;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Exception;

class YouTubeConnector implements SocialPlatformConnector
{
    protected string $clientId;
    protected string $clientSecret;
    protected string $redirectUri;

    public function __construct()
    {
        $this->clientId = config('services.youtube.client_id');
        $this->clientSecret = config('services.youtube.client_secret');
        $this->redirectUri = config('services.youtube.redirect_uri');
    }

    public function getPlatformName(): string
    {
        return 'youtube';
    }

    public function getRequiredScopes(): array
    {
        return [
            'https://www.googleapis.com/auth/youtube.upload',
            'https://www.googleapis.com/auth/youtube.readonly',
            'https://www.googleapis.com/auth/userinfo.profile',
        ];
    }

    public function getAuthorizationUrl(string $state): string
    {
        $params = http_build_query([
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => implode(' ', $this->getRequiredScopes()),
            'access_type' => 'offline',
            'prompt' => 'consent',
            'state' => $state,
        ]);

        return 'https://accounts.google.com/o/oauth2/v2/auth?' . $params;
    }

    public function handleCallback(string $code): array
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code',
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to exchange code for tokens: ' . $response->body());
        }

        $data = $response->json();

        return [
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'] ?? null,
            'expires_in' => $data['expires_in'],
            'token_type' => $data['token_type'],
        ];
    }

    public function refreshAccessToken(SocialAccount $account): array
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $account->enc_refresh_token,
            'grant_type' => 'refresh_token',
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to refresh access token: ' . $response->body());
        }

        $data = $response->json();

        // Update the account with new token
        $account->update([
            'enc_access_token' => $data['access_token'],
            'token_expires_at' => now()->addSeconds($data['expires_in']),
        ]);

        return [
            'access_token' => $data['access_token'],
            'expires_in' => $data['expires_in'],
        ];
    }

    public function getUserProfile(string $accessToken): array
    {
        // Get YouTube channel info
        $response = Http::withToken($accessToken)
            ->get('https://www.googleapis.com/youtube/v3/channels', [
                'part' => 'snippet',
                'mine' => 'true',
            ]);

        if ($response->failed()) {
            throw new Exception('Failed to get YouTube profile: ' . $response->body());
        }

        $data = $response->json();
        $channel = $data['items'][0] ?? null;

        if (!$channel) {
            throw new Exception('No YouTube channel found for this account');
        }

        return [
            'platform_user_id' => $channel['id'],
            'name' => $channel['snippet']['title'],
            'avatar_url' => $channel['snippet']['thumbnails']['default']['url'] ?? null,
        ];
    }

    public function supportsContentType(string $contentType): bool
    {
        return in_array($contentType, ['youtube_video', 'short', 'reel']);
    }

    public function publish(ContentItem $content, SocialAccount $account): array
    {
        // Ensure token is fresh
        if ($account->isTokenExpired()) {
            $this->refreshAccessToken($account);
            $account->refresh();
        }

        $accessToken = $account->enc_access_token;

        // Check for media - support both media_path and mediaAsset
        $filePath = $content->media_path;
        $disk = Storage::disk('r2');

        if (!$filePath) {
            // Fallback to mediaAsset relation
            if ($content->mediaAsset) {
                $filePath = $content->mediaAsset->path;
                $disk = Storage::disk($content->mediaAsset->disk);
            } else {
                throw new Exception('No media file attached to content. Please upload a video file.');
            }
        }

        if (!$disk->exists($filePath)) {
            throw new Exception('Media file not found in storage: ' . $filePath);
        }

        // Get file info
        $fileSize = $disk->size($filePath);
        $mimeType = $disk->mimeType($filePath) ?: 'video/mp4';

        // Prepare video metadata
        $videoMetadata = [
            'snippet' => [
                'title' => $content->title ?? 'Untitled Video',
                'description' => $content->caption ?? '',
                'categoryId' => '22', // People & Blogs
            ],
            'status' => [
                'privacyStatus' => 'public',
                'selfDeclaredMadeForKids' => false,
            ],
        ];

        // For Shorts, add #Shorts to description
        if ($content->content_type === 'short') {
            $videoMetadata['snippet']['description'] .= "\n\n#Shorts";
        }

        // Step 1: Initialize resumable upload
        $initResponse = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'X-Upload-Content-Type' => $mimeType,
                'X-Upload-Content-Length' => $fileSize,
            ])
            ->post('https://www.googleapis.com/upload/youtube/v3/videos?uploadType=resumable&part=snippet,status', $videoMetadata);

        if ($initResponse->failed()) {
            throw new Exception('Failed to initialize YouTube upload: ' . $initResponse->body());
        }

        $uploadUrl = $initResponse->header('Location');

        if (!$uploadUrl) {
            throw new Exception('No upload URL received from YouTube');
        }

        // Step 2: Upload the video file
        $fileContent = $disk->get($filePath);

        $uploadResponse = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => $mimeType,
                'Content-Length' => $fileSize,
            ])
            ->withBody($fileContent, $mimeType)
            ->put($uploadUrl);

        if ($uploadResponse->failed()) {
            throw new Exception('Failed to upload video to YouTube: ' . $uploadResponse->body());
        }

        $videoData = $uploadResponse->json();

        return [
            'external_post_id' => $videoData['id'],
            'external_url' => 'https://www.youtube.com/watch?v=' . $videoData['id'],
        ];
    }
}
