<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Orders\Widgets;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

final class ConfirmedOrderStats extends BaseWidget
{
    protected ?string $heading = 'Statistik Order Confirmed';

    public static function canView(): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        if (method_exists($user, 'hasRole')) {
            return $user->hasRole('super_admin');
        }

        return $user->roles()
            ->where('name', 'super_admin')
            ->exists();
    }

    protected function getStats(): array
    {
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $todayConfirmedOrders = $this->confirmedOrdersBetween($todayStart, $todayEnd)->count();
        $weekConfirmedOrders = $this->confirmedOrdersBetween($weekStart, $weekEnd)->count();
        $monthConfirmedOrders = $this->confirmedOrdersBetween($monthStart, $monthEnd)->count();

        return [
            Stat::make('Order Confirmed Hari Ini', number_format($todayConfirmedOrders, 0, ',', '.'))
                ->description('Order yang dikonfirmasi hari ini')
                ->descriptionIcon('heroicon-m-check-circle')
                ->chart($this->dailyConfirmedChart())
                ->color('success')
                ->extraAttributes([
                    'class' => '!border-0 !ring-0 rounded-2xl bg-gradient-to-br from-success-500/10 via-success-500/5 to-transparent shadow-lg shadow-success-500/10 transition duration-300 hover:scale-[1.02] hover:shadow-success-500/20',
                ]),

            Stat::make('Order Confirmed Minggu Ini', number_format($weekConfirmedOrders, 0, ',', '.'))
                ->description('Order yang dikonfirmasi minggu ini')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart($this->weeklyConfirmedChart())
                ->color('info')
                ->extraAttributes([
                    'class' => '!border-0 !ring-0 rounded-2xl bg-gradient-to-br from-info-500/10 via-info-500/5 to-transparent shadow-lg shadow-info-500/10 transition duration-300 hover:scale-[1.02] hover:shadow-info-500/20',
                ]),

            Stat::make('Order Confirmed Bulan Ini', number_format($monthConfirmedOrders, 0, ',', '.'))
                ->description('Order yang dikonfirmasi bulan ini')
                ->descriptionIcon('heroicon-m-calendar')
                ->chart($this->monthlyConfirmedChart())
                ->color('warning')
                ->extraAttributes([
                    'class' => '!border-0 !ring-0 rounded-2xl bg-gradient-to-br from-warning-500/10 via-warning-500/5 to-transparent shadow-lg shadow-warning-500/10 transition duration-300 hover:scale-[1.02] hover:shadow-warning-500/20',
                ]),
        ];
    }

    private function confirmedOrdersBetween($startDate, $endDate): Builder
    {
        return Order::query()
            ->where('status', 'confirmed')
            ->whereNotNull('confirmed_at')
            ->whereBetween('confirmed_at', [$startDate, $endDate]);
    }

    private function confirmedOrderQuery(): Builder
    {
        return Order::query()
            ->where('status', 'confirmed')
            ->whereNotNull('confirmed_at');
    }

    private function dailyConfirmedChart(): array
    {
        return collect(range(6, 0))
            ->map(function (int $daysAgo): int {
                $date = now()->subDays($daysAgo);

                return $this->confirmedOrderQuery()
                    ->whereDate('confirmed_at', $date)
                    ->count();
            })
            ->all();
    }

    private function weeklyConfirmedChart(): array
    {
        return collect(range(6, 0))
            ->map(function (int $weeksAgo): int {
                $date = now()->subWeeks($weeksAgo);

                return $this->confirmedOrderQuery()
                    ->whereBetween('confirmed_at', [
                        $date->copy()->startOfWeek(),
                        $date->copy()->endOfWeek(),
                    ])
                    ->count();
            })
            ->all();
    }

    private function monthlyConfirmedChart(): array
    {
        return collect(range(5, 0))
            ->map(function (int $monthsAgo): int {
                $date = now()->subMonths($monthsAgo);

                return $this->confirmedOrderQuery()
                    ->whereBetween('confirmed_at', [
                        $date->copy()->startOfMonth(),
                        $date->copy()->endOfMonth(),
                    ])
                    ->count();
            })
            ->all();
    }
}