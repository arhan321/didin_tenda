<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

final class ConfirmedOrderStats extends BaseWidget
{
    protected ?string $heading = 'Statistik Order Confirmed';

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
Stat::make('Order Confirmed Hari Ini', $todayConfirmedOrders)
    ->description('Order yang dikonfirmasi hari ini')
    ->descriptionIcon('heroicon-m-check-circle')
    ->chart([1, 3, 2, 5, 4, 7, $todayConfirmedOrders])
    ->color('success')
    ->extraAttributes([
        'class' => '!border-0 !ring-0 rounded-2xl bg-gradient-to-br from-success-500/10 via-success-500/5 to-transparent shadow-lg shadow-success-500/10 transition duration-300 hover:scale-[1.02] hover:shadow-success-500/20',
    ]),

Stat::make('Order Confirmed Minggu Ini', $weekConfirmedOrders)
    ->description('Order yang dikonfirmasi minggu ini')
    ->descriptionIcon('heroicon-m-calendar-days')
    ->chart([2, 4, 5, 3, 8, 6, $weekConfirmedOrders])
    ->color('info')
    ->extraAttributes([
        'class' => '!border-0 !ring-0 rounded-2xl bg-gradient-to-br from-info-500/10 via-info-500/5 to-transparent shadow-lg shadow-info-500/10 transition duration-300 hover:scale-[1.02] hover:shadow-info-500/20',
    ]),

Stat::make('Order Confirmed Bulan Ini', $monthConfirmedOrders)
    ->description('Order yang dikonfirmasi bulan ini')
    ->descriptionIcon('heroicon-m-calendar')
    ->chart([5, 8, 6, 10, 12, 9, $monthConfirmedOrders])
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
            ->whereBetween('confirmed_at', [$startDate, $endDate]);
    }
}