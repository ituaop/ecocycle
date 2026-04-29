<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->string('description');
            $table->string('badge_color');
            $table->string('badge_icon');
            $table->unsignedInteger('min_points');
            $table->unsignedInteger('max_points');
            $table->unsignedTinyInteger('order');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ranks'); }
};
