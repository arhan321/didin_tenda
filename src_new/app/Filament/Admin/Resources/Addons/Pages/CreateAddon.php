<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Addons\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\Addons\AddonResource;

class CreateAddon extends CreateRecord
{
    protected static string $resource = AddonResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Addon berhasil ditambahkan';
    }
}