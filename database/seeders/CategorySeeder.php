<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kamera',
                'description' => 'Body kamera DSLR, Mirrorless, dan Action Cam',
            ],
            [
                'name' => 'Lensa',
                'description' => 'Lensa Wide, Zoom, Tele, dan Prime/Fix',
            ],
            [
                'name' => 'Tripod & Stabilizer',
                'description' => 'Tripod, Monopod, Gimbal, dan Slider',
            ],
            [
                'name' => 'Lighting',
                'description' => 'Lampu Studio, Softbox, LED Panel, dan Ring Light',
            ],
            [
                'name' => 'Audio & Mic',
                'description' => 'Microphone Shotgun, Clip-on, Recorder, dan Headphone',
            ],
            [
                'name' => 'Memory & Storage',
                'description' => 'SD Card, Micro SD, SSD Portable, dan Harddisk',
            ],
            [
                'name' => 'Kabel & Konektor',
                'description' => 'Kabel HDMI, XLR, USB, dan Adapter',
            ],
            [
                'name' => 'Aksesoris Lain',
                'description' => 'Tas Kamera, Baterai Cadangan, Charger, dll',
            ],
        ];

        foreach ($categories as $cat) {
            // Gunakan firstOrCreate agar tidak duplikat jika dijalankan 2x
            Category::firstOrCreate(
                ['name' => $cat['name']], // Cek berdasarkan nama
                $cat // Jika tidak ada, buat baru dengan data ini
            );
        }
    }
}