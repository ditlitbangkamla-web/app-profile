<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headerMenu = Menu::updateOrCreate(
            ['location' => 'header'],
            [
                'name' => 'Menu Utama (Header)',
                'is_active' => true,
            ]
        );

        $aboutPage = Page::where('slug', 'tentang-kami')->first();
        $visiPage = Page::where('slug', 'visi-misi')->first();

        // Header items
        MenuItem::updateOrCreate(
            ['menu_id' => $headerMenu->id, 'label' => 'Beranda'],
            ['url' => '/', 'type' => 'custom', 'sort_order' => 1, 'is_active' => true]
        );

        $profilParent = MenuItem::updateOrCreate(
            ['menu_id' => $headerMenu->id, 'label' => 'Profil Instansi'],
            ['url' => '#', 'type' => 'custom', 'sort_order' => 2, 'is_active' => true]
        );

        if ($aboutPage) {
            MenuItem::updateOrCreate(
                ['menu_id' => $headerMenu->id, 'label' => 'Tentang Kami', 'parent_id' => $profilParent->id],
                [
                    'url' => '/pages/'.$aboutPage->slug,
                    'type' => 'page',
                    'linkable_type' => Page::class,
                    'linkable_id' => $aboutPage->id,
                    'sort_order' => 1,
                    'is_active' => true,
                ]
            );
        }

        if ($visiPage) {
            MenuItem::updateOrCreate(
                ['menu_id' => $headerMenu->id, 'label' => 'Visi & Misi', 'parent_id' => $profilParent->id],
                [
                    'url' => '/pages/'.$visiPage->slug,
                    'type' => 'page',
                    'linkable_type' => Page::class,
                    'linkable_id' => $visiPage->id,
                    'sort_order' => 2,
                    'is_active' => true,
                ]
            );
        }

        MenuItem::updateOrCreate(
            ['menu_id' => $headerMenu->id, 'label' => 'Berita & Artikel'],
            ['url' => '/posts', 'type' => 'custom', 'sort_order' => 3, 'is_active' => true]
        );

        MenuItem::updateOrCreate(
            ['menu_id' => $headerMenu->id, 'label' => 'Tanya Masyarakat'],
            ['url' => '/pertanyaan', 'type' => 'custom', 'sort_order' => 4, 'is_active' => true]
        );
    }
}
