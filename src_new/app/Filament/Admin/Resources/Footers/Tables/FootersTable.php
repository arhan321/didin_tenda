<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Footers\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class FootersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query->latest('id');
            })
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->searchable()
                    ->limit(60)
                    ->wrap()
                    ->placeholder('-'),

                TextColumn::make('nomor_telfon')
                    ->label('Nomor Telepon')
                    ->searchable()
                    ->copyable()
                    ->placeholder('-'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->placeholder('-'),

                TextColumn::make('copyright')
                    ->label('Copyright')
                    ->searchable()
                    ->limit(60)
                    ->placeholder('-'),

                TextColumn::make('develop_by')
                    ->label('Develop By')
                    ->searchable()
                    ->limit(50)
                    ->placeholder('-'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('View'),

                EditAction::make()
                    ->label('Edit'),

                DeleteAction::make()
                    ->label('Delete'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete selected'),
                ]),
            ])
            ->emptyStateHeading('Belum ada data Footer')
            ->emptyStateDescription('Silakan tambahkan data footer untuk halaman frontend.')
            ->paginated([10, 25, 50, 100]);
    }
}