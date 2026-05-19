<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use App\Filament\Widgets\Concerns\OnlySuperAdminWidget;

final class RevenueChartTitle extends Widget
{
    use OnlySuperAdminWidget;

    protected string $view = 'filament.admin.widgets.revenue-chart-title';

    protected static ?int $sort = 9;

    public function getColumnSpan(): int | string | array
    {
        return 'full';
    }
}