<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\User\Enums\UserTypeEnum;
use App\Models\Product\ProductUnit;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Company\Company;
use App\Models\Company\CompanyBalance;
use App\Models\Company\CompanyDetails;
use App\Models\Company\CompanyMember;
use App\Models\Product\ProductTag;
use Illuminate\Support\Str;
use App\Models\Product\Product;
use App\Models\Product\Enums\ProductStatusEnum;
use App\Models\Product\Enums\ProductVerificationStatusEnum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Company::truncate();
        Company::truncate();
        CompanyDetails::truncate();
        CompanyBalance::truncate();
        CompanyMember::truncate();
        Role::truncate();
        ProductTag::truncate();
        Product::truncate();
        Schema::enableForeignKeyConstraints();

        for($i = 0; $i < 5; $i++)
        {
            $user = User::create([
                'email' => 'user' . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'type' => UserTypeEnum::BACK_OFFICE(),
                'language_id' => 1,
            ]);

            $company = Company::create([
                'name' => 'Company ' . $i,
                'short_description' => 'Short description for company ' . $i,
                'description' => 'Description for company ' . $i,
                'slug' => Str::slug('Company ' . $i),
                'owner_id' => $user->id,
                'status' => 'UNVERIFIED',
            ]);

            $companyDetails = CompanyDetails::create([
                'country_id' => 16,
                'address' => 'Address for company ' . $i,
                'email' => 'company' . $i . '@gmail.com',
                'phone_number' => '+48536123700',
                'external_website' => 'https://company' . $i . '.com',
                'logo' => 'logo.png',
                'company_id' => $company->id,
                'company_category_id' => 1,
                'tin' => '1234567890',
                'contact_person' => 'Contact Person ' . $i,
            ]);

            $companyBalance = CompanyBalance::create([
                'company_id' => $company->id,
                'balance' => 0,
            ]);

            $roles = [
                Role::create(['name' => 'Company owner', 'team_id' => $company->id, 'guard_name' => 'sanctum']),
                Role::create(['name' => 'Company admin', 'team_id' => $company->id, 'guard_name' => 'sanctum']),
                Role::create(['name' => 'Company member', 'team_id' => $company->id, 'guard_name' => 'sanctum']),
            ];

            $companyMember = CompanyMember::create([
                'user_id' => $user->id,
                'company_id' => $company->id,
                'role_id' => $roles[0]->id,
            ]);
            $colors = [
                'black',
                'yellow',
                'blue',
                'red',
                'green'
            ];
            $tags = [];
            for($j = 0; $j< 5; $j++)
            {
                $tagData = [
                    'name' => 'tag'.$j,
                    'slug' => Str::slug('tag'.$j),
                    'color' => $colors[$j],
                    'company_id' => $company->id,
                ];
                $tag = ProductTag::create($tagData);
                $tags[] = $tag->id;
            }
            for($k = 0; $k < 10; $k++)
            {
                $productData = [
                    'producer' => 'producer'.$k,
                    'code' => 'code/'.$k,
                    'product_unit_id' => 1,
                    'product_subcategory_id' => 1,
                    'company_id' => $company->id,
                    'status' => ProductStatusEnum::INACTIVE(),
                    'verification_status' => ProductVerificationStatusEnum::UNVERIFIED()
                ];
                $json = '{
                    "translations": [
                        {
                            "languageId": 1,
                            "name": "Product name",
                            "description": "Product description"
                        },
                        {
                            "languageId": 2,
                            "name": "Nazwa produktu",
                            "description": "Opis produktu"
                        }
                    ]
                  }';
                 $array = json_decode($json, true);
                 $product = new Product($productData);
                 $user->company->products()->save($product);
                 $product->productTags()->attach($tags ?? []);
                 foreach ($array as $translations) {
                    foreach ($translations as $translation) {
                        $product->languages()->attach($translation['languageId'], ['name' => $translation['name'], 'description' => $translation['description']]);
                    }
                 }
            }
        }
    }
}
