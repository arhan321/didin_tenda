<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\SosialMedia\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class SosialMediaTable
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

                TextColumn::make('icon')
                    ->label('Icon')
                    ->searchable()
                    ->badge()
                    ->placeholder('-'),

                TextColumn::make('link')
                    ->label('Link')
                    ->searchable()
                    ->copyable()
                    ->limit(70)
                    ->url(fn ($record): ?string => $record->link)
                    ->openUrlInNewTab()
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
            ->emptyStateHeading('Belum ada data Sosial Media')
            ->emptyStateDescription('Silakan tambahkan link sosial media untuk halaman frontend.')
            ->paginated([10, 25, 50, 100]);
    }
}