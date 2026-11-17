<?php

namespace Tests\Feature;

use App\Models\ContactItem;
use App\Models\ContactSection;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
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

        $this->seed(RolePermissionSeeder::class);

        $this->user = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $this->user->assignRole('super_admin');
    }

    public function test_admin_can_access_contact_sections_index_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.contact-sections.index'));

        $response->assertStatus(200);
        $response->assertSee('Informasi Kontak Desa');
        $response->assertSee('Tambah Saluran Kontak');
    }

    public function test_admin_can_manage_contact_hub_header_and_items_directly(): void
    {
        $this->actingAs($this->user)
            ->post(route('admin.contact-sections.update-header'), [
                'title' => 'Hubungi Tim Pengelola Desa',
                'description' => 'Kami siap melayani pertanyaan warga setiap hari.',
            ])
            ->assertRedirect(route('admin.contact-sections.index'));

        $this->assertDatabaseHas('contact_sections', [
            'title' => 'Hubungi Tim Pengelola Desa',
            'description' => 'Kami siap melayani pertanyaan warga setiap hari.',
        ]);

        // Store individual contact item
        $this->actingAs($this->user)
            ->post(route('admin.contact-sections.items.store'), [
                'label' => 'WHATSAPP',
                'type' => 'whatsapp',
                'value' => '+62 812 3456 7890',
                'icon_name' => 'phone',
            ])
            ->assertRedirect(route('admin.contact-sections.index'));

        $item = ContactItem::where('value', '+62 812 3456 7890')->first();
        $this->assertNotNull($item);

        // Update individual contact item
        $this->actingAs($this->user)
            ->put(route('admin.contact-sections.items.update', $item), [
                'label' => 'WHATSAPP DESA',
                'type' => 'whatsapp',
                'value' => '+62 811 2233 4455',
                'icon_name' => 'phone',
            ])
            ->assertRedirect(route('admin.contact-sections.index'));

        $this->assertDatabaseHas('contact_items', [
            'id' => $item->id,
            'label' => 'WHATSAPP DESA',
            'value' => '+62 811 2233 4455',
        ]);

        // Delete individual contact item
        $this->actingAs($this->user)
            ->delete(route('admin.contact-sections.items.destroy', $item))
            ->assertRedirect(route('admin.contact-sections.index'));

        $this->assertDatabaseMissing('contact_items', ['id' => $item->id]);
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

    public function test_contact_hub_renders_clean_cards_without_copy_or_external_action_buttons(): void
    {
        ContactSection::where('is_active', true)->update(['is_active' => false]);

        $section = ContactSection::create([
            'title' => 'Hubungi Pengelola Desa',
            'description' => 'Silakan hubungi kami melalui saluran resmi.',
            'is_active' => true,
        ]);

        $section->items()->createMany([
            [
                'type' => 'whatsapp',
                'label' => 'WhatsApp Layanan',
                'value' => '0812-3456-7890',
                'icon_name' => 'phone',
                'order' => 1,
            ],
            [
                'type' => 'location',
                'label' => 'Alamat Jawa Tengah',
                'value' => 'Desa Jeruklegi, Jawa Tengah',
                'icon_name' => 'map-pin',
                'order' => 2,
            ],
            [
                'type' => 'hours',
                'label' => 'Jadwal Operasional',
                'value' => 'Senin - Sabtu, 08.00 - 16.00 WIB',
                'icon_name' => 'clock',
                'order' => 3,
            ],
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.contact-sections.index'));

        $response->assertOk();
        $response->assertSee('WhatsApp Layanan');
        $response->assertSee('Alamat Jawa Tengah');
        $response->assertSee('Jadwal Operasional');
        $response->assertSee('Nama Kontak');
        $response->assertSee('Isi Kontak');
        $response->assertSee('Ikon atau Gambar');
        $response->assertDontSee('Kategori Saluran');
        $response->assertDontSee('Lihat di Peta');
        $response->assertDontSee('Buka Chat');
        $response->assertDontSee('Kirim Email');
        $response->assertDontSee('Salin Isi Kontak');
    }

    public function test_admin_can_store_and_update_contact_item_without_type_field(): void
    {
        $this->actingAs($this->user)
            ->post(route('admin.contact-sections.items.store'), [
                'label' => 'Alamat Kantor Desa',
                'value' => 'Jl. Raya Jeruklegi No. 10, Cilacap',
                'icon_name' => 'map-pin',
            ])
            ->assertRedirect(route('admin.contact-sections.index'));

        $item = ContactItem::where('label', 'Alamat Kantor Desa')->first();
        $this->assertNotNull($item);
        $this->assertSame('location', $item->type);

        $this->actingAs($this->user)
            ->put(route('admin.contact-sections.items.update', $item), [
                'label' => 'Email Pengelola',
                'value' => 'kontak@jeruklegi.id',
                'icon_name' => 'mail',
            ])
            ->assertRedirect(route('admin.contact-sections.index'));

        $this->assertDatabaseHas('contact_items', [
            'id' => $item->id,
            'label' => 'Email Pengelola',
            'type' => 'email',
            'value' => 'kontak@jeruklegi.id',
            'icon_name' => 'mail',
        ]);
    }

    public function test_contact_edit_page_only_shows_clean_item_inputs(): void
    {
        $contactSection = ContactSection::create([
            'title' => 'Section Kontak Clean Edit',
            'description' => 'Deskripsi singkat',
            'is_active' => true,
        ]);

        $contactSection->items()->create([
            'type' => 'whatsapp',
            'label' => 'WhatsApp Desa',
            'value' => '+62 812 3456 7890',
            'icon_name' => 'phone',
            'order' => 1,
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.contact-sections.edit', $contactSection));

        $response->assertOk();
        $response->assertSee('Nama Kontak');
        $response->assertSee('Isi Kontak');
        $response->assertSee('Ikon atau Gambar');
        $response->assertDontSee('Kategori Saluran');
    }

    public function test_contact_hub_renders_search_empty_state_when_query_has_no_matches(): void
    {
        ContactSection::where('is_active', true)->update(['is_active' => false]);

        $section = ContactSection::create([
            'title' => 'Hubungi Pengelola Desa',
            'description' => 'Silakan hubungi kami.',
            'is_active' => true,
        ]);

        $section->items()->create([
            'type' => 'whatsapp',
            'label' => 'WHATSAPP',
            'value' => '+62 812 3456 7890',
            'icon_name' => 'phone',
            'order' => 1,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('admin.contact-sections.index', ['search' => 'saluran-tidak-ada']));

        $response->assertOk();
        $response->assertSee('Saluran Kontak Tidak Ditemukan');
        $response->assertSee('Tampilkan Semua Saluran');
        $response->assertDontSee('Belum Ada Saluran Kontak');
    }

    public function test_contact_hub_renders_empty_state_when_no_items_exist(): void
    {
        ContactSection::where('is_active', true)->update(['is_active' => false]);

        ContactSection::create([
            'title' => 'Hubungi Pengelola Desa',
            'description' => 'Silakan hubungi kami.',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.contact-sections.index'));

        $response->assertOk();
        $response->assertSee('Belum Ada Saluran Kontak');
        $response->assertSee('0 Saluran');
    }
}
