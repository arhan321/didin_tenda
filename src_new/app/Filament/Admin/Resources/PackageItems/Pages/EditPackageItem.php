<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PackageItems\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\PackageItems\PackageItemResource;

class EditPackageItem extends EditRecord
{
    protected static string $resource = PackageItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Item Paket'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Item paket berhasil diperbarui';
    }
}