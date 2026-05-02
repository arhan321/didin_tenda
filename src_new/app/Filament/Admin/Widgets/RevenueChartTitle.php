<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

final class RevenueChartTitle extends Widget
{
    protected string $view = 'filament.admin.widgets.revenue-chart-title';

    protected static ?int $sort = 9;

    public function getColumnSpan(): int | string | array
    {
        return 'full';
    }
}