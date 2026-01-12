<?php

namespace App\Filament\Resources\SocialAccounts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SocialAccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('organization_id')
                    ->required()
                    ->numeric(),
                Select::make('platform')
                    ->options([
            'youtube' => 'Youtube',
            'tiktok' => 'Tiktok',
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
            'threads' => 'Threads',
        ])
                    ->required(),
                TextInput::make('platform_user_id'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('avatar_url')
                    ->url(),
                DateTimePicker::make('token_expires_at'),
                TextInput::make('scopes'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
