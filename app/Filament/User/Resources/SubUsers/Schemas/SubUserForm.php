<?php

namespace App\Filament\User\Resources\SubUsers\Schemas;

use App\Models\UserModalidade;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->dehydrated()
                    ->suffixIcon('heroicon-o-key'),
                Select::make('modalidade')
                    ->label('Modalidade')
                    ->options([
                        'Futsal' => 'Futsal Masculino',
                        'Vôlei' => 'Vôlei (Misto)',
                        'Queimada' => 'Queimada (Misto)',
                    ])
                    ->required()
                    ->native(false),
                TextInput::make('team_name')
                    ->label('Nome do Time')
                    ->placeholder('Será gerado automaticamente se deixado em branco')
                    ->helperText('Ex: Time 1, Time Azul, etc.')
                    ->maxLength(255),
            ])
            ->columns(1);
    }
}
