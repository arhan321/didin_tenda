<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrderAddons\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\OrderAddons\OrderAddonResource;

class ListOrderAddons extends ListRecords
{
    protected static string $resource = OrderAddonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('resetFilters')
                ->label('Reset Filters')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->url(fn (): string => OrderAddonResource::getUrl('index')),

            CreateAction::make()
                ->label('Tambah Order Addon')
                ->icon('heroicon-o-plus'),
        ];
    }
}