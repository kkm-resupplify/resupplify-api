<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('producer');
            $table->string('code');
            $table->string('image');
            $table->string('image_alt')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('verification_status')->default(0);
            $table->foreignId('company_id')->constrained();
            $table->foreignId('product_unit_id')->constrained();
            $table->foreignId('product_subcategory_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
