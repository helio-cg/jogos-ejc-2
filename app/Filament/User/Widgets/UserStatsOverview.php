<?php

namespace App\Filament\User\Widgets;

use App\Models\Atleta;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class UserStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = Auth::user();
        $parishUserIds = $user->getParishUserIds();

        $total = Atleta::whereIn('user_id', $parishUserIds)->where('pagamento', true)->count(); // apenas com pagamento confirmado
        $pagos = Atleta::whereIn('user_id', $parishUserIds)->where('pagamento', true)->count();
        $pendentes = Atleta::whereIn('user_id', $parishUserIds)->where('pagamento', false)->count();
        $valorTotal = $total * 10;

        $paroquia = $user->paroquia;
        $paroquiaNome = $paroquia ? $paroquia->name . ' - ' . $paroquia->city : 'Não definida';

        return [
            Stat::make($paroquiaNome, $total . ' inscritos' )
                ->description($user->name . ' (' . ($user->role === 'parent' ? 'Responsável' : 'Sub-Usuário') . ')')
                ->descriptionIcon(Heroicon::OutlinedMapPin)
                ->color('primary'),
          /*  Stat::make('Atletas da Paróquia', $total)
                ->icon(Heroicon::OutlinedUserGroup)
                ->color('info'),
            Stat::make('Pagamentos Confirmados', $pagos)
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success'),*/
            Stat::make('Pagamentos Pendentes', $pendentes)
                ->icon(Heroicon::OutlinedClock)
                ->color('danger'),
            Stat::make('Total a pagar (R$ 10 / atleta)', 'R$ ' . number_format($valorTotal, 2, ',', '.'))
                ->icon(Heroicon::OutlinedCurrencyDollar)
                ->color('warning'),
        ];
    }
}
