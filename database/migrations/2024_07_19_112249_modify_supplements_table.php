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
        Schema::table('supplements', function (Blueprint $table) {
            // Change 'Status' column type to boolean
            $table->boolean('Status')->nullable()->change();

            // Change 'CreatedOn' column type to datetime
            $table->dateTime('CreatedOn')->nullable()->change();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('supplements', function (Blueprint $table) {
            // Revert 'Status' column type back to string
            $table->string('Status', 45)->nullable()->change();

            // Revert 'CreatedBy' column type back to string
            $table->string('CreatedBy', 45)->nullable()->change();

            // Revert 'CreatedOn' column type back to string
            $table->string('CreatedOn', 45)->nullable()->change();
        });
    }
};
