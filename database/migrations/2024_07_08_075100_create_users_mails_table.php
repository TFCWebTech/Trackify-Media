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
        Schema::create('users_mails', function (Blueprint $table) {
            $table->integer('users_mails_id', true);
            $table->integer('client_id')->nullable();
            $table->string('users_mails')->nullable();
            $table->tinyInteger('report_service')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_mails');
    }
};
