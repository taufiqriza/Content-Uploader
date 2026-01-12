<?php

namespace App\Filament\Resources\MediaAssets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MediaAssetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('organization_id')
                    ->numeric(),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('original_filename'),
                TextEntry::make('disk'),
                TextEntry::make('path'),
                TextEntry::make('mime_type')
                    ->placeholder('-'),
                TextEntry::make('size_bytes')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
