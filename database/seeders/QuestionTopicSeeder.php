<?php

namespace Database\Seeders;

use App\Models\QuestionTopic;
use Illuminate\Database\Seeder;

class QuestionTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            [
                'name' => 'Layanan Informasi Publik',
                'slug' => 'layanan-informasi-publik',
                'description' => 'Permohonan informasi publik dan keterbukaan informasi instansi.',
                'icon' => 'information-circle',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Kerjasama Riset & Litbang',
                'slug' => 'kerjasama-riset-dan-litbang',
                'description' => 'Pertanyaan terkait kolaborasi penelitian, magang, dan kemitraan akademik.',
                'icon' => 'academic-cap',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Keselamatan & Keamanan Laut',
                'slug' => 'keselamatan-dan-keamanan-laut',
                'description' => 'Konsultasi dan laporan terkait kepatuhan dan keselamatan di laut.',
                'icon' => 'shield-check',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Aduan & Saran Masyarakat',
                'slug' => 'aduan-dan-saran-masyarakat',
                'description' => 'Kritik, saran, masukan perbaikan layanan institusi.',
                'icon' => 'chat-bubble-left-right',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($topics as $t) {
            QuestionTopic::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}
