<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrderAddons\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\OrderAddons\OrderAddonResource;

class EditOrderAddon extends EditRecord
{
    protected static string $resource = OrderAddonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Order addon berhasil diperbarui';
    }
}