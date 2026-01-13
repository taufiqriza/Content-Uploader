<?php

namespace App\Filament\Resources\AuditLogs;

use App\Filament\Resources\AuditLogs\Pages\ManageAuditLogs;
use App\Models\AuditLog;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class AuditLogsResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Audit Logs';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'action';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('action')
                    ->label('Aksi'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('auditable_type')
                    ->label('Tipe Model')
                    ->formatStateUsing(fn ($state) => class_basename($state)),
                TextEntry::make('auditable_id')
                    ->label('ID Model'),
                TextEntry::make('ip_address')
                    ->label('IP Address'),
                TextEntry::make('user_agent')
                    ->label('Browser')
                    ->limit(50),
                TextEntry::make('old_values')
                    ->label('Nilai Lama')
                    ->formatStateUsing(fn ($state) => $state ? json_encode($state, JSON_PRETTY_PRINT) : '-')
                    ->columnSpanFull(),
                TextEntry::make('new_values')
                    ->label('Nilai Baru')
                    ->formatStateUsing(fn ($state) => $state ? json_encode($state, JSON_PRETTY_PRINT) : '-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i:s'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('action')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable()
                    ->placeholder('System'),

                TextColumn::make('action')
                    ->label('Aksi')
                    ->badge()
                    ->colors([
                        'success' => fn ($state) => str_contains($state, 'create') || str_contains($state, 'publish'),
                        'warning' => fn ($state) => str_contains($state, 'update') || str_contains($state, 'edit'),
                        'danger' => fn ($state) => str_contains($state, 'delete') || str_contains($state, 'fail'),
                        'info' => fn ($state) => str_contains($state, 'connect') || str_contains($state, 'login'),
                    ])
                    ->searchable(),

                TextColumn::make('auditable_type')
                    ->label('Model')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->badge()
                    ->color('gray'),

                TextColumn::make('auditable_id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('action')
                    ->options([
                        'create' => 'Create',
                        'update' => 'Update',
                        'delete' => 'Delete',
                        'publish' => 'Publish',
                        'connect' => 'Connect',
                        'login' => 'Login',
                    ]),
                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User'),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAuditLogs::route('/'),
        ];
    }
}
