<?php

namespace App\Filament\Resources\SocialAccounts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SocialAccountInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('organization_id')
                    ->numeric(),
                TextEntry::make('platform')
                    ->badge(),
                TextEntry::make('platform_user_id')
                    ->placeholder('-'),
                TextEntry::make('name'),
                TextEntry::make('avatar_url')
                    ->placeholder('-'),
                TextEntry::make('token_expires_at')
                    ->dateTime()
                    ->placeholder('-'),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
