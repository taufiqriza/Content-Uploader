<?php

namespace App\Contracts;

use App\Models\ContentItem;
use App\Models\SocialAccount;

interface SocialPlatformConnector
{
    /**
     * Get the platform identifier (youtube, instagram, tiktok, etc.)
     */
    public function getPlatformName(): string;

    /**
     * Get the OAuth authorization URL
     */
    public function getAuthorizationUrl(string $state): string;

    /**
     * Handle OAuth callback and exchange code for tokens
     * Returns array with access_token, refresh_token, expires_in
     */
    public function handleCallback(string $code): array;

    /**
     * Refresh the access token using refresh token
     */
    public function refreshAccessToken(SocialAccount $account): array;

    /**
     * Get user profile info from the platform
     */
    public function getUserProfile(string $accessToken): array;

    /**
     * Publish content to the platform
     * Returns external post ID and URL
     */
    public function publish(ContentItem $content, SocialAccount $account): array;

    /**
     * Check if the content type is supported by this platform
     */
    public function supportsContentType(string $contentType): bool;

    /**
     * Get required OAuth scopes for this platform
     */
    public function getRequiredScopes(): array;
}
