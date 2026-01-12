<?php

namespace App\Filament\Pages;

use BackedEnum;
use UnitEnum;
use Filament\Pages\Page;

class ConnectAccount extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-plus-circle';

    protected static string|UnitEnum|null $navigationGroup = 'Platform';

    protected static ?string $navigationLabel = 'Hubungkan Akun';

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'Hubungkan Akun Sosial';

    public function getView(): string
    {
        return 'filament.pages.connect-account';
    }

    public array $platforms = [
        [
            'name' => 'YouTube',
            'slug' => 'youtube',
            'icon' => 'https://www.youtube.com/favicon.ico',
            'description' => 'Upload video dan shorts ke YouTube',
            'available' => true,
        ],
        [
            'name' => 'Instagram',
            'slug' => 'instagram',
            'icon' => 'https://www.instagram.com/favicon.ico',
            'description' => 'Post foto, reels, dan story ke Instagram (Butuh Facebook Page)',
            'available' => true,
        ],
        [
            'name' => 'TikTok',
            'slug' => 'tiktok',
            'icon' => 'https://www.tiktok.com/favicon.ico',
            'description' => 'Upload video ke TikTok',
            'available' => true,
        ],
        [
            'name' => 'Facebook',
            'slug' => 'facebook',
            'icon' => 'https://www.facebook.com/favicon.ico',
            'description' => 'Post ke Facebook Page',
            'available' => true,
        ],
    ];

    public function connectPlatform(string $platform): void
    {
        $this->redirect(route('social.redirect', ['platform' => $platform]));
    }
}
