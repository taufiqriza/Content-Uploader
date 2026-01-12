<?php

namespace App\Filament\Widgets;

use App\Models\ContentItem;
use App\Models\SocialAccount;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AccountStatusWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalAccounts = SocialAccount::count();
        $activeAccounts = SocialAccount::where('is_active', true)->count();
        $expiredTokens = SocialAccount::where('token_expires_at', '<', now())->count();

        $totalContent = ContentItem::count();
        $draftContent = ContentItem::where('status', 'draft')->count();
        $scheduledContent = ContentItem::whereNotNull('scheduled_at')
            ->where('scheduled_at', '>', now())
            ->count();

        return [
            Stat::make('Akun Terhubung', $activeAccounts)
                ->description("dari {$totalAccounts} total akun")
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Token Expired', $expiredTokens)
                ->description('Perlu refresh')
                ->descriptionIcon('heroicon-o-key')
                ->color($expiredTokens > 0 ? 'danger' : 'success'),

            Stat::make('Total Konten', $totalContent)
                ->description("{$draftContent} draft")
                ->descriptionIcon('heroicon-o-document-text')
                ->color('info'),

            Stat::make('Terjadwal', $scheduledContent)
                ->description('Menunggu waktu kirim')
                ->descriptionIcon('heroicon-o-calendar')
                ->color($scheduledContent > 0 ? 'warning' : 'gray'),
        ];
    }
}
