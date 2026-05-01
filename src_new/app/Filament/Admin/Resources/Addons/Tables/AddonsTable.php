<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Addons\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;

class AddonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query->orderBy('sort_order');
            })
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->square()
                    ->toggleable(),

                TextColumn::make('name')
                    ->label('Nama Addon')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record): ?string => $record->detail),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('unit')
                    ->label('Unit')
                    ->searchable()
                    ->placeholder('-'),

                IconColumn::make('is_quantity_based')
                    ->label('Qty Based')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->sortable()
                    ->placeholder('-')
                    ->alignCenter(),

                TextColumn::make('icon')
                    ->label('Icon')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('sort_order')
                    ->label('Sort')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

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
            // ->filters([
            //     TernaryFilter::make('is_quantity_based')
            //         ->label('Quantity Based')
            //         ->placeholder('Semua')
            //         ->trueLabel('Quantity Based')
            //         ->falseLabel('Tidak Quantity Based'),

            //     TernaryFilter::make('is_active')
            //         ->label('Status Active')
            //         ->placeholder('Semua Status')
            //         ->trueLabel('Aktif')
            //         ->falseLabel('Tidak Aktif'),
            // ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(2)
            ->recordActions([
                ViewAction::make()
                    ->label('Show'),

                EditAction::make()
                    ->label('Edit'),

                DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete selected'),
                ]),
            ])
            ->emptyStateHeading('Belum ada Addon')
            ->emptyStateDescription('Silakan tambahkan addon seperti sound system, lighting, photobooth, atau perlengkapan tambahan lainnya.')
            ->paginated([10, 25, 50, 100]);
    }
}