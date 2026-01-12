<?php

namespace App\Services;

use App\Contracts\SocialPlatformConnector;
use App\Services\Connectors\YouTubeConnector;
use App\Services\Connectors\InstagramConnector;
use App\Services\Connectors\TikTokConnector;
use App\Services\Connectors\FacebookConnector;
use InvalidArgumentException;

class ConnectorManager
{
    protected array $connectors = [];

    public function __construct()
    {
        // Register all available connectors
        $this->register('youtube', YouTubeConnector::class);
        $this->register('instagram', InstagramConnector::class);
        $this->register('tiktok', TikTokConnector::class);
        $this->register('facebook', FacebookConnector::class);
    }

    /**
     * Register a connector class for a platform
     */
    public function register(string $platform, string $connectorClass): void
    {
        $this->connectors[$platform] = $connectorClass;
    }

    /**
     * Get connector instance for a platform
     */
    public function get(string $platform): SocialPlatformConnector
    {
        if (!isset($this->connectors[$platform])) {
            throw new InvalidArgumentException("No connector registered for platform: {$platform}");
        }

        return app($this->connectors[$platform]);
    }

    /**
     * Check if a platform has a registered connector
     */
    public function has(string $platform): bool
    {
        return isset($this->connectors[$platform]);
    }

    /**
     * Get all registered platform names
     */
    public function getAvailablePlatforms(): array
    {
        return array_keys($this->connectors);
    }
}
