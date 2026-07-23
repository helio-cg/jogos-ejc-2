<?php

namespace App\Filament\User\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected function getHeaderActions(): array
    {
        $user = Auth::user();
        $actions = [];

        if ($user->isCompleted()) {
            Notification::make()
                ->title('Inscrição Confirmada')
                ->body('Sua inscrição está confirmada. Não é mais possível cadastrar ou alterar participantes.')
                ->info()
                ->send();
        }

        if ($user->isParent()) {
            $actions[] = Action::make('gerenciarPagamentos')
                ->label('CONFIRMAR PAGAMENTO E INSCRIÇÃO')
                ->icon('heroicon-o-currency-dollar')
                ->color('success')
                ->url(GerenciarPagamentos::getUrl());
        }

        return $actions;
    }
}
