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
        Schema::create('keywords', function (Blueprint $table) {
            $table->bigIncrements('gidKeywords_id')->unsigned()->primary();
            $table->string('gidKeywords', 45)->nullable();
            $table->string('gidCompany', 45)->nullable();
            $table->longText('Keywords')->nullable();
            $table->integer('MatchRelevance')->nullable();
            $table->string('gidMediaType', 45)->nullable();
            $table->integer('Status')->nullable();
            $table->string('CreatedBy', 45)->nullable();
            $table->string('CreatedOn', 45)->nullable();
            $table->string('UpdatedBy', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keywords');
    }
};
