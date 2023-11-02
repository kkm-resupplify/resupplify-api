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
            ['code' => 'BEVERAGES'],
            ['code' => 'SNACKS'],
            ['code' => 'PERSONAL_CARE'],
            ['code' => 'DAIRY'],
            ['code' => 'CLEANING_SUPPLIES'],
            ['code' => 'CANNED_GOODS'],
            ['code' => 'FROZEN_FOODS'],
            ['code' => 'BAKERY'],
            ['code' => 'CONFECTIONERY'],
            ['code' => 'HEALTH_AND_WELLNESS'],
            ['code' => 'PAPER_PRODUCTS'],
            ['code' => 'BABY_CARE'],
            ['code' => 'PET_CARE'],
            ['code' => 'TOILETRIES'],
            ['code' => 'BREAKFAST_FOODS'],
            ['code' => 'MEAT_AND_SEAFOOD'],
            ['code' => 'HOUSEHOLD_ITEMS'],
            ['code' => 'FRESH_PRODUCE'],
            ['code' => 'SPICES_AND_CONDIMENTS'],
            ['code' => 'GRAINS_AND_PASTA'],
            ['code' => 'SOUPS_AND_SAUCES'],
            ['code' => 'CEREALS'],
            ['code' => 'HOME_APPLIANCES'],
            ['code' => 'KITCHENWARE'],
            ['code' => 'BATHROOM_SUPPLIES'],
            ['code' => 'ELECTRONICS'],
            ['code' => 'BEAUTY_PRODUCTS'],
            ['code' => 'HAIR_CARE'],
            ['code' => 'ORAL_CARE'],
            ['code' => 'SKIN_CARE'],
            ['code' => 'FEMININE_HYGIENE'],
            ['code' => 'ADULT_CARE'],
            ['code' => 'INCONTINENCE'],
            ['code' => 'FOOTWEAR'],
            ['code' => 'APPAREL'],
            ['code' => 'ACCESSORIES'],
            ['code' => 'HOME_DECOR'],
            ['code' => 'FURNITURE'],
            ['code' => 'BED_AND_BATH'],
            ['code' => 'TOOLS_AND_HARDWARE'],
            ['code' => 'AUTOMOTIVE'],
            ['code' => 'HOME_ENTERTAINMENT'],
            ['code' => 'OUTDOOR_RECREATION'],
            ['code' => 'FITNESS_EQUIPMENT'],
            ['code' => 'GARDENING'],
            ['code' => 'BOOKS_AND_STATIONERY'],
            ['code' => 'HOME_IMPROVEMENT'],
            ['code' => 'ELECTRICAL_AND_LIGHTING'],
            ['code' => 'PARTY_SUPPLIES'],
            ['code' => 'OFFICE_SUPPLIES'],
            ['code' => 'TOYS_AND_GAMES'],
            ['code' => 'CRAFTS_AND_HOBBIES'],
        ];

        foreach ($productCategories as $category) {
            $category['slug'] = Str::slug($category['code']);
            ProductCategory::create($category);
        }
    }
}
