<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Galeries;

use UnitEnum;
use BackedEnum;
use App\Models\Galery;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\Galeries\Pages\EditGalery;
use App\Filament\Admin\Resources\Galeries\Pages\ViewGalery;
use App\Filament\Admin\Resources\Galeries\Pages\CreateGalery;
use App\Filament\Admin\Resources\Galeries\Pages\ListGaleries;
use App\Filament\Admin\Resources\Galeries\Schemas\GaleryForm;
use App\Filament\Admin\Resources\Galeries\Tables\GaleriesTable;

class GaleryResource extends Resource
{
    protected static ?string $model = Galery::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-photo';

    protected static string | UnitEnum | null $navigationGroup = 'Frontend Management';

    protected static ?string $navigationLabel = 'Galeri';

    protected static ?string $modelLabel = 'Galeri';

    protected static ?string $pluralModelLabel = 'Galeri List';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return GaleryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GaleriesTable::configure($table);
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
            'index' => ListGaleries::route('/'),
            'create' => CreateGalery::route('/create'),
            'view' => ViewGalery::route('/{record}'),
            'edit' => EditGalery::route('/{record}/edit'),
        ];
    }
}