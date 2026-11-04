<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General
            [
                'group' => 'general',
                'key' => 'site_name',
                'label' => 'Nama Instansi / Website',
                'value' => 'Direktorat Penelitian dan Pengembangan Keamanan Laut',
                'type' => 'text',
            ],
            [
                'group' => 'general',
                'key' => 'site_tagline',
                'label' => 'Tagline / Slogan',
                'value' => 'Mewujudkan Keamanan Laut yang Tangguh dan Modern',
                'type' => 'text',
            ],
            [
                'group' => 'general',
                'key' => 'site_description',
                'label' => 'Deskripsi Singkat',
                'value' => 'Portal resmi layanan informasi dan interaksi masyarakat.',
                'type' => 'textarea',
            ],
            [
                'group' => 'general',
                'key' => 'site_logo',
                'label' => 'Logo Instansi',
                'value' => null,
                'type' => 'image',
            ],

            // Contact
            [
                'group' => 'contact',
                'key' => 'contact_address',
                'label' => 'Alamat Kantor',
                'value' => 'Jl. Proklamasi No. 56, Menteng, Jakarta Pusat, DKI Jakarta',
                'type' => 'textarea',
            ],
            [
                'group' => 'contact',
                'key' => 'contact_phone',
                'label' => 'Nomor Telepon',
                'value' => '+62 21 3190 0000',
                'type' => 'text',
            ],
            [
                'group' => 'contact',
                'key' => 'contact_email',
                'label' => 'Email Kontak',
                'value' => 'ditlibangkamla@gmail.com',
                'type' => 'text',
            ],
            [
                'group' => 'contact',
                'key' => 'contact_whatsapp',
                'label' => 'Nomor WhatsApp',
                'value' => '+62 812 3456 7890',
                'type' => 'text',
            ],

            // Social Media
            [
                'group' => 'social',
                'key' => 'social_facebook',
                'label' => 'Facebook URL',
                'value' => 'https://facebook.com',
                'type' => 'text',
            ],
            [
                'group' => 'social',
                'key' => 'social_instagram',
                'label' => 'Instagram URL',
                'value' => 'https://instagram.com',
                'type' => 'text',
            ],
            [
                'group' => 'social',
                'key' => 'social_twitter',
                'label' => 'X / Twitter URL',
                'value' => 'https://x.com',
                'type' => 'text',
            ],
            [
                'group' => 'social',
                'key' => 'social_youtube',
                'label' => 'YouTube Channel URL',
                'value' => 'https://youtube.com',
                'type' => 'text',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
