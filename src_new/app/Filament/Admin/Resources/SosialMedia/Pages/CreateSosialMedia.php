<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SosialMedia\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\SosialMedia\SosialMediaResource;

class CreateSosialMedia extends CreateRecord
{
    protected static string $resource = SosialMediaResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Sosial media berhasil ditambahkan';
    }
}