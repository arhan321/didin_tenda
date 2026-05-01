<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrderAddons\Schemas;

use App\Models\Addon;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class OrderAddonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Order Addon')
                    ->description('Addon tambahan yang dipilih untuk sebuah order.')
                    ->schema([
                        Select::make('order_id')
                            ->label('Order')
                            ->relationship('order', 'invoice_number')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('addon_id')
                            ->label('Addon Master')
                            ->relationship('addon', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?int $state): void {
                                if (! $state) {
                                    return;
                                }

                                $addon = Addon::find($state);

                                if (! $addon) {
                                    return;
                                }

                                $set('name', $addon->name);
                                $set('detail', $addon->detail);
                                $set('unit', $addon->unit);
                                $set('price', $addon->price);
                                $set('total_price', $addon->price);
                                $set('snapshot', [
                                    'id' => $addon->id,
                                    'name' => $addon->name,
                                    'slug' => $addon->slug,
                                    'detail' => $addon->detail,
                                    'price' => $addon->price,
                                    'unit' => $addon->unit,
                                ]);
                            }),

                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('unit')
                            ->label('Unit')
                            ->maxLength(255)
                            ->nullable(),

                        Textarea::make('detail')
                            ->label('Detail')
                            ->rows(3)
                            ->columnSpanFull()
                            ->nullable(),
                    ])
                    ->columns(2),

                Section::make('Harga & Quantity')
                    ->description('Atur jumlah, harga satuan, dan total addon.')
                    ->schema([
                        TextInput::make('quantity')
                            ->label('Qty')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get): void {
                                self::syncTotalPrice($set, $get);
                            }),

                        TextInput::make('price')
                            ->label('Price')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->prefix('Rp')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get): void {
                                self::syncTotalPrice($set, $get);
                            }),

                        TextInput::make('total_price')
                            ->label('Total')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->prefix('Rp'),
                    ])
                    ->columns(3),

                Section::make('Snapshot')
                    ->description('Data snapshot addon saat order dibuat.')
                    ->schema([
                        Textarea::make('snapshot')
                            ->label('Snapshot')
                            ->rows(5)
                            ->formatStateUsing(fn ($state): ?string => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $state)
                            ->dehydrateStateUsing(fn ($state): ?array => filled($state) ? json_decode($state, true) : null)
                            ->columnSpanFull()
                            ->nullable(),
                    ]),
            ]);
    }

    private static function syncTotalPrice(Set $set, Get $get): void
    {
        $quantity = (int) ($get('quantity') ?: 0);
        $price = (int) ($get('price') ?: 0);

        $set('total_price', $quantity * $price);
    }
}