<?php

namespace App\Enums;

enum AnswerStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft Jawaban',
            self::Published => 'Dipublikasikan',
            self::Rejected => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Published => 'success',
            self::Rejected => 'danger',
        };
    }
}

