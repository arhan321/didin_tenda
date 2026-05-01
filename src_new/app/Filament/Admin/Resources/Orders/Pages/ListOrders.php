<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Orders\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\Orders\OrderResource;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('resetFilters')
                ->label('Reset Filters')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->url(fn (): string => OrderResource::getUrl('index')),

            CreateAction::make()
                ->label('Tambah Order')
                ->icon('heroicon-o-plus'),
        ];
    }
}