<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;

final class YearlyRevenueChart extends ChartWidget
{
    protected ?string $heading = 'Pendapatan Tahunan';

    protected ?string $description = 'Pendapatan bulanan dari order confirmed berdasarkan tahun';

    protected ?string $maxHeight = '300px';

    protected static ?int $sort = 12;

    public ?string $filter = null;

    protected function getData(): array
    {
        $selectedYear = $this->getSelectedYear();

        $labels = [];
        $data = [];

        foreach (range(1, 12) as $month) {
            $date = now()
                ->setYear($selectedYear)
                ->setMonth($month)
                ->startOfMonth();

            $labels[] = $date->translatedFormat('M');

            $data[] = (int) $this->revenueQuery()
                ->whereYear('confirmed_at', $selectedYear)
                ->whereMonth('confirmed_at', $month)
                ->sum('total_price');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan Tahun ' . $selectedYear,
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

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        $years = $this->availableYears();

        if ($years === []) {
            return [
                (string) now()->year => (string) now()->year,
            ];
        }

        return $years;
    }

    private function getSelectedYear(): int
    {
        if ($this->filter !== null) {
            return (int) $this->filter;
        }

        $latestYear = $this->revenueQuery()
            ->selectRaw('YEAR(confirmed_at) as year')
            ->orderByDesc('year')
            ->value('year');

        return $latestYear ? (int) $latestYear : (int) now()->year;
    }

    private function availableYears(): array
    {
        return $this->revenueQuery()
            ->selectRaw('YEAR(confirmed_at) as year')
            ->groupByRaw('YEAR(confirmed_at)')
            ->orderByDesc('year')
            ->pluck('year')
            ->mapWithKeys(fn ($year): array => [
                (string) $year => (string) $year,
            ])
            ->all();
    }

    private function revenueQuery(): Builder
    {
        return Order::query()
            ->where('status', 'confirmed')
            ->whereNotNull('confirmed_at');
    }
}