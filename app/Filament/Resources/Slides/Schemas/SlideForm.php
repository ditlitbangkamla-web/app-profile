<?php

namespace App\Filament\Resources\Slides\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Grid::make(1)->schema([
                        Section::make('Informasi Slide Banner')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Banner')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description')
                                    ->label('Deskripsi / Teks Pendukung')
                                    ->rows(3),
                                TextInput::make('link_url')
                                    ->label('URL Tautan (Opsional)')
                                    ->placeholder('/pages/tentang-kami atau https://...')
                                    ->maxLength(255),
                                FileUpload::make('image')
                                    ->label('Gambar Banner')
                                    ->image()
                                    ->disk('public')
                                    ->directory('slides')
                                    ->required()
                                    ->imageCropAspectRatio('16:9'),
                            ]),
                    ])->columnSpan(2),

                    Grid::make(1)->schema([
                        Section::make('Jadwal & Pengaturan')
                            ->schema([
                                TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0),
                                Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true),
                                DatePicker::make('start_date')
                                    ->label('Mulai Tayang'),
                                DatePicker::make('end_date')
                                    ->label('Selesai Tayang'),
                            ]),
                    ])->columnSpan(1),
                ]),
            ]);
    }
}
