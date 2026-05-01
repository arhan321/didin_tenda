<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PackageItems;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use App\Models\PackageItem;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Admin\Resources\PackageItems\Pages\EditPackageItem;
use App\Filament\Admin\Resources\PackageItems\Pages\ViewPackageItem;
use App\Filament\Admin\Resources\PackageItems\Pages\ListPackageItems;
use App\Filament\Admin\Resources\PackageItems\Pages\CreatePackageItem;
use App\Filament\Admin\Resources\PackageItems\Schemas\PackageItemForm;
use App\Filament\Admin\Resources\PackageItems\Tables\PackageItemsTable;

class PackageItemResource extends Resource
{
    protected static ?string $model = PackageItem::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Paket';

    protected static ?string $navigationLabel = 'Item Paket';

    protected static ?string $modelLabel = 'Package Item';

    protected static ?string $pluralModelLabel = 'Package Item List';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PackageItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PackageItemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPackageItems::route('/'),
            'create' => CreatePackageItem::route('/create'),
            'view' => ViewPackageItem::route('/{record}'),
            'edit' => EditPackageItem::route('/{record}/edit'),
        ];
    }
}