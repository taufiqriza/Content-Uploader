<?php

namespace App\Filament\Resources\PlatformPosts\Pages;

use App\Filament\Resources\PlatformPosts\PlatformPostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlatformPost extends CreateRecord
{
    protected static string $resource = PlatformPostResource::class;
}
