<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_balance_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('company_balances')->references('company_id')->onDelete('cascade');
            $table->float('amount');
            $table->string('currency')->default(1);
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('companies')->onDelete('cascade')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_balance_transactions');
    }
};
