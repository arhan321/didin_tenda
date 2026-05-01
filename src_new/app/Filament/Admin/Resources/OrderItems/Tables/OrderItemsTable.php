<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrderItems\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class OrderItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query
                    ->with('order')
                    ->latest('id');
            })
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('order.invoice_number')
                    ->label('Invoice')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->description(fn ($record): ?string => $record->order?->customer_name),

                TextColumn::make('order.customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('item_type')
                    ->label('Item Type')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'package' => 'Package',
                        'custom' => 'Custom',
                        'addon' => 'Addon',
                        default => ucfirst((string) $state),
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'package' => 'info',
                        'custom' => 'success',
                        'addon' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('source_id')
                    ->label('Source ID')
                    ->numeric()
                    ->sortable()
                    ->placeholder('-')
                    ->alignCenter(),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('unit')
                    ->label('Unit')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('quantity')
                    ->label('Qty')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold'),

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
                SelectFilter::make('order_id')
                    ->label('Semua Order')
                    ->placeholder('Semua Order')
                    ->relationship('order', 'invoice_number')
                    ->searchable()
                    ->preload()
                    ->native(false),

                SelectFilter::make('item_type')
                    ->label('Semua Type')
                    ->placeholder('Semua Type')
                    ->options([
                        'package' => 'Package',
                        'custom' => 'Custom',
                        'addon' => 'Addon',
                    ])
                    ->native(false),
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(2)
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
            ->emptyStateHeading('Belum ada Order Item')
            ->emptyStateDescription('Item pesanan pelanggan akan tampil di halaman ini.')
            ->paginated([10, 25, 50, 100]);
    }
}