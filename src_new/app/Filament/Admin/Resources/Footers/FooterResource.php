<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Footers;

use UnitEnum;
use BackedEnum;
use App\Models\Footer;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\Footers\Pages\EditFooter;
use App\Filament\Admin\Resources\Footers\Pages\ViewFooter;
use App\Filament\Admin\Resources\Footers\Pages\ListFooters;
use App\Filament\Admin\Resources\Footers\Pages\CreateFooter;
use App\Filament\Admin\Resources\Footers\Schemas\FooterForm;
use App\Filament\Admin\Resources\Footers\Tables\FootersTable;

class FooterResource extends Resource
{
    protected static ?string $model = Footer::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-bars-3-bottom-left';

    protected static string | UnitEnum | null $navigationGroup = 'Frontend Management';

    protected static ?string $navigationLabel = 'Footer';

    protected static ?string $modelLabel = 'Footer';

    protected static ?string $pluralModelLabel = 'Footer List';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'email';

    public static function form(Schema $schema): Schema
    {
        return FooterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FootersTable::configure($table);
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
            'index' => ListFooters::route('/'),
            'create' => CreateFooter::route('/create'),
            'view' => ViewFooter::route('/{record}'),
            'edit' => EditFooter::route('/{record}/edit'),
        ];
    }
}