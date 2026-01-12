<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            Platform Tersedia
        </x-slot>
        <x-slot name="description">
            Hubungkan akun sosial media Anda untuk mulai upload konten
        </x-slot>

        <div class="grid gap-4 md:grid-cols-2">
            {{-- YouTube --}}
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <span>YouTube</span>
                    </div>
                </x-slot>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Upload video dan shorts ke YouTube
                </p>
                <x-filament::button
                    wire:click="connectPlatform('youtube')"
                    icon="heroicon-o-link"
                >
                    Hubungkan YouTube
                </x-filament::button>
            </x-filament::section>

            {{-- Instagram --}}
            <x-filament::section>
                <x-slot name="heading">
                    Instagram
                </x-slot>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Post foto, reels, dan story ke Instagram
                </p>
                <x-filament::button
                    disabled
                    color="gray"
                >
                    Segera Tersedia
                </x-filament::button>
            </x-filament::section>

            {{-- TikTok --}}
            <x-filament::section>
                <x-slot name="heading">
                    TikTok
                </x-slot>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Upload video ke TikTok
                </p>
                <x-filament::button
                    disabled
                    color="gray"
                >
                    Segera Tersedia
                </x-filament::button>
            </x-filament::section>

            {{-- Facebook --}}
            <x-filament::section>
                <x-slot name="heading">
                    Facebook
                </x-slot>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Post ke Facebook Page
                </p>
                <x-filament::button
                    disabled
                    color="gray"
                >
                    Segera Tersedia
                </x-filament::button>
            </x-filament::section>
        </div>
    </x-filament::section>

    <x-filament::section class="mt-6">
        <x-slot name="heading">
            Catatan Pengaturan
        </x-slot>

        <p class="text-sm text-gray-600 dark:text-gray-400">
            Untuk menghubungkan akun YouTube, Anda perlu mengonfigurasi Google Cloud Console terlebih dahulu.
            Pastikan sudah mengaktifkan YouTube Data API v3 dan mengatur OAuth consent screen dengan test user.
        </p>
    </x-filament::section>
</x-filament-panels::page>
