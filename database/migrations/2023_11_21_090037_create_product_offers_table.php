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
        Schema::create('product_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_product_id')->constrained('products')->onDelete('cascade')->onDelete('cascade');
            $table->float('price');
            $table->integer('product_quantity');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->timestamp('started_at');
            $table->timestamp('ended_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_offers');
    }
};
