<?php

namespace App\Filament\Resources\ContentItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use App\Models\SocialAccount;

class ContentItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('content_type')
                    ->label('Tipe Konten')
                    ->options([
                        'post' => 'Feed Post (Image)',
                        'reel' => 'Reel / Short Video',
                        'story' => 'Story (24 jam)',
                        'youtube_video' => 'YouTube Video',
                        'short' => 'YouTube Short',
                    ])
                    ->required()
                    ->default('youtube_video'),

                TextInput::make('title')
                    ->label('Judul')
                    ->placeholder('Judul video/post')
                    ->required()
                    ->maxLength(255),

                Textarea::make('caption')
                    ->label('Caption / Deskripsi')
                    ->placeholder('Tulis caption untuk postingan...')
                    ->rows(4),

                FileUpload::make('media_path')
                    ->label('Upload Media (Video/Gambar)')
                    ->disk('r2')
                    ->directory('content')
                    ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(512000)
                    ->visibility('private'),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'approved' => 'Approved',
                    ])
                    ->default('draft')
                    ->required(),

                DateTimePicker::make('scheduled_at')
                    ->label('Jadwal Posting')
                    ->helperText('Kosongkan untuk posting segera')
                    ->native(false),

                Select::make('target_platforms')
                    ->label('Platform Tujuan')
                    ->multiple()
                    ->options(function () {
                        return SocialAccount::query()
                            ->where('is_active', true)
                            ->get()
                            ->mapWithKeys(fn ($account) => [
                                $account->id => strtoupper($account->platform) . ' - ' . $account->name
                            ])
                            ->toArray();
                    })
                    ->required(),

                Hidden::make('organization_id')
                    ->default(1),

                Hidden::make('user_id')
                    ->default(fn () => auth()->id()),
            ]);
    }
}
