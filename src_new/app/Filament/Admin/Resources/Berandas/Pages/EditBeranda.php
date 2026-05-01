<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Berandas\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\Berandas\BerandaResource;

class EditBeranda extends EditRecord
{
    protected static string $resource = BerandaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Beranda berhasil diperbarui';
    }
}