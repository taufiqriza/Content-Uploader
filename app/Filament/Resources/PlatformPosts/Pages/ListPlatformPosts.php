<?php

namespace App\Filament\Resources\PlatformPosts\Pages;

use App\Filament\Resources\PlatformPosts\PlatformPostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlatformPosts extends ListRecords
{
    protected static string $resource = PlatformPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
