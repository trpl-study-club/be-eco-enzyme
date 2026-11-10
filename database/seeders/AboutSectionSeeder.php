<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use Illuminate\Database\Seeder;

class AboutSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $about = AboutSection::create([
            'title' => 'Tentang Program Pengabdian',
            'description' => '<p>Program Pengabdian Kepada Masyarakat (PKM) merupakan bentuk nyata kontribusi perguruan tinggi dalam membangun masyarakat. Kami berkomitmen untuk memberikan dampak positif melalui penerapan ilmu pengetahuan, teknologi, dan seni yang bermanfaat bagi masyarakat luas.</p>',
            'image' => null,
            'is_active' => true,
        ]);

        $cards = [
            [
                'title' => 'Pemberdayaan Masyarakat',
                'description' => 'Melaksanakan program pemberdayaan masyarakat melalui pelatihan, pendampingan, dan transfer teknologi tepat guna untuk meningkatkan kemandirian dan kesejahteraan.',
                'image' => null,
                'steps' => 1,
            ],
            [
                'title' => 'Penerapan IPTEK',
                'description' => 'Menerapkan hasil penelitian dan ilmu pengetahuan untuk menyelesaikan permasalahan nyata di masyarakat secara efektif dan berkelanjutan.',
                'image' => null,
                'steps' => 2,
            ],
            [
                'title' => 'Kemitraan Berkelanjutan',
                'description' => 'Membangun kemitraan jangka panjang dengan masyarakat, pemerintah daerah, dan pihak terkait untuk memastikan keberlanjutan program pengabdian.',
                'image' => null,
                'steps' => 3,
            ],
        ];

        foreach ($cards as $card) {
            $about->cards()->create($card);
        }
    }
}
