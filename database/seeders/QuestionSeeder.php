<?php

namespace Database\Seeders;

use App\Enums\AnswerStatus;
use App\Enums\QuestionStatus;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionTopic;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $topic = QuestionTopic::first();

        $question1 = Question::updateOrCreate(
            ['subject' => 'Permohonan Data Laporan Tahunan Keamanan Laut 2025'],
            [
                'topic_id' => $topic?->id,
                'name' => 'Budi Santoso',
                'email' => 'budisantoso@example.com',
                'phone' => '08123456789',
                'body' => 'Selamat siang, saya mahasiswa tingkat akhir ingin meminta data statistik kegiatan riset keamanan laut untuk keperluan skripsi. Terima kasih.',
                'status' => QuestionStatus::Answered,
                'ip_address' => '127.0.0.1',
            ]
        );

        QuestionAnswer::updateOrCreate(
            ['question_id' => $question1->id],
            [
                'user_id' => $admin?->id,
                'body' => '<p>Halo Saudara Budi Santoso, data laporan tahunan yang bersifat publik dapat diunduh langsung pada menu Dokumen Publik atau lampiran resmi pada link berikut. Sukses untuk skripsinya!</p>',
                'status' => AnswerStatus::Published,
                'is_published' => true,
                'answered_at' => now(),
            ]
        );

        Question::updateOrCreate(
            ['subject' => 'Pertanyaan Kerjasama Pengujian Radar Pantai'],
            [
                'topic_id' => $topic?->id,
                'name' => 'Dewi Lestari',
                'email' => 'dewilestari@example.com',
                'phone' => '08987654321',
                'body' => 'Apakah terbuka kesempatan uji coba perangkat radar buatan dalam negeri bersama tim Litbang?',
                'status' => QuestionStatus::Pending,
                'ip_address' => '127.0.0.1',
            ]
        );
    }
}
