<?php

namespace Database\Seeders;

use App\Models\User\User;
use App\Models\Company\Company;
use App\Models\Product\Product;
use Illuminate\Database\Seeder;
use App\Models\User\UserDetails;
use App\Models\Product\ProductTag;
use Spatie\Permission\Models\Role;
use App\Models\Warehouse\Warehouse;
use App\Models\Product\ProductOffer;
use Illuminate\Support\Facades\File;
use App\Models\Company\CompanyMember;
use App\Models\Company\CompanyBalance;
use App\Models\Company\CompanyDetails;
use Illuminate\Support\Facades\Schema;
use App\Models\Product\LanguageProduct;
use App\Http\Dto\Company\TransactionDto;
use App\Models\Product\ProductWarehouse;
use App\Models\Company\Enums\CompanyStatusEnum;
use App\Models\Product\Enums\ProductStatusEnum;
use App\Services\Company\CompanyBalanceService;
use App\Models\Company\CompanyBalanceTransaction;


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
        UserDetails::truncate();
        Role::truncate();
        ProductTag::truncate();
        Product::truncate();
        CompanyBalance::truncate();
        CompanyBalanceTransaction::truncate();
        Warehouse::truncate();
        ProductWarehouse::truncate();
        ProductOffer::truncate();
        LanguageProduct::truncate();
        Schema::enableForeignKeyConstraints();

        $json = File::get(__DIR__ . '/userSeederData.json');
        $data = json_decode($json, true);

        foreach ($data['data']['user'] as $userData) {
            $user = User::create($userData['account']);
            $userDetails = UserDetails::create($userData['userDetails']);
        }

        foreach ($data['data']['company'] as $companyData) {
            $company = Company::create($companyData['company']);
            $company->status = CompanyStatusEnum::VERIFIED();
            $company->save();

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
            $created = false;
            foreach($companyData['warehouses'] as $warehouse){
                $warehouse = $company->warehouses()->create($warehouse);
                if($created == false){
                    foreach($companyProducts as $product){
                        $safeQuantity = rand(100, 5000);
                        $warehouseProductData = [
                            'quantity' => $safeQuantity*2,
                            'safe_quantity' => $safeQuantity,
                            'status' => ProductStatusEnum::ACTIVE(),
                        ];
                        $productTag = $company->productTags()->get();
                        $product->warehouses()->attach($warehouse->id, $warehouseProductData);
                        $product->productTags()->attach($productData['product_tags_id'] ?? []);
                        $productWarehouse = ProductWarehouse::where('warehouse_id', $warehouse->id)->where('product_id', $product->id)->first();
                        $startDate = date('Y-m-d H:i:s');
                        $endDate = date('Y-m-d H:i:s', strtotime('+2 days'));
                        $offer = new ProductOffer([
                            'price' => rand(1, 10),
                            'product_quantity' => $safeQuantity/2,
                            'status' => 1,
                            'company_product_id' => $productWarehouse->id,
                            'company_id' => $company->id,
                            'started_at' => $startDate,
                            'ended_at' => $endDate,
                        ]);
                        $offer->save();
                    }
                }
                $created = true;
            }


        }
    }
}
