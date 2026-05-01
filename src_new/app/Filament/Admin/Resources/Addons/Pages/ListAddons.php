<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Addons\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\Addons\AddonResource;

class ListAddons extends ListRecords
{
    protected static string $resource = AddonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('resetFilters')
                ->label('Reset Filters')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->url(fn (): string => AddonResource::getUrl('index')),

            CreateAction::make()
                ->label('Tambah Addon')
                ->icon('heroicon-o-plus'),
        ];
    }
}