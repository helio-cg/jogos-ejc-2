<?php

namespace App\Filament\User\Resources\ActivityLogs\Pages;

use App\Filament\User\Resources\ActivityLogs\ActivityLogResource;
use Filament\Resources\Pages\ListRecords;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;
}
