<?php

namespace App\Filament\Widgets;

use App\Models\Atleta;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AtletasPendentes extends BaseWidget
{
    protected static ?int $sort = 7;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Pagamentos Pendentes')
            ->query(
                Atleta::where('pagamento', false)
                    ->orderByDesc('created_at')
            )
            ->columns([
                TextColumn::make('nome')
                    ->searchable(),
                TextColumn::make('data_nascimento')
                    ->label('Idade')
                    ->formatStateUsing(fn ($record) => $record->data_nascimento?->age ?? '-'),
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
                TextColumn::make('user.name')
                    ->label('Responsável'),
            ]);
    }
}
