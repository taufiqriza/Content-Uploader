<?php

namespace App\Jobs;

use App\Models\ContentItem;
use App\Models\PlatformPost;
use App\Models\SocialAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DistributeContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public ContentItem $contentItem
    ) {}

    public function handle(): void
    {
        $contentItem = $this->contentItem;

        // Update status to publishing
        $contentItem->update(['status' => 'publishing']);

        // Get target platforms (social account IDs from JSON field)
        $targetAccountIds = $contentItem->target_platforms ?? [];

        if (empty($targetAccountIds)) {
            $contentItem->update(['status' => 'failed']);
            return;
        }

        $socialAccounts = SocialAccount::whereIn('id', $targetAccountIds)
            ->where('is_active', true)
            ->get();

        if ($socialAccounts->isEmpty()) {
            $contentItem->update(['status' => 'failed']);
            return;
        }

        // Create platform posts for each target
        foreach ($socialAccounts as $account) {
            $platformPost = PlatformPost::firstOrCreate(
                [
                    'content_item_id' => $contentItem->id,
                    'social_account_id' => $account->id,
                ],
                [
                    'status' => 'pending',
                ]
            );

            // Dispatch individual publish job
            PublishToPlatformJob::dispatch($platformPost)
                ->delay(now()->addSeconds(5)); // Slight delay between posts
        }
    }
}
