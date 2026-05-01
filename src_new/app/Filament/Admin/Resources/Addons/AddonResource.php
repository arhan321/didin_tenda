<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Addons;

use UnitEnum;
use BackedEnum;
use App\Models\Addon;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\Addons\Pages\EditAddon;
use App\Filament\Admin\Resources\Addons\Pages\ViewAddon;
use App\Filament\Admin\Resources\Addons\Pages\ListAddons;
use App\Filament\Admin\Resources\Addons\Pages\CreateAddon;
use App\Filament\Admin\Resources\Addons\Schemas\AddonForm;
use App\Filament\Admin\Resources\Addons\Tables\AddonsTable;

class AddonResource extends Resource
{
    protected static ?string $model = Addon::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-plus-circle';

    protected static string | UnitEnum | null $navigationGroup = 'Addon Management';

    protected static ?string $navigationLabel = 'Addon';

    protected static ?string $modelLabel = 'Addon';

    protected static ?string $pluralModelLabel = 'Addon List';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AddonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AddonsTable::configure($table);
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
            'index' => ListAddons::route('/'),
            'create' => CreateAddon::route('/create'),
            'view' => ViewAddon::route('/{record}'),
            'edit' => EditAddon::route('/{record}/edit'),
        ];
    }
}