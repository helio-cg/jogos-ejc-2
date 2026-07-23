<?php

namespace App\Filament\Widgets;

use App\Models\Atleta;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AtletasVolei extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Vôlei (Misto)')
            ->query(
                Atleta::whereJsonContains('modalidade', 'Vôlei')
                    ->orderByDesc('pagamento')
                    ->orderByDesc('created_at')
            )
            ->columns([
                TextColumn::make('nome')
                    ->searchable(),
                TextColumn::make('data_nascimento')
                    ->label('Idade')
                    ->formatStateUsing(fn ($record) => $record->data_nascimento?->age ?? '-'),
                TextColumn::make('pagamento')
                    ->label('Pagamento')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Pago' : 'Pendente'),
                TextColumn::make('user.name')
                    ->label('Responsável'),
            ]);
    }
}
