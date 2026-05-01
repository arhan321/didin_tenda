<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Berandas\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;

class BerandasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query->latest('id');
            })
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('title_1')
                    ->label('Title 1')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->placeholder('-'),

                TextColumn::make('title_2')
                    ->label('Title 2')
                    ->searchable()
                    ->sortable()
                    ->limit(70)
                    ->weight('bold')
                    ->placeholder('-'),

                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->searchable()
                    ->limit(80)
                    ->wrap()
                    ->placeholder('-'),

                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->square()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('View'),

                EditAction::make()
                    ->label('Edit'),

                DeleteAction::make()
                    ->label('Delete'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete selected'),
                ]),
            ])
            ->emptyStateHeading('Belum ada data Beranda')
            ->emptyStateDescription('Silakan tambahkan konten hero beranda untuk halaman depan website.')
            ->paginated([10, 25, 50, 100]);
    }
}