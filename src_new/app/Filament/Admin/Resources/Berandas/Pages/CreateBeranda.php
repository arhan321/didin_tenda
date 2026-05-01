<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Berandas\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\Berandas\BerandaResource;

class CreateBeranda extends CreateRecord
{
    protected static string $resource = BerandaResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Beranda berhasil ditambahkan';
    }
}