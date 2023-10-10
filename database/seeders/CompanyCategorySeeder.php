<?php

namespace Database\Seeders;

use App\Models\Company\CompanyCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CompanyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        CompanyCategory::truncate();
        Schema::enableForeignKeyConstraints();

        $categories = [
            [
                'name' => 'Beverages',
                'slug' => Str::slug('Beverages'),
                'description' => 'A variety of refreshing drinks for every occasion.',
            ],
            [
                'name' => 'Snacks',
                'slug' => Str::slug('Snacks'),
                'description' => 'Delicious treats for on-the-go snacking.',
            ],
            [
                'name' => 'Personal Care',
                'slug' => Str::slug('Personal Care'),
                'description' => 'Products for personal hygiene and care.',
            ],
            [
                'name' => 'Household Essentials',
                'slug' => Str::slug('Household Essentials'),
                'description' => 'Everyday items for your household needs.',
            ],
            [
                'name' => 'Frozen Foods',
                'slug' => Str::slug('Frozen Foods'),
                'description' => 'Convenient and frozen ready-to-eat meals.',
            ],
            [
                'name' => 'Dairy Products',
                'slug' => Str::slug('Dairy Products'),
                'description' => 'A selection of dairy-based products and milk derivatives.',
            ],
            [
                'name' => 'Bakery and Confectionery',
                'slug' => Str::slug('Bakery and Confectionery'),
                'description' => 'Freshly baked goods and sweet confections.',
            ],
            [
                'name' => 'Canned Goods',
                'slug' => Str::slug('Canned Goods'),
                'description' => 'Preserved foods in cans for long shelf life.',
            ],
            [
                'name' => 'Health and Wellness',
                'slug' => Str::slug('Health and Wellness'),
                'description' => 'Products promoting health and overall well-being.',
            ],
            [
                'name' => 'Baby Care',
                'slug' => Str::slug('Baby Care'),
                'description' => 'Essentials for the care of infants and toddlers.',
            ],
            [
                'name' => 'Pet Care',
                'slug' => Str::slug('Pet Care'),
                'description' => 'Supplies for the well-being of pets and animals.',
            ],
            [
                'name' => 'Cleaning Supplies',
                'slug' => Str::slug('Cleaning Supplies'),
                'description' => 'Tools and agents for household cleaning tasks.',
            ],
            [
                'name' => 'Toiletries',
                'slug' => Str::slug('Toiletries'),
                'description' => 'Personal care and hygiene items for daily use.',
            ],
            [
                'name' => 'Paper Products',
                'slug' => Str::slug('Paper Products'),
                'description' => 'Disposable paper-based products for various purposes.',
            ],
            [
                'name' => 'Cosmetics',
                'slug' => Str::slug('Cosmetics'),
                'description' => 'Beauty and cosmetic products for personal care.',
            ],
            [
                'name' => 'Spices and Condiments',
                'slug' => Str::slug('Spices and Condiments'),
                'description' => 'Seasonings and flavor enhancers for cooking.',
            ],
            [
                'name' => 'Breakfast Foods',
                'slug' => Str::slug('Breakfast Foods'),
                'description' => 'Nutritious options for a wholesome breakfast.',
            ],
            [
                'name' => 'Instant Noodles and Pasta',
                'slug' => Str::slug('Instant Noodles and Pasta'),
                'description' => 'Quick and easy-to-prepare noodle and pasta options.',
            ],
            [
                'name' => 'Cooking Oils',
                'slug' => Str::slug('Cooking Oils'),
                'description' => 'Various cooking oils for culinary purposes.',
            ],
            [
                'name' => 'Sauces and Marinades',
                'slug' => Str::slug('Sauces and Marinades'),
                'description' => 'Flavorful sauces and marinades for cooking.',
            ],
            [
                'name' => 'Nutritional Supplements',
                'slug' => Str::slug('Nutritional Supplements'),
                'description' => 'Supplements to enhance nutritional intake.',
            ],
            [
                'name' => 'Office and School Supplies',
                'slug' => Str::slug('Office and School Supplies'),
                'description' => 'Essentials for office and school environments.',
            ],
        ];

        foreach ($categories as $category) {
            CompanyCategory::create($category);
        }
    }
}
