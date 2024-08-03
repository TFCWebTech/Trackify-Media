<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('client', function (Blueprint $table) {
            $table->string('client_name')->nullable()->change();
            $table->string('client_keywords')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->dateTime('create_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('client', function (Blueprint $table) {
            $table->string('client_name')->nullable(false)->change();
            $table->string('client_keywords')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->dateTime('create_at')->nullable(false)->change();
        });
    }
};
