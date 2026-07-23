<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                IconColumn::make('active')
                    ->boolean(),
                TextColumn::make('role')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'parent' => 'primary',
                        'sub_user' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'parent' => 'Responsável',
                        'sub_user' => 'Sub-Usuário',
                        default => $state,
                    }),
                TextColumn::make('parent.name')
                    ->label('Responsável')
                    ->sortable(),
                TextColumn::make('team_name')
                    ->label('Time')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completo' => 'success',
                        'incompleto' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('paroquia.name')
                    ->label('Paróquia')
                    ->getStateUsing(fn ($record) => $record->paroquia?->name . ' (' . $record->paroquia?->city . ')')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                Action::make('confirmarPagamento')
                    ->label('Confirmar Pagamento')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status !== 'completo')
                    ->action(function ($record) {
                        $record->update(['status' => 'completo']);

                        if ($record->isParent()) {
                            $record->children()->where('role', 'sub_user')->update(['status' => 'completo']);
                        }

                        Notification::make()
                            ->title('Inscrição confirmada!')
                            ->body('Status alterado para completo. O usuário não poderá mais cadastrar ou alterar participantes.')
                            ->success()
                            ->send();
                    }),
                Action::make('gerarPdf')
                    ->label('Baixar PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->visible(fn ($record) => $record->status === 'completo')
                    ->url(fn ($record) => route('pdf.comprovante', $record), shouldOpenInNewTab: true),
                Action::make('acessarComo')
                    ->label('Acessar como')
                    ->icon('heroicon-o-arrow-right-on-rectangle')
                    ->color('warning')
                    ->url(fn ($record) => route('admin.switch.user', $record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
