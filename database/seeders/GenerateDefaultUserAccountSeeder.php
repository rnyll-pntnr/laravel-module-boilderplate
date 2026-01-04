<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class GenerateDefaultUserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Create Super Admin
         */
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'Demo@123',
        ]);

        /**
         * Create Super Admin Role
         */
        $role = Role::create(['name' => 'Super Admin']);

        /**
         * Assign Super Admin Role to Super Admin User
         */
        $user->assignRole($role);
    }
}
