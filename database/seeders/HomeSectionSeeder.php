<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Illuminate\Database\Seeder;

class HomeSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeSection::create([
            'title' => 'Pengabdian Kepada Masyarakat',
            'description' => '<p>Program pengabdian kepada masyarakat merupakan salah satu pilar utama Tri Dharma Perguruan Tinggi. Melalui program ini, dosen dan mahasiswa berkontribusi langsung dalam pemberdayaan masyarakat melalui penerapan ilmu pengetahuan dan teknologi.</p><p>Bergabunglah bersama kami untuk menciptakan dampak nyata bagi masyarakat dan lingkungan sekitar.</p>',
            'image' => null,
            'button_one_text' => 'Lihat Program',
            'button_one_link' => '#programs',
            'button_two_text' => 'Hubungi Kami',
            'button_two_link' => '#contact',
            'is_active' => true,
        ]);
    }
}
