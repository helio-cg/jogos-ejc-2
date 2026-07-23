<?php

namespace App\Filament\User\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\SimplePage;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class SettingsPage extends SimplePage implements HasForms
{
    use InteractsWithForms;

    protected static ?string $slug = 'settings';

    public ?string $team_name = null;

    public function getHeading(): string
    {
        return 'Configuração do Time';
    }

    public static function getNavigationLabel(): string
    {
        return 'Configurações';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-cog-6-tooth';
    }

    public static function getNavigationSort(): int
    {
        return 100;
    }

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->isSubUser();
    }

    public function mount(): void
    {
        $user = Auth::user();
        $this->form->fill([
            'team_name' => $user->team_name,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        $user = Auth::user();

        return $schema
            ->components([
                TextInput::make('team_name')
                    ->label('Nome do Time')
                    ->default($user->team_name)
                    ->placeholder('Ex: Time Azul, Time 1, etc.')
                    ->maxLength(255),
            ])
            ->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Salvar')
                                ->submit('form')
                                ->button(),
                        ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $user = Auth::user();
        $data = $this->form->getState();

        $user->update(['team_name' => $data['team_name'] ?? null]);

        Notification::make()
            ->title('Configuração salva com sucesso!')
            ->success()
            ->send();
    }
}
