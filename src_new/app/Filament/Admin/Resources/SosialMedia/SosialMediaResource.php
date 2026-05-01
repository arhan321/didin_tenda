<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SosialMedia;

use UnitEnum;
use BackedEnum;
use Filament\Tables\Table;
use App\Models\SosialMedia;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\SosialMedia\Pages\EditSosialMedia;
use App\Filament\Admin\Resources\SosialMedia\Pages\ListSosialMedia;
use App\Filament\Admin\Resources\SosialMedia\Pages\ViewSosialMedia;
use App\Filament\Admin\Resources\SosialMedia\Pages\CreateSosialMedia;
use App\Filament\Admin\Resources\SosialMedia\Schemas\SosialMediaForm;
use App\Filament\Admin\Resources\SosialMedia\Tables\SosialMediaTable;

class SosialMediaResource extends Resource
{
    protected static ?string $model = SosialMedia::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-link';

    protected static string | UnitEnum | null $navigationGroup = 'Frontend Management';

    protected static ?string $navigationLabel = 'Sosial Media';

    protected static ?string $modelLabel = 'Sosial Media';

    protected static ?string $pluralModelLabel = 'Sosial Media List';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'link';

    public static function form(Schema $schema): Schema
    {
        return SosialMediaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SosialMediaTable::configure($table);
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
            'index' => ListSosialMedia::route('/'),
            'create' => CreateSosialMedia::route('/create'),
            'view' => ViewSosialMedia::route('/{record}'),
            'edit' => EditSosialMedia::route('/{record}/edit'),
        ];
    }
}