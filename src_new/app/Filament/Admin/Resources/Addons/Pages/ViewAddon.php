<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Addons\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Admin\Resources\Addons\AddonResource;

class ViewAddon extends ViewRecord
{
    protected static string $resource = AddonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit Addon'),

            DeleteAction::make()
                ->label('Hapus Addon'),
        ];
    }
}