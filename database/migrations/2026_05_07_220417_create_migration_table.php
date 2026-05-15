<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rewards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('description');
            $table->string('emoji');               // visual del premio
            $table->string('category');            // DISCOUNT, BADGE, EXPERIENCE, DONATION
            $table->unsignedInteger('points_required'); // puntos necesarios para desbloquear
            $table->string('badge_color')->default('#2d6a4f');
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('order')->default(0);
            $table->timestamps();
        });

        // Tabla pivote: qué usuario ha desbloqueado qué recompensa
        Schema::create('user_rewards', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->uuid('reward_id')->constrained('rewards')->onDelete('cascade');
            $table->timestamp('unlocked_at');
            $table->timestamps();
            $table->unique(['user_id', 'reward_id']);
            $table->foreign('user_id')->references('id')->on('recycling_users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_rewards');
        Schema::dropIfExists('rewards');
    }
};