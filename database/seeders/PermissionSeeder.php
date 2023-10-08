<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Schema;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();
        //
        // Permissions for Super Admin
        $permissions = [
            ['name' => 'manage users', 'guard_name' => 'sanctum'],
            ['name' => 'manage products', 'guard_name' => 'sanctum'],
            ['name' => 'manage transactions', 'guard_name' => 'sanctum'],
            ['name' => 'access settings', 'guard_name' => 'sanctum'],
            ['name' => 'view reports', 'guard_name' => 'sanctum'],
            ['name' => 'manage own products', 'guard_name' => 'sanctum'],
            ['name' => 'view own transactions', 'guard_name' => 'sanctum'],
            ['name' => 'view products', 'guard_name' => 'sanctum'],
            ['name' => 'purchase products', 'guard_name' => 'sanctum'],
            ['name' => 'manage own account settings', 'guard_name' => 'sanctum'],
            ['name' => 'manage users in own company', 'guard_name' => 'sanctum'],
            ['name' => 'manage products in own company', 'guard_name' => 'sanctum'],
            ['name' => 'view transactions in own company', 'guard_name' => 'sanctum'],
            ['name' => 'view products in own company', 'guard_name' => 'sanctum'],
            ['name' => 'add products in own company', 'guard_name' => 'sanctum'],
        ];

        foreach($permissions as $key => $value) {
            Permission::create($value);
        }
    }
}
