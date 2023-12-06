<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            CountrySeeder::class,
            PermissionSeeder::class,
            CompanyCategorySeeder::class,
            ProductUnitSeeder::class,
            ProductCategorySeeder::class,
            ProductSubcategorySeeder::class,
            //ProductCategoryAndSubcategorySeeder::class,
            UserSeeder::class
        ]);
    }
}
