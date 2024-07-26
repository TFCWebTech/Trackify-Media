<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AddRate_Model;
use App\Models\MailTemplate_Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class addClientTemplate extends Controller
{
    public function addNewsTemplate($client_id){
         
        $get_publication = DB::table('mediaoutlet')
        ->select('*')
        ->get();
        
        $get_edition = DB::table('edition')
        ->select('*')
        ->get();

        return view('add_news_template', compact('get_publication' , 'get_edition', 'client_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trackify_media' => 'required',
            'trackify_link' => 'required',
            'menu_bg_color' => 'required',
            'menu_font_color' => 'required',
            'header_font' => 'required',
            'header_font_size' => 'required',
            'row_background' => 'required',
            'row_font_color' => 'required',
            'row_font' => 'required',
            'row_font_size' => 'required',
            'no_news_text' => 'required',
            'quick_links_name' => 'required',
            'quick_link_url' => 'required',
            'quick_links_position' => 'required',
            'header_bg_color' => 'required',
            'logo_url' => 'required',
            'logo_position' => 'required',
            'title_name' => 'required',
            'font_color' => 'required',
            'font_size' => 'required',
            'content_publication' => 'required',
            'content_edition' => 'required',
            'content_news_summary_color' => 'required',
            'content_news_summary_color_size' => 'required',
            'content_headline_color' => 'required',
            'headline_font_size' => 'required',
            'media_details' => 'required',
            'media_color' => 'required',
            'media_font' => 'required',
            'media_font_size' => 'required',
            'context' => 'required',
            'context_font' => 'required',
            'context_font_size' => 'required',
            'footer_bg_color' => 'required',
            'footer_logo_url' => 'required',
            'footer_logo_position' => 'required',
            'footer_title_name' => 'required',
            'footer_font_color' => 'required',
            'footer_font_size' => 'required'
        ]);

        $content_publication = $request->input('content_publication');
        $content_publication_string = implode(',', $content_publication);
        $content_edition = $request->input('content_edition');
        $content_edition_string = implode(',', $content_edition);

        $quick_links_name = $request->input('quick_links_name');
        $quick_links_url = $request->input('quick_link_url');
        $quick_links_position = $request->input('quick_links_position');
    
        $mailTemplate = MailTemplate_Model::create([
            'client_id' => $request->input('client_id'),
            'trackify_link_status' => $request->input('trackify_media'),
            'trackify_link' => $request->input('trackify_link'),
            'menu_background_color' => $request->input('menu_bg_color'),
            'menu_font_color' => $request->input('menu_font_color'),
            'menu_font' => $request->input('header_font'),
            'menu_font_size' => $request->input('header_font_size'),
            'menu_row_background' => $request->input('row_background'),
            'menu_row_font_color' => $request->input('row_font_color'),
            'menu_row_font' => $request->input('row_font'),
            'menu_row_font_Size' => $request->input('row_font_size'),
            'menu_no_news_text' => $request->input('no_news_text'),
            'quick_links' => 'null',
            'quick_links_url' => 'null',
            'quick_links_position' => 'null',
            'header_background_color' => $request->input('header_bg_color'),
            'header_logo_url' => $request->input('logo_url'),
            'logo_position' => $request->input('logo_position'),
            'header_title_name' => $request->input('title_name'),
            'header_title_font_color' => $request->input('font_color'),
            'header_title_font_size' => $request->input('font_size'),
            'content_category' => 'null',
            'content_publication' => $content_publication_string,
            'content_edition' => $content_edition_string,
            'content_news_summary_color' => $request->input('content_news_summary_color'),
            'content_news_summary_font_size' => $request->input('content_news_summary_color_size'),
            'content_headline_font' => $request->input('content_headline_color'),
            'content_headline_font_size' => $request->input('headline_font_size'),
            'content_media_details' => $request->input('media_details'),
            'content_media_color' => $request->input('media_color'),
            'content_media_font' => $request->input('media_font'),
            'content_media_font_size' => $request->input('media_font_size'),
            'content_context' => $request->input('context'),
            'content_context_font' => $request->input('context_font'),
            'content_context_font_size' => $request->input('context_font_size'),
            'footer_background_color' => $request->input('footer_bg_color'),
            'footer_logo_url' => $request->input('footer_logo_url'),
            'footer_logo_position' => $request->input('footer_logo_position'),
            'footer_title_name' => $request->input('footer_title_name'),
            'footer_title_font_color' => $request->input('footer_font_color'),
            'footer_title_font_size' => $request->input('footer_font_size'),
        ]);
        $templateId = $mailTemplate->mail_template_id;
        if ($templateId) {
            $quick_links_data = [];
    
            for ($i = 0; $i < count($quick_links_name); $i++) {
                $quick_links_data[] = [
                    'mail_template_id' => $templateId,
                    'quick_links_name' => $quick_links_name[$i],
                    'quick_links_url' => $quick_links_url[$i],
                    'quick_links_position' => $quick_links_position[$i]
                ];
            }
    
            $all_inserted = true;
            foreach ($quick_links_data as $link_data) {
                $inserted = DB::table('quick_links')->insert($link_data);
                if (!$inserted) {
                    $all_inserted = false;
                    break;
                }
            }
    
            if ($all_inserted) {
                return redirect()->route('addNewsTemplate', $request->input('client_id'))->with('success', 'Template Added Successfully');
            } else {
                return redirect()->route('addNewsTemplate', $request->input('client_id'))->with('error', 'Error adding template');
            }
        } else {
            return redirect()->route('addNewsTemplate', $request->input('client_id'))->with('error', 'Something Went Wrong');
        }
    }
}
