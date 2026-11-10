<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use DatabaseTransactions;

    protected User $superAdmin;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->superAdmin = User::firstOrCreate(
            ['email' => 'test_superadmin@example.com'],
            [
                'name' => 'Test Super Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $this->superAdmin->assignRole('super_admin');

        $this->admin = User::firstOrCreate(
            ['email' => 'test_admin@example.com'],
            [
                'name' => 'Test Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $this->admin->assignRole('admin');
    }

    public function test_guest_cannot_access_user_management(): void
    {
        $response = $this->get(route('admin.users.index'));
        $response->assertRedirect('/login');
    }

    public function test_regular_admin_cannot_access_user_management(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_view_users_index(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('admin.users.index'));

        $response->assertStatus(200)
            ->assertSee('Daftar Petugas Pengelola')
            ->assertSee($this->superAdmin->name)
            ->assertSee($this->admin->name);
    }

    public function test_super_admin_can_search_and_filter_users(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('admin.users.index', [
            'search' => 'Test Super Admin',
            'role' => 'super_admin',
            'status' => 'active',
        ]));

        $response->assertStatus(200)
            ->assertSee('Test Super Admin');
    }

    public function test_super_admin_can_view_create_user_page(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('admin.users.create'));

        $response->assertStatus(200)
            ->assertSee('Tambah Petugas Baru')
            ->assertSee('Informasi Akun Petugas')
            ->assertSee('Hak Akses Modul Website');
    }

    public function test_super_admin_can_create_new_user_with_role_and_permissions(): void
    {
        $response = $this->actingAs($this->superAdmin)->post(route('admin.users.store'), [
            'name' => 'New Staff Admin',
            'email' => 'staff@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
            'permissions' => ['manage_home_sections', 'manage_about_sections'],
        ]);

        $response->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'staff@example.com',
            'name' => 'New Staff Admin',
            'is_active' => true,
        ]);

        $newUser = User::where('email', 'staff@example.com')->first();
        $this->assertTrue($newUser->hasRole('admin'));
        $this->assertTrue($newUser->hasPermissionTo('manage_home_sections'));
        $this->assertTrue($newUser->hasPermissionTo('manage_about_sections'));
        $this->assertFalse($newUser->hasPermissionTo('manage_product_sections'));
    }

    public function test_super_admin_can_view_edit_user_page(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('admin.users.edit', $this->admin));

        $response->assertStatus(200)
            ->assertSee('Ubah Data Petugas')
            ->assertSee($this->admin->email);
    }

    public function test_super_admin_can_update_user_and_sync_permissions(): void
    {
        $response = $this->actingAs($this->superAdmin)->put(route('admin.users.update', $this->admin), [
            'name' => 'Updated Admin Name',
            'email' => 'updated_admin@example.com',
            'role' => 'admin',
            'permissions' => ['manage_product_sections'],
        ]);

        $response->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success');

        $this->admin->refresh();
        $this->assertEquals('Updated Admin Name', $this->admin->name);
        $this->assertEquals('updated_admin@example.com', $this->admin->email);
        $this->assertTrue($this->admin->hasPermissionTo('manage_product_sections'));
    }

    public function test_super_admin_cannot_demote_own_role(): void
    {
        $response = $this->actingAs($this->superAdmin)->put(route('admin.users.update', $this->superAdmin), [
            'name' => $this->superAdmin->name,
            'email' => $this->superAdmin->email,
            'role' => 'admin',
        ]);

        $response->assertSessionHas('error');
        $this->superAdmin->refresh();
        $this->assertTrue($this->superAdmin->hasRole('super_admin'));
    }

    public function test_super_admin_cannot_delete_own_account(): void
    {
        $response = $this->actingAs($this->superAdmin)->delete(route('admin.users.destroy', $this->superAdmin));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->superAdmin->id]);
    }

    public function test_super_admin_can_delete_other_user(): void
    {
        $targetUser = User::create([
            'name' => 'User To Delete',
            'email' => 'delete_me@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->superAdmin)->delete(route('admin.users.destroy', $targetUser));

        $response->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    public function test_super_admin_cannot_deactivate_own_account(): void
    {
        $response = $this->actingAs($this->superAdmin)->patch(route('admin.users.toggle-active', $this->superAdmin));

        $response->assertSessionHas('error');
        $this->superAdmin->refresh();
        $this->assertTrue($this->superAdmin->is_active);
    }

    public function test_super_admin_can_toggle_active_status_of_other_user(): void
    {
        $this->assertTrue($this->admin->is_active);

        // Deactivate
        $response = $this->actingAs($this->superAdmin)->patch(route('admin.users.toggle-active', $this->admin));
        $response->assertSessionHas('success');

        $this->admin->refresh();
        $this->assertFalse($this->admin->is_active);

        // Reactivate
        $response = $this->actingAs($this->superAdmin)->patch(route('admin.users.toggle-active', $this->admin));
        $response->assertSessionHas('success');

        $this->admin->refresh();
        $this->assertTrue($this->admin->is_active);
    }

    public function test_super_admin_can_reset_password_of_other_user(): void
    {
        $response = $this->actingAs($this->superAdmin)->post(route('admin.users.reset-password', $this->admin), [
            'new_password' => 'newSecret123',
            'new_password_confirmation' => 'newSecret123',
        ]);

        $response->assertSessionHas('success');

        $this->admin->refresh();
        $this->assertTrue(Hash::check('newSecret123', $this->admin->password));
    }

    public function test_super_admin_cannot_reset_own_password_via_user_management(): void
    {
        $response = $this->actingAs($this->superAdmin)->post(route('admin.users.reset-password', $this->superAdmin), [
            'new_password' => 'newSecret123',
            'new_password_confirmation' => 'newSecret123',
        ]);

        $response->assertSessionHas('error');
    }

    public function test_inactive_user_cannot_login(): void
    {
        $inactiveUser = User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@example.com',
            'password' => 'password123',
            'is_active' => false,
        ]);

        $response = $this->post('/login', [
            'email' => 'inactive@example.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_inactive_user_is_logged_out_by_middleware_on_next_request(): void
    {
        $user = User::create([
            'name' => 'Logged In Inactive',
            'email' => 'deactivated_session@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);
        $user->assignRole('admin');

        // User was active when logged in
        $this->actingAs($user);

        // Now deactivated
        $user->update(['is_active' => false]);

        // Attempting to access dashboard
        $response = $this->get(route('admin.dashboard'));

        $this->assertGuest();
        $response->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');
    }
}
