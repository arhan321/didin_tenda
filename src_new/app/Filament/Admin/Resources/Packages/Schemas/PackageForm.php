<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Packages\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Utilities\Set;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Paket')
                    ->description('Data utama paket dekorasi yang akan tampil di halaman website.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Paket')
                            ->placeholder('Contoh: Paket Wedding Premium')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                $set('slug', Str::slug($state ?? ''));
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->placeholder('Otomatis mengikuti nama paket')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(true),

                        Select::make('type')
                            ->label('Tipe Paket')
                            ->options([
                                'fixed' => 'Fixed',
                                'custom' => 'Custom ',
                            ])
                            ->default('fixed')
                            ->required(),

                        TextInput::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->placeholder('Contoh: Paket dekorasi lengkap untuk acara pernikahan')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Deskripsi Lengkap')
                            ->placeholder('Jelaskan detail paket, fasilitas, dan ketentuan paket.')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Harga & Tampilan')
                    ->description('Atur harga, satuan harga, badge, warna tema, dan status paket.')
                    ->schema([
                        TextInput::make('price')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->prefix('Rp'),

                        TextInput::make('price_unit')
                            ->label('Satuan Harga')
                            ->required()
                            ->default('paket')
                            ->placeholder('paket'),

                        TextInput::make('badge')
                            ->label('Badge')
                            ->placeholder('Best Seller / Hemat / Premium')
                            ->maxLength(255),

                        // ColorPicker::make('color')
                        //     ->label('Warna Tema'),

                        Toggle::make('is_popular')
                            ->label('Paket Populer')
                            ->default(false)
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->required(),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                    ])
                    ->columns(3),

                Section::make('Gambar Paket')
                    ->description('Upload gambar utama dan galeri paket. Pastikan sudah menjalankan php artisan storage:link.')
                    ->schema([
                        FileUpload::make('main_image')
                            ->label('Gambar Utama')
                            ->image()
                            ->disk('public')
                            ->directory('packages/main')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->helperText('Rekomendasi ukuran 800x500 px. Maksimal 2 MB.'),

                        FileUpload::make('images')
                            ->label('Galeri Gambar')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->disk('public')
                            ->directory('packages/gallery')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->helperText('Bisa upload beberapa gambar untuk galeri paket.'),
                    ])
                    ->columns(2),
            ]);
    }
}