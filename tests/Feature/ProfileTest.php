<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->user = User::create([
            'name' => 'Profile Test User',
            'email' => 'profile_user@example.com',
            'password' => 'initialPassword123',
            'is_active' => true,
        ]);
        $this->user->assignRole('admin');
    }

    public function test_guest_cannot_access_profile_page(): void
    {
        $response = $this->get(route('admin.profile.edit'));
        $response->assertRedirect('/login');
    }

    public function test_user_can_view_profile_edit_page(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.profile.edit'));

        $response->assertStatus(200)
            ->assertSee('Profil Saya')
            ->assertSee('Informasi Profil')
            ->assertSee('Ubah Kata Sandi')
            ->assertSee($this->user->name)
            ->assertSee($this->user->email);
    }

    public function test_user_can_update_name_and_email(): void
    {
        $response = $this->actingAs($this->user)->put(route('admin.profile.update'), [
            'name' => 'Updated Profile Name',
            'email' => 'new_email@example.com',
        ]);

        $response->assertSessionHas('success');

        $this->user->refresh();
        $this->assertEquals('Updated Profile Name', $this->user->name);
        $this->assertEquals('new_email@example.com', $this->user->email);
    }

    public function test_user_cannot_update_email_to_another_users_email(): void
    {
        User::create([
            'name' => 'Another User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->user)->put(route('admin.profile.update'), [
            'name' => 'My Name',
            'email' => 'existing@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_can_change_password_with_correct_current_password(): void
    {
        $response = $this->actingAs($this->user)->put(route('admin.profile.update-password'), [
            'current_password' => 'initialPassword123',
            'new_password' => 'BrandNewPassword456',
            'new_password_confirmation' => 'BrandNewPassword456',
        ]);

        $response->assertSessionHas('success');

        $this->user->refresh();
        $this->assertTrue(Hash::check('BrandNewPassword456', $this->user->password));
    }

    public function test_user_cannot_change_password_with_incorrect_current_password(): void
    {
        $response = $this->actingAs($this->user)->put(route('admin.profile.update-password'), [
            'current_password' => 'wrongCurrentPassword',
            'new_password' => 'BrandNewPassword456',
            'new_password_confirmation' => 'BrandNewPassword456',
        ]);

        $response->assertSessionHasErrors('current_password');

        $this->user->refresh();
        $this->assertTrue(Hash::check('initialPassword123', $this->user->password));
    }

    public function test_new_password_must_be_confirmed(): void
    {
        $response = $this->actingAs($this->user)->put(route('admin.profile.update-password'), [
            'current_password' => 'initialPassword123',
            'new_password' => 'BrandNewPassword456',
            'new_password_confirmation' => 'mismatchingPassword',
        ]);

        $response->assertSessionHasErrors('new_password');
    }
}
