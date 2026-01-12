<?php

namespace App\Filament\Widgets;

use App\Models\PlatformPost;
use App\Jobs\PublishToPlatformJob;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Tables\Actions\Action;

class RecentFailedPostsWidget extends TableWidget
{
    protected static ?string $heading = 'Post Gagal Terbaru';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PlatformPost::query()
                    ->where('status', 'failed')
                    ->latest('updated_at')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('contentItem.title')
                    ->label('Konten')
                    ->limit(25)
                    ->default('(Tanpa Judul)'),

                TextColumn::make('socialAccount.platform')
                    ->label('Platform')
                    ->badge()
                    ->formatStateUsing(fn ($state) => strtoupper($state)),

                TextColumn::make('socialAccount.name')
                    ->label('Akun')
                    ->limit(15),

                TextColumn::make('error_message')
                    ->label('Error')
                    ->limit(40)
                    ->wrap(),

                TextColumn::make('attempt_count')
                    ->label('Attempts')
                    ->alignCenter(),

                TextColumn::make('updated_at')
                    ->label('Gagal Pada')
                    ->dateTime('d M, H:i')
                    ->sortable(),
            ])
            ->actions([
                Action::make('retry')
                    ->label('Retry')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->size('sm')
                    ->visible(fn ($record) => $record->canRetry())
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'pending',
                            'error_message' => null,
                        ]);

                        PublishToPlatformJob::dispatch($record);

                        Notification::make()
                            ->title('Retry Dijadwalkan')
                            ->success()
                            ->send();
                    }),
            ])
            ->emptyStateHeading('Tidak ada post gagal')
            ->emptyStateDescription('Semua post berhasil dipublish!')
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}
