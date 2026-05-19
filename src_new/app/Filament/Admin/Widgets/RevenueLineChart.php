<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Widgets\Concerns\OnlySuperAdminWidget;

final class RevenueLineChart extends ChartWidget
{
    use OnlySuperAdminWidget;

    protected ?string $heading = 'Grafik Pendapatan';

    protected ?string $description = 'Pendapatan dari order dengan status confirmed';

    protected ?string $maxHeight = '320px';

    public ?string $filter = 'week';

    protected function getData(): array
    {
        $activeFilter = $this->filter ?? 'week';

        return match ($activeFilter) {
            'month' => $this->getMonthlyRevenueData(),
            'year' => $this->getYearlyRevenueData(),
            default => $this->getWeeklyRevenueData(),
        };
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'week' => 'Minggu Ini',
            'month' => 'Bulan Ini',
            'year' => 'Tahun Ini',
        ];
    }

    private function getWeeklyRevenueData(): array
    {
        $startOfWeek = now()->startOfWeek();

        $labels = [];
        $data = [];

        foreach (range(0, 6) as $day) {
            $date = $startOfWeek->copy()->addDays($day);

            $labels[] = $date->translatedFormat('D, d M');

            $data[] = (int) $this->revenueQuery()
                ->whereDate('confirmed_at', $date)
                ->sum('total_price');
        }

        return $this->makeChartData(
            label: 'Pendapatan Minggu Ini',
            labels: $labels,
            data: $data,
        );
    }

    private function getMonthlyRevenueData(): array
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $labels = [];
        $data = [];

        $weekNumber = 1;
        $currentStart = $startOfMonth->copy();

        while ($currentStart->lte($endOfMonth)) {
            $currentEnd = $currentStart->copy()->endOfWeek();

            if ($currentEnd->gt($endOfMonth)) {
                $currentEnd = $endOfMonth->copy();
            }

            $labels[] = 'Minggu ' . $weekNumber;

            $data[] = (int) $this->revenueQuery()
                ->whereBetween('confirmed_at', [
                    $currentStart->copy()->startOfDay(),
                    $currentEnd->copy()->endOfDay(),
                ])
                ->sum('total_price');

            $currentStart = $currentEnd->copy()->addDay()->startOfDay();
            $weekNumber++;
        }

        return $this->makeChartData(
            label: 'Pendapatan Bulan Ini',
            labels: $labels,
            data: $data,
        );
    }

    private function getYearlyRevenueData(): array
    {
        $labels = [];
        $data = [];

        foreach (range(1, 12) as $month) {
            $date = now()->month($month)->startOfMonth();

            $labels[] = $date->translatedFormat('M');

            $data[] = (int) $this->revenueQuery()
                ->whereBetween('confirmed_at', [
                    $date->copy()->startOfMonth(),
                    $date->copy()->endOfMonth(),
                ])
                ->sum('total_price');
        }

        return $this->makeChartData(
            label: 'Pendapatan Tahun Ini',
            labels: $labels,
            data: $data,
        );
    }

    private function makeChartData(string $label, array $labels, array $data): array
    {
        return [
            'datasets' => [
                [
                    'label' => $label,
                    'data' => $data,
                    'tension' => 0.35,
                    'fill' => true,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 7,
                ],
            ],
            'labels' => $labels,
        ];
    }

    private function revenueQuery(): Builder
    {
        return Order::query()
            ->where('status', 'confirmed')
            ->whereNotNull('confirmed_at');

        // Kalau pendapatan hanya mau dihitung dari order yang sudah dibayar,
        // aktifkan juga query ini:
        // ->where('payment_status', 'paid');
    }
}