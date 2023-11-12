<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Product\ProductCategory;
use App\Models\Product\ProductSubcategory;
use App\Models\Language\Language;
use Illuminate\Support\Facades\Schema;

class ProductSubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        ProductSubcategory::truncate();
        Schema::enableForeignKeyConstraints();

        $json = file_get_contents(__DIR__ . '/productSubcategories.json');
        $data = json_decode($json, true);

        foreach ($data as $categoryId => $subcategories) {
            $productCategory = ProductCategory::find($categoryId);

            for ($i = 0; $i < 5; $i++) {
                $productSubcategory = new ProductSubcategory();
                $productCategory
                    ->productSubcategories()
                    ->save($productSubcategory);
            }

            foreach ($subcategories as $languageId => $subcategoryData) {
                foreach ($subcategoryData as $subcategoryName) {
                    $productSubcategory
                        ->languages()
                        ->attach($languageId, ['name' => $subcategoryName]);
                }
            }
        }
    }
}
