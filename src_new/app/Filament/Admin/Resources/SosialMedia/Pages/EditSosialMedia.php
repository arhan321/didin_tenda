<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SosialMedia\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\SosialMedia\SosialMediaResource;

class EditSosialMedia extends EditRecord
{
    protected static string $resource = SosialMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Sosial media berhasil diperbarui';
    }
}