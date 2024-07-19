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
        Schema::create('journalist', function (Blueprint $table) {
            $table->bigIncrements('journalist_id')->unsigned()->primary();
            $table->string('gidJournalist', 45)->nullable();
            $table->string('Journalist', 500)->nullable();
            $table->string('JEmailId', 45)->nullable();
            $table->integer('Status')->nullable();
            $table->string('CreatedOn', 45)->nullable();
            $table->string('CreatedBy', 45)->nullable();
            $table->string('gigMediaOutlet', 45)->nullable();
            $table->bigInteger('phoneNo1')->nullable();
            $table->bigInteger('phoneNo2')->nullable();
            $table->bigInteger('mobNo1')->nullable();
            $table->bigInteger('mobNo2')->nullable();
            $table->string('LastMediaOutlets', 300)->nullable();
            $table->string('designation', 300)->nullable();
            $table->text('beats')->nullable();
            $table->text('twitter')->nullable();
            $table->text('facebook')->nullable();
            $table->text('quora')->nullable();
            $table->text('website')->nullable();
            $table->text('blog')->nullable();
            $table->text('linkedin')->nullable();
            $table->text('otherDetails')->nullable();
            $table->integer('showOnNewJourno')->nullable()->default(-1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journalist');
    }
};
