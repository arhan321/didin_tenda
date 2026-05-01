<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrderAddons\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\OrderAddons\OrderAddonResource;

class CreateOrderAddon extends CreateRecord
{
    protected static string $resource = OrderAddonResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Order addon berhasil ditambahkan';
    }
}