<?php

namespace App\Filament\Resources\PlatformPosts\Tables;

use App\Jobs\PublishToPlatformJob;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PlatformPostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('contentItem.title')
                    ->label('Konten')
                    ->limit(30)
                    ->searchable()
                    ->default('(Tanpa Judul)'),

                TextColumn::make('socialAccount.platform')
                    ->label('Platform')
                    ->badge()
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->colors([
                        'danger' => 'youtube',
                        'pink' => 'instagram',
                        'dark' => 'tiktok',
                        'primary' => 'facebook',
                    ]),

                TextColumn::make('socialAccount.name')
                    ->label('Akun')
                    ->limit(20),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'gray' => 'pending',
                        'warning' => 'processing',
                        'success' => 'published',
                        'danger' => 'failed',
                    ]),

                TextColumn::make('attempt_count')
                    ->label('Percobaan')
                    ->alignCenter(),

                TextColumn::make('published_at')
                    ->label('Dipublish')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('error_message')
                    ->label('Error')
                    ->limit(30)
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('external_url')
                    ->label('Link')
                    ->url(fn ($record) => $record->external_url)
                    ->openUrlInNewTab()
                    ->placeholder('-')
                    ->limit(20),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'published' => 'Published',
                        'failed' => 'Failed',
                    ]),
                SelectFilter::make('platform')
                    ->relationship('socialAccount', 'platform')
                    ->label('Platform'),
            ])
            ->recordActions([
                Action::make('retry')
                    ->label('Retry')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Retry Posting')
                    ->modalDescription('Apakah Anda yakin ingin mencoba posting ulang?')
                    ->visible(fn ($record) => $record->status === 'failed' && $record->canRetry())
                    ->action(function ($record) {
                        // Reset status
                        $record->update([
                            'status' => 'pending',
                            'error_message' => null,
                        ]);

                        // Dispatch job
                        PublishToPlatformJob::dispatch($record);

                        Notification::make()
                            ->title('Retry Dijadwalkan')
                            ->body('Posting akan dicoba ulang.')
                            ->success()
                            ->send();
                    }),

                Action::make('view_post')
                    ->label('Lihat Post')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('success')
                    ->url(fn ($record) => $record->external_url)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => !empty($record->external_url)),

                ViewAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('bulk_retry')
                        ->label('Retry Selected')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $retried = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'failed' && $record->canRetry()) {
                                    $record->update([
                                        'status' => 'pending',
                                        'error_message' => null,
                                    ]);
                                    PublishToPlatformJob::dispatch($record);
                                    $retried++;
                                }
                            }

                            Notification::make()
                                ->title('Bulk Retry')
                                ->body("{$retried} post(s) dijadwalkan untuk retry.")
                                ->success()
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
