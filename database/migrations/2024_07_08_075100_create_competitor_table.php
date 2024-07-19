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
        Schema::create('competitor', function (Blueprint $table) {
            $table->integer('competitor_id', true);
            $table->string('Competitor_name');
            $table->integer('client_id');
            $table->tinyInteger('is_active');
            $table->string('Keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitor');
    }
};
