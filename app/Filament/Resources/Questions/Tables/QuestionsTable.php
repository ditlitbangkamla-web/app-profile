<?php

namespace App\Filament\Resources\Questions\Tables;

use App\Enums\QuestionStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject')
                    ->label('Subjek Pertanyaan')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),
                TextColumn::make('name')
                    ->label('Penanya')
                    ->description(fn ($record): string => $record->email)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('topic.name')
                    ->label('Topik')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (QuestionStatus $state): string => $state->color())
                    ->formatStateUsing(fn (QuestionStatus $state): string => $state->label())
                    ->sortable(),
                TextColumn::make('answers_count')
                    ->counts('answers')
                    ->label('Jawaban')
                    ->badge()
                    ->color('success'),
                TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(QuestionStatus::class),
                SelectFilter::make('topic')
                    ->label('Filter Topik')
                    ->relationship('topic', 'name'),
            ])
            ->recordActions([
                EditAction::make()->label('Tinjau / Jawab'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
