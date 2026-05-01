<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Galeries\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\Galeries\GaleryResource;

class EditGalery extends EditRecord
{
    protected static string $resource = GaleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Galeri berhasil diperbarui';
    }
}