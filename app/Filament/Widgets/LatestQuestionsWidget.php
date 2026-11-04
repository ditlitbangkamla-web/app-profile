<?php

namespace App\Filament\Widgets;

use App\Enums\QuestionStatus;
use App\Filament\Resources\Questions\QuestionResource;
use App\Models\Question;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestQuestionsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Question::query()->latest()->limit(5)
            )
            ->heading('Pertanyaan Masyarakat Terbaru')
            ->columns([
                TextColumn::make('subject')
                    ->label('Subjek')
                    ->wrap()
                    ->limit(40),
                TextColumn::make('name')
                    ->label('Pengirim')
                    ->description(fn ($record): string => $record->email),
                TextColumn::make('topic.name')
                    ->label('Topik')
                    ->badge()
                    ->color('info'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (QuestionStatus $state): string => $state->color())
                    ->formatStateUsing(fn (QuestionStatus $state): string => $state->label()),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i'),
            ])
            ->recordUrl(
                fn (Question $record): string => QuestionResource::getUrl('edit', ['record' => $record])
            );
    }
}

