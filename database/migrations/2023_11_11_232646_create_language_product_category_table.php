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
        Schema::create('language_product_category', function (Blueprint $table) {
            $table->id();
            $table
            ->foreignId('product_category_id')
            ->constrained()
            ->onDelete('cascade');
            $table
            ->foreignId('language_id')
            ->constrained()
            ->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language_product_category');
    }
};
