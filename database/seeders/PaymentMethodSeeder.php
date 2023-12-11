<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\PaymentMethod;
class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        PaymentMethod::truncate();
        Schema::enableForeignKeyConstraints();

        $payments = [
            [
                'name' => 'Balance'
            ],
            [
                'name' => 'Credit card'
            ],
            [
                'name' => 'Bank transfer'
            ],
        ];
        foreach ($payments as $payment) {
            PaymentMethod::create($payment);
        }
    }
}
