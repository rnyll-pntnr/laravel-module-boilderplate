<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GenerateDefaultUserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermissions = [
            'View Roles',
            'Create Roles',
            'Edit Roles',
            'Delete Roles',
        ];

        $userPermissions = [
            'View Users',
            'Create Users',
            'Edit Users',
            'Delete Users'
        ];

        $permissions = [
            ...$rolePermissions,
            ...$userPermissions
        ];

        /**
         * Save all default permissions
         */
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        /**
         * Create Super Admin with all permissions
         */
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);

        foreach ($permissions as $permission) {
            $superAdmin->givePermissionTo($permission);
        }

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'password' => bcrypt('Demo@123')
        ])->assignRole($superAdmin);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('Demo@123')
        ])->assignRole($admin);
    }
}
