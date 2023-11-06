<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_warehouse', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table
                ->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade');
            $table
                ->foreignId('warehouse_id')
                ->constrained()
                ->onDelete('cascade');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('safe_quantity');
            $table->tinyInteger('status')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_warehouse');
    }
};
