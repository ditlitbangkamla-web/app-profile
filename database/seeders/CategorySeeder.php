<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Berita Utama',
                'slug' => 'berita-utama',
                'description' => 'Informasi dan berita terkini instansi.',
                'icon' => 'newspaper',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Riset & Kajian',
                'slug' => 'riset-dan-kajian',
                'description' => 'Hasil penelitian, kajian ilmiah, dan publikasi strategis.',
                'icon' => 'academic-cap',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Pengumuman resmi dan siaran pers.',
                'icon' => 'megaphone',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Kegiatan',
                'slug' => 'kegiatan',
                'description' => 'Dokumentasi kegiatan dan agenda instansi.',
                'icon' => 'calendar',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
