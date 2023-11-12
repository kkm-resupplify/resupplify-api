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
        Schema::create('language_product', function (
            Blueprint $table
        ) {
            $table->id();
            $table
                ->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade');
            $table
                ->foreignId('language_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language_product');
    }
};
