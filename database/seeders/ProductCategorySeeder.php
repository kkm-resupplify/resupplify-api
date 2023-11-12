<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

use App\Models\Product\ProductCategory;
use App\Models\Language\Language;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        ProductCategory::truncate();
        Schema::enableForeignKeyConstraints();

        $json = file_get_contents(__DIR__ . '/productCategories.json');
        $data = json_decode($json, true);

        foreach ($data as $categoryId => $categoryData) {
            $productCategory = ProductCategory::firstOrCreate([
                'id' => $categoryId,
            ]);

            foreach ($categoryData as $languageId => $name) {
                $language = Language::find($languageId);

                if ($language) {
                    $productCategory
                        ->languages()
                        ->attach($language, ['name' => $name]);
                }
            }
        }
    }
}
