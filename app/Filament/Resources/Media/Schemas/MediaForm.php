<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Unggah Berkas Media')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('Pilih Berkas / Gambar')
                            ->disk('public')
                            ->directory('media')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('file_name')
                            ->label('Nama Berkas')
                            ->maxLength(255),
                        TextInput::make('alt_text')
                            ->label('Teks Alternatif (Alt Text)')
                            ->placeholder('Deskripsi singkat gambar untuk aksesibilitas...')
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }
}
