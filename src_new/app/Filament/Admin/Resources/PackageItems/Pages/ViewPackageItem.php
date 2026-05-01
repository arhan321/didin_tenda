<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PackageItems\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Admin\Resources\PackageItems\PackageItemResource;

class ViewPackageItem extends ViewRecord
{
    protected static string $resource = PackageItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit Item Paket'),

            DeleteAction::make()
                ->label('Hapus Item Paket'),
        ];
    }
}