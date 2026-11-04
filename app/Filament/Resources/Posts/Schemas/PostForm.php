<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    // Main column (2 cols wide)
                    Grid::make(1)->schema([
                        Section::make('Konten Artikel')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Artikel')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                                TextInput::make('slug')
                                    ->label('Slug (URL)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                Textarea::make('summary')
                                    ->label('Ringkasan / Sinopsis')
                                    ->rows(3)
                                    ->placeholder('Ringkasan singkat artikel untuk preview...'),
                                RichEditor::make('content')
                                    ->label('Isi Lengkap')
                                    ->required()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('posts/attachments'),
                            ]),
                    ])->columnSpan(2),

                    // Sidebar column (1 col wide)
                    Grid::make(1)->schema([
                        Section::make('Publikasi & Kategori')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->label('Nama Kategori')
                                            ->required(),
                                    ]),
                                Select::make('status')
                                    ->label('Status')
                                    ->options(PostStatus::class)
                                    ->default(PostStatus::Draft->value)
                                    ->required(),
                                DateTimePicker::make('published_at')
                                    ->label('Jadwal Tayang')
                                    ->default(now()),
                                Toggle::make('is_featured')
                                    ->label('Artikel Pilihan / Unggulan')
                                    ->default(false),
                            ]),
                        Section::make('Gambar Utama')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Gambar Utama')
                                    ->image()
                                    ->disk('public')
                                    ->directory('posts')
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9'),
                            ]),
                    ])->columnSpan(1),
                ]),
            ]);
    }
}
