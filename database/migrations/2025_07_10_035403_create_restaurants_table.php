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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('place_id');
            $table->string('name');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('area')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('operating_hours', 1000)->nullable();
            $table->string('google_maps_link')->nullable();
            $table->string('restaurant_website')->nullable();
            $table->string('instagram_link')->nullable();
            $table->float('rating')->nullable();
            $table->integer('price_level')->nullable();
            $table->string('image')->nullable();
            $table->string('cuisine')->nullable();
            $table->string('ubereats')->nullable();
            $table->string('doordash')->nullable();
            $table->string('grubhub')->nullable();
            $table->string('restaurant_order_link')->nullable();
            $table->string('source')->nullable();
            $table->string('last_updated')->nullable();
            $table->timestamps();


            $table->unique(['name', 'latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
