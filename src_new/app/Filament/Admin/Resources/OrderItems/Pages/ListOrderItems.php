<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrderItems\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\OrderItems\OrderItemResource;

class ListOrderItems extends ListRecords
{
    protected static string $resource = OrderItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('resetFilters')
                ->label('Reset Filters')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->url(fn (): string => OrderItemResource::getUrl('index')),

            CreateAction::make()
                ->label('Tambah Order Item')
                ->icon('heroicon-o-plus'),
        ];
    }
}