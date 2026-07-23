<?php

namespace App\Filament\User\Pages;

use App\Filament\User\Widgets\TeamNameHeader;
use App\Models\ActivityLog;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    public function getHeaderWidgets(): array
    {
        $user = Auth::user();

        if ($user->isSubUser()) {
            return [
                TeamNameHeader::class,
            ];
        }

        return [];
    }

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

        if ($user->isSubUser()) {
            $actions[] = Action::make('mudarNomeTime')
                ->label('MUDAR NOME DO TIME')
                ->icon('heroicon-o-pencil-square')
                ->color('primary')
                ->modalHeading('Alterar Nome do Time')
                ->modalDescription('Altere o nome do seu time abaixo.')
                ->form([
                    TextInput::make('team_name')
                        ->label('Nome do Time')
                        ->default(fn () => Auth::user()->team_name)
                        ->placeholder('Ex: Time Azul, Time 1, etc.')
                        ->maxLength(255)
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $user = Auth::user();
                    $oldName = $user->team_name;
                    $newName = $data['team_name'];

                    $user->update(['team_name' => $newName]);

                    ActivityLog::log(
                        'time_nome_alterado',
                        'Nome do time alterado de "' . $oldName . '" para "' . $newName . '"',
                        \App\Models\User::class,
                        $user->id,
                        ['old_team_name' => $oldName, 'new_team_name' => $newName]
                    );

                    Notification::make()
                        ->title('Nome do time atualizado!')
                        ->success()
                        ->send();
                });
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
