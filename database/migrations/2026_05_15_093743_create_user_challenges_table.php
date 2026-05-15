<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_challenges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('challenge_id')->index();
            $table->integer('current_value')->default(0);   // progreso actual
            $table->boolean('completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->boolean('reward_claimed')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'challenge_id']);

            $table->foreign('user_id')
                  ->references('id')->on('recycling_users')->onDelete('cascade');
            $table->foreign('challenge_id')
                  ->references('id')->on('challenges')->onDelete('cascade');
        });
    }

    public function down(): void { Schema::dropIfExists('user_challenges'); }
};
