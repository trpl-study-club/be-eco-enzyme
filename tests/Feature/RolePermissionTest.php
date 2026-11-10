<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use DatabaseTransactions;

    protected User $superAdmin;

    protected User $adminWithHome;

    protected User $adminWithoutPerms;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->superAdmin = User::create([
            'name' => 'Super Admin Tester',
            'email' => 'perm_superadmin@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);
        $this->superAdmin->assignRole('super_admin');

        $this->adminWithHome = User::create([
            'name' => 'Admin Home Only',
            'email' => 'perm_admin_home@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);
        $this->adminWithHome->assignRole('admin');
        $this->adminWithHome->givePermissionTo('manage_home_sections');

        $this->adminWithoutPerms = User::create([
            'name' => 'Admin No Perms',
            'email' => 'perm_admin_none@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);
        $this->adminWithoutPerms->assignRole('admin');
    }

    public function test_super_admin_can_access_all_module_sections(): void
    {
        $routes = [
            'admin.home-sections.index',
            'admin.about-sections.index',
            'admin.product-sections.index',
            'admin.how-to-orders.index',
            'admin.testimonials.index',
            'admin.contact-sections.index',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($this->superAdmin)->get(route($route));
            $response->assertStatus(200);
        }
    }

    public function test_admin_with_home_permission_can_access_home_section(): void
    {
        $response = $this->actingAs($this->adminWithHome)->get(route('admin.home-sections.index'));
        $response->assertStatus(200);
    }

    public function test_admin_without_home_permission_is_forbidden(): void
    {
        $response = $this->actingAs($this->adminWithoutPerms)->get(route('admin.home-sections.index'));
        $response->assertStatus(403);
    }

    public function test_admin_without_about_permission_is_forbidden(): void
    {
        $response = $this->actingAs($this->adminWithHome)->get(route('admin.about-sections.index'));
        $response->assertStatus(403);
    }

    public function test_admin_without_product_permission_is_forbidden(): void
    {
        $response = $this->actingAs($this->adminWithHome)->get(route('admin.product-sections.index'));
        $response->assertStatus(403);
    }

    public function test_admin_without_how_to_order_permission_is_forbidden(): void
    {
        $response = $this->actingAs($this->adminWithHome)->get(route('admin.how-to-orders.index'));
        $response->assertStatus(403);
    }

    public function test_admin_without_testimonials_permission_is_forbidden(): void
    {
        $response = $this->actingAs($this->adminWithHome)->get(route('admin.testimonials.index'));
        $response->assertStatus(403);
    }

    public function test_admin_without_contact_permission_is_forbidden(): void
    {
        $response = $this->actingAs($this->adminWithHome)->get(route('admin.contact-sections.index'));
        $response->assertStatus(403);
    }

    public function test_sidebar_shows_only_permitted_modules_for_admin(): void
    {
        $response = $this->actingAs($this->adminWithHome)->get(route('admin.dashboard'));

        $response->assertStatus(200)
            ->assertSee(route('admin.home-sections.index'))
            ->assertDontSee(route('admin.about-sections.index'))
            ->assertDontSee(route('admin.product-sections.index'))
            ->assertDontSee(route('admin.how-to-orders.index'))
            ->assertDontSee(route('admin.testimonials.index'))
            ->assertDontSee(route('admin.contact-sections.index'))
            ->assertDontSee(route('admin.users.index'))
            ->assertDontSee('Daftar Petugas Pengelola');
    }

    public function test_sidebar_shows_all_modules_and_pengaturan_for_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('admin.dashboard'));

        $response->assertStatus(200)
            ->assertSee('Pengaturan')
            ->assertSee('Daftar Petugas Pengelola')
            ->assertSee('Beranda')
            ->assertSee('Tentang Kami')
            ->assertSee('Produk')
            ->assertSee('Cara Pesan')
            ->assertSee('Testimoni')
            ->assertSee('Kontak');
    }
}
