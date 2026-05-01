<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Footers\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Admin\Resources\Footers\FooterResource;

class ListFooters extends ListRecords
{
    protected static string $resource = FooterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Footer')
                ->icon('heroicon-o-plus'),
        ];
    }
}