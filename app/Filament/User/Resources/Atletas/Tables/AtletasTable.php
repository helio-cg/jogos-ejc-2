<?php

namespace App\Filament\User\Resources\Atletas\Tables;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AtletasTable
{
    public static function configure(Table $table): Table
    {
        $user = Auth::user();
        $isParent = $user->isParent();
        $isCompleted = $user->isParent()
            ? $user->isCompleted()
            : $user->parent?->isCompleted();

        $columns = [
            TextColumn::make('nome')
                ->label('Nome')
                ->searchable()
                ->sortable()
                ->description(fn ($record) => $record->data_nascimento?->age . ' anos' ?? '-')
                ->formatStateUsing(function ($record) {
                    $name = $record->nome;
                    if ($record->conhecido_como) {
                        $name .= ' (' . $record->conhecido_como . ')';
                    }
                    return $name;
                }),
            TextColumn::make('data_nascimento')
                ->label('Data de Nascimento')
                ->date('d/m/Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('modalidade')
                ->label('Modalidade')
                ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state)
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Futsal' => 'primary',
                    'Vôlei' => 'success',
                    'Queimada' => 'warning',
                    default => 'gray',
                }),
            TextColumn::make('pagamento')
                ->label('Pagamento')
                ->badge()
                ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                ->formatStateUsing(fn (bool $state): string => $state ? 'Pago' : 'Pendente'),
            TextColumn::make('user.name')
                ->label('Cadastrado por')
                ->sortable(),
        ];

        $actions = [];

        if ($isParent && !$isCompleted) {
            $actions[] = Action::make('marcarPago')
                ->label('Marcar Pago')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn ($record) => !$record->pagamento)
                ->action(fn ($record) => $record->update(['pagamento' => true]))
                ->after(function () {
                    Notification::make()->title('Pagamento confirmado!')->success()->send();
                });
        }

        if (!$isCompleted) {
            $actions[] = EditAction::make();
        }

        if ($isParent && !$isCompleted) {
            $actions[] = DeleteAction::make()
                ->visible(fn ($record) => !$record->pagamento);
        }

        return $table
            ->columns($columns)
            ->filters([
                SelectFilter::make('pagamento')
                    ->label('Pagamento')
                    ->options([
                        '1' => 'Pago',
                        '0' => 'Pendente',
                    ])
                    ->query(function ($query, array $data) {
                        $value = $data['value'] ?? null;
                        if ($value === '1') {
                            $query->where('pagamento', true);
                        } elseif ($value === '0') {
                            $query->where('pagamento', false);
                        }
                    }),
                SelectFilter::make('modalidade')
                    ->label('Modalidade')
                    ->options([
                        'Futsal' => 'Futsal',
                        'Vôlei' => 'Vôlei',
                        'Queimada' => 'Queimada',
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value']) {
                            $query->whereJsonContains('modalidade', $data['value']);
                        }
                    }),
            ])
            ->recordActions($actions)
            ->toolbarActions([]);
    }
}
