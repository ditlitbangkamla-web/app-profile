<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Selamat Datang di Portal Litbang Keamanan Laut',
                'description' => 'Mewujudkan riset maritim terunggul untuk kedaulatan perairan Nusantara.',
                'image' => 'slides/slide-1.jpg',
                'link_url' => '/pages/tentang-kami',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Layanan Aspirasi & Pertanyaan Masyarakat',
                'description' => 'Sampaikan pertanyaan dan permohonan informasi secara cepat dan transparan.',
                'image' => 'slides/slide-2.jpg',
                'link_url' => '/pertanyaan',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            Slide::updateOrCreate(['title' => $slide['title']], $slide);
        }
    }
}
