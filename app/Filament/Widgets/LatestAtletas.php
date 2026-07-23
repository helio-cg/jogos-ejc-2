<?php

namespace App\Filament\Widgets;

use App\Models\Atleta;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestAtletas extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Atleta::query()->latest()->limit(10)
            )
            ->columns([
                TextColumn::make('nome')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Responsável'),
                TextColumn::make('modalidade')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Futsal' => 'primary',
                        'Vôlei' => 'success',
                        'Queimada' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Cadastro')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ]);
    }
}
