<?php

namespace App\Notifications;

use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionAnsweredNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Question $question,
        public QuestionAnswer $answer
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Tanggapan atas Pertanyaan: {$this->question->subject}")
            ->greeting("Halo, {$this->question->name}")
            ->line("Terima kasih telah menghubungi kami. Pertanyaan Anda mengenai \"{$this->question->subject}\" telah dijawab oleh tim kami.")
            ->line('Pertanyaan Anda:')
            ->line($this->question->body)
            ->line('Jawaban Resmi:')
            ->line(strip_tags($this->answer->body))
            ->line('Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami kembali melalui portal kami.');
    }
}

