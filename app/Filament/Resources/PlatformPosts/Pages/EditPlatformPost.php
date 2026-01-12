<?php

namespace App\Filament\Resources\PlatformPosts\Pages;

use App\Filament\Resources\PlatformPosts\PlatformPostResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPlatformPost extends EditRecord
{
    protected static string $resource = PlatformPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
