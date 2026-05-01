<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Berandas\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\Berandas\BerandaResource;

class ListBerandas extends ListRecords
{
    protected static string $resource = BerandaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Beranda')
                ->icon('heroicon-o-plus'),
        ];
    }
}