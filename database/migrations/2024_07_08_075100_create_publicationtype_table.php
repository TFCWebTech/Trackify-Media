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
        Schema::create('publicationtype', function (Blueprint $table) {
            $table->bigIncrements('gidPublicationType_id')->unsigned()->primary();
            $table->string('gidPublicationType', 45)->nullable();
            $table->string('PublicationType', 45)->nullable()->unique('uq_publication');
            $table->integer('Status')->nullable();
            $table->dateTime('CreatedOn')->nullable();
            $table->string('CreatedBy', 45)->nullable();
            $table->dateTime('UpdatedOn')->nullable();
            $table->string('UpdatedBy', 45)->nullable();
            $table->integer('PubOrder')->default(0);
            $table->integer('PubCoeff')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicationtype');
    }
};
