<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed roles and permissions using Spatie Laravel Permission.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for each content module
        $permissions = [
            'manage_home_sections',
            'manage_about_sections',
            'manage_product_sections',
            'manage_how_to_order',
            'manage_testimonials',
            'manage_contact_sections',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Super Admin role with all permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->syncPermissions($permissions);

        // Create Admin role (permissions assigned per-user by Super Admin)
        Role::firstOrCreate(['name' => 'admin']);
    }
}
