<?php

namespace App\Filament\Resources\Questions\Schemas;

use App\Enums\AnswerStatus;
use App\Enums\QuestionStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Grid::make(1)->schema([
                        Section::make('Rincian Pertanyaan Masuk')
                            ->schema([
                                TextInput::make('subject')
                                    ->label('Subjek / Judul Pertanyaan')
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('body')
                                    ->label('Isi Pertanyaan Lengkap')
                                    ->rows(6)
                                    ->required()
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Tanggapan & Jawaban Resmi')
                            ->schema([
                                Repeater::make('answers')
                                    ->label('Jawaban Tim')
                                    ->relationship('answers')
                                    ->schema([
                                        RichEditor::make('body')
                                            ->label('Isi Jawaban Resmi')
                                            ->required()
                                            ->columnSpanFull(),
                                        Grid::make(3)->schema([
                                            Select::make('status')
                                                ->label('Status Jawaban')
                                                ->options(AnswerStatus::class)
                                                ->default(AnswerStatus::Published->value)
                                                ->required(),
                                            Toggle::make('is_published')
                                                ->label('Tampilkan ke Publik')
                                                ->default(true)
                                                ->inline(false),
                                            DateTimePicker::make('answered_at')
                                                ->label('Waktu Menjawab')
                                                ->default(now()),
                                        ]),
                                    ])
                                    ->defaultItems(1)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => 'Jawaban: '.strip_tags(substr($state['body'] ?? '', 0, 50))),
                            ]),
                    ])->columnSpan(2),

                    Grid::make(1)->schema([
                        Section::make('Data Penanya')
                            ->schema([
                                Select::make('topic_id')
                                    ->label('Topik')
                                    ->relationship('topic', 'name')
                                    ->searchable()
                                    ->preload(),
                                Select::make('status')
                                    ->label('Status Tiket')
                                    ->options(QuestionStatus::class)
                                    ->default(QuestionStatus::Pending->value)
                                    ->required(),
                                TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email Penanya')
                                    ->email()
                                    ->required(),
                                TextInput::make('phone')
                                    ->label('Nomor Telepon / WA'),
                                TextInput::make('ip_address')
                                    ->label('Alamat IP')
                                    ->disabled(),
                            ]),
                    ])->columnSpan(1),
                ]),
            ]);
    }
}
