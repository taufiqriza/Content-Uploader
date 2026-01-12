<?php

namespace App\Filament\Widgets;

use App\Models\ContentItem;
use App\Models\PlatformPost;
use App\Models\SocialAccount;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Content Stats
        $totalContent = ContentItem::count();
        $publishedContent = ContentItem::where('status', 'done')->count();
        $pendingContent = ContentItem::whereIn('status', ['draft', 'approved', 'scheduling'])->count();

        // Platform Post Stats
        $totalPosts = PlatformPost::count();
        $successPosts = PlatformPost::where('status', 'published')->count();
        $failedPosts = PlatformPost::where('status', 'failed')->count();
        $successRate = $totalPosts > 0 ? round(($successPosts / $totalPosts) * 100) : 0;

        // Account Stats
        $activeAccounts = SocialAccount::where('is_active', true)->count();
        $expiredTokens = SocialAccount::where('is_active', true)
            ->whereNotNull('token_expires_at')
            ->where('token_expires_at', '<', now())
            ->count();

        return [
            Stat::make('Total Konten', $totalContent)
                ->description("{$publishedContent} published, {$pendingContent} pending")
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Success Rate', "{$successRate}%")
                ->description("{$successPosts} of {$totalPosts} posts")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color($successRate >= 80 ? 'success' : ($successRate >= 50 ? 'warning' : 'danger')),

            Stat::make('Failed Posts', $failedPosts)
                ->description($failedPosts > 0 ? 'Perlu retry' : 'Semua sukses!')
                ->descriptionIcon($failedPosts > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($failedPosts > 0 ? 'danger' : 'success'),

            Stat::make('Connected Accounts', $activeAccounts)
                ->description($expiredTokens > 0 ? "{$expiredTokens} token expired" : 'Semua aktif')
                ->descriptionIcon('heroicon-m-user-group')
                ->color($expiredTokens > 0 ? 'warning' : 'success'),
        ];
    }
}
