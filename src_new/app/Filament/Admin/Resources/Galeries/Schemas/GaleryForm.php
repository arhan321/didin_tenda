<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Galeries\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class GaleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Galeri')
                    ->description('Data ini digunakan untuk menampilkan galeri pada halaman frontend.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('Contoh: Dekorasi Wedding Outdoor')
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpanFull(),

                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->placeholder('Contoh: Dokumentasi dekorasi tenda untuk acara pernikahan outdoor.')
                            ->rows(4)
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->disk('public')
                            ->directory('galeries')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(3072)
                            ->helperText('Rekomendasi ukuran 1200x800 px. Maksimal 3 MB.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}