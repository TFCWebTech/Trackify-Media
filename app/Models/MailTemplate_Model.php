<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate_Model extends Model
{
    use HasFactory;
    protected $table = 'mail_template';
    protected $primaryKey = 'mail_template_id';

    // Specify any fields that are not mass assignable
    protected $guarded = [];

    protected $fillable = [
        'client_id',
        'trackify_link',
        'trackify_link_status',
        'menu_background_color', 
        'menu_font_color', 
        'menu_font',
        'menu_font_size',
        'menu_row_background',
        'menu_row_font_color',
        'menu_row_font',
        'menu_row_font_Size',
        'menu_no_news_text',
        'quick_links',
        'quick_links_url',
        'quick_links_position',
        'header_background_color',
        'header_logo_url',
        'logo_position',
        'header_title_name',
        'header_title_font_color',
        'header_title_font_size',
        'content_category',
        'content_publication',
        'content_edition',
        'content_news_summary_color',
        'content_news_summary_font_size',
        'content_headline_color',
        'content_headline_font',
        'content_headline_font_size',
        'content_media_details',
        'content_media_color',
        'content_media_font',
        'content_media_font_size',
        'content_context',
        'content_context_font',
        'content_context_font_size',
        'footer_background_color',
        'footer_logo_url',
        'footer_logo_position',
        'footer_title_name',
        'footer_title_font_color',
        'footer_title_font_size'
    ];
    public $timestamps = false; // Disable the updated_at column
}
