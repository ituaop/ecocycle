<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('team_id')->index();
            $table->uuid('user_id')->index();
            $table->string('role', 20)->default('MEMBER'); // OWNER | MEMBER
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();

            $table->unique(['team_id', 'user_id']);

            $table->foreign('team_id')
                  ->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('user_id')
                  ->references('id')->on('recycling_users')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('team_members'); }
};

