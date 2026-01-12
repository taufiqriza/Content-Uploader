<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            Platform Tersedia
        </x-slot>
        <x-slot name="description">
            Hubungkan akun sosial media Anda untuk mulai upload konten
        </x-slot>

        <div class="grid gap-4 md:grid-cols-2">
            @foreach($platforms as $platform)
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <img src="{{ $platform['icon'] }}" alt="{{ $platform['name'] }}" class="w-5 h-5">
                            <span>{{ $platform['name'] }}</span>
                        </div>
                    </x-slot>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        {{ $platform['description'] }}
                    </p>
                    @if($platform['available'])
                        <x-filament::button
                            wire:click="connectPlatform('{{ $platform['slug'] }}')"
                            icon="heroicon-o-link"
                        >
                            Hubungkan {{ $platform['name'] }}
                        </x-filament::button>
                    @else
                        <x-filament::button
                            disabled
                            color="gray"
                        >
                            Segera Tersedia
                        </x-filament::button>
                    @endif
                </x-filament::section>
            @endforeach
        </div>
    </x-filament::section>

    <x-filament::section class="mt-6">
        <x-slot name="heading">
            Akun Terhubung
        </x-slot>

        @php
            $connectedAccounts = \App\Models\SocialAccount::where('is_active', true)->get();
        @endphp

        @if($connectedAccounts->isEmpty())
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Belum ada akun yang terhubung.
            </p>
        @else
            <div class="space-y-3">
                @foreach($connectedAccounts as $account)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <div class="flex items-center gap-3">
                            @if($account->avatar_url)
                                <img src="{{ $account->avatar_url }}" alt="{{ $account->name }}" class="w-10 h-10 rounded-full">
                            @else
                                <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <x-heroicon-o-user class="w-5 h-5 text-gray-400" />
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $account->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($account->platform) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($account->token_expires_at && $account->token_expires_at->isPast())
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-700 dark:bg-red-900/20 dark:text-red-400 rounded-full">
                                    Token Expired
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400 rounded-full">
                                    Aktif
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-filament::section>

    <x-filament::section class="mt-6">
        <x-slot name="heading">
            Panduan Setup
        </x-slot>

        <div class="prose dark:prose-invert max-w-none text-sm">
            <h4>YouTube</h4>
            <p>Buka <a href="https://console.cloud.google.com" target="_blank">Google Cloud Console</a>, aktifkan YouTube Data API v3, dan buat OAuth credentials.</p>
            
            <h4>Instagram & Facebook</h4>
            <p>Buka <a href="https://developers.facebook.com" target="_blank">Meta for Developers</a>, buat App, dan aktifkan Instagram Graph API. Instagram harus terhubung ke Facebook Page.</p>
            
            <h4>TikTok</h4>
            <p>Buka <a href="https://developers.tiktok.com" target="_blank">TikTok for Developers</a>, buat App dengan Content Posting API access.</p>
        </div>
    </x-filament::section>
</x-filament-panels::page>
