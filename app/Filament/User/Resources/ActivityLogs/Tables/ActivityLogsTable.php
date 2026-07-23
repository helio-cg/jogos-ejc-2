<?php

namespace App\Filament\User\Resources\ActivityLogs\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Usuário')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('action')
                    ->label('Ação')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'atleta_criado' => 'success',
                        'atleta_atualizado' => 'warning',
                        'atleta_removido' => 'danger',
                        'sub_usuario_criado' => 'info',
                        'sub_usuario_atualizado' => 'info',
                        'sub_usuario_removido' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'atleta_criado' => 'Atleta Criado',
                        'atleta_atualizado' => 'Atleta Atualizado',
                        'atleta_removido' => 'Atleta Removido',
                        'sub_usuario_criado' => 'Sub-Usuário Criado',
                        'sub_usuario_atualizado' => 'Sub-Usuário Atualizado',
                        'sub_usuario_removido' => 'Sub-Usuário Removido',
                        default => $state,
                    }),
                TextColumn::make('description')
                    ->label('Descrição')
                    ->limit(80)
                    ->tooltip(fn ($record) => $record->description),
                TextColumn::make('created_at')
                    ->label('Data/Hora')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
