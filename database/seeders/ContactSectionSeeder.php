<?php

namespace Database\Seeders;

use App\Models\ContactSection;
use Illuminate\Database\Seeder;

class ContactSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactSection = ContactSection::firstOrCreate(
            ['is_active' => true],
            [
                'title' => 'Ada Pertanyaan? Kami Siap Membantu.',
                'description' => "Ingin tahu lebih banyak tentang produk, cara pembuatan, atau peluang kolaborasi?\nJangan ragu untuk menghubungi kami.",
                'is_active' => true,
            ]
        );

        $defaultItems = [
            [
                'type' => 'location',
                'label' => 'LOKASI',
                'value' => 'Desa Jeruklegi, Jawa Tengah',
                'icon_name' => 'map-pin',
                'order' => 1,
            ],
            [
                'type' => 'email',
                'label' => 'EMAIL',
                'value' => 'halo@ecoenzyme-jeruklegi.id',
                'icon_name' => 'mail',
                'order' => 2,
            ],
            [
                'type' => 'whatsapp',
                'label' => 'WHATSAPP',
                'value' => '+62 888 0245 7102',
                'icon_name' => 'phone',
                'order' => 3,
            ],
        ];

        foreach ($defaultItems as $item) {
            $contactSection->items()->firstOrCreate(
                [
                    'label' => $item['label'],
                ],
                $item
            );
        }
    }
}
