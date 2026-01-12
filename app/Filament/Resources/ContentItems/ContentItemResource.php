<?php

namespace App\Filament\Resources\ContentItems;

use App\Filament\Resources\ContentItems\Pages\CreateContentItem;
use App\Filament\Resources\ContentItems\Pages\EditContentItem;
use App\Filament\Resources\ContentItems\Pages\ListContentItems;
use App\Filament\Resources\ContentItems\Pages\ViewContentItem;
use App\Filament\Resources\ContentItems\Schemas\ContentItemForm;
use App\Filament\Resources\ContentItems\Schemas\ContentItemInfolist;
use App\Filament\Resources\ContentItems\Tables\ContentItemsTable;
use App\Models\ContentItem;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContentItemResource extends Resource
{
    protected static ?string $model = ContentItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCloudArrowUp;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Upload Konten';

    protected static ?string $modelLabel = 'Konten';

    protected static ?string $pluralModelLabel = 'Konten';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ContentItemForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContentItemInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentItemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContentItems::route('/'),
            'create' => CreateContentItem::route('/create'),
            'view' => ViewContentItem::route('/{record}'),
            'edit' => EditContentItem::route('/{record}/edit'),
        ];
    }
}
