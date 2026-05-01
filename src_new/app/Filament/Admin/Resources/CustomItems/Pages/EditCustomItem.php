<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\CustomItems\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\CustomItems\CustomItemResource;

class EditCustomItem extends EditRecord
{
    protected static string $resource = CustomItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Custom item berhasil diperbarui';
    }
}