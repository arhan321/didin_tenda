<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Berandas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class BerandaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Hero Beranda')
                    ->description('Data ini digunakan untuk tampilan utama halaman depan website.')
                    ->schema([
                        TextInput::make('title_1')
                            ->label('Title 1')
                            ->placeholder('Contoh: Sejak 1996 • Terpercaya')
                            ->maxLength(255)
                            ->nullable(),

                        TextInput::make('title_2')
                            ->label('Title 2')
                            ->placeholder('Contoh: Sewakan Tenda & Dekorasi Impian untuk Acara Istimewa Anda')
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpanFull(),

                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->placeholder('Contoh: Booking online 24/7, cek ketersediaan real-time, dan pembayaran aman via berbagai metode.')
                            ->rows(5)
                            ->nullable()
                            ->columnSpanFull(),

                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->disk('public')
                            ->directory('beranda')
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