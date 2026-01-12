<?php

namespace App\Services\Connectors;

use App\Contracts\SocialPlatformConnector;
use App\Models\ContentItem;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Exception;

class TikTokConnector implements SocialPlatformConnector
{
    protected string $clientKey;
    protected string $clientSecret;
    protected string $redirectUri;

    public function __construct()
    {
        $this->clientKey = config('services.tiktok.client_key');
        $this->clientSecret = config('services.tiktok.client_secret');
        $this->redirectUri = config('services.tiktok.redirect_uri');
    }

    public function getPlatformName(): string
    {
        return 'tiktok';
    }

    public function getRequiredScopes(): array
    {
        return [
            'user.info.basic',
            'video.publish',
            'video.upload',
        ];
    }

    public function getAuthorizationUrl(string $state): string
    {
        $params = http_build_query([
            'client_key' => $this->clientKey,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => implode(',', $this->getRequiredScopes()),
            'state' => $state,
        ]);

        return 'https://www.tiktok.com/v2/auth/authorize/?' . $params;
    }

    public function handleCallback(string $code): array
    {
        $response = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
            'client_key' => $this->clientKey,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUri,
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to exchange code for tokens: ' . $response->body());
        }

        $data = $response->json();

        if (isset($data['error'])) {
            throw new Exception('TikTok OAuth error: ' . ($data['error_description'] ?? $data['error']));
        }

        return [
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'] ?? null,
            'expires_in' => $data['expires_in'] ?? 86400,
            'token_type' => 'Bearer',
            'open_id' => $data['open_id'] ?? null,
        ];
    }

    public function refreshAccessToken(SocialAccount $account): array
    {
        $response = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
            'client_key' => $this->clientKey,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $account->enc_refresh_token,
            'grant_type' => 'refresh_token',
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to refresh access token: ' . $response->body());
        }

        $data = $response->json();

        $account->update([
            'enc_access_token' => $data['access_token'],
            'enc_refresh_token' => $data['refresh_token'] ?? $account->enc_refresh_token,
            'token_expires_at' => now()->addSeconds($data['expires_in'] ?? 86400),
        ]);

        return [
            'access_token' => $data['access_token'],
            'expires_in' => $data['expires_in'] ?? 86400,
        ];
    }

    public function getUserProfile(string $accessToken): array
    {
        $response = Http::withToken($accessToken)
            ->get('https://open.tiktokapis.com/v2/user/info/', [
                'fields' => 'open_id,union_id,avatar_url,display_name',
            ]);

        if ($response->failed()) {
            throw new Exception('Failed to get TikTok profile: ' . $response->body());
        }

        $data = $response->json();

        if (isset($data['error']['code']) && $data['error']['code'] !== 'ok') {
            throw new Exception('TikTok API error: ' . ($data['error']['message'] ?? 'Unknown error'));
        }

        $user = $data['data']['user'] ?? [];

        return [
            'platform_user_id' => $user['open_id'] ?? '',
            'name' => $user['display_name'] ?? 'TikTok User',
            'avatar_url' => $user['avatar_url'] ?? null,
        ];
    }

    public function supportsContentType(string $contentType): bool
    {
        return in_array($contentType, ['reel', 'short', 'story']);
    }

    public function publish(ContentItem $content, SocialAccount $account): array
    {
        // Ensure token is fresh
        if ($account->isTokenExpired()) {
            $this->refreshAccessToken($account);
            $account->refresh();
        }

        $accessToken = $account->enc_access_token;

        // Get media file
        $filePath = $content->media_path;
        $disk = Storage::disk('r2');

        if (!$filePath || !$disk->exists($filePath)) {
            throw new Exception('Media file not found');
        }

        $fileSize = $disk->size($filePath);
        $fileContent = $disk->get($filePath);

        // Step 1: Initialize video upload
        $initResponse = Http::withToken($accessToken)
            ->post('https://open.tiktokapis.com/v2/post/publish/video/init/', [
                'post_info' => [
                    'title' => $content->title ?? '',
                    'description' => $content->caption ?? '',
                    'privacy_level' => 'PUBLIC_TO_EVERYONE',
                    'disable_duet' => false,
                    'disable_stitch' => false,
                    'disable_comment' => false,
                ],
                'source_info' => [
                    'source' => 'PULL_FROM_URL',
                    'video_url' => $disk->temporaryUrl($filePath, now()->addHour()),
                ],
            ]);

        if ($initResponse->failed()) {
            // Fallback: Try direct upload
            return $this->publishDirectUpload($accessToken, $content, $fileContent, $fileSize);
        }

        $initData = $initResponse->json();

        if (isset($initData['error']['code']) && $initData['error']['code'] !== 'ok') {
            throw new Exception('TikTok init error: ' . ($initData['error']['message'] ?? 'Unknown error'));
        }

        $publishId = $initData['data']['publish_id'] ?? null;

        if (!$publishId) {
            throw new Exception('No publish ID received from TikTok');
        }

        // Step 2: Check publish status (poll)
        $maxAttempts = 30;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            sleep(10);

            $statusResponse = Http::withToken($accessToken)
                ->post('https://open.tiktokapis.com/v2/post/publish/status/fetch/', [
                    'publish_id' => $publishId,
                ]);

            if ($statusResponse->successful()) {
                $statusData = $statusResponse->json();
                $status = $statusData['data']['status'] ?? '';

                if ($status === 'PUBLISH_COMPLETE') {
                    return [
                        'external_post_id' => $publishId,
                        'external_url' => 'https://www.tiktok.com/@' . $account->name,
                    ];
                } elseif ($status === 'FAILED') {
                    throw new Exception('TikTok publish failed: ' . ($statusData['data']['fail_reason'] ?? 'Unknown'));
                }
            }

            $attempt++;
        }

        throw new Exception('TikTok publish timed out');
    }

    protected function publishDirectUpload(string $accessToken, ContentItem $content, string $fileContent, int $fileSize): array
    {
        // Initialize chunk upload
        $initResponse = Http::withToken($accessToken)
            ->post('https://open.tiktokapis.com/v2/post/publish/inbox/video/init/', [
                'source_info' => [
                    'source' => 'FILE_UPLOAD',
                    'video_size' => $fileSize,
                    'chunk_size' => $fileSize,
                    'total_chunk_count' => 1,
                ],
            ]);

        if ($initResponse->failed()) {
            throw new Exception('Failed to initialize TikTok upload: ' . $initResponse->body());
        }

        $initData = $initResponse->json();
        $uploadUrl = $initData['data']['upload_url'] ?? null;
        $publishId = $initData['data']['publish_id'] ?? null;

        if (!$uploadUrl) {
            throw new Exception('No upload URL from TikTok');
        }

        // Upload video chunk
        $uploadResponse = Http::withHeaders([
            'Content-Type' => 'video/mp4',
            'Content-Range' => "bytes 0-" . ($fileSize - 1) . "/{$fileSize}",
        ])->withBody($fileContent, 'video/mp4')->put($uploadUrl);

        if ($uploadResponse->failed()) {
            throw new Exception('Failed to upload video to TikTok: ' . $uploadResponse->body());
        }

        return [
            'external_post_id' => $publishId,
            'external_url' => 'https://www.tiktok.com/@' . ($content->user->name ?? 'user'),
        ];
    }
}
