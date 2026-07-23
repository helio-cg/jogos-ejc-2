<?php

namespace App\Filament\User\Resources\Atletas\Pages;

use App\Filament\User\Resources\Atletas\AtletaResource;
use App\Models\ActivityLog;
use App\Models\Atleta;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListAtletas extends ListRecords
{
    protected static string $resource = AtletaResource::class;

    protected function getHeaderActions(): array
    {
        $user = Auth::user();
        $isCompleted = $user->isParent()
            ? $user->isCompleted()
            : $user->parent?->isCompleted();

        return [
            CreateAction::make()
                ->visible(fn () => !$isCompleted)
                ->mutateDataUsing(function (array $data): array {
                    $user = Auth::user();

                    $isCompleted = $user->isParent()
                        ? $user->isCompleted()
                        : $user->parent?->isCompleted();

                    if ($isCompleted) {
                        Notification::make()
                            ->title('Cadastro bloqueado')
                            ->body('Seu status está completo. Não é possível cadastrar ou alterar participantes.')
                            ->danger()
                            ->send();

                        throw new \Filament\Support\Exceptions\Halt();
                    }

                    $nome = $data['nome'] ?? null;
                    $dataNascimento = $data['data_nascimento'] ?? null;
                    $modalidades = $data['modalidade'] ?? [];

                    $existing = Atleta::whereIn('user_id', $user->getParishUserIds())
                        ->where('nome', $nome)
                        ->where('data_nascimento', $dataNascimento)
                        ->first();

                    if ($existing) {
                        $existingModalidades = $existing->modalidade ?? [];
                        $newModalidades = array_unique(array_merge($existingModalidades, $modalidades));

                        if (count($newModalidades) > count($existingModalidades)) {
                            $existing->update(['modalidade' => $newModalidades]);

                            Notification::make()
                                ->title('Modalidade adicionada')
                                ->body('O participante "' . $nome . '" já existia. As novas modalidades foram adicionadas: ' . implode(', ', array_diff($newModalidades, $existingModalidades)))
                                ->success()
                                ->send();

                            throw new \Filament\Support\Exceptions\Halt();
                        } else {
                            Notification::make()
                                ->title('Participante já existe')
                                ->body('O participante "' . $nome . '" já está inscrito nestas modalidades.')
                                ->danger()
                                ->send();

                            throw new \Filament\Support\Exceptions\Halt();
                        }
                    }

                    $data['user_id'] = $user->id;
                    return $data;
                }),
        ];
    }
}
