<?php

namespace App\Filament\User\Widgets;

use App\Models\Atleta;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class UserAtletasQueimada extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $parishUserIds = Auth::user()->getParishUserIds();

        return $table
            ->heading('Queimada (Misto)')
            ->query(
                Atleta::whereIn('user_id', $parishUserIds)
                    ->whereJsonContains('modalidade', 'Queimada')
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
            ]);
    }
}
