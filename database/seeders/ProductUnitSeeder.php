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
            ['code' => 'kg'],
            ['code' => 'l'],
            ['code' => 'g'],
            ['code' => 'ml'],
            ['code' => 'pcs'],
            ['code' => 'pkt'],
            ['code' => 'cans'],
            ['code' => 'bottles'],
            ['code' => 'cartons'],
            ['code' => 'dozens'],
            ['code' => 'lb'],
            ['code' => 'oz'],
            ['code' => 'm'],
            ['code' => 'sheets'],
            ['code' => 'pieces per pack'],
        ];

        foreach ($productUnits as $unit) {
            ProductUnit::create($unit);
        }
    }
}
