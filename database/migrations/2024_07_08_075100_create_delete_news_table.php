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
        Schema::create('delete_news', function (Blueprint $table) {
            $table->integer('delete_news_id', true);
            $table->integer('news_details_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('is_delete')->nullable();
            $table->integer('is_hide')->nullable();
            $table->string('headline')->nullable();
            $table->text('summary')->nullable();
            $table->integer('is_update')->nullable();
            $table->timestamp('create_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delete_news');
    }
};
