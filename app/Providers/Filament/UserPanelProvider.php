<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use App\Http\Middleware\WizardMiddleware;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\User\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('user')
            ->path('user')
            ->viteTheme('resources/css/filament/user/theme.css')
            ->colors([
                'primary' => Color::Indigo,
                'gray' => Color::Zinc,
            ])
            ->profile()
            ->topbar(false)
            ->login()
            ->registration()
            ->authGuard('web')
            ->defaultThemeMode(ThemeMode::Light)
            ->darkMode(false)
            ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\Filament\User\Resources')
            ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\Filament\User\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->renderHook(
                \Filament\View\PanelsRenderHook::SIDEBAR_FOOTER,
                fn () => view('filament.user.partials.sidebar-help'),
            )
            ->renderHook(
                \Filament\View\PanelsRenderHook::CONTENT_START,
                fn () => view('filament.user.partials.impersonation-bar'),
            )
            ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\Filament\User\Widgets')
            ->widgets([
                \App\Filament\User\Widgets\UserStatsOverview::class,
                \App\Filament\User\Widgets\UserAtletasFutsal::class,
                \App\Filament\User\Widgets\UserAtletasVolei::class,
                \App\Filament\User\Widgets\UserAtletasQueimada::class,
                \App\Filament\User\Widgets\UserAtletasPendentes::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                WizardMiddleware::class,
            ]);
    }
}
