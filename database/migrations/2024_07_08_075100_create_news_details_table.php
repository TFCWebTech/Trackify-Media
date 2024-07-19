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
        Schema::create('news_details', function (Blueprint $table) {
            $table->integer('news_details_id', true);
            $table->string('media_type_id')->nullable();
            $table->string('publication_id')->nullable();
            $table->string('edition_id')->nullable();
            $table->string('supplement_id')->nullable();
            $table->string('journalist_id')->nullable();
            $table->string('agencies_id')->nullable();
            $table->string('author')->nullable();
            $table->string('news_position')->nullable();
            $table->string('news_city_id')->nullable();
            $table->string('category')->nullable();
            $table->string('head_line')->nullable();
            $table->string('summary')->nullable();
            $table->tinyInteger('is_send')->default(0);
            $table->string('keywords')->nullable();
            $table->string('client_id')->nullable();
            $table->string('company')->nullable();
            $table->string('sizeofArticle')->nullable();
            $table->string('website_url')->nullable();
            $table->timestamp('create_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_details');
    }
};
