<?php

namespace App\Filament\User\Resources\SubUsers\Pages;

use App\Filament\User\Resources\SubUsers\SubUserResource;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\UserModalidade;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListSubUsers extends ListRecords
{
    protected static string $resource = SubUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data): array {
                    $modalidade = $data['modalidade'] ?? null;
                    $parentId = Auth::id();
                    $paroquiaId = Auth::user()->paroquia_id;

                    if ($modalidade) {
                        $parishUserIds = User::where('paroquia_id', $paroquiaId)
                            ->where('role', 'sub_user')
                            ->pluck('id')
                            ->toArray();

                        $jaExiste = UserModalidade::whereIn('user_id', $parishUserIds)
                            ->where('modalidade', $modalidade)
                            ->exists();

                        if ($jaExiste) {
                            Notification::make()
                                ->title('Modalidade já utilizada na paróquia')
                                ->body('A modalidade "' . $modalidade . '" já está atribuída a outro sub-usuário nesta paróquia.')
                                ->danger()
                                ->send();

                            throw new \Filament\Support\Exceptions\Halt();
                        }
                    }

                    $data['parent_id'] = $parentId;
                    $data['paroquia_id'] = $paroquiaId;
                    $data['role'] = 'sub_user';
                    $data['active'] = true;
                    $data['status'] = 'incompleto';
                    return $data;
                })
                ->after(function ($record, array $data) {
                    $modalidade = $data['modalidade'] ?? null;

                    if ($modalidade) {
                        UserModalidade::create([
                            'user_id' => $record->id,
                            'modalidade' => $modalidade,
                        ]);
                    }

                    ActivityLog::log(
                        'sub_usuario_criado',
                        'Sub-usuário "' . $record->name . '" foi criado com modalidade: ' . $modalidade,
                        \App\Models\User::class,
                        $record->id,
                        ['name' => $record->name, 'email' => $record->email, 'modalidade' => $modalidade]
                    );
                }),
        ];
    }
}
