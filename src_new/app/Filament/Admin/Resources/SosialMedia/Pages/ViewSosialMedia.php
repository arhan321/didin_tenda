<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SosialMedia\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Admin\Resources\SosialMedia\SosialMediaResource;

class ViewSosialMedia extends ViewRecord
{
    protected static string $resource = SosialMediaResource::class;

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