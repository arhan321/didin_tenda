<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;

final class WeeklyRevenueChart extends ChartWidget
{
    protected ?string $heading = 'Pendapatan Minggu Ini';

    protected ?string $description = 'Pendapatan harian dari order confirmed';

    protected ?string $maxHeight = '300px';

    protected static ?int $sort = 10;

    public function getColumnSpan(): int | string | array
    {
        return 'full';
    }

//     public function getColumnSpan(): int | string | array
// {
//     return 1;
// }

    protected function getData(): array
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

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan Minggu Ini',
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