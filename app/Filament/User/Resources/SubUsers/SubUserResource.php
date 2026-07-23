<?php

namespace App\Filament\User\Resources\SubUsers;

use App\Filament\User\Resources\SubUsers\Pages\ListSubUsers;
use App\Filament\User\Resources\SubUsers\Schemas\SubUserForm;
use App\Filament\User\Resources\SubUsers\Tables\SubUsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SubUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'sub-usuário';

    protected static ?string $navigationLabel = 'Sub Usuários';

    public static function canViewAny(): bool
    {
        return Auth::check() && Auth::user()->isParent();
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function form(Schema $schema): Schema
    {
        return SubUserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubUsersTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('parent_id', Auth::id())
            ->where('role', 'sub_user');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubUsers::route('/'),
        ];
    }
}
