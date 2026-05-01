<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Footers\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\Footers\FooterResource;

class CreateFooter extends CreateRecord
{
    protected static string $resource = FooterResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Footer berhasil ditambahkan';
    }
}