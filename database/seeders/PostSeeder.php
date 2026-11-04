<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        $newsCat = Category::where('slug', 'berita-utama')->first();
        $researchCat = Category::where('slug', 'riset-dan-kajian')->first();

        $posts = [
            [
                'title' => 'Pengembangan Sistem Monitoring Maritim Terpadu Berbasis AI',
                'slug' => 'pengembangan-sistem-monitoring-maritim-terpadu-berbasis-ai',
                'summary' => 'Inovasi pengawasan wilayah laut menggunakan teknologi kecerdasan buatan dan citra satelit.',
                'content' => '<p>Direktorat Litbang Keamanan Laut resmi menguji coba sistem monitoring maritim cerdas yang memanfaatkan integrasi radar pantai, sensor AIS, dan algoritma kecerdasan buatan guna mendeteksi anomali pergerakan kapal secara real-time.</p>',
                'category_id' => $researchCat?->id,
                'status' => PostStatus::Published,
                'published_at' => now(),
                'is_featured' => true,
                'view_count' => 120,
            ],
            [
                'title' => 'Sosialisasi Keselamatan dan Kepatuhan Pelayaran di Wilayah Perbatasan',
                'slug' => 'sosialisasi-keselamatan-dan-kepatuhan-pelayaran-di-wilayah-perbatasan',
                'summary' => 'Kegiatan penyuluhan kepada nelayan dan pelaku usaha maritim di wilayah kepulauan.',
                'content' => '<p>Kegiatan sosialisasi keselamatan berlayar dan pemanfaatan perangkat navigasi darurat telah dilaksanakan di Kepulauan Natuna dengan melibatkan ratusan nelayan lokal.</p>',
                'category_id' => $newsCat?->id,
                'status' => PostStatus::Published,
                'published_at' => now()->subDays(2),
                'is_featured' => false,
                'view_count' => 85,
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, ['user_id' => $admin?->id])
            );
        }
    }
}
