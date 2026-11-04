<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Enums\PageStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Grid::make(1)->schema([
                        Section::make('Konten Halaman')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Halaman')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                                TextInput::make('slug')
                                    ->label('Slug (URL)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                RichEditor::make('content')
                                    ->label('Isi Halaman')
                                    ->required()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('pages/attachments'),
                            ]),
                    ])->columnSpan(2),

                    Grid::make(1)->schema([
                        Section::make('Pengaturan Halaman')
                            ->schema([
                                Select::make('status')
                                    ->label('Status')
                                    ->options(PageStatus::class)
                                    ->default(PageStatus::Published->value)
                                    ->required(),
                                TextInput::make('sort_order')
                                    ->label('Urutan Tampilan')
                                    ->numeric()
                                    ->default(0),
                                Toggle::make('show_in_menu')
                                    ->label('Tampilkan di Navigasi Menu')
                                    ->default(true),
                            ]),
                        Section::make('Gambar Unggulan')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Gambar Header / Cover')
                                    ->image()
                                    ->disk('public')
                                    ->directory('pages'),
                            ]),
                    ])->columnSpan(1),
                ]),
            ]);
    }
}
