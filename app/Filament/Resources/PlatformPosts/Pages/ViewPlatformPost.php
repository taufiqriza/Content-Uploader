<?php

namespace App\Filament\Resources\PlatformPosts\Pages;

use App\Filament\Resources\PlatformPosts\PlatformPostResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPlatformPost extends ViewRecord
{
    protected static string $resource = PlatformPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
