<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('food_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('menu_type_idx');
            $table->string('menu_type');
            $table->integer('dish_type_idx');
            $table->string('dish_type');
            $table->string('add_on')->nullable();
            $table->text('description')->nullable();
            $table->boolean('dairy')->default(true);
            $table->boolean('eggs')->default(true);
            $table->boolean('shellfish')->default(true);
            $table->boolean('fish')->default(true);
            $table->boolean('tree_nuts')->default(true);
            $table->boolean('peanuts')->default(true);
            $table->boolean('wheat')->default(true);
            $table->boolean('soybeans')->default(true);
            $table->boolean('sesame')->default(true);
            $table->boolean('vegetarian')->default(false);
            $table->boolean('vegan')->default(false);
            $table->boolean('glutenfree')->default(false);
            $table->boolean('pescatarian')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_items');
    }
};
