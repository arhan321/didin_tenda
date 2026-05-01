<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrderAddons;

use UnitEnum;
use BackedEnum;
use App\Models\OrderAddon;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\OrderAddons\Pages\EditOrderAddon;
use App\Filament\Admin\Resources\OrderAddons\Pages\ViewOrderAddon;
use App\Filament\Admin\Resources\OrderAddons\Pages\ListOrderAddons;
use App\Filament\Admin\Resources\OrderAddons\Pages\CreateOrderAddon;
use App\Filament\Admin\Resources\OrderAddons\Schemas\OrderAddonForm;
use App\Filament\Admin\Resources\OrderAddons\Tables\OrderAddonsTable;

class OrderAddonResource extends Resource
{
    protected static ?string $model = OrderAddon::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string | UnitEnum | null $navigationGroup = 'Order Management';

    protected static ?string $navigationLabel = 'Order Addon';

    protected static ?string $modelLabel = 'Order Addon';

    protected static ?string $pluralModelLabel = 'Order Addon List';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrderAddonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrderAddonsTable::configure($table);
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
            'index' => ListOrderAddons::route('/'),
            'create' => CreateOrderAddon::route('/create'),
            'view' => ViewOrderAddon::route('/{record}'),
            'edit' => EditOrderAddon::route('/{record}/edit'),
        ];
    }
}