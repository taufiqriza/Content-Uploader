<?php

namespace App\Filament\Widgets;

use App\Models\ContentItem;
use App\Models\PlatformPost;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class QueueStatusWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $pendingJobs = DB::table('jobs')->count();
        $failedJobs = DB::table('failed_jobs')->count();

        $totalPosts = PlatformPost::count();
        $publishedPosts = PlatformPost::where('status', 'published')->count();
        $failedPosts = PlatformPost::where('status', 'failed')->count();
        $pendingPosts = PlatformPost::where('status', 'pending')->count();

        return [
            Stat::make('Antrian Job', $pendingJobs)
                ->description('Job menunggu diproses')
                ->descriptionIcon('heroicon-o-queue-list')
                ->color($pendingJobs > 10 ? 'warning' : 'success'),

            Stat::make('Failed Jobs', $failedJobs)
                ->description('Job gagal')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color($failedJobs > 0 ? 'danger' : 'success'),

            Stat::make('Sukses Rate', $totalPosts > 0 ? round(($publishedPosts / $totalPosts) * 100, 1) . '%' : '0%')
                ->description("{$publishedPosts} dari {$totalPosts} post")
                ->descriptionIcon('heroicon-o-check-circle')
                ->color($totalPosts > 0 && ($publishedPosts / $totalPosts) >= 0.8 ? 'success' : 'warning'),

            Stat::make('Pending Upload', $pendingPosts)
                ->description('Menunggu dikirim')
                ->descriptionIcon('heroicon-o-clock')
                ->color($pendingPosts > 0 ? 'info' : 'gray'),
        ];
    }
}
