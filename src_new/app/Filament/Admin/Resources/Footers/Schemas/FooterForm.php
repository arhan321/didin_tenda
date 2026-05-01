<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Footers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class FooterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Footer')
                    ->description('Data ini digunakan untuk tampilan footer pada halaman frontend.')
                    ->schema([
                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->placeholder('Contoh: Jl. Raya Cibinong No. 10, Bogor')
                            ->rows(4)
                            ->nullable()
                            ->columnSpanFull(),

                        TextInput::make('nomor_telfon')
                            ->label('Nomor Telepon')
                            ->placeholder('Contoh: 082123456789')
                            ->tel()
                            ->maxLength(255)
                            ->nullable(),

                        TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Contoh: info@didintenda.com')
                            ->email()
                            ->maxLength(255)
                            ->nullable(),

                        TextInput::make('copyright')
                            ->label('Copyright')
                            ->placeholder('Contoh: © 2026 Didin Tenda Decoration. All rights reserved.')
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpanFull(),

                        TextInput::make('develop_by')
                            ->label('Develop By')
                            ->placeholder('Contoh: Developed by DJNCloud')
                            ->maxLength(255)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}