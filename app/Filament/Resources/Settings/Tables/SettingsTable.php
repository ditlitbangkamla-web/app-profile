<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group')
                    ->label('Grup')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'general' => 'primary',
                        'contact' => 'success',
                        'social' => 'info',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('label')
                    ->label('Nama Pengaturan')
                    ->description(fn ($record): string => $record->key)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Nilai')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('group')
            ->filters([
                SelectFilter::make('group')
                    ->label('Filter Grup')
                    ->options([
                        'general' => 'Umum',
                        'contact' => 'Kontak',
                        'social' => 'Media Sosial',
                        'appearance' => 'Tampilan',
                        'other' => 'Lainnya',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
