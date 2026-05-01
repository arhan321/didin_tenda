<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\CustomItems\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Utilities\Set;

class CustomItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Custom Item')
                    ->description('Data item custom yang dapat dipilih pelanggan pada paket custom.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->placeholder('Contoh: Sound System')
                            ->required()
                            ->maxLength(255)
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                $set('slug', Str::slug($state ?? ''));
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->placeholder('Otomatis mengikuti nama item')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(true),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Contoh: Sound system lengkap untuk kebutuhan acara.')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Harga & Quantity')
                    ->description('Atur harga, satuan, minimal quantity, dan maksimal quantity.')
                    ->schema([
                        TextInput::make('price')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->prefix('Rp'),

                        TextInput::make('unit')
                            ->label('Unit')
                            ->required()
                            ->default('pcs')
                            ->placeholder('pcs / set / meter / unit'),

                        TextInput::make('min_quantity')
                            ->label('Min Qty')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),

                        TextInput::make('max_quantity')
                            ->label('Max Qty')
                            ->numeric()
                            ->minValue(0)
                            ->nullable()
                            ->placeholder('Kosongkan jika tidak dibatasi'),
                    ])
                    ->columns(4),

                Section::make('Gambar & Icon')
                    ->description('Upload gambar custom item dan isi icon jika digunakan di frontend.')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar')
                            ->image()
                            ->disk('public')
                            ->directory('custom-items')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->helperText('Rekomendasi ukuran 600x400 px. Maksimal 2 MB.'),

                        TextInput::make('icon')
                            ->label('Icon')
                            ->placeholder('Contoh: bi-speaker')
                            ->maxLength(255)
                            ->helperText('Isi class icon Bootstrap, misalnya bi-speaker, bi-table, bi-lightbulb.'),
                    ])
                    ->columns(2),

                Section::make('Pengaturan')
                    ->description('Atur status aktif dan urutan tampil custom item.')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->required(),

                        TextInput::make('sort_order')
                            ->label('Sort')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}