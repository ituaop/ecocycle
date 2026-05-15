<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        Schema::create('challenges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('emoji', 10)->default('♻️');
            $table->string('type', 30);           // WEEKLY | MONTHLY | SPECIAL
            $table->string('category', 30);       // QUANTITY | VARIETY | STREAK | POINTS
            $table->integer('target_value');       // ej: recicla 10 veces, acumula 200 pts
            $table->integer('bonus_points');       // puntos extra al completar
            $table->string('badge_color', 10)->default('#2d6a4f');
            $table->boolean('is_active')->default(true);
            $table->date('starts_at');
            $table->date('ends_at');
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('challenges'); }
};