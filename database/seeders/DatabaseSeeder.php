<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call(RolePermissionSeeder::class);

        // Create super admin user for Admin Portal
        $admin = User::updateOrCreate(
            ['email' => 'superadmin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'is_active' => true,
            ]
        );

        $admin->assignRole('super_admin');

        // Seed landing page content
        $this->call([
            HomeSectionSeeder::class,
            AboutSectionSeeder::class,
            ContactSectionSeeder::class,
        ]);
    }
}
