<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Berandas;

use UnitEnum;
use BackedEnum;
use App\Models\Beranda;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\Berandas\Pages\EditBeranda;
use App\Filament\Admin\Resources\Berandas\Pages\ViewBeranda;
use App\Filament\Admin\Resources\Berandas\Pages\ListBerandas;
use App\Filament\Admin\Resources\Berandas\Pages\CreateBeranda;
use App\Filament\Admin\Resources\Berandas\Schemas\BerandaForm;
use App\Filament\Admin\Resources\Berandas\Tables\BerandasTable;

class BerandaResource extends Resource
{
    protected static ?string $model = Beranda::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected static string | UnitEnum | null $navigationGroup = 'Frontend Management';

    protected static ?string $navigationLabel = 'Beranda';

    protected static ?string $modelLabel = 'Beranda';

    protected static ?string $pluralModelLabel = 'Beranda List';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title_2';

    public static function form(Schema $schema): Schema
    {
        return BerandaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BerandasTable::configure($table);
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
            'index' => ListBerandas::route('/'),
            'create' => CreateBeranda::route('/create'),
            'view' => ViewBeranda::route('/{record}'),
            'edit' => EditBeranda::route('/{record}/edit'),
        ];
    }
}