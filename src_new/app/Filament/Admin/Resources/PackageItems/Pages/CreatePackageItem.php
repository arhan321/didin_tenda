<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PackageItems\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\PackageItems\PackageItemResource;

class CreatePackageItem extends CreateRecord
{
    protected static string $resource = PackageItemResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Item paket berhasil ditambahkan';
    }
}