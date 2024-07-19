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
        Schema::create('industry', function (Blueprint $table) {
            $table->integer('Industry_id', true);
            $table->string('Industry_name');
            $table->string('client_id');
            $table->integer('competitor_id')->nullable();
            $table->tinyInteger('is_active');
            $table->string('Keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industry');
    }
};
