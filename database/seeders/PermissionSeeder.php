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
            ['name' => 'Super Admin', 'guard_name' =>'sanctum'],
            ['name' => 'Owner permissions', 'guard_name' =>'sanctum'],
            ['name' => 'Admin permissions', 'guard_name' =>'sanctum'],
            ['name' => 'CompanyMember permissions', 'guard_name' =>'sanctum'],
            ['name' => 'Manage users', 'guard_name' => 'sanctum'],
            ['name' => 'Manage products', 'guard_name' => 'sanctum'],
            ['name' => 'Manage transactions', 'guard_name' => 'sanctum'],
            ['name' => 'Access settings', 'guard_name' => 'sanctum'],
            ['name' => 'View reports', 'guard_name' => 'sanctum'],
            ['name' => 'Manage own products', 'guard_name' => 'sanctum'],
            ['name' => 'View own transactions', 'guard_name' => 'sanctum'],
            ['name' => 'View products', 'guard_name' => 'sanctum'],
            ['name' => 'Purchase products', 'guard_name' => 'sanctum'],
            ['name' => 'Manage own account settings', 'guard_name' => 'sanctum'],
            ['name' => 'Manage company members in own company', 'guard_name' => 'sanctum'],
            ['name' => 'Manage products in own company', 'guard_name' => 'sanctum'],
            ['name' => 'View transactions in own company', 'guard_name' => 'sanctum'],
            ['name' => 'View products in own company', 'guard_name' => 'sanctum'],
            ['name' => 'Add products in own company', 'guard_name' => 'sanctum'],
        ];

        foreach($permissions as $key => $value) {
            Permission::create($value);
        }
    }
}
