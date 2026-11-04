<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengaturan')
                    ->schema([
                        Select::make('group')
                            ->label('Grup Pengaturan')
                            ->options([
                                'general' => 'Umum (General)',
                                'contact' => 'Kontak (Contact)',
                                'social' => 'Media Sosial (Social Media)',
                                'appearance' => 'Tampilan (Appearance)',
                                'other' => 'Lainnya',
                            ])
                            ->default('general')
                            ->required(),
                        TextInput::make('key')
                            ->label('Kunci (Key)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabled(fn (string $operation): bool => $operation === 'edit'),
                        TextInput::make('label')
                            ->label('Label Tampilan')
                            ->maxLength(255),
                        Select::make('type')
                            ->label('Tipe Nilai')
                            ->options([
                                'text' => 'Teks Singkat',
                                'textarea' => 'Teks Panjang',
                                'image' => 'Gambar / Logo',
                                'boolean' => 'Boolean (1 / 0)',
                                'json' => 'Format JSON',
                            ])
                            ->default('text')
                            ->live()
                            ->required(),
                        FileUpload::make('value')
                            ->label('Berkas Gambar / Logo')
                            ->image()
                            ->disk('public')
                            ->directory('settings')
                            ->visible(fn (Get $get): bool => $get('type') === 'image')
                            ->columnSpanFull(),
                        Textarea::make('value')
                            ->label('Nilai Pengaturan')
                            ->rows(4)
                            ->visible(fn (Get $get): bool => $get('type') !== 'image')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
