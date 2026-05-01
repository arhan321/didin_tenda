<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PackageItems\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class PackageItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Item Paket')
                    ->description('Data item atau fasilitas yang termasuk dalam paket dekorasi.')
                    ->schema([
                        Select::make('package_id')
                            ->label('Paket Dekorasi')
                            ->relationship('package', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('name')
                            ->label('Nama Item')
                            ->placeholder('Contoh: Kursi Tamu')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('quantity')
                            ->label('Jumlah')
                            ->placeholder('Contoh: 200')
                            ->numeric()
                            ->minValue(0)
                            ->nullable(),

                        TextInput::make('unit')
                            ->label('Satuan')
                            ->placeholder('pcs / set / meter')
                            ->maxLength(255)
                            ->nullable(),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Jelaskan detail item paket ini.')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Pengaturan')
                    ->description('Atur status dan urutan tampil item paket.')
                    ->schema([
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
                    ->columns(2),
            ]);
    }
}