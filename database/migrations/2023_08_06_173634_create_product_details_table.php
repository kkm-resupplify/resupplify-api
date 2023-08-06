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
        Schema::create('company_product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_unit_id')->constrained();
            $table->foreignId('company_product_id')->constrained();
            $table->float('available_quantity');
            $table->string('description');
            $table->string('external_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_product_details');
    }
};
