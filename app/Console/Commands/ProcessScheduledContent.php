<?php

namespace App\Console\Commands;

use App\Jobs\DistributeContentJob;
use App\Models\ContentItem;
use Illuminate\Console\Command;

class ProcessScheduledContent extends Command
{
    protected $signature = 'app:process-scheduled-content';

    protected $description = 'Process content items that are scheduled to be published';

    public function handle(): int
    {
        $now = now();

        // Find content that is scheduled and ready to publish
        $scheduledContent = ContentItem::query()
            ->whereIn('status', ['approved', 'scheduling'])
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', $now)
            ->whereNotNull('target_platforms')
            ->get();

        if ($scheduledContent->isEmpty()) {
            $this->info('No scheduled content to process.');
            return self::SUCCESS;
        }

        $this->info("Found {$scheduledContent->count()} content item(s) to process.");

        foreach ($scheduledContent as $content) {
            $this->info("Processing: {$content->title} (ID: {$content->id})");

            // Dispatch the distribute job
            DistributeContentJob::dispatch($content);

            // Update status to scheduling
            $content->update(['status' => 'scheduling']);
        }

        $this->info('All scheduled content has been queued for processing.');

        return self::SUCCESS;
    }
}
