<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PackageItems\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\PackageItems\PackageItemResource;

class ListPackageItems extends ListRecords
{
    protected static string $resource = PackageItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('resetFilters')
                ->label('Reset Filters')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->url(fn (): string => PackageItemResource::getUrl('index')),

            CreateAction::make()
                ->label('Tambah Package Item')
                ->icon('heroicon-o-plus'),
        ];
    }
}