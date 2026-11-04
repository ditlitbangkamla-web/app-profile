<?php

namespace App\Models;

use App\Enums\AnswerStatus;
use App\Enums\QuestionStatus;
use App\Notifications\QuestionAnsweredNotification;
use Database\Factories\QuestionAnswerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Notification;

class QuestionAnswer extends Model
{
    /** @use HasFactory<QuestionAnswerFactory> */
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'body',
        'status',
        'is_published',
        'answered_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => AnswerStatus::class,
            'is_published' => 'boolean',
            'answered_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (QuestionAnswer $answer) {
            if (empty($answer->user_id) && auth()->check()) {
                $answer->user_id = auth()->id();
            }
            if (empty($answer->answered_at)) {
                $answer->answered_at = now();
            }
        });

        static::created(function (QuestionAnswer $answer) {
            if ($answer->is_published && $answer->question) {
                $answer->question->update(['status' => QuestionStatus::Answered]);

                // Notify inquirer by email
                if (! empty($answer->question->email)) {
                    try {
                        Notification::route('mail', $answer->question->email)
                            ->notify(new QuestionAnsweredNotification($answer->question, $answer));
                    } catch (\Throwable $e) {
                        // Log or ignore notification failure
                    }
                }
            }
        });
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->where('status', AnswerStatus::Published);
    }
}
