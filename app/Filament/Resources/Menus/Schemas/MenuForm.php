<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Menu')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('name')
                                ->label('Nama Menu')
                                ->required()
                                ->maxLength(255),
                            Select::make('location')
                                ->label('Posisi Penempatan')
                                ->options([
                                    'header' => 'Header (Atas)',
                                    'footer' => 'Footer (Bawah)',
                                    'sidebar' => 'Sidebar (Samping)',
                                ])
                                ->required(),
                            Toggle::make('is_active')
                                ->label('Menu Aktif')
                                ->default(true)
                                ->inline(false),
                        ]),
                    ]),

                Section::make('Item Menu Navigasi')
                    ->schema([
                        Repeater::make('allItems')
                            ->label('Daftar Tautan Menu')
                            ->relationship('allItems')
                            ->schema([
                                Grid::make(4)->schema([
                                    TextInput::make('label')
                                        ->label('Label Menu')
                                        ->required(),
                                    Select::make('type')
                                        ->label('Tipe Menu')
                                        ->options([
                                            'custom' => 'Tautan Kustom (URL)',
                                            'page' => 'Halaman Statis',
                                            'post' => 'Artikel Berita',
                                            'category' => 'Kategori Berita',
                                        ])
                                        ->default('custom')
                                        ->live(),
                                    TextInput::make('url')
                                        ->label('URL / Path')
                                        ->placeholder('/url-tujuan atau https://...')
                                        ->required(fn (Get $get): bool => $get('type') === 'custom')
                                        ->columnSpan(2),
                                ]),
                                Grid::make(3)->schema([
                                    TextInput::make('sort_order')
                                        ->label('Urutan')
                                        ->numeric()
                                        ->default(0),
                                    Toggle::make('is_active')
                                        ->label('Aktif')
                                        ->default(true),
                                ]),
                            ])
                            ->orderColumn('sort_order')
                            ->defaultItems(1)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
                    ]),
            ]);
    }
}
