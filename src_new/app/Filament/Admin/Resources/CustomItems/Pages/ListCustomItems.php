<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\CustomItems\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\CustomItems\CustomItemResource;

class ListCustomItems extends ListRecords
{
    protected static string $resource = CustomItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('resetFilters')
                ->label('Reset Filters')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->url(fn (): string => CustomItemResource::getUrl('index')),

            CreateAction::make()
                ->label('Tambah Custom Item')
                ->icon('heroicon-o-plus'),
        ];
    }
}