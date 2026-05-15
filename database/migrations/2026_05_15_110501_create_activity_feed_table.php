<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_feed', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('team_id')->nullable()->index();
            $table->string('type', 40);         // RECYCLE | LEVEL_UP | CHALLENGE_DONE | REWARD_UNLOCKED | TEAM_JOINED
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('emoji', 10)->default('♻️');
            $table->integer('points')->default(0);
            $table->json('meta')->nullable();    // datos extra según type
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('recycling_users')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('activity_feed'); }
};