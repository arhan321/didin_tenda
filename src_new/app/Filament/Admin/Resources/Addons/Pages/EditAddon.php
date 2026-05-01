<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Addons\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\Addons\AddonResource;

class EditAddon extends EditRecord
{
    protected static string $resource = AddonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus Addon'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Addon berhasil diperbarui';
    }
}