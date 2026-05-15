<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('emoji', 10)->default('♻️');
            $table->string('badge_color', 10)->default('#2d6a4f');
            $table->uuid('owner_id')->index();
            $table->boolean('is_public')->default(true);
            $table->integer('max_members')->default(20);
            $table->integer('total_points')->default(0);
            $table->timestamps();

            $table->foreign('owner_id')
                  ->references('id')->on('recycling_users')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('teams'); }
};