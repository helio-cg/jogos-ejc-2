<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('whatsapp')
                    ->label('WhatsApp')
                    ->mask('(99) 99999-9999'),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->dehydrated(fn ($state) => filled($state))
                    ->length(6),
                Toggle::make('active')
                    ->required(),
                Select::make('status')
                    ->options([
                        'incompleto' => 'Incompleto',
                        'completo' => 'Completo',
                    ])
                    ->default('incompleto')
                    ->required(),
                Select::make('role')
                    ->label('Tipo de Usuário')
                    ->options([
                        'parent' => 'Usuário (Responsável)',
                        'sub_user' => 'Sub-Usuário',
                    ])
                    ->default('parent')
                    ->required(),
                Select::make('paroquia_id')
                    ->relationship('paroquia', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('parent_id')
                    ->label('Responsável (Parent)')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Selecione o responsável para este sub-usuário'),
                TextInput::make('team_name')
                    ->label('Nome do Time')
                    ->placeholder('Ex: Time 1, Time Azul, etc.')
                    ->maxLength(255),
            ]);
    }
}
