<?php

namespace App\Filament\User\Resources\ActivityLogs;

use App\Filament\User\Resources\ActivityLogs\Pages\ListActivityLogs;
use App\Filament\User\Resources\ActivityLogs\Tables\ActivityLogsTable;
use App\Models\ActivityLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?string $recordTitleAttribute = 'description';

    protected static ?string $modelLabel = 'registro de atividade';

    protected static ?string $navigationLabel = 'Log de Atividades';

    protected static ?int $navigationSort = 99;

    public static function canViewAny(): bool
    {
        return Auth::check() && Auth::user()->isParent();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return ActivityLogsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $userIds = $user->getParishUserIds();

        return parent::getEloquentQuery()
            ->whereIn('user_id', $userIds)
            ->latest();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
        ];
    }
}
