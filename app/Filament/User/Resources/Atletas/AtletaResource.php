<?php

namespace App\Filament\User\Resources\Atletas;

use App\Filament\User\Resources\Atletas\Pages\ListAtletas;
use App\Filament\User\Resources\Atletas\Schemas\AtletaForm;
use App\Filament\User\Resources\Atletas\Tables\AtletasTable;
use App\Models\Atleta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AtletaResource extends Resource
{
    protected static ?string $model = Atleta::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nome';

    protected static ?string $modelLabel = 'participante';

    public static function form(Schema $schema): Schema
    {
        return AtletaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AtletasTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $parishUserIds = $user->getParishUserIds();

        return parent::getEloquentQuery()->whereIn('user_id', $parishUserIds);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAtletas::route('/'),
        ];
    }
}
