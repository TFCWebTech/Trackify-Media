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
        Schema::create('mail_template', function (Blueprint $table) {
            $table->integer('mail_template_id', true);
            $table->integer('client_id')->nullable();
            $table->string('trackify_link')->nullable();
            $table->tinyInteger('trackify_link_status')->default(0);
            $table->string('menu_background_color')->nullable();
            $table->string('menu_font_color')->nullable();
            $table->string('menu_font')->nullable();
            $table->string('menu_font_size')->nullable();
            $table->string('menu_row_background')->nullable();
            $table->string('menu_row_font_color')->nullable();
            $table->string('menu_row_font')->nullable();
            $table->string('menu_row_font_Size')->nullable();
            $table->string('menu_no_news_text')->nullable();
            $table->string('quick_links')->nullable();
            $table->string('quick_links_url')->nullable();
            $table->string('quick_links_position')->nullable();
            $table->string('header_background_color')->nullable();
            $table->string('header_logo_url')->nullable();
            $table->string('logo_position')->nullable();
            $table->string('header_title_name')->nullable();
            $table->string('header_title_font_color')->nullable();
            $table->string('header_title_font_size')->nullable();
            $table->string('content_category')->nullable();
            $table->string('content_publication')->nullable();
            $table->string('content_edition')->nullable();
            $table->string('content_news_summary_color')->nullable();
            $table->string('content_news_summary_font_size')->nullable();
            $table->string('content_headline_color')->nullable();
            $table->string('content_headline_font')->nullable();
            $table->string('content_headline_font_size')->nullable();
            $table->string('content_media_details')->nullable();
            $table->string('content_media_color')->nullable();
            $table->string('content_media_font')->nullable();
            $table->string('content_media_font_size')->nullable();
            $table->string('content_context')->nullable();
            $table->string('content_context_font')->nullable();
            $table->string('content_context_font_size')->nullable();
            $table->string('footer_background_color')->nullable();
            $table->string('footer_logo_url')->nullable();
            $table->string('footer_logo_position')->nullable();
            $table->string('footer_title_name')->nullable();
            $table->string('footer_title_font_color')->nullable();
            $table->string('footer_title_font_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_template');
    }
};
