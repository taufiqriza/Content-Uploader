<?php

namespace App\Jobs;

use App\Models\ContentItem;
use App\Models\PlatformPost;
use App\Models\SocialAccount;
use App\Services\ConnectorManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Exception;

class PublishToPlatformJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60; // Wait 60 seconds before retry
    public int $timeout = 300; // 5 minutes max

    public function __construct(
        public PlatformPost $platformPost
    ) {}

    public function handle(ConnectorManager $connectorManager): void
    {
        $platformPost = $this->platformPost;
        $contentItem = $platformPost->contentItem;
        $socialAccount = $platformPost->socialAccount;

        // Acquire lock to prevent duplicate processing
        $lockKey = 'publishing_' . $platformPost->id;
        $lock = Cache::lock($lockKey, 300);

        if (!$lock->get()) {
            // Another process is handling this
            return;
        }

        try {
            // Check if already published (idempotency)
            if ($platformPost->external_post_id) {
                $platformPost->update(['status' => 'published']);
                return;
            }

            // Mark as processing
            $platformPost->markAsProcessing();

            // Get the connector for this platform
            $connector = $connectorManager->get($socialAccount->platform);

            // Check if content type is supported
            if (!$connector->supportsContentType($contentItem->content_type)) {
                throw new Exception("Content type '{$contentItem->content_type}' is not supported by {$socialAccount->platform}");
            }

            // Publish to platform
            $result = $connector->publish($contentItem, $socialAccount);

            // Mark as published
            $platformPost->markAsPublished(
                $result['external_post_id'],
                $result['external_url']
            );

            // Update content item status if all posts are done
            $this->updateContentItemStatus($contentItem);

        } catch (Exception $e) {
            $platformPost->markAsFailed($e->getMessage());

            // If max retries reached, update content item status
            if ($this->attempts() >= $this->tries) {
                $this->updateContentItemStatus($contentItem);
            }

            throw $e; // Re-throw to trigger retry
        } finally {
            $lock->release();
        }
    }

    protected function updateContentItemStatus(ContentItem $contentItem): void
    {
        $allPosts = $contentItem->platformPosts;
        $publishedCount = $allPosts->where('status', 'published')->count();
        $failedCount = $allPosts->where('status', 'failed')->count();
        $totalCount = $allPosts->count();

        if ($publishedCount === $totalCount) {
            $contentItem->update([
                'status' => 'done',
                'published_at' => now(),
            ]);
        } elseif ($failedCount === $totalCount) {
            $contentItem->update(['status' => 'failed']);
        } elseif ($publishedCount > 0 && ($publishedCount + $failedCount) === $totalCount) {
            $contentItem->update([
                'status' => 'partial_fail',
                'published_at' => now(),
            ]);
        }
    }

    public function failed(Exception $exception): void
    {
        // Log the final failure
        $this->platformPost->update([
            'status' => 'failed',
            'error_message' => 'Max retries exceeded: ' . $exception->getMessage(),
        ]);
    }
}
