<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrderItems\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\OrderItems\OrderItemResource;

class CreateOrderItem extends CreateRecord
{
    protected static string $resource = OrderItemResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Order item berhasil ditambahkan';
    }
}