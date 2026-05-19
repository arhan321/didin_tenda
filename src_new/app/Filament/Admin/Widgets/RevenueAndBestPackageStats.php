<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Widgets\Concerns\OnlySuperAdminWidget;

final class RevenueAndBestPackageStats extends BaseWidget
{
    use OnlySuperAdminWidget;

    protected ?string $heading = 'Pendapatan & Paket Terlaris';

    protected function getStats(): array
    {
        $todayRevenue = $this->revenueBetween(
            now()->startOfDay(),
            now()->endOfDay(),
        );

        $weekRevenue = $this->revenueBetween(
            now()->startOfWeek(),
            now()->endOfWeek(),
        );

        $monthRevenue = $this->revenueBetween(
            now()->startOfMonth(),
            now()->endOfMonth(),
        );

        $topPackages = $this->getTopPackages();

        $bestPackage = $topPackages->first();

        $bestPackageName = $bestPackage
            ? $this->getPackageName($bestPackage)
            : 'Belum ada data';

        $bestPackageDescription = $topPackages->isNotEmpty()
            ? $topPackages
                ->map(fn (Order $order): string => $this->getPackageName($order) . ' (' . $order->total_orders . ' order)')
                ->join(', ')
            : 'Belum ada paket yang terjual';

        return [
            Stat::make('Pendapatan Hari Ini', $this->formatRupiah($todayRevenue))
                ->description('Total pendapatan order confirmed hari ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->chart($this->dailyRevenueChart())
                ->color('success')
                ->extraAttributes([
                    'class' => '!border-0 !ring-0 rounded-2xl bg-gradient-to-br from-success-500/10 via-success-500/5 to-transparent shadow-lg shadow-success-500/10 transition duration-300 hover:scale-[1.02] hover:shadow-success-500/20',
                ]),

            Stat::make('Pendapatan Minggu Ini', $this->formatRupiah($weekRevenue))
                ->description('Total pendapatan order confirmed minggu ini')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart($this->weeklyRevenueChart())
                ->color('info')
                ->extraAttributes([
                    'class' => '!border-0 !ring-0 rounded-2xl bg-gradient-to-br from-info-500/10 via-info-500/5 to-transparent shadow-lg shadow-info-500/10 transition duration-300 hover:scale-[1.02] hover:shadow-info-500/20',
                ]),

            Stat::make('Pendapatan Bulan Ini', $this->formatRupiah($monthRevenue))
                ->description('Total pendapatan order confirmed bulan ini')
                ->descriptionIcon('heroicon-m-calendar')
                ->chart($this->monthlyRevenueChart())
                ->color('warning')
                ->extraAttributes([
                    'class' => '!border-0 !ring-0 rounded-2xl bg-gradient-to-br from-warning-500/10 via-warning-500/5 to-transparent shadow-lg shadow-warning-500/10 transition duration-300 hover:scale-[1.02] hover:shadow-warning-500/20',
                ]),

            Stat::make('Paket Paling Laris', $bestPackageName)
                ->description($bestPackageDescription)
                ->descriptionIcon('heroicon-m-trophy')
                ->color('primary')
                ->extraAttributes([
                    'class' => '!border-0 !ring-0 rounded-2xl bg-gradient-to-br from-primary-500/10 via-primary-500/5 to-transparent shadow-lg shadow-primary-500/10 transition duration-300 hover:scale-[1.02] hover:shadow-primary-500/20',
                ]),
        ];
    }

    private function confirmedOrderQuery(): Builder
    {
        return Order::query()
            ->where('status', 'confirmed')
            ->whereNotNull('confirmed_at');

        // Kalau nanti mau pendapatan hanya dari yang sudah dibayar,
        // tambahkan ini:
        // ->where('payment_status', 'paid');
    }

    private function revenueBetween($startDate, $endDate): int
    {
        return (int) $this->confirmedOrderQuery()
            ->whereBetween('confirmed_at', [$startDate, $endDate])
            ->sum('total_price');
    }

    private function dailyRevenueChart(): array
    {
        return collect(range(6, 0))
            ->map(function (int $daysAgo): int {
                $date = now()->subDays($daysAgo);

                return (int) $this->confirmedOrderQuery()
                    ->whereDate('confirmed_at', $date)
                    ->sum('total_price');
            })
            ->all();
    }

    private function weeklyRevenueChart(): array
    {
        return collect(range(6, 0))
            ->map(function (int $weeksAgo): int {
                $date = now()->subWeeks($weeksAgo);

                return (int) $this->confirmedOrderQuery()
                    ->whereBetween('confirmed_at', [
                        $date->copy()->startOfWeek(),
                        $date->copy()->endOfWeek(),
                    ])
                    ->sum('total_price');
            })
            ->all();
    }

    private function monthlyRevenueChart(): array
    {
        return collect(range(5, 0))
            ->map(function (int $monthsAgo): int {
                $date = now()->subMonths($monthsAgo);

                return (int) $this->confirmedOrderQuery()
                    ->whereBetween('confirmed_at', [
                        $date->copy()->startOfMonth(),
                        $date->copy()->endOfMonth(),
                    ])
                    ->sum('total_price');
            })
            ->all();
    }

    private function getTopPackages(): Collection
    {
        return Order::query()
            ->with('package')
            ->select('package_id')
            ->selectRaw('COUNT(*) as total_orders')
            ->where('status', 'confirmed')
            ->whereNotNull('package_id')
            ->groupBy('package_id')
            ->orderByDesc('total_orders')
            ->limit(3)
            ->get();
    }

    private function getPackageName(Order $order): string
    {
        return data_get($order->package, 'name')
            ?? data_get($order->package, 'title')
            ?? data_get($order->package, 'package_name')
            ?? 'Paket #' . $order->package_id;
    }

    private function formatRupiah(int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}