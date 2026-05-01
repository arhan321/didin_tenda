<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Galeries\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\Galeries\GaleryResource;

class ListGaleries extends ListRecords
{
    protected static string $resource = GaleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Galeri')
                ->icon('heroicon-o-plus'),
        ];
    }
}