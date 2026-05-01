<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Orders\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\Orders\OrderResource;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Order berhasil ditambahkan';
    }
}