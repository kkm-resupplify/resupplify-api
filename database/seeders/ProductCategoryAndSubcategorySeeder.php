<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Models\Product\ProductSubcategory;
use App\Models\Product\ProductCategory;

class ProductCategoryAndSubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ProductSubcategory::truncate();
        Schema::enableForeignKeyConstraints();

        $jsonFilePath = __DIR__ . '/subcategories.json';

        if (File::exists($jsonFilePath)) {
            $jsonContents = File::get($jsonFilePath);
            $categorySubcategories = json_decode($jsonContents, true);

            foreach (
                $categorySubcategories
                as $categoryKey => $categorySubcategory
            ) {
                foreach ($categorySubcategory as $subcategoryCode) {
                    $category = ProductCategory::firstOrCreate([
                        'code' => $categoryKey,
                        'slug' => Str::slug($categoryKey),
                    ]);

                    ProductSubcategory::create([
                        'code' => $subcategoryCode,
                        'slug' => Str::slug($subcategoryCode),
                        'product_category_id' => $category->id,
                    ]);
                }
            }
        }
    }
}
