<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrderItems\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class OrderItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Order Item')
                    ->description('Item utama yang masuk ke dalam pesanan pelanggan.')
                    ->schema([
                        Select::make('order_id')
                            ->label('Order')
                            ->relationship('order', 'invoice_number')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('item_type')
                            ->label('Item Type')
                            ->options([
                                'package' => 'Package',
                                'custom' => 'Custom',
                                'addon' => 'Addon',
                            ])
                            ->default('package')
                            ->required()
                            ->native(false),

                        TextInput::make('source_id')
                            ->label('Source ID')
                            ->numeric()
                            ->nullable()
                            ->helperText('ID sumber item, misalnya ID package, custom item, atau addon.'),

                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('unit')
                            ->label('Unit')
                            ->maxLength(255)
                            ->nullable(),

                        Textarea::make('snapshot')
                            ->label('Snapshot')
                            ->rows(5)
                            ->formatStateUsing(function ($state): ?string {
                                if (is_array($state)) {
                                    return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                }

                                return $state;
                            })
                            ->dehydrateStateUsing(function ($state): ?array {
                                if (blank($state)) {
                                    return null;
                                }

                                $decoded = json_decode($state, true);

                                return is_array($decoded) ? $decoded : null;
                            })
                            ->columnSpanFull()
                            ->nullable(),
                    ])
                    ->columns(3),

                Section::make('Harga & Quantity')
                    ->description('Atur quantity, harga satuan, dan total harga item.')
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
            ]);
    }

    private static function syncTotalPrice(Set $set, Get $get): void
    {
        $quantity = (int) ($get('quantity') ?: 0);
        $price = (int) ($get('price') ?: 0);

        $set('total_price', $quantity * $price);
    }
}