<?php

namespace Database\Seeders;

use App\Models\Language\Language;
use Illuminate\Database\Seeder;
use App\Models\Country\Country;
use Illuminate\Support\Facades\Schema;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Language::truncate();
        Schema::enableForeignKeyConstraints();

        //seeder for languages
        $languages = [
            [
                'name' => 'English',
                'code' => 'en-GB',
                'origin_name' => 'English',
            ],
            [
                'name' => 'Polish',
                'code' => 'pl-PL',
                'origin_name' => 'Polski',
            ],
        ];
        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
