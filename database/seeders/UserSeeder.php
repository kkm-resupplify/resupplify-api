<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Support\Str;
use App\Models\Company\Company;
use App\Models\Product\Product;
use Illuminate\Database\Seeder;
use App\Models\Product\ProductTag;
use Spatie\Permission\Models\Role;
use App\Models\Product\ProductUnit;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\Company\CompanyMember;
use App\Models\Company\CompanyBalance;
use App\Models\Company\CompanyDetails;
use Illuminate\Support\Facades\Schema;
use App\Models\User\Enums\UserTypeEnum;
use App\Http\Dto\Company\TransactionDto;
use Spatie\Permission\Models\Permission;
use App\Models\Product\Enums\ProductStatusEnum;
use App\Services\Company\CompanyBalanceService;
use App\Models\Company\CompanyBalanceTransaction;
use App\Models\Product\Enums\ProductVerificationStatusEnum;

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
        CompanyBalance::truncate();
        CompanyBalanceTransaction::truncate();
        Schema::enableForeignKeyConstraints();

        $json = File::get(__DIR__ . '/userSeederData.json');
        $data = json_decode($json, true);

        foreach ($data['data']['user'] as $userData) {
            User::create($userData);
        }

        foreach ($data['data']['company'] as $companyData) {
            $company = Company::create($companyData['company']);

            CompanyDetails::create($companyData['companyDetails']);
            $companyBalance = CompanyBalance::create($companyData['companyBalance']);

            foreach ($companyData['roles'] as $role) {
                Role::create($role);
            }

            foreach ($companyData['companyMember'] as $companyMember) {
                CompanyMember::create($companyMember);
            }

            foreach ($companyData['tag'] as $tag) {
                ProductTag::create($tag);
            }

            foreach ($companyData['products'] as $productData) {
                $product = Product::create($productData['product']);
                foreach ($productData['translations'] as $translation) {
                    $product->languages()->attach($translation['languageId'], ['name' => $translation['name'], 'description' => $translation['description']]);
                }
            }

            $transactionDto = new TransactionDto(
                $companyBalanceId = $companyBalance->company_id,
                $currency = "Euro",
                $amount = 10000,
                $type = 2,
                $status = 1,
                $senderId = null,
                $receiverId = $company->id,
                $paymentMethodId = 1
            );

            $transaction = CompanyBalanceService::createTransaction($transactionDto);
            $companyBalance = CompanyBalanceService::handleCompanyBalance($companyBalance, $transaction);
            $companyProducts = $company->products;

            foreach($companyData['warehouses'] as $warehouse){
                $warehouse = $company->warehouses()->create($warehouse);

                foreach($companyProducts as $product){
                    $safeQuantity = rand(1, 100);
                    $warehouseProductData = [
                        'quantity' => $safeQuantity*2,
                        'safe_quantity' => $safeQuantity,
                        'status' => ProductStatusEnum::ACTIVE(),
                    ];

                    $product->warehouses()->attach($warehouse->id, $warehouseProductData);
                }
            }


        }
    }
}
