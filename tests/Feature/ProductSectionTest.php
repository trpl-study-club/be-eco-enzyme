<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductSectionTest extends TestCase
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

        Storage::fake('public');
    }

    public function test_admin_can_access_products_index_page(): void
    {
        Product::create([
            'name' => 'Sabun Eco-Enzyme Uji',
            'price' => 'Rp 15.000',
            'detail' => 'Deskripsi singkat produk uji.',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.product-sections.index'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Produk');
        $response->assertSee('Sabun Eco-Enzyme Uji');
        $response->assertSee('Rp 15.000');
    }

    public function test_admin_can_access_product_create_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.product-sections.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Produk Baru');
        $response->assertSee('Nama Produk');
        $response->assertSee('Harga Produk');
    }

    public function test_admin_can_store_individual_product_with_auto_incremented_order(): void
    {
        Product::query()->delete();

        $mainImage = UploadedFile::fake()->image('main.jpg');
        $detailImages = [
            UploadedFile::fake()->image('detail1.jpg'),
            UploadedFile::fake()->image('detail2.png'),
        ];

        $payload1 = [
            'name' => 'Sabun Mandi Eco-Enzyme',
            'price' => 'Rp 20.000',
            'detail' => 'Sabun alami untuk mandi harian tanpa busa kimia berbahaya.',
            'action' => 'publish',
            'image' => $mainImage,
            'detail_images' => $detailImages,
        ];

        $response1 = $this->actingAs($this->user)->post(route('admin.product-sections.store'), $payload1);
        $response1->assertRedirect(route('admin.product-sections.index'));

        $payload2 = [
            'name' => 'Cairan Pembersih Eco-Enzyme',
            'price' => 'Rp 25.000',
            'detail' => 'Pembersih lantai ramah lingkungan.',
            'action' => 'publish',
        ];

        $response2 = $this->actingAs($this->user)->post(route('admin.product-sections.store'), $payload2);
        $response2->assertRedirect(route('admin.product-sections.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Sabun Mandi Eco-Enzyme',
            'order' => 1,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Cairan Pembersih Eco-Enzyme',
            'order' => 2,
            'is_active' => true,
        ]);

        $savedProduct = Product::where('name', 'Sabun Mandi Eco-Enzyme')->first();
        $this->assertNotNull($savedProduct);
        $this->assertNotNull($savedProduct->image);
        $this->assertCount(2, $savedProduct->detailImages);
    }

    public function test_admin_can_edit_and_update_individual_product(): void
    {
        $product = Product::create([
            'name' => 'Produk Lama',
            'price' => 'Rp 10.000',
            'detail' => 'Detail Lama',
            'order' => 1,
            'is_active' => true,
        ]);

        $editResponse = $this->actingAs($this->user)->get(route('admin.product-sections.edit', $product));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Produk Lama');

        $payload = [
            'name' => 'Produk Diperbarui',
            'price' => 'Rp 18.000',
            'detail' => 'Detail produk telah diperbarui.',
            'action' => 'draft',
        ];

        $response = $this->actingAs($this->user)->put(route('admin.product-sections.update', $product), $payload);

        $response->assertRedirect(route('admin.product-sections.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Produk Diperbarui',
            'price' => 'Rp 18.000',
            'detail' => 'Detail produk telah diperbarui.',
            'is_active' => false,
        ]);
    }

    public function test_admin_can_toggle_individual_product_status_independently(): void
    {
        $product1 = Product::create([
            'name' => 'Produk 1',
            'price' => 'Rp 10.000',
            'order' => 1,
            'is_active' => true,
        ]);

        $product2 = Product::create([
            'name' => 'Produk 2',
            'price' => 'Rp 15.000',
            'order' => 2,
            'is_active' => false,
        ]);

        // Activate product 2 without deactivating product 1
        $this->actingAs($this->user)
            ->patch(route('admin.product-sections.toggle-status', $product2))
            ->assertRedirect();

        $this->assertTrue($product1->fresh()->is_active);
        $this->assertTrue($product2->fresh()->is_active);

        // Deactivate product 1 while keeping it in database
        $this->actingAs($this->user)
            ->patch(route('admin.product-sections.toggle-status', $product1))
            ->assertRedirect();

        $this->assertFalse($product1->fresh()->is_active);
        $this->assertTrue($product2->fresh()->is_active);
    }

    public function test_api_products_returns_only_active_products_with_exact_schema(): void
    {
        Product::query()->delete();

        $inactiveProduct = Product::create([
            'name' => 'Produk Nonaktif',
            'price' => 'Rp 50.000',
            'detail' => 'Tidak tampil di API publik',
            'order' => 1,
            'is_active' => false,
        ]);

        $activeProduct2 = Product::create([
            'name' => 'Produk Kedua',
            'price' => 'Rp 25.000',
            'detail' => 'Detail 2',
            'order' => 2,
            'is_active' => true,
        ]);

        $activeProduct1 = Product::create([
            'name' => 'Sabun Batang',
            'price' => '11000',
            'detail' => 'Lembut di kulit, wangi alami dari enzim buah.',
            'image' => 'product-images/sabun-batang-1.webp',
            'order' => 1,
            'is_active' => true,
        ]);

        $activeProduct1->detailImages()->create([
            'image' => 'product-detail-images/sabun-batang-2.webp',
            'order' => 1,
        ]);

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonPath('data.0.id', $activeProduct1->id);
        $response->assertJsonPath('data.0.name', 'Sabun Batang');
        $response->assertJsonPath('data.0.detail', 'Lembut di kulit, wangi alami dari enzim buah.');
        $response->assertJsonPath('data.0.price', '11000');
        $response->assertJsonPath('data.0.price_formatted', 'Rp 11.000');
        $response->assertJsonPath('data.0.order', 1);
        $response->assertJsonPath('data.0.is_active', true);
        $response->assertJsonCount(2, 'data.0.images');

        $response->assertJsonPath('data.1.id', $activeProduct2->id);
        $response->assertJsonPath('data.1.price', 'Rp 25.000');
        $response->assertJsonPath('data.1.price_formatted', 'Rp 25.000');
        $response->assertJsonPath('data.1.order', 2);
        $response->assertJsonMissing(['id' => $inactiveProduct->id]);

        $firstItemKeys = array_keys($response->json('data.0'));
        $this->assertSame(['id', 'name', 'detail', 'price', 'price_formatted', 'order', 'images', 'is_active'], $firstItemKeys);
    }

    public function test_format_rupiah_helper_handles_numeric_null_empty_and_non_numeric_safely(): void
    {
        $this->assertSame('Rp 11.000', formatRupiah('11000'));
        $this->assertSame('Rp 11.000', formatRupiah(11000));
        $this->assertSame('Rp 1.250.000', formatRupiah('1250000'));
        $this->assertSame('Rp 15.000', formatRupiah('Rp 15.000'));
        $this->assertSame('Rp 0', formatRupiah(0));
        $this->assertNull(formatRupiah(null));
        $this->assertNull(formatRupiah(''));
        $this->assertNull(formatRupiah('   '));
        $this->assertNull(formatRupiah('Hubungi Petugas'));
        $this->assertNull(formatRupiah([]));
    }

    public function test_destroy_product_deletes_images_from_storage(): void
    {
        $product = Product::create([
            'name' => 'Produk Delete Storage',
            'price' => 'Rp 12.000',
            'image' => 'product-images/main_del.jpg',
            'order' => 1,
            'is_active' => true,
        ]);
        Storage::disk('public')->put('product-images/main_del.jpg', 'main content');

        $product->detailImages()->create([
            'image' => 'product-detail-images/detail_del.jpg',
            'order' => 1,
        ]);
        Storage::disk('public')->put('product-detail-images/detail_del.jpg', 'detail content');

        $response = $this->actingAs($this->user)->delete(route('admin.product-sections.destroy', $product));

        $response->assertRedirect(route('admin.product-sections.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);

        Storage::disk('public')->assertMissing('product-images/main_del.jpg');
        Storage::disk('public')->assertMissing('product-detail-images/detail_del.jpg');
    }
}
