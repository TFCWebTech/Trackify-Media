<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addrate', function (Blueprint $table) {
            $table->bigIncrements('gidAddRate_id')->unsigned()->primary();
            $table->string('gidAddRate', 45)->nullable();
            $table->double('Rate')->default(0);
            $table->bigInteger('Circulation_Fig')->default(0);
            $table->string('gidMediaType', 50);
            $table->string('gidMediaOutlet', 50);
            $table->string('gidEdition', 50);
            $table->string('gidSupplement', 50)->default('1');
            $table->integer('Status')->default(0);
            $table->dateTime('CreatedOn');
            $table->string('CreatedBy', 100);
            $table->double('NewRate')->default(0);
            $table->dateTime('UpdatedOn');

            $table->unique(['gidMediaOutlet', 'gidEdition', 'gidSupplement'], 'uq_addrate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addrate');
    }
};
