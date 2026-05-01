<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Order')
                    ->description('Data utama pesanan pelanggan.')
                    ->schema([
                        TextInput::make('invoice_number')
                            ->label('Invoice')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Select::make('package_id')
                            ->label('Package')
                            ->relationship('package', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Select::make('order_type')
                            ->label('Type')
                            ->options([
                                'package' => 'Package',
                                'custom' => 'Custom',
                            ])
                            ->default('package')
                            ->required(),
                    ])
                    ->columns(4),

                Section::make('Data Customer')
                    ->description('Informasi pelanggan yang melakukan booking.')
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Customer')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('customer_phone')
                            ->label('Phone')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('customer_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255)
                            ->nullable(),
                    ])
                    ->columns(3),

                Section::make('Data Acara')
                    ->description('Tanggal dan lokasi acara pelanggan.')
                    ->schema([
                        DatePicker::make('event_date')
                            ->label('Event Date')
                            ->required()
                            ->native(false),

                        TextInput::make('event_location_name')
                            ->label('Nama Lokasi')
                            ->maxLength(255)
                            ->nullable(),

                        TextInput::make('event_latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->nullable(),

                        TextInput::make('event_longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->nullable(),

                        TextInput::make('distance_km')
                            ->label('Distance KM')
                            ->numeric()
                            ->nullable(),

                        Textarea::make('event_address')
                            ->label('Alamat Acara')
                            ->rows(4)
                            ->columnSpanFull()
                            ->nullable(),
                    ])
                    ->columns(3),

                Section::make('Harga')
                    ->description('Subtotal dan total pembayaran order.')
                    ->schema([
                        TextInput::make('subtotal_package')
                            ->label('Subtotal Package')
                            ->numeric()
                            ->default(0)
                            ->prefix('Rp')
                            ->required(),

                        TextInput::make('subtotal_custom')
                            ->label('Subtotal Custom')
                            ->numeric()
                            ->default(0)
                            ->prefix('Rp')
                            ->required(),

                        TextInput::make('subtotal_addons')
                            ->label('Subtotal Addons')
                            ->numeric()
                            ->default(0)
                            ->prefix('Rp')
                            ->required(),

                        TextInput::make('shipping_fee')
                            ->label('Shipping Fee')
                            ->numeric()
                            ->default(0)
                            ->prefix('Rp')
                            ->required(),

                        TextInput::make('total_price')
                            ->label('Total')
                            ->numeric()
                            ->default(0)
                            ->prefix('Rp')
                            ->required(),
                    ])
                    ->columns(5),

                Section::make('Status')
                    ->description('Status order dan pembayaran.')
                    ->schema([
                        Select::make('status')
                            ->label('Status Order')
                            ->options([
                                'waiting_payment' => 'Waiting Payment',
                                'confirmed' => 'Confirmed',
                                'processed' => 'Processed',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('waiting_payment')
                            ->required(),

                        Select::make('payment_status')
                            ->label('Payment')
                            ->options([
                                'unpaid' => 'Unpaid',
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'expired' => 'Expired',
                                'failed' => 'Failed',
                                'cancelled' => 'Cancelled',
                                'refunded' => 'Refunded',
                            ])
                            ->default('unpaid')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Waktu Penting')
                    ->description('Timestamp proses order dan pembayaran.')
                    ->schema([
                        DateTimePicker::make('payment_deadline')
                            ->label('Payment Deadline')
                            ->native(false)
                            ->nullable(),

                        DateTimePicker::make('paid_at')
                            ->label('Paid At')
                            ->native(false)
                            ->nullable(),

                        DateTimePicker::make('confirmed_at')
                            ->label('Confirmed At')
                            ->native(false)
                            ->nullable(),

                        DateTimePicker::make('invoice_sent_at')
                            ->label('Invoice Sent At')
                            ->native(false)
                            ->nullable(),

                        DateTimePicker::make('processed_at')
                            ->label('Processed At')
                            ->native(false)
                            ->nullable(),

                        DateTimePicker::make('completed_at')
                            ->label('Completed At')
                            ->native(false)
                            ->nullable(),

                        DateTimePicker::make('cancelled_at')
                            ->label('Cancelled At')
                            ->native(false)
                            ->nullable(),
                    ])
                    ->columns(3),

                Section::make('Catatan')
                    ->description('Alasan pembatalan dan catatan tambahan.')
                    ->schema([
                        Textarea::make('cancelled_reason')
                            ->label('Cancelled Reason')
                            ->rows(4)
                            ->nullable(),

                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(4)
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }
}