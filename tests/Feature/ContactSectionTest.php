<?php

namespace Tests\Feature;

use App\Models\ContactSection;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ContactSectionTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
    }

    public function test_admin_can_access_contact_sections_index_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.contact-sections.index'));

        $response->assertStatus(200);
        $response->assertSee('Section Kontak');
        $response->assertSee('Buat Kontak Baru');
    }

    public function test_admin_can_access_contact_sections_create_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.contact-sections.create'));

        $response->assertStatus(200);
        $response->assertSee('Buat Kontak Baru');
        $response->assertSee('Konten Utama Section');
    }

    public function test_admin_can_store_contact_section(): void
    {
        $payload = [
            'title' => 'Kontak Section Baru',
            'description' => 'Hubungi kami sekarang untuk kolaborasi.',
            'action' => 'publish',
            'items' => [
                [
                    'type' => 'location',
                    'label' => 'LOKASI',
                    'value' => 'Desa Jeruklegi, Jawa Tengah',
                    'icon_name' => 'map-pin',
                ],
                [
                    'type' => 'email',
                    'label' => 'EMAIL',
                    'value' => 'halo@ecoenzyme-jeruklegi.id',
                    'icon_name' => 'mail',
                ],
            ],
        ];

        $response = $this->actingAs($this->user)->post(route('admin.contact-sections.store'), $payload);

        $response->assertRedirect(route('admin.contact-sections.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_sections', [
            'title' => 'Kontak Section Baru',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('contact_items', [
            'label' => 'LOKASI',
            'value' => 'Desa Jeruklegi, Jawa Tengah',
        ]);
    }

    public function test_admin_can_access_contact_sections_edit_page(): void
    {
        $contactSection = ContactSection::create([
            'title' => 'Section Kontak Edit Test',
            'description' => 'Deskripsi untuk edit',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.contact-sections.edit', $contactSection));

        $response->assertStatus(200);
        $response->assertSee('Edit Section Kontak');
        $response->assertSee('Section Kontak Edit Test');
    }

    public function test_admin_can_update_contact_section(): void
    {
        $contactSection = ContactSection::create([
            'title' => 'Judul Awal Kontak',
            'description' => 'Deskripsi awal',
            'is_active' => true,
        ]);

        $payload = [
            'title' => 'Ada Pertanyaan? Kami Siap Membantu.',
            'description' => "Ingin tahu lebih banyak tentang produk, cara pembuatan, atau peluang kolaborasi?\nJangan ragu untuk menghubungi kami.",
            'action' => 'publish',
            'items' => [
                [
                    'type' => 'location',
                    'label' => 'LOKASI',
                    'value' => 'Desa Jeruklegi, Jawa Tengah',
                    'icon_name' => 'map-pin',
                ],
                [
                    'type' => 'email',
                    'label' => 'EMAIL',
                    'value' => 'halo@ecoenzyme-jeruklegi.id',
                    'icon_name' => 'mail',
                ],
                [
                    'type' => 'whatsapp',
                    'label' => 'WHATSAPP',
                    'value' => '+62 888 0245 7102',
                    'icon_name' => 'phone',
                ],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->put(route('admin.contact-sections.update', $contactSection), $payload);

        $response->assertRedirect(route('admin.contact-sections.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_sections', [
            'id' => $contactSection->id,
            'title' => 'Ada Pertanyaan? Kami Siap Membantu.',
        ]);

        $this->assertDatabaseHas('contact_items', [
            'contact_section_id' => $contactSection->id,
            'label' => 'LOKASI',
            'value' => 'Desa Jeruklegi, Jawa Tengah',
            'icon_name' => 'map-pin',
        ]);
    }

    public function test_admin_can_toggle_contact_section_status(): void
    {
        $contactSection = ContactSection::create([
            'title' => 'Toggle Test Section',
            'description' => 'Desc',
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->user)
            ->patch(route('admin.contact-sections.toggle-status', $contactSection));

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_sections', [
            'id' => $contactSection->id,
            'is_active' => true,
        ]);
    }

    public function test_admin_can_destroy_contact_section(): void
    {
        $contactSection = ContactSection::create([
            'title' => 'Section to Delete',
            'description' => 'To be deleted',
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('admin.contact-sections.destroy', $contactSection));

        $response->assertRedirect(route('admin.contact-sections.index'));
        $this->assertDatabaseMissing('contact_sections', [
            'id' => $contactSection->id,
        ]);
    }

    public function test_api_v1_contact_returns_expected_payload(): void
    {
        ContactSection::where('is_active', true)->update(['is_active' => false]);

        $contactSection = ContactSection::create([
            'title' => 'Ada Pertanyaan? Kami Siap Membantu.',
            'description' => 'Ingin tahu lebih banyak tentang produk, cara pembuatan, atau peluang kolaborasi?',
            'is_active' => true,
        ]);

        $contactSection->items()->createMany([
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
        ]);

        $response = $this->getJson('/api/v1/contact');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $contactSection->id,
                'title' => 'Ada Pertanyaan? Kami Siap Membantu.',
                'location' => 'Desa Jeruklegi, Jawa Tengah',
                'email' => 'halo@ecoenzyme-jeruklegi.id',
                'whatsapp' => '+62 888 0245 7102',
                'is_active' => true,
                'items' => [
                    [
                        'label' => 'LOKASI',
                        'value' => 'Desa Jeruklegi, Jawa Tengah',
                        'icon_name' => 'map-pin',
                    ],
                    [
                        'label' => 'EMAIL',
                        'value' => 'halo@ecoenzyme-jeruklegi.id',
                        'icon_name' => 'mail',
                    ],
                    [
                        'label' => 'WHATSAPP',
                        'value' => '+62 888 0245 7102',
                        'icon_name' => 'phone',
                    ],
                ],
            ],
        ]);
    }
}
