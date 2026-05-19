<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Widgets\Concerns\OnlySuperAdminWidget;

final class MonthlyRevenueChart extends ChartWidget
{
    use OnlySuperAdminWidget;

    protected ?string $heading = 'Pendapatan Bulan Ini';

    protected ?string $description = 'Pendapatan mingguan dari order confirmed';

    protected ?string $maxHeight = '300px';

    protected static ?int $sort = 11;

    protected function getData(): array
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

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan Bulan Ini',
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

    private function revenueQuery(): Builder
    {
        return Order::query()
            ->where('status', 'confirmed')
            ->whereNotNull('confirmed_at');
    }
}