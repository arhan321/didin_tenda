<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrderItems;

use UnitEnum;
use BackedEnum;
use App\Models\OrderItem;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\OrderItems\Pages\EditOrderItem;
use App\Filament\Admin\Resources\OrderItems\Pages\ViewOrderItem;
use App\Filament\Admin\Resources\OrderItems\Pages\ListOrderItems;
use App\Filament\Admin\Resources\OrderItems\Pages\CreateOrderItem;
use App\Filament\Admin\Resources\OrderItems\Schemas\OrderItemForm;
use App\Filament\Admin\Resources\OrderItems\Tables\OrderItemsTable;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string | UnitEnum | null $navigationGroup = 'Order Management';

    protected static ?string $navigationLabel = 'Order Item';

    protected static ?string $modelLabel = 'Order Item';

    protected static ?string $pluralModelLabel = 'Order Item List';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrderItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrderItemsTable::configure($table);
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
            'index' => ListOrderItems::route('/'),
            'create' => CreateOrderItem::route('/create'),
            'view' => ViewOrderItem::route('/{record}'),
            'edit' => EditOrderItem::route('/{record}/edit'),
        ];
    }
}