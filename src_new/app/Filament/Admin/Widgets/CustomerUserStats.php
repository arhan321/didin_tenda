<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

final class CustomerUserStats extends BaseWidget
{
    protected ?string $heading = 'Informasi Customer';

    protected function getStats(): array
    {
        $totalCustomers = $this->customerQuery()->count();

        return [
            Stat::make('Total Customer', number_format($totalCustomers, 0, ',', '.'))
                ->description('Customer aktif yang terdaftar di website')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->extraAttributes([
                    'class' => '
                        !border-0 !ring-0 rounded-2xl
                        bg-gradient-to-br from-slate-800/80 via-slate-900/80 to-primary-950/70
                        shadow-xl shadow-primary-500/10
                        transition-all duration-300 ease-out
                        transform-gpu cursor-pointer
                        hover:-translate-y-2 hover:scale-[1.03] hover:rotate-[0.4deg]
                        hover:shadow-2xl hover:shadow-primary-500/25
                        active:scale-[0.98]
                    ',
                    'style' => '
                        background:
                            radial-gradient(circle at top right, rgba(59, 130, 246, 0.25), transparent 35%),
                            linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.80));
                        will-change: transform;
                    ',
                ]),
        ];
    }

    private function customerQuery(): Builder
    {
        return User::query()
            ->whereHas('roles', function (Builder $query): void {
                $query->where('name', 'user');
            });
    }
}