<?php

namespace App\Console\Commands;

use App\Models\SocialAccount;
use App\Services\ConnectorManager;
use Illuminate\Console\Command;
use Exception;

class RefreshExpiringTokens extends Command
{
    protected $signature = 'app:refresh-expiring-tokens';

    protected $description = 'Refresh OAuth tokens that are expiring soon';

    public function handle(ConnectorManager $connectorManager): int
    {
        // Find tokens expiring in the next 24 hours
        $expiringAccounts = SocialAccount::query()
            ->where('is_active', true)
            ->whereNotNull('token_expires_at')
            ->where('token_expires_at', '<=', now()->addDay())
            ->whereNotNull('enc_refresh_token')
            ->get();

        if ($expiringAccounts->isEmpty()) {
            $this->info('No tokens need refreshing.');
            return self::SUCCESS;
        }

        $this->info("Found {$expiringAccounts->count()} token(s) to refresh.");

        foreach ($expiringAccounts as $account) {
            try {
                $this->info("Refreshing token for: {$account->platform} - {$account->name}");

                $connector = $connectorManager->get($account->platform);
                $connector->refreshAccessToken($account);

                $this->info("  ✓ Token refreshed successfully");
            } catch (Exception $e) {
                $this->error("  ✗ Failed to refresh: {$e->getMessage()}");

                // Mark account as needing re-authentication if refresh fails
                $account->update(['is_active' => false]);
            }
        }

        return self::SUCCESS;
    }
}
