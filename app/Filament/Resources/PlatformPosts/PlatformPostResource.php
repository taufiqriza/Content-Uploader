<?php

namespace App\Filament\Resources\PlatformPosts;

use App\Filament\Resources\PlatformPosts\Pages\CreatePlatformPost;
use App\Filament\Resources\PlatformPosts\Pages\EditPlatformPost;
use App\Filament\Resources\PlatformPosts\Pages\ListPlatformPosts;
use App\Filament\Resources\PlatformPosts\Pages\ViewPlatformPost;
use App\Filament\Resources\PlatformPosts\Schemas\PlatformPostForm;
use App\Filament\Resources\PlatformPosts\Schemas\PlatformPostInfolist;
use App\Filament\Resources\PlatformPosts\Tables\PlatformPostsTable;
use App\Models\PlatformPost;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PlatformPostResource extends Resource
{
    protected static ?string $model = PlatformPost::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-paper-airplane';

    protected static string|UnitEnum|null $navigationGroup = 'Platform';

    protected static ?string $navigationLabel = 'Status Posting';

    protected static ?string $modelLabel = 'Platform Post';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PlatformPostForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PlatformPostInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlatformPostsTable::configure($table);
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
            'index' => ListPlatformPosts::route('/'),
            'create' => CreatePlatformPost::route('/create'),
            'view' => ViewPlatformPost::route('/{record}'),
            'edit' => EditPlatformPost::route('/{record}/edit'),
        ];
    }
}
