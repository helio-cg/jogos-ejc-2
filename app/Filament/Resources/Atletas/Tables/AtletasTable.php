<?php

namespace App\Filament\Resources\Atletas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AtletasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->searchable(),
                TextColumn::make('data_nascimento')
                    ->date()
                    ->sortable(),
                TextColumn::make('idade')
                    ->label('Idade')
                    ->getStateUsing(fn ($record) => $record->data_nascimento?->age ?? '-'),
                TextColumn::make('modalidade')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Futsal' => 'primary',
                        'Vôlei' => 'success',
                        'Queimada' => 'warning',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('pagamento')
                    ->label('Pagamento')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Pago' : 'Pendente'),
                TextColumn::make('user.name')
                    ->label('Usuário')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
