<?php

namespace App\Filament\Resources\ContentItems\Tables;

use App\Jobs\DistributeContentJob;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContentItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(30)
                    ->default('(Tanpa Judul)'),
                TextColumn::make('content_type')
                    ->label('Tipe')
                    ->badge()
                    ->colors([
                        'primary' => 'post',
                        'success' => 'reel',
                        'warning' => 'story',
                        'danger' => 'youtube_video',
                        'info' => 'short',
                    ]),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'warning' => 'pending_approval',
                        'info' => 'approved',
                        'primary' => 'scheduling',
                        'secondary' => 'publishing',
                        'success' => 'done',
                        'danger' => fn ($state) => in_array($state, ['failed', 'partial_fail']),
                    ]),
                TextColumn::make('user.name')
                    ->label('Pembuat')
                    ->sortable(),
                TextColumn::make('scheduled_at')
                    ->label('Dijadwalkan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->placeholder('-'),
                TextColumn::make('platformPosts_count')
                    ->label('Platform')
                    ->counts('platformPosts')
                    ->suffix(' target'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'pending_approval' => 'Pending Approval',
                        'approved' => 'Approved',
                        'publishing' => 'Publishing',
                        'done' => 'Done',
                        'failed' => 'Failed',
                    ]),
                SelectFilter::make('content_type')
                    ->options([
                        'post' => 'Post',
                        'reel' => 'Reel',
                        'story' => 'Story',
                        'youtube_video' => 'YouTube Video',
                        'short' => 'Short',
                    ]),
            ])
            ->recordActions([
                Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Publish Konten')
                    ->modalDescription('Apakah Anda yakin ingin mempublikasikan konten ini ke semua platform tujuan?')
                    ->modalSubmitActionLabel('Ya, Publish Sekarang')
                    ->visible(fn ($record) => in_array($record->status, ['draft', 'approved', 'failed']))
                    ->action(function ($record) {
                        if (empty($record->target_platforms)) {
                            Notification::make()
                                ->title('Gagal')
                                ->body('Tidak ada platform tujuan yang dipilih.')
                                ->danger()
                                ->send();
                            return;
                        }

                        DistributeContentJob::dispatch($record);

                        Notification::make()
                            ->title('Berhasil')
                            ->body('Konten sedang dikirim ke platform tujuan.')
                            ->success()
                            ->send();
                    }),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

