<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\CustomItems\Pages;

use App\Filament\Admin\Resources\CustomItems\CustomItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomItem extends CreateRecord
{
    protected static string $resource = CustomItemResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Custom item berhasil ditambahkan';
    }
}