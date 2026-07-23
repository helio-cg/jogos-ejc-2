<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestAtletas;
use App\Filament\Widgets\Paroquia;
use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 3;
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Bem-vindo ao Painel')
                    ->description('Gerencie os participantes, paróquias e usuários do III Jogos EJC.')
                    ->icon('heroicon-o-home'),
            ]);
    }

    protected function getFooterWidgets(): array
    {
        return [
            Paroquia::class,
            LatestAtletas::class,
        ];
    }

    public function getFooterWidgetsColumns(): int | array
    {
        return 1;
    }
}
