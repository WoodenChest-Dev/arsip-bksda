<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\ArchiveStatsWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Pages\Auth\CustomLogin::class)
            ->brandName('ARSIP BKSDA')
            ->brandLogo(fn (): HtmlString => new HtmlString(
                '<div style="display:flex; align-items:center; gap:0.5rem;">' .
                '<img src="' . asset('images/logos/logo-bksda.png') . '" alt="Logo BKSDA" style="height:2rem; width:auto;">' .
                '<span style="font-weight:700; color:var(--primary-600); white-space:nowrap;">ARSIP BKSDA</span>' .
                '</div>'
            ))
            ->brandLogoHeight('2rem')
            ->font('Plus Jakarta Sans', provider: GoogleFontProvider::class)
            ->colors([
                'primary' => Color::hex('#008A3C'),
                'secondary' => Color::hex('#A87B18'),
                'danger' => Color::hex('#DC2626'),
                'success' => Color::hex('#16A34A'),
                'warning' => Color::hex('#D97706'),
                'info' => Color::hex('#0EA5E9'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                ArchiveStatsWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                'throttle:admin',
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}