<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaderboard_snapshots', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->string('period_type', 20);    
            $table->string('period_key', 20);       
            $table->integer('points')->default(0);
            $table->integer('position')->default(0);
            $table->string('level', 30)->default('BEGINNER');
            $table->timestamps();

            $table->unique(['user_id', 'period_type', 'period_key']);

            $table->foreign('user_id')
                  ->references('id')->on('recycling_users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaderboard_snapshots');
    }
};