<?php

namespace Tests\Feature;

use App\Models\HowToOrderSection;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HowToOrderSectionTest extends TestCase
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

    public function test_admin_can_access_how_to_orders_index_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.how-to-orders.index'));

        $response->assertStatus(200);
        $response->assertSee('Cara Pesan');
        $response->assertSee('Tambah Panduan Baru');
    }

    public function test_admin_can_access_how_to_orders_create_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.how-to-orders.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Panduan Cara Pesan');
        $response->assertSee('Daftar Langkah (Steps)');
    }

    public function test_admin_can_store_how_to_order_section_with_lucide_icon(): void
    {
        $payload = [
            'title' => 'Cara Order Baru',
            'description' => 'Langkah-langkah pemesanan produk kami.',
            'button_text' => 'Pesan Sekarang',
            'button_link' => 'https://wa.me/6281234567890',
            'action' => 'publish',
            'steps' => [
                [
                    'title' => 'Pilih Produk',
                    'description' => 'Tentukan varian dan jumlah produk yang diinginkan.',
                    'icon_name' => 'shopping-cart',
                ],
                [
                    'title' => 'Konfirmasi Pembayaran',
                    'description' => 'Transfer dan kirimkan bukti transfer ke admin.',
                    'icon_name' => 'credit-card',
                ],
                [
                    'title' => 'Pengiriman Cepat',
                    'description' => 'Pesanan dikirim langsung ke alamat tujuan.',
                    'icon_name' => 'truck',
                ],
            ],
        ];

        $response = $this->actingAs($this->user)->post(route('admin.how-to-orders.store'), $payload);

        $response->assertRedirect(route('admin.how-to-orders.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('how_to_order_sections', [
            'title' => 'Cara Order Baru',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('how_to_order_steps', [
            'title' => 'Pilih Produk',
            'icon_name' => 'shopping-cart',
            'step_order' => 1,
        ]);

        $this->assertDatabaseHas('how_to_order_steps', [
            'title' => 'Konfirmasi Pembayaran',
            'icon_name' => 'credit-card',
            'step_order' => 2,
        ]);

        $this->assertDatabaseHas('how_to_order_steps', [
            'title' => 'Pengiriman Cepat',
            'icon_name' => 'truck',
            'step_order' => 3,
        ]);
    }

    public function test_admin_can_store_how_to_order_section_with_custom_icon_upload(): void
    {
        Storage::fake('public');

        $fakeIcon = UploadedFile::fake()->image('custom-icon.png', 64, 64);

        $payload = [
            'title' => 'Cara Order dengan Custom Icon',
            'description' => 'Deskripsi order',
            'action' => 'publish',
            'steps' => [
                [
                    'title' => 'Langkah Custom',
                    'description' => 'Menggunakan custom upload icon',
                    'icon_name' => 'package',
                    'icon_image' => $fakeIcon,
                ],
            ],
        ];

        $response = $this->actingAs($this->user)->post(route('admin.how-to-orders.store'), $payload);

        $response->assertRedirect(route('admin.how-to-orders.index'));

        $section = HowToOrderSection::where('title', 'Cara Order dengan Custom Icon')->firstOrFail();
        $step = $section->steps()->firstOrFail();

        $this->assertEquals('package', $step->icon_name);
        $this->assertNotNull($step->icon_image);
        Storage::disk('public')->assertExists($step->icon_image);
        $this->assertStringContainsString('storage/', $step->icon_image_url);
    }

    public function test_admin_can_update_how_to_order_section_and_change_icons(): void
    {
        Storage::fake('public');

        $section = HowToOrderSection::create([
            'title' => 'Order Lama',
            'description' => 'Desc Lama',
            'is_active' => true,
        ]);

        $step = $section->steps()->create([
            'title' => 'Step Awal',
            'description' => 'Desc Awal',
            'icon_name' => 'phone',
            'step_order' => 1,
        ]);

        $newIcon = UploadedFile::fake()->image('new-icon.png', 64, 64);

        $payload = [
            'title' => 'Order Updated',
            'description' => 'Desc Baru',
            'action' => 'publish',
            'steps' => [
                [
                    'id' => $step->id,
                    'title' => 'Step Diperbarui',
                    'description' => 'Desc Diperbarui',
                    'icon_name' => 'mail',
                    'icon_image' => $newIcon,
                ],
            ],
        ];

        $response = $this->actingAs($this->user)->put(route('admin.how-to-orders.update', $section), $payload);

        $response->assertRedirect(route('admin.how-to-orders.index'));

        $step->refresh();
        $this->assertEquals('Step Diperbarui', $step->title);
        $this->assertEquals('mail', $step->icon_name);
        $this->assertNotNull($step->icon_image);
        Storage::disk('public')->assertExists($step->icon_image);
    }

    public function test_admin_can_remove_custom_icon_image(): void
    {
        Storage::fake('public');

        $storedPath = UploadedFile::fake()->image('old-icon.png')->store('how-to-order-step-icons', 'public');

        $section = HowToOrderSection::create([
            'title' => 'Order Section Hapus Icon',
            'is_active' => true,
        ]);

        $step = $section->steps()->create([
            'title' => 'Langkah Bersihkan Icon',
            'description' => 'Deskripsi',
            'icon_name' => 'box',
            'icon_image' => $storedPath,
            'step_order' => 1,
        ]);

        Storage::disk('public')->assertExists($storedPath);

        $payload = [
            'title' => 'Order Section Hapus Icon',
            'action' => 'publish',
            'steps' => [
                [
                    'id' => $step->id,
                    'title' => 'Langkah Bersihkan Icon',
                    'description' => 'Deskripsi',
                    'icon_name' => 'box',
                    'remove_icon_image' => '1',
                ],
            ],
        ];

        $response = $this->actingAs($this->user)->put(route('admin.how-to-orders.update', $section), $payload);

        $response->assertRedirect(route('admin.how-to-orders.index'));

        $step->refresh();
        $this->assertNull($step->icon_image);
        Storage::disk('public')->assertMissing($storedPath);
    }

    public function test_api_v1_how_to_orders_returns_icon_attributes(): void
    {
        HowToOrderSection::where('is_active', true)->update(['is_active' => false]);

        $section = HowToOrderSection::create([
            'title' => 'API Cara Pesan Test',
            'description' => 'API Desc',
            'button_text' => 'Hubungi Kami',
            'button_link' => 'https://wa.me/test',
            'is_active' => true,
        ]);

        $section->steps()->create([
            'title' => 'Langkah Pertama',
            'description' => 'Detail langkah pertama',
            'icon_name' => 'sparkles',
            'step_order' => 1,
        ]);

        $response = $this->getJson('/api/v1/how-to-orders');

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'API Cara Pesan Test')
            ->assertJsonPath('data.steps.0.title', 'Langkah Pertama')
            ->assertJsonPath('data.steps.0.icon_name', 'sparkles');
    }
}
