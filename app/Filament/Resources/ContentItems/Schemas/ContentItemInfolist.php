<?php

namespace App\Filament\Resources\ContentItems\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Schema;

class ContentItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label('Judul')
                    ->placeholder('-'),

                TextEntry::make('content_type')
                    ->label('Tipe Konten')
                    ->badge(),

                TextEntry::make('status')
                    ->label('Status')
                    ->badge(),

                TextEntry::make('user.name')
                    ->label('Dibuat oleh')
                    ->placeholder('-'),

                TextEntry::make('caption')
                    ->label('Caption')
                    ->placeholder('-'),

                TextEntry::make('media_path')
                    ->label('File Path')
                    ->placeholder('Belum ada file'),

                TextEntry::make('scheduled_at')
                    ->label('Dijadwalkan')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('Tidak dijadwalkan'),

                TextEntry::make('published_at')
                    ->label('Dipublikasikan')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('Belum dipublikasikan'),

                TextEntry::make('target_platforms')
                    ->label('Platform Tujuan')
                    ->placeholder('Tidak ada'),

                TextEntry::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i'),

                TextEntry::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y, H:i'),
            ]);
    }
}
