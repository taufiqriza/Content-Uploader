<?php

namespace App\Filament\Resources\PlatformPosts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PlatformPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('content_item_id')
                    ->required()
                    ->numeric(),
                TextInput::make('social_account_id')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'processing' => 'Processing',
            'published' => 'Published',
            'failed' => 'Failed',
            'cancelled' => 'Cancelled',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('external_post_id'),
                TextInput::make('external_url')
                    ->url(),
                Textarea::make('error_message')
                    ->columnSpanFull(),
                TextInput::make('attempt_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('last_attempt_at'),
                DateTimePicker::make('published_at'),
                TextInput::make('idempotency_key'),
            ]);
    }
}
