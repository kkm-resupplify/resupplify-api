<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

use App\Models\Product\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ProductCategory::truncate();
        Schema::enableForeignKeyConstraints();

        $productCategories = [
            ['code' => 'Beverages'],
            ['code' => 'Snacks'],
            ['code' => 'Personal Care'],
            ['code' => 'Dairy'],
            ['code' => 'Cleaning Supplies'],
            ['code' => 'Canned Goods'],
            ['code' => 'Frozen Foods'],
            ['code' => 'Bakery'],
            ['code' => 'Confectionery'],
            ['code' => 'Health and Wellness'],
            ['code' => 'Paper Products'],
            ['code' => 'Baby Care'],
            ['code' => 'Pet Care'],
            ['code' => 'Toiletries'],
            ['code' => 'Breakfast Foods'],
            ['code' => 'Meat and Seafood'],
            ['code' => 'Household Items'],
            ['code' => 'Fresh Produce'],
            ['code' => 'Spices and Condiments'],
            ['code' => 'Grains and Pasta'],
            ['code' => 'Soups and Sauces'],
            ['code' => 'Cereals'],
            ['code' => 'Home Appliances'],
            ['code' => 'Kitchenware'],
            ['code' => 'Bathroom Supplies'],
            ['code' => 'Electronics'],
            ['code' => 'Beauty Products'],
            ['code' => 'Hair Care'],
            ['code' => 'Oral Care'],
            ['code' => 'Skin Care'],
            ['code' => 'Feminine Hygiene'],
            ['code' => 'Adult Care'],
            ['code' => 'Incontinence'],
            ['code' => 'Footwear'],
            ['code' => 'Apparel'],
            ['code' => 'Accessories'],
            ['code' => 'Home Decor'],
            ['code' => 'Furniture'],
            ['code' => 'Bed and Bath'],
            ['code' => 'Tools and Hardware'],
            ['code' => 'Automotive'],
            ['code' => 'Home Entertainment'],
            ['code' => 'Outdoor Recreation'],
            ['code' => 'Fitness Equipment'],
            ['code' => 'Gardening'],
            ['code' => 'Books and Stationery'],
            ['code' => 'Home Improvement'],
            ['code' => 'Electrical and Lighting'],
            ['code' => 'Party Supplies'],
            ['code' => 'Office Supplies'],
            ['code' => 'Toys and Games'],
            ['code' => 'Crafts and Hobbies'],
        ];

        foreach ($productCategories as $category) {
            $category['slug'] = Str::slug($category['code']);
            ProductCategory::create($category);
        }
    }
}
