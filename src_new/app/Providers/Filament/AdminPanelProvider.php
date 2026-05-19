<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Filament\Panel;
use App\Models\User;
use Filament\PanelProvider;
use Filament\Enums\ThemeMode;
use Filament\Support\Enums\Width;
use Awcodes\Overlook\OverlookPlugin;
use Filament\Support\Icons\Heroicon;
use App\Filament\Admin\Pages\Dashboard;
use Filament\Navigation\NavigationGroup;
use Openplain\FilamentShadcnTheme\Color;
use Filament\Http\Middleware\Authenticate;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Awcodes\Overlook\Widgets\OverlookWidget;
use Filament\Support\Colors\Color as FilamentColor;
use Illuminate\Session\Middleware\StartSession;
use App\Filament\Admin\Widgets\LatestAccessLogs;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Jacobtims\FilamentLogger\FilamentLoggerPlugin;
use App\Filament\Admin\Resources\Users\UserResource;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use DutchCodingCompany\FilamentDeveloperLogins\FilamentDeveloperLoginsPlugin;


final class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->authGuard('web')
            ->spa()
            ->spaUrlExceptions([
                Dashboard::class,
            ])
            ->login()
            ->topbar(false)
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('16rem')
            ->maxContentWidth(Width::Full)
            ->databaseTransactions()
            ->defaultThemeMode(ThemeMode::Dark)
            ->colors([
                'primary' => Color::adaptive(
                    lightColor: FilamentColor::Blue,
                    darkColor: FilamentColor::Sky
                ),
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                // OverlookWidget::class,
                 \App\Filament\Admin\Resources\Orders\Widgets\ConfirmedOrderStats::class,
                 \App\Filament\Widgets\RevenueAndBestPackageStats::class,
                 \App\Filament\Widgets\CustomerUserStats::class,
                //   \App\Filament\Widgets\RevenueLineChart::class,
                \App\Filament\Admin\Widgets\RevenueChartTitle::class,
                \App\Filament\Widgets\WeeklyRevenueChart::class,
                \App\Filament\Widgets\MonthlyRevenueChart::class,
                \App\Filament\Widgets\YearlyRevenueChart::class,
            ])
            ->navigationGroups([
    NavigationGroup::make()
        ->collapsed(true)
        ->label('Administration'),

    NavigationGroup::make()
        ->collapsed(true)
        ->label('Manajemen Paket'),

    NavigationGroup::make()
        ->collapsed(true)
        ->label('Addon Management'),

    NavigationGroup::make()
        ->collapsed(true)
        ->label('Custom Item Management'),

    NavigationGroup::make()
        ->collapsed(true)
        ->label('Order Management'),

    NavigationGroup::make()
        ->collapsed(true)
        ->label('Frontend Management'),

    NavigationGroup::make()
        ->collapsed(true)
        ->label('General'),
            ])
            ->plugins([
                AuthDesignerPlugin::make()
                    ->login(fn ($config) => $config
                        ->media('https://images.pexels.com/photos/466685/pexels-photo-466685.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2')
                        ->mediaPosition(MediaPosition::Left)
                        ->mediaSize('70%')
                        ->blur(1)
                    )
                    ->themeToggle('90%', '50%'),
                BreezyCore::make()
                    ->myProfile(
                        hasAvatars: true,
                        slug: 'profile',
                        userMenuLabel: 'Profile',
                    )
                    ->enableBrowserSessions(),
                GlobalSearchModalPlugin::make(),
                OverlookPlugin::make()
                    ->sort(2)
                    ->columns([
                        'default' => 4,
                        'sm' => 2,
                        'lg' => 4,
                        'xl' => 6,
                    ])
                    ->includes([
                        UserResource::class,
                    ]),
                FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 2,
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 2,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 2,
                    ])
                    ->navigationLabel('Roles & Permissions')
                    ->navigationGroup('Administration')
                    ->navigationSort(2)
                    ->navigationIcon(Heroicon::ShieldCheck),
                FilamentLoggerPlugin::make(),
                FilamentDeveloperLoginsPlugin::make()
                    ->enabled(app()->environment('local'))
                    ->switchable(true)
                    ->users(fn () => User::pluck('email', 'name')->toArray()),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
