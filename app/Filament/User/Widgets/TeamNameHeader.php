<?php

namespace App\Filament\User\Widgets;

use Filament\Widgets\Widget;

class TeamNameHeader extends Widget
{
    protected string $view = 'filament.user.widgets.team-name-header';

    protected static ?int $sort = 0;
}
