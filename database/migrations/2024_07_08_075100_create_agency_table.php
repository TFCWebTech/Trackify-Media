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
        Schema::create('Agency', function (Blueprint $table) {
            $table->bigIncrements('gidAgency_id')->unsigned()->primary();
            $table->string('gidAgency', 45)->nullable();
            $table->string('Agency', 45)->nullable()->unique('uq_agency');
            $table->integer('Status')->nullable();
            $table->string('CreatedOn', 45)->nullable();
            $table->string('CreatedBy', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency');
    }
};
