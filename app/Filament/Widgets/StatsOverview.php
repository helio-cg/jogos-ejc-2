<?php

namespace App\Filament\Widgets;

use App\Models\Atleta;
use App\Models\Paroquia;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Icons\Heroicon;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Usuários', User::count())
                ->icon(Heroicon::OutlinedUsers)
                ->color('primary'),
            Stat::make('Paróquias Ativas', Paroquia::whereIn('id', User::where('active', true)->select('paroquia_id'))->count())
                ->icon(Heroicon::OutlinedBuildingOffice)
                ->color('warning'),
            Stat::make('Participantes', Atleta::count())
                ->icon(Heroicon::OutlinedUserGroup)
                ->color('success'),
        ];
    }
}
