<?php

namespace App\Filament\Admin\Resources\SosialMedia\Pages;

use App\Filament\Admin\Resources\SosialMedia\SosialMediaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSosialMedia extends ListRecords
{
    protected static string $resource = SosialMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
