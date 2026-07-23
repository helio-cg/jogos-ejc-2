<?php

namespace App\Filament\User\Pages;

use App\Models\Atleta;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Actions\Action as TableAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class GerenciarPagamentos extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $title = 'Confirmar Pagamento e Inscrição';

    protected string $view = 'filament.user.pages.gerenciar-pagamentos';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'gerenciar-pagamentos';

    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->isParent();
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-currency-dollar';
    }

    public function table(Table $table): Table
    {
        $user = Auth::user();
        $parishUserIds = $user->getParishUserIds();

        return $table
            ->query(
                Atleta::query()
                    ->whereIn('user_id', $parishUserIds)
                    ->where('pagamento', true)
                    ->orderBy('nome')
            )
            ->columns([
                TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('conhecido_como')
                    ->label('Conhecido como')
                    ->searchable(),
                TextColumn::make('modalidade')
                    ->label('Modalidades')
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),
                TextColumn::make('data_nascimento')
                    ->label('Idade')
                    ->formatStateUsing(fn ($record) => $record->data_nascimento?->age ?? '-'),
                TextColumn::make('user.name')
                    ->label('Cadastrado por')
                    ->sortable(),
            ])
            ->actions([
                TableAction::make('gerarPdf')
                    ->label('Baixar PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->url(fn () => route('pdf.comprovante', Auth::user()), shouldOpenInNewTab: true),
            ])
            ->defaultSort('nome');
    }

    protected function getViewData(): array
    {
        $user = Auth::user();
        $parishUserIds = $user->getParishUserIds();
        $totalAtletas = Atleta::whereIn('user_id', $parishUserIds)->count();
        $totalPagos = Atleta::whereIn('user_id', $parishUserIds)->where('pagamento', true)->count();
        $whatsapp = config('app.whatsapp', '');

        return [
            'isCompleted' => $user->isCompleted(),
            'totalAtletas' => $totalAtletas,
            'totalPagos' => $totalPagos,
            'totalPendentes' => $totalAtletas - $totalPagos,
            'valorTotal' => $totalPagos * 10,
            'pixKey' => config('app.pix_key', ''),
            'whatsapp' => $whatsapp,
            'whatsappLink' => $whatsapp
                ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsapp)
                : '#',
            'pdfUrl' => route('pdf.comprovante', $user),
        ];
    }
}
