<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Galeries\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\Galeries\GaleryResource;

class CreateGalery extends CreateRecord
{
    protected static string $resource = GaleryResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Galeri berhasil ditambahkan';
    }
}