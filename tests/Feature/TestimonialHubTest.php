<?php

namespace Tests\Feature;

use App\Models\TestimonialSection;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TestimonialHubTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $this->user->assignRole('super_admin');
    }

    public function test_admin_can_access_testimonial_hub(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/testimonials');

        $response->assertStatus(200);
        $response->assertSee('Testimonial Pelanggan');
        $response->assertSee('Tambah Ulasan Sekarang');
    }

    public function test_admin_can_batch_store_testimonials(): void
    {
        $payload = [
            'items' => [
                [
                    'name' => 'Budi Hartono',
                    'location' => 'Cilacap',
                    'quote' => 'Pelatihan eco-enzyme ini sangat bermanfaat untuk pertanian organik kami.',
                ],
                [
                    'name' => 'Siti Nurhaliza',
                    'location' => 'Banyumas',
                    'quote' => 'Limbah dapur sekarang bernilai dan lingkungan rumah jadi lebih bersih.',
                ],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->post('/admin/testimonials/batch-store', $payload);

        $response->assertRedirect('/admin/testimonials');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('testimonial_items', [
            'name' => 'Budi Hartono',
            'location' => 'Cilacap',
        ]);

        $this->assertDatabaseHas('testimonial_items', [
            'name' => 'Siti Nurhaliza',
            'location' => 'Banyumas',
        ]);
    }

    public function test_admin_can_batch_store_testimonials_with_legacy_subtitle(): void
    {
        $payload = [
            'items' => [
                [
                    'name' => 'Legacy User',
                    'subtitle' => 'Legacy Subtitle',
                    'quote' => 'Ulasan dengan key subtitle lama.',
                ],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->post('/admin/testimonials/batch-store', $payload);

        $response->assertRedirect('/admin/testimonials');
        $this->assertDatabaseHas('testimonial_items', [
            'name' => 'Legacy User',
            'location' => 'Legacy Subtitle',
        ]);
    }

    public function test_admin_can_update_testimonial_item(): void
    {
        $section = TestimonialSection::firstOrCreate(
            ['is_active' => true],
            ['title' => 'Apa Kata Mereka?']
        );

        $item = $section->testimonials()->create([
            'name' => 'Nama Lama',
            'location' => 'Lokasi Lama',
            'quote' => 'Ulasan lama yang perlu diedit.',
        ]);

        $response = $this->actingAs($this->user)
            ->put("/admin/testimonials/items/{$item->id}", [
                'name' => 'Nama Baru Diperbarui',
                'location' => 'Cilacap Selatan',
                'quote' => 'Ulasan yang sudah diperbarui dengan baik.',
            ]);

        $response->assertRedirect('/admin/testimonials');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('testimonial_items', [
            'id' => $item->id,
            'name' => 'Nama Baru Diperbarui',
            'location' => 'Cilacap Selatan',
        ]);
    }

    public function test_admin_can_delete_testimonial_item(): void
    {
        $section = TestimonialSection::firstOrCreate(
            ['is_active' => true],
            ['title' => 'Apa Kata Mereka?']
        );

        $item = $section->testimonials()->create([
            'name' => 'Untuk Dihapus',
            'location' => 'Tester',
            'quote' => 'Data ulasan uji coba.',
        ]);

        $response = $this->actingAs($this->user)
            ->delete("/admin/testimonials/items/{$item->id}");

        $response->assertRedirect('/admin/testimonials');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('testimonial_items', [
            'id' => $item->id,
        ]);
    }

    public function test_admin_can_update_header_and_statistics(): void
    {
        $payload = [
            'title' => 'Suara Komunitas Eco-Enzyme',
            'statistics' => [
                [
                    'value' => '750+',
                    'description' => 'Relawan Terlibat',
                ],
                [
                    'value' => '1.200 L',
                    'description' => 'Cairan Terproduksi',
                ],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->post('/admin/testimonials/header', $payload);

        $response->assertRedirect('/admin/testimonials');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('testimonial_sections', [
            'title' => 'Suara Komunitas Eco-Enzyme',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('testimonial_statistics', [
            'value' => '750+',
            'description' => 'Relawan Terlibat',
        ]);
    }

    public function test_legacy_testimonial_sections_route_redirects_to_hub(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/testimonial-sections');

        $response->assertRedirect('/admin/testimonials');
    }

    public function test_api_v1_testimonials_returns_location_in_payload(): void
    {
        $section = TestimonialSection::firstOrCreate(
            ['is_active' => true],
            ['title' => 'Apa Kata Mereka?']
        );

        $section->testimonials()->create([
            'name' => 'Budi Hartono',
            'location' => 'Cilacap',
            'quote' => 'Sangat bermanfaat.',
        ]);

        $response = $this->getJson('/api/v1/testimonials');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'is_active',
                'statistics',
                'testimonials' => [
                    '*' => [
                        'id',
                        'quote',
                        'name',
                        'location',
                    ],
                ],
            ],
        ]);
        $response->assertJsonPath('data.is_active', true);
        $response->assertJsonMissingPath('data.testimonials.0.subtitle');
    }

    public function test_admin_can_toggle_testimonial_section_status(): void
    {
        TestimonialSection::query()->delete();

        $section = TestimonialSection::create([
            'title' => 'Apa Kata Mereka?',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)
            ->from('/admin/testimonials')
            ->patch('/admin/testimonials/toggle-status');

        $response->assertRedirect('/admin/testimonials');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('testimonial_sections', [
            'id' => $section->id,
            'is_active' => false,
        ]);

        $this->actingAs($this->user)->get('/admin/testimonials')->assertStatus(200);
        $this->assertDatabaseHas('testimonial_sections', [
            'id' => $section->id,
            'is_active' => false,
        ]);

        $this->getJson('/api/v1/testimonials')
            ->assertStatus(200)
            ->assertExactJson(['data' => null]);

        $this->actingAs($this->user)
            ->from('/admin/testimonials')
            ->patch('/admin/testimonials/toggle-status')
            ->assertRedirect('/admin/testimonials');

        $this->assertDatabaseHas('testimonial_sections', [
            'id' => $section->id,
            'is_active' => true,
        ]);
    }
}
