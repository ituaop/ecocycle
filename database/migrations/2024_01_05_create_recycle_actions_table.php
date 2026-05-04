<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('recycle_actions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('waste_item_id');
            $table->uuid('collection_point_id');
            $table->unsignedSmallInteger('quantity');
            $table->date('date');
            $table->unsignedInteger('points_earned');
            $table->string('level_before')->nullable();
            $table->string('level_after')->nullable();
            $table->boolean('level_up')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('recycling_users')->onDelete('cascade');
            $table->foreign('waste_item_id')->references('id')->on('waste_items');
            $table->foreign('collection_point_id')->references('id')->on('collection_points');
        });
    }
    public function down(): void { Schema::dropIfExists('recycle_actions'); }
};
