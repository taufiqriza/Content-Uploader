<?php

namespace App\Filament\Resources\MediaAssets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MediaAssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('organization_id')
                    ->required()
                    ->numeric(),
                Select::make('type')
                    ->options(['video' => 'Video', 'image' => 'Image', 'story' => 'Story'])
                    ->required(),
                TextInput::make('original_filename')
                    ->required(),
                TextInput::make('disk')
                    ->required()
                    ->default('r2'),
                TextInput::make('path')
                    ->required(),
                TextInput::make('mime_type'),
                TextInput::make('size_bytes')
                    ->numeric(),
                TextInput::make('metadata'),
            ]);
    }
}
