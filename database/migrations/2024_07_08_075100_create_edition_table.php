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
        Schema::create('edition', function (Blueprint $table) {
            $table->bigIncrements('gidEdition_id')->unsigned()->primary();
            $table->string('gidEdition', 45)->nullable();
            $table->string('Edition', 45)->nullable();
            $table->string('EditionOrder', 45)->nullable();
            $table->integer('Status')->nullable();
            $table->dateTime('CreatedOn')->nullable();
            $table->string('CreatedBy', 45)->nullable();
            $table->dateTime('UpdatedOn')->nullable();
            $table->string('UpdatedBy', 45)->nullable();
            $table->string('MediaOutletId', 45);
            $table->string('ShortName', 45);

            $table->unique(['Edition', 'MediaOutletId'], 'uq_edition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edition');
    }
};
