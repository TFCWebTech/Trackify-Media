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
        Schema::create('newscity', function (Blueprint $table) {
            $table->bigIncrements('gidNewscity_id')->unsigned()->primary();
            $table->string('gidNewscity', 50);
            $table->string('CityName', 100)->unique('uq_city');
            $table->integer('Status');
            $table->dateTime('CreatedOn');
            $table->string('CreatedBy', 50);
            $table->integer('CityOrder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newscity');
    }
};
