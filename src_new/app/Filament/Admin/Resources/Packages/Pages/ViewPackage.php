<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Packages\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Admin\Resources\Packages\PackageResource;
use App\Filament\Admin\Resources\PackageItems\PackageItemResource;

class ViewPackage extends ViewRecord
{
    protected static string $resource = PackageResource::class;

    protected string $view = 'filament.admin.resources.packages.pages.view-package';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit'),

            DeleteAction::make()
                ->label('Hapus'),
        ];
    }

    public function getPackageItems(): Collection
    {
        return $this->record
            ->items()
            ->orderBy('sort_order')
            ->get();
    }

    public function getCreatePackageItemUrl(): string
    {
        return PackageItemResource::getUrl('create', [
            'package_id' => $this->record->getKey(),
        ]);
    }

    public function getPackageItemsIndexUrl(): string
    {
        return PackageItemResource::getUrl('index', [
            'tableFilters' => [
                'package_id' => [
                    'value' => $this->record->getKey(),
                ],
            ],
        ]);
    }

    public function getPackageItemViewUrl(int|string $itemId): string
    {
        return PackageItemResource::getUrl('view', [
            'record' => $itemId,
        ]);
    }

    public function getPackageItemEditUrl(int|string $itemId): string
    {
        return PackageItemResource::getUrl('edit', [
            'record' => $itemId,
        ]);
    }

    public function deletePackageItem(int|string $itemId): void
    {
        $item = $this->record
            ->items()
            ->whereKey($itemId)
            ->firstOrFail();

        $itemName = $item->name;

        $item->delete();

        Notification::make()
            ->title('Item paket berhasil dihapus')
            ->body("Item {$itemName} sudah dihapus dari paket ini.")
            ->success()
            ->send();
    }
}