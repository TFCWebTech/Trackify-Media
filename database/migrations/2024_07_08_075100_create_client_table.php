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
        Schema::create('client', function (Blueprint $table) {
            $table->integer('client_id', true);
            $table->string('client_name');
            $table->string('email')->default('');
            $table->string('password')->nullable();
            $table->string('client_keywords');
            $table->tinyInteger('cilent_status')->default(1);
            $table->dateTime('create_at');
            $table->string('sector_id')->nullable();
            $table->string('client_type')->nullable();
            $table->string('clients')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('version')->nullable();
            $table->string('website_url')->nullable();
            $table->string('blank_mail')->nullable();
            $table->tinyInteger('report_service')->nullable();
            $table->string('token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client');
    }
};
