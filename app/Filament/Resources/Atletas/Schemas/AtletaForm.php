<?php

namespace App\Filament\Resources\Atletas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AtletaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                DatePicker::make('data_nascimento')
                    ->label('Data de Nascimento')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->required()
                    ->maxDate(now()),
                CheckboxList::make('modalidade')
                    ->label('Modalidade')
                    ->options([
                        'Futsal' => 'Futsal Masculino',
                        'Queimada' => 'Queimada (Misto)',
                        'Vôlei' => 'Vôlei (Misto)',
                    ])
                    ->required()
                    ->columns(3),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable(),
            ])->columns(1);
    }
}
