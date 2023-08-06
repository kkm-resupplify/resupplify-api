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
        Schema::create('company_member', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('company_role_id');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');

            $table
                ->foreign('company_id')
                ->references('id')
                ->on('companies');

            $table
                ->foreign('company_role_id')
                ->references('id')
                ->on('company_roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_member');
    }
};
