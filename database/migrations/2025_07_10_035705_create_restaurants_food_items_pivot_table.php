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
        Schema::create('restaurants_food_items_pivot', function (Blueprint $table) {
            $table->uuid('restaurant_id');
            $table->uuid('food_item_id');
            $table->timestamps();

            $table->primary(['restaurant_id', 'food_item_id']);

            // Foreign key constraints
            $table->foreign('restaurant_id')
                ->references('id')->on('restaurants')
                ->onDelete('cascade');

            $table->foreign('food_item_id')
                ->references('id')->on('food_items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants_food_items_pivot');
    }
};
