<?php

namespace App\Filament\Widgets;

use App\Models\Atleta;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Icons\Heroicon;

class StatsFinanceiro extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $total = Atleta::count();
        $pagos = Atleta::where('pagamento', true)->count();
        $pendentes = Atleta::where('pagamento', false)->count();
        $valorTotal = $total * 10;

        return [
            Stat::make('Total de Atletas', $total)
                ->icon(Heroicon::OutlinedUserGroup)
                ->color('info'),
            Stat::make('Pagamentos Confirmados', $pagos)
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success'),
            Stat::make('Pagamentos Pendentes', $pendentes)
                ->icon(Heroicon::OutlinedClock)
                ->color('danger'),
            Stat::make('Valor Total (R$ 10 / atleta)', 'R$ ' . number_format($valorTotal, 2, ',', '.'))
                ->icon(Heroicon::OutlinedCurrencyDollar)
                ->color('warning'),
        ];
    }
}
