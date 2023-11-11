<?php

namespace Database\Seeders;

use App\Models\Language\Language;
use Illuminate\Database\Seeder;
use App\Models\Country\Country;
use Illuminate\Support\Facades\Schema;

class CompanyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Language::truncate();
        Schema::enableForeignKeyConstraints();

        
    }
}
