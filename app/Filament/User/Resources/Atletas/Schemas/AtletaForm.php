<?php

namespace App\Filament\User\Resources\Atletas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Auth;

class AtletaForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = Auth::user();

        $schemaComponents = [
            TextInput::make('nome')
                ->label('Nome')
                ->required(),
            TextInput::make('conhecido_como')
                ->label('Conhecido como')
                ->placeholder('Apelido (opcional)'),
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
                    'Vôlei' => 'Vôlei (Misto)',
                    'Queimada' => 'Queimada (Misto)',
                ])
                ->required(),
        ];

        if ($user->isParent()) {
            $schemaComponents[] = Toggle::make('pagamento')
                ->label('Pagamento Confirmado')
                ->inline(false)
                ->onColor('success')
                ->offColor('danger');
        }

        return $schema
            ->components($schemaComponents)
            ->columns(1);
    }
}
