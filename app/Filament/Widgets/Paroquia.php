<?php

namespace App\Filament\Widgets;

use App\Models\Paroquia as ParoquiaModel;
use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class Paroquia extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ParoquiaModel::withCount('users')
                    ->whereIn('id', User::where('active', true)->select('paroquia_id')->distinct())
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Paróquia')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('users_count')
                    ->label('Usuários Ativos')
                    ->sortable(),
            ]);
    }
}
