<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Services\ConnectorManager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class SocialAuthController extends Controller
{
    protected ConnectorManager $connectorManager;

    public function __construct(ConnectorManager $connectorManager)
    {
        $this->connectorManager = $connectorManager;
    }

    /**
     * Redirect to platform's OAuth authorization page
     */
    public function redirect(Request $request, string $platform)
    {
        if (!$this->connectorManager->has($platform)) {
            return redirect()->back()->with('error', "Platform '{$platform}' is not supported.");
        }

        $connector = $this->connectorManager->get($platform);

        // Generate state token for CSRF protection
        $state = Str::random(40);
        session(['oauth_state' => $state, 'oauth_platform' => $platform]);

        $authUrl = $connector->getAuthorizationUrl($state);

        return redirect($authUrl);
    }

    /**
     * Handle OAuth callback from platform
     */
    public function callback(Request $request, string $platform)
    {
        // Verify state token
        if ($request->state !== session('oauth_state')) {
            return redirect()->route('filament.admin.resources.social-accounts.index')
                ->with('error', 'Invalid OAuth state. Please try again.');
        }

        if ($request->has('error')) {
            return redirect()->route('filament.admin.resources.social-accounts.index')
                ->with('error', 'Authorization was denied: ' . $request->error_description);
        }

        if (!$this->connectorManager->has($platform)) {
            return redirect()->route('filament.admin.resources.social-accounts.index')
                ->with('error', "Platform '{$platform}' is not supported.");
        }

        try {
            $connector = $this->connectorManager->get($platform);

            // Exchange code for tokens
            $tokens = $connector->handleCallback($request->code);

            // Get user profile from platform
            $profile = $connector->getUserProfile($tokens['access_token']);

            // Create or update social account
            $user = auth()->user();

            $socialAccount = SocialAccount::updateOrCreate(
                [
                    'organization_id' => $user->organization_id ?? 1,
                    'platform' => $platform,
                    'platform_user_id' => $profile['platform_user_id'],
                ],
                [
                    'name' => $profile['name'],
                    'avatar_url' => $profile['avatar_url'],
                    'enc_access_token' => $tokens['access_token'],
                    'enc_refresh_token' => $tokens['refresh_token'],
                    'token_expires_at' => now()->addSeconds($tokens['expires_in']),
                    'scopes' => $connector->getRequiredScopes(),
                    'is_active' => true,
                ]
            );

            // Clear session
            session()->forget(['oauth_state', 'oauth_platform']);

            return redirect()->route('filament.admin.resources.social-accounts.index')
                ->with('success', "Successfully connected {$platform} account: {$profile['name']}");

        } catch (Exception $e) {
            return redirect()->route('filament.admin.resources.social-accounts.index')
                ->with('error', 'Failed to connect account: ' . $e->getMessage());
        }
    }

    /**
     * Disconnect/revoke a social account
     */
    public function disconnect(SocialAccount $account)
    {
        $account->update(['is_active' => false]);

        return redirect()->back()
            ->with('success', "Disconnected {$account->platform} account: {$account->name}");
    }
}
