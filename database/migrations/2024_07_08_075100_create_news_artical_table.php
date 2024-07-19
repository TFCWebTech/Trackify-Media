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
        Schema::create('news_artical', function (Blueprint $table) {
            $table->integer('news_artical_id', true);
            $table->integer('news_details_id');
            $table->integer('artical_images_id')->nullable();
            $table->text('news_artical')->nullable();
            $table->integer('page_no')->nullable();
            $table->timestamp('create_at')->useCurrentOnUpdate()->useCurrent();
            $table->string('image_height')->nullable();
            $table->string('image_width')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_artical');
    }
};
