<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Addons\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Utilities\Set;

class AddonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Addon')
                    ->description('Data addon tambahan yang bisa dipilih pelanggan saat booking.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Addon')
                            ->placeholder('Contoh: Sound System')
                            ->required()
                            ->maxLength(255)
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                $set('slug', Str::slug($state ?? ''));
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->placeholder('Otomatis mengikuti nama addon')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(true),

                        Textarea::make('detail')
                            ->label('Detail')
                            ->placeholder('Jelaskan detail addon ini.')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Harga & Stok')
                    ->description('Atur harga, satuan, stok, dan apakah addon menggunakan jumlah.')
                    ->schema([
                        TextInput::make('price')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->prefix('Rp'),

                        TextInput::make('unit')
                            ->label('Satuan')
                            ->required()
                            ->default('pcs')
                            ->placeholder('pcs / set / unit'),

                        Toggle::make('is_quantity_based')
                            ->label('Quantity Based')
                            ->default(true)
                            ->required(),

                        TextInput::make('stock')
                            ->label('Stok')
                            ->numeric()
                            ->minValue(0)
                            ->nullable()
                            ->placeholder('Kosongkan jika tidak dibatasi'),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(3),

                Section::make('Gambar & Icon')
                    ->description('Upload gambar addon dan isi icon Bootstrap jika digunakan di frontend.')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar Addon')
                            ->image()
                            ->disk('public')
                            ->directory('addons')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->helperText('Rekomendasi ukuran 600x400 px. Maksimal 2 MB.'),

                        TextInput::make('icon')
                            ->label('Icon')
                            ->placeholder('Contoh: bi-speaker')
                            ->maxLength(255)
                            ->helperText('Isi class icon Bootstrap, misalnya bi-speaker, bi-camera, bi-lightbulb.'),
                    ])
                    ->columns(2),
            ]);
    }
}