<?php

namespace App\Filament\User\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\SimplePage;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use App\Models\Paroquia;
use Illuminate\Support\Facades\Auth;

class WelcomePage extends SimplePage implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function getHeading(): string
    {
        return 'Bem-vindo, ative sua conta.';
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->active == 0;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('whatsapp')
                    ->label('WhatsApp com DDD')
                    ->placeholder('(11) 99999-9999')
                    ->mask('(99) 99999-9999')
                    ->required()
                    ->rule('min:14'),
                Select::make('paroquia_id')
                    ->label('Qual é a sua paróquia?')
                    ->placeholder('Digite a cidade e selecione a sua paróquia')
                    ->options(function () {
                        return Paroquia::query()
                            ->whereNotIn('id', function ($query) {
                                $query->select('paroquia_id')
                                    ->from('users')
                                    ->where('active', 1)
                                    ->whereNotNull('paroquia_id');
                            })
                            ->orderBy('city')
                            ->orderBy('name')
                            ->get()
                            ->groupBy('city')
                            ->mapWithKeys(function ($group, $city) {
                                return [
                                    $city => $group->mapWithKeys(function ($paroquia) {
                                        return [
                                            $paroquia->id => "{$paroquia->name} - {$paroquia->city}",
                                        ];
                                    }),
                                ];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->required()
                    ->preload(),
            ])
            ->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('submit')
                    ->footer([
                        Actions::make([
                            Action::make('submit')
                                ->label('Salvar')
                                ->submit('form')
                                ->button(),
                        ]),
                    ]),
            ]);
    }

    public function submit(): void
    {
        $user = Auth::user();
        $data = $this->form->getState();
        $data['active'] = 1;

        $user->update($data);

        $this->redirect('/user');
    }
}
