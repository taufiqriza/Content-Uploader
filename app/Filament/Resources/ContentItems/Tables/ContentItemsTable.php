<?php

namespace App\Filament\Resources\ContentItems\Tables;

use App\Jobs\DistributeContentJob;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

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
                    ->formatStateUsing(fn ($state) => match($state) {
                        'post' => 'Post',
                        'reel' => 'Reel',
                        'story' => 'Story',
                        'youtube_video' => 'YouTube',
                        'short' => 'Short',
                        default => $state,
                    })
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
                    ->formatStateUsing(fn ($state) => match($state) {
                        'draft' => 'Draft',
                        'pending_approval' => 'Pending',
                        'approved' => 'Approved',
                        'scheduling' => 'Scheduling',
                        'publishing' => 'Publishing',
                        'done' => 'Done',
                        'failed' => 'Failed',
                        'partial_fail' => 'Partial',
                        default => $state,
                    })
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('scheduled_at')
                    ->label('Dijadwalkan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->placeholder('Langsung'),

                TextColumn::make('platformPosts_count')
                    ->label('Posts')
                    ->counts('platformPosts')
                    ->alignCenter(),

                TextColumn::make('published_posts')
                    ->label('Published')
                    ->state(function ($record) {
                        $published = $record->platformPosts()->where('status', 'published')->count();
                        $total = $record->platformPosts()->count();
                        return $total > 0 ? "{$published}/{$total}" : '-';
                    })
                    ->alignCenter(),

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
                    ->label('Tipe Konten')
                    ->options([
                        'post' => 'Post',
                        'reel' => 'Reel',
                        'story' => 'Story',
                        'youtube_video' => 'YouTube Video',
                        'short' => 'Short',
                    ]),
                Filter::make('has_scheduled')
                    ->label('Dijadwalkan')
                    ->query(fn (Builder $query) => $query->whereNotNull('scheduled_at')),
                Filter::make('ready_to_publish')
                    ->label('Siap Publish')
                    ->query(fn (Builder $query) => $query->whereIn('status', ['approved', 'draft'])->whereNotNull('target_platforms')),
            ])
            ->recordActions([
                Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Publish Konten')
                    ->modalDescription('Konten akan dipublikasikan ke semua platform tujuan.')
                    ->modalSubmitActionLabel('Publish Sekarang')
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

                        $record->update(['status' => 'scheduling']);
                        DistributeContentJob::dispatch($record);

                        Notification::make()
                            ->title('Berhasil')
                            ->body('Konten sedang dikirim ke platform tujuan.')
                            ->success()
                            ->send();
                    }),

                Action::make('view_posts')
                    ->label('Lihat Posts')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => route('filament.admin.resources.platform-posts.index', ['tableFilters[content_item_id][value]' => $record->id]))
                    ->visible(fn ($record) => $record->platformPosts()->exists()),

                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('bulk_publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Bulk Publish')
                        ->modalDescription('Publish semua konten yang dipilih ke platform tujuan masing-masing?')
                        ->action(function (Collection $records) {
                            $published = 0;
                            $skipped = 0;

                            foreach ($records as $record) {
                                if (empty($record->target_platforms)) {
                                    $skipped++;
                                    continue;
                                }

                                if (!in_array($record->status, ['draft', 'approved', 'failed'])) {
                                    $skipped++;
                                    continue;
                                }

                                $record->update(['status' => 'scheduling']);
                                DistributeContentJob::dispatch($record);
                                $published++;
                            }

                            Notification::make()
                                ->title('Bulk Publish')
                                ->body("{$published} konten dijadwalkan. {$skipped} dilewati.")
                                ->success()
                                ->send();
                        }),

                    BulkAction::make('bulk_approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('info')
                        ->action(function (Collection $records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'draft' || $record->status === 'pending_approval') {
                                    $record->update(['status' => 'approved']);
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title('Bulk Approve')
                                ->body("{$count} konten disetujui.")
                                ->success()
                                ->send();
                        }),

                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
