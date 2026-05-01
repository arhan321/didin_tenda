<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Galeries\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Admin\Resources\Galeries\GaleryResource;

class ViewGalery extends ViewRecord
{
    protected static string $resource = GaleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit'),

            DeleteAction::make()
                ->label('Delete'),
        ];
    }
}