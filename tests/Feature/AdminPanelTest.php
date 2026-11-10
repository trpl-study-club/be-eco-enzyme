<?php

namespace Tests\Feature;

use App\Models\AboutSection;
use App\Models\HomeSection;
use App\Models\HowToOrderSection;
use App\Models\ProductSection;
use App\Models\TestimonialSection;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPanelTest extends TestCase
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

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200)
            ->assertSee('Halaman Masuk Pengelola Desa')
            ->assertSee('togglePasswordBtn')
            ->assertSee('Tampilkan kata sandi');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_authenticated_user_can_view_dashboard(): void
    {
        $response = $this->actingAs($this->user)->get('/admin/dashboard');

        $response->assertStatus(200)
            ->assertSee('Halaman Utama')
            ->assertSee('Panel Pengelola')
            ->assertSee('Lihat Halaman Utama')
            ->assertSee('https://sanitasihijau.com/');
    }

    public function test_dashboard_displays_correct_about_points_pilar_count(): void
    {
        // Deactivate existing about sections to isolate this test
        AboutSection::query()->update(['is_active' => false]);

        $about = AboutSection::create([
            'title' => 'Program Pengabdian Test',
            'description' => 'Deskripsi program test',
            'is_active' => true,
        ]);

        $about->cards()->createMany([
            ['title' => 'Pilar 1', 'description' => 'Deskripsi 1', 'steps' => 1],
            ['title' => 'Pilar 2', 'description' => 'Deskripsi 2', 'steps' => 2],
            ['title' => 'Pilar 3', 'description' => 'Deskripsi 3', 'steps' => 3],
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.dashboard'));

        $response->assertStatus(200)
            ->assertSee('3 Poin Pilar');
    }

    public function test_home_sections_index_displays_correct_badge_when_no_active_banner(): void
    {
        HomeSection::query()->delete();

        $response = $this->actingAs($this->user)->get(route('admin.home-sections.index'));

        $response->assertStatus(200)
            ->assertSee('Belum Ada Banner Aktif')
            ->assertDontSee('1 Banner Aktif Utama');
    }

    public function test_home_sections_index_displays_correct_badge_when_active_banner_exists(): void
    {
        HomeSection::query()->delete();
        HomeSection::create([
            'title' => 'Banner Aktif',
            'description' => 'Deskripsi banner',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.home-sections.index'));

        $response->assertStatus(200)
            ->assertSee('1 Banner Aktif Utama')
            ->assertDontSee('Belum Ada Banner Aktif');
    }

    public function test_authenticated_user_can_create_home_section(): void
    {
        $file = UploadedFile::fake()->image('hero.jpg');

        $response = $this->actingAs($this->user)->post(route('admin.home-sections.store'), [
            'title' => 'Pengabdian Masyarakat Inovatif',
            'description' => '<p>Deskripsi program beranda inovatif.</p>',
            'image' => $file,
            'button_one_text' => 'Lihat Program',
            'button_one_link' => '#programs',
            'button_two_text' => 'Kontak',
            'button_two_link' => '#contact',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.home-sections.index'));
        $this->assertDatabaseHas('home_sections', [
            'title' => 'Pengabdian Masyarakat Inovatif',
            'is_active' => true,
        ]);
    }

    public function test_authenticated_user_can_create_home_section_as_draft(): void
    {
        $response = $this->actingAs($this->user)->post(route('admin.home-sections.store'), [
            'title' => 'Banner Draf Pengabdian',
            'description' => '<p>Deskripsi banner draf yang belum dipublikasikan.</p>',
            'action' => 'draft',
        ]);

        $response->assertRedirect(route('admin.home-sections.index'))
            ->assertSessionHas('success', 'Banner berhasil disimpan sebagai draft.');

        $this->assertDatabaseHas('home_sections', [
            'title' => 'Banner Draf Pengabdian',
            'is_active' => false,
        ]);
    }

    public function test_authenticated_user_can_create_active_banner_and_deactivate_others(): void
    {
        $oldBanner = HomeSection::create([
            'title' => 'Banner Lama Aktif',
            'description' => 'Deskripsi banner lama',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->post(route('admin.home-sections.store'), [
            'title' => 'Banner Baru Pengganti',
            'description' => '<p>Deskripsi banner baru</p>',
            'action' => 'publish',
        ]);

        $response->assertRedirect(route('admin.home-sections.index'));

        $this->assertDatabaseHas('home_sections', [
            'title' => 'Banner Baru Pengganti',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('home_sections', [
            'id' => $oldBanner->id,
            'is_active' => false,
        ]);
    }

    public function test_authenticated_user_can_toggle_home_section_status(): void
    {
        $banner = HomeSection::create([
            'title' => 'Banner Toggle Test',
            'description' => 'Deskripsi banner toggle',
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->user)->patch(route('admin.home-sections.toggle-status', $banner));
        $response->assertRedirect();

        $this->assertDatabaseHas('home_sections', [
            'id' => $banner->id,
            'is_active' => true,
        ]);
    }

    public function test_authenticated_user_can_update_home_section_and_remove_image(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('banner.jpg');
        $path = $file->store('home-sections', 'public');

        $banner = HomeSection::create([
            'title' => 'Banner Dengan Gambar',
            'description' => '<p>Deskripsi banner</p>',
            'image' => $path,
            'is_active' => true,
        ]);

        Storage::disk('public')->assertExists($path);

        $response = $this->actingAs($this->user)->put(route('admin.home-sections.update', $banner), [
            'title' => 'Banner Tanpa Gambar',
            'description' => '<p>Deskripsi banner</p>',
            'remove_image' => '1',
            'action' => 'publish',
        ]);

        $response->assertRedirect(route('admin.home-sections.index'))
            ->assertSessionHas('success', 'Banner berhasil diperbarui.');

        $this->assertDatabaseHas('home_sections', [
            'id' => $banner->id,
            'title' => 'Banner Tanpa Gambar',
            'image' => null,
        ]);

        Storage::disk('public')->assertMissing($path);
    }

    public function test_home_section_edit_view_renders_delete_image_button(): void
    {
        $banner = HomeSection::create([
            'title' => 'Banner Edit View Test',
            'description' => '<p>Deskripsi banner</p>',
            'image' => 'home-sections/sample.jpg',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.home-sections.edit', $banner));
        $response->assertStatus(200)
            ->assertSee('id="remove-image-flag"', false)
            ->assertSee('id="btn-remove-image"', false)
            ->assertSee('Hapus Gambar');
    }

    public function test_authenticated_user_can_create_about_section_with_points(): void
    {
        $file = UploadedFile::fake()->image('about.jpg');

        $response = $this->actingAs($this->user)->post(route('admin.about-sections.store'), [
            'title' => 'Tentang Pengabdian Dosen',
            'description' => '<p>Deskripsi kegiatan tentang pengabdian.</p>',
            'image' => $file,
            'points' => [
                [
                    'number' => 1,
                    'title' => 'Pemberdayaan Masyarakat',
                    'description' => 'Pendampingan dan pelatihan masyarakat.',
                ],
                [
                    'number' => 2,
                    'title' => 'Penerapan IPTEK',
                    'description' => 'Penerapan teknologi tepat guna.',
                ],
            ],
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.about-sections.index'));
        $this->assertDatabaseHas('about_sections', [
            'title' => 'Tentang Pengabdian Dosen',
            'is_active' => true,
        ]);
    }

    public function test_authenticated_user_can_create_about_section_as_draft(): void
    {
        $response = $this->actingAs($this->user)->post(route('admin.about-sections.store'), [
            'title' => 'About Section Draft',
            'description' => '<p>Deskripsi draft about section.</p>',
            'action' => 'draft',
        ]);

        $response->assertRedirect(route('admin.about-sections.index'))
            ->assertSessionHas('success', 'Konten Tentang Kami berhasil disimpan sebagai draf.');

        $this->assertDatabaseHas('about_sections', [
            'title' => 'About Section Draft',
            'is_active' => false,
        ]);
    }

    public function test_authenticated_user_can_create_active_about_section_and_deactivate_others(): void
    {
        $oldSection = AboutSection::create([
            'title' => 'About Section Lama Aktif',
            'description' => 'Deskripsi section lama',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->post(route('admin.about-sections.store'), [
            'title' => 'About Section Baru Pengganti',
            'description' => '<p>Deskripsi section baru</p>',
            'action' => 'publish',
        ]);

        $response->assertRedirect(route('admin.about-sections.index'));

        $this->assertDatabaseHas('about_sections', [
            'title' => 'About Section Baru Pengganti',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('about_sections', [
            'id' => $oldSection->id,
            'is_active' => false,
        ]);
    }

    public function test_authenticated_user_can_toggle_about_section_status(): void
    {
        $section = AboutSection::create([
            'title' => 'About Toggle Test',
            'description' => 'Deskripsi toggle',
            'is_active' => false,
        ]);

        $response = $this->actingAs($this->user)->patch(route('admin.about-sections.toggle-status', $section));
        $response->assertRedirect();

        $this->assertDatabaseHas('about_sections', [
            'id' => $section->id,
            'is_active' => true,
        ]);
    }

    public function test_frontend_api_returns_active_home_sections(): void
    {
        HomeSection::create([
            'title' => 'Banner FE Test',
            'description' => 'Deskripsi untuk frontend',
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/v1/home');
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Banner FE Test']);
    }

    public function test_frontend_api_returns_active_about_sections(): void
    {
        $about = AboutSection::create([
            'title' => 'About FE Test',
            'description' => 'Deskripsi tentang program',
            'points' => [
                ['number' => 1, 'title' => 'Pilar Satu', 'description' => 'Uraian pilar satu'],
            ],
            'is_active' => true,
        ]);

        $about->cards()->create([
            'title' => 'Pilar Inovasi',
            'description' => 'Deskripsi pilar inovasi',
            'icon_name' => 'sparkles',
        ]);

        $response = $this->getJson('/api/v1/about');
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'About FE Test'])
            ->assertJsonPath('data.0.cards.0.icon_name', 'sparkles');
    }

    public function test_create_views_display_terakhir_diperbarui_wib(): void
    {
        $sections = [
            'admin.home-sections.create',
            'admin.about-sections.create',
            'admin.product-sections.create',
            'admin.how-to-orders.create',
            'admin.testimonial-sections.create',
        ];

        foreach ($sections as $route) {
            $response = $this->actingAs($this->user)->get(route($route));
            $response->assertStatus(200)
                ->assertSee('Terakhir Diperbarui:')
                ->assertSee('WIB')
                ->assertSee('Saat disimpan (Baru)');
        }
    }

    public function test_updating_product_touches_product_section_timestamp(): void
    {
        Carbon::setTestNow(now()->subHours(2));

        $section = ProductSection::create([
            'title' => 'Produk Awal',
            'description' => 'Deskripsi',
            'is_active' => true,
        ]);

        $initialTime = $section->fresh()->updated_at;

        Carbon::setTestNow(now()->addHours(2));

        // Update via controller endpoint
        $this->actingAs($this->user)->put(route('admin.product-sections.update', $section), [
            'title' => 'Produk Awal', // Main attributes unchanged
            'description' => 'Deskripsi',
            'is_active' => '1',
            'products' => [
                [
                    'name' => 'Produk Baru Ditambahkan',
                    'price' => 'Rp 50.000',
                ],
            ],
        ]);

        $updatedSection = $section->fresh();
        $this->assertTrue($updatedSection->updated_at->isAfter($initialTime));

        Carbon::setTestNow();
    }

    public function test_edit_views_display_terakhir_diperbarui_wib(): void
    {
        $home = HomeSection::create(['title' => 'Home Edit', 'description' => 'Desc', 'is_active' => true]);
        $about = AboutSection::create(['title' => 'About Edit', 'description' => 'Desc', 'is_active' => true]);
        $product = ProductSection::create(['title' => 'Product Edit', 'description' => 'Desc', 'is_active' => true]);
        $howToOrder = HowToOrderSection::create(['title' => 'How To Order Edit', 'description' => 'Desc', 'is_active' => true]);
        $testimonial = TestimonialSection::create(['title' => 'Testimonial Edit', 'is_active' => true]);

        $routesWithModels = [
            route('admin.home-sections.edit', $home),
            route('admin.about-sections.edit', $about),
            route('admin.product-sections.edit', $product),
            route('admin.how-to-orders.edit', $howToOrder),
            route('admin.testimonial-sections.edit', $testimonial),
        ];

        foreach ($routesWithModels as $url) {
            $response = $this->actingAs($this->user)->get($url);
            $response->assertStatus(200)
                ->assertSee('Terakhir Diperbarui:')
                ->assertSee('WIB');
        }
    }
}
