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
        Schema::create('product_cart_product_offer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_cart_id')->constrained('product_carts')->onDelete('cascade')->onDelete('cascade');
            $table->foreignId('product_offer_id')->constrained('product_offers')->onDelete('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_carts');
    }
};
