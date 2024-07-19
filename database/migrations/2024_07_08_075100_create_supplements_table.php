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
        Schema::create('supplements', function (Blueprint $table) {
            $table->integer('supplement_id', true);
            $table->string('gidSupplement', 45);
            $table->string('Supplement', 45)->nullable();
            $table->string('gidEdition', 45)->nullable();
            $table->string('Status', 45)->nullable();
            $table->string('CreatedOn', 45)->nullable();
            $table->string('CreatedBy', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplements');
    }
};
