<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Footers\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\Footers\FooterResource;

class EditFooter extends EditRecord
{
    protected static string $resource = FooterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete'),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Footer berhasil diperbarui';
    }
}