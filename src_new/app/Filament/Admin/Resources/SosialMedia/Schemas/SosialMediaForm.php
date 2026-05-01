<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SosialMedia\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class SosialMediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Sosial Media')
                    ->description('Data ini digunakan untuk link sosial media di frontend, biasanya pada bagian footer.')
                    ->schema([
                        TextInput::make('icon')
                            ->label('Icon')
                            ->placeholder('Contoh: bi bi-instagram')
                            ->maxLength(255)
                            ->nullable()
                            ->helperText('Isi class icon Bootstrap, contoh: bi bi-facebook, bi bi-instagram, bi bi-whatsapp, bi bi-youtube.'),

                        TextInput::make('link')
                            ->label('Link')
                            ->placeholder('Contoh: https://instagram.com/didintenda')
                            ->url()
                            ->maxLength(255)
                            ->nullable()
                            ->helperText('Isi URL lengkap sosial media.'),
                    ])
                    ->columns(2),
            ]);
    }
}