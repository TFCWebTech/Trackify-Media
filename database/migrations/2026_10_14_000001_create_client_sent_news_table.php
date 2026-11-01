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
        if (!Schema::hasTable('client_sent_news')) {
            Schema::create('client_sent_news', function (Blueprint $table) {
                $table->id();
                $table->integer('news_details_id');
                $table->integer('client_id');
                $table->date('sent_date');
                $table->timestamps();

                $table->unique(['news_details_id', 'client_id'], 'client_news_sent_unique');
                $table->index(['client_id', 'sent_date'], 'client_news_sent_date_idx');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_sent_news');
    }
};
