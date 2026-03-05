<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage_users',
            'manage_roles',
            'manage_permissions',
            'view_sales',
            'manage_services',
            'manage_settings',
            'use_pos'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and assign permissions
        $role = Role::firstOrCreate(['name' => 'Super Admin']);
        $role->syncPermissions(Permission::all());

        $staffRole = Role::firstOrCreate(['name' => 'Staff']);
        $staffRole->syncPermissions(['use_pos', 'view_sales']);

        // Create Initial Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole($role);
    }
}
