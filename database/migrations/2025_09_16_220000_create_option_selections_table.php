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
        Schema::create('option_selections', function (Blueprint $table) {
            $table->id();
            $table->text('selections');
            $table->date('selection_date');
            $table->unsignedInteger('selection_count')->default(0);
            $table->timestamps();

            $table->unique(['selections', 'selection_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option_selections');
    }
};
