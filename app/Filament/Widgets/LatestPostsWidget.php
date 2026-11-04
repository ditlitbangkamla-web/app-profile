<?php

namespace App\Filament\Widgets;

use App\Enums\PostStatus;
use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPostsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()->latest()->limit(5)
            )
            ->heading('Artikel & Publikasi Terbaru')
            ->columns([
                ImageColumn::make('image')
                    ->label('Cover')
                    ->disk('public')
                    ->square(),
                TextColumn::make('title')
                    ->label('Judul Artikel')
                    ->wrap()
                    ->limit(50),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (PostStatus $state): string => $state->color())
                    ->formatStateUsing(fn (PostStatus $state): string => $state->label()),
                TextColumn::make('view_count')
                    ->label('Dilihat')
                    ->numeric(),
                TextColumn::make('published_at')
                    ->label('Tanggal Tayang')
                    ->dateTime('d M Y'),
            ])
            ->recordUrl(
                fn (Post $record): string => PostResource::getUrl('edit', ['record' => $record])
            );
    }
}

