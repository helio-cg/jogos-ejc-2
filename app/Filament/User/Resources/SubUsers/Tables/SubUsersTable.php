<?php

namespace App\Filament\User\Resources\SubUsers\Tables;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\UserModalidade;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SubUsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('userModalidades.modalidade')
                    ->label('Modalidade')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Futsal' => 'primary',
                        'Vôlei' => 'success',
                        'Queimada' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('team_name')
                    ->label('Time')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
                    ->mutateFormDataUsing(function (array $data, $record): array {
                        $modalidade = $data['modalidade'] ?? null;
                        $paroquiaId = Auth::user()->paroquia_id;

                        if ($modalidade) {
                            $parishSubIds = User::where('paroquia_id', $paroquiaId)
                                ->where('role', 'sub_user')
                                ->where('id', '!=', $record->id)
                                ->pluck('id')
                                ->toArray();

                            $jaExiste = UserModalidade::whereIn('user_id', $parishSubIds)
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

                        UserModalidade::where('user_id', $record->id)->delete();

                        if ($modalidade) {
                            UserModalidade::create([
                                'user_id' => $record->id,
                                'modalidade' => $modalidade,
                            ]);
                        }

                        unset($data['modalidade']);
                        return $data;
                    })
                    ->after(function ($record) {
                        $mod = $record->userModalidades()->pluck('modalidade')->first();
                        ActivityLog::log(
                            'sub_usuario_atualizado',
                            'Sub-usuário "' . $record->name . '" foi atualizado (Modalidade: ' . $mod . ')',
                            \App\Models\User::class,
                            $record->id,
                            ['name' => $record->name, 'modalidade' => $mod]
                        );
                    }),
                DeleteAction::make()
                    ->before(function ($record) {
                        ActivityLog::log(
                            'sub_usuario_removido',
                            'Sub-usuário "' . $record->name . '" foi removido',
                            \App\Models\User::class,
                            $record->id,
                            ['name' => $record->name, 'email' => $record->email]
                        );
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
