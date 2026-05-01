<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\CustomItems;

use UnitEnum;
use BackedEnum;
use App\Models\CustomItem;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\CustomItems\Pages\EditCustomItem;
use App\Filament\Admin\Resources\CustomItems\Pages\ViewCustomItem;
use App\Filament\Admin\Resources\CustomItems\Pages\ListCustomItems;
use App\Filament\Admin\Resources\CustomItems\Pages\CreateCustomItem;
use App\Filament\Admin\Resources\CustomItems\Schemas\CustomItemForm;
use App\Filament\Admin\Resources\CustomItems\Tables\CustomItemsTable;

class CustomItemResource extends Resource
{
    protected static ?string $model = CustomItem::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static string | UnitEnum | null $navigationGroup = 'Custom Item Management';

    protected static ?string $navigationLabel = 
    'Paket Custom';

    protected static ?string $modelLabel = 'Custom Item';

    protected static ?string $pluralModelLabel = 'Manajemen Custom Item';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CustomItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomItemsTable::configure($table);
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
            'index' => ListCustomItems::route('/'),
            'create' => CreateCustomItem::route('/create'),
            'view' => ViewCustomItem::route('/{record}'),
            'edit' => EditCustomItem::route('/{record}/edit'),
        ];
    }
}