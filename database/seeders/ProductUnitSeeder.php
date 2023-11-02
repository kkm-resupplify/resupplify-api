<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

use App\Models\Product\ProductUnit;

class ProductUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ProductUnit::truncate();
        Schema::enableForeignKeyConstraints();

        $productUnits = [
            ['code' => 'KILOGRAM'],
            ['code' => 'LITRE'],
            ['code' => 'GRAM'],
            ['code' => 'MILLILITER'],
            ['code' => 'PIECE'],
            ['code' => 'CAN'],
            ['code' => 'BOTTLE'],
            ['code' => 'CARTON'],
            ['code' => 'DOZEN'],
            ['code' => 'POUND'],
            ['code' => 'OUNCE'],
            ['code' => 'METER'],
            ['code' => 'SHEET'],
            ['code' => 'PIECES_PER_PACK'],
        ];

        foreach ($productUnits as $unit) {
            ProductUnit::create($unit);
        }
    }
}
