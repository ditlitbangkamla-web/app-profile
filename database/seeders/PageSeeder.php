<?php

namespace Database\Seeders;

use App\Enums\PageStatus;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();

        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => '<p>Direktorat Penelitian dan Pengembangan Keamanan Laut bertugas menyelenggarakan perumusan dan pelaksanaan kebijakan teknis di bidang penelitian dan pengembangan keamanan dan keselamatan di wilayah perairan Indonesia dan wilayah yurisdiksi Indonesia.</p>',
                'status' => PageStatus::Published,
                'sort_order' => 1,
                'show_in_menu' => true,
            ],
            [
                'title' => 'Visi & Misi',
                'slug' => 'visi-misi',
                'content' => '<h3>Visi</h3><p>Terwujudnya keamanan dan keselamatan laut nusantara yang berdaulat, mandiri, dan berlandaskan riset serta inovasi terpadu.</p><h3>Misi</h3><ul><li>Mendorong penelitian dan inovasi teknologi keamanan laut.</li><li>Menyediakan analisis dan kajian strategis keselamatan pelayaran.</li><li>Membangun kolaborasi riset maritim nasional dan internasional.</li></ul>',
                'status' => PageStatus::Published,
                'sort_order' => 2,
                'show_in_menu' => true,
            ],
            [
                'title' => 'Struktur Organisasi',
                'slug' => 'struktur-organisasi',
                'content' => '<p>Struktur organisasi disusun secara profesional untuk memastikan tata kelola riset keamanan maritim yang efektif dan efisien.</p>',
                'status' => PageStatus::Published,
                'sort_order' => 3,
                'show_in_menu' => true,
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(
                ['slug' => $p['slug']],
                array_merge($p, ['user_id' => $admin?->id])
            );
        }
    }
}
