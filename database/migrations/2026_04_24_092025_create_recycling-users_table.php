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
        // Crear la tabla completa si no existe
        if (!Schema::hasTable('recycling_users')) {
            Schema::create('recycling_users', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('username')->unique();
                $table->string('email')->unique();
                $table->string('password');
                $table->string('level')->default('BEGINNER');
                $table->unsignedInteger('total_points')->default(0);
                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });

            return;
        };
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('recycling_users');
    }
};
