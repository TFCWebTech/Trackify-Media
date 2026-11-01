@include('common/header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .modal-footer{
        justify-content: flex-start !important; 
        display: block !important;
    }
</style>
<div class="container" >
@if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ session('success') }}
            </div>
        @endif
    <div class="card p-3">

        <form action="{{ route('addNewsTemplate.store') }}" method="POST"> 
        @csrf
            <div class="row">
                    <div class="col-md-12 py-2">
                        <div class="text-center">
                            <h5 class="font-weight-bold text-uppercase text-color">Add Email Template</h5>
                        </div>
                        <hr>
                    </div>
                    @php
    $mail_template = DB::table('mail_template')
    ->where('mail_template.client_id', $client_id)
    ->orderBy('mail_template.mail_template_id', 'desc')
    ->select('mail_template.*')
    ->first();
@endphp
                    <div class="col-md-12" >
                        <div class="border-with-text" data-heading="Menu Information">
                            <div class="row">
                                <div class="col-md-3">
                                <input type="hidden" name="client_id" value="{{ $client_id }}">
                                <input type="hidden" name="mail_template_id" value="{{ $mail_template ? $mail_template->mail_template_id : '' }}">
                                    <label class="px-1 font-weight-bold" for="Trackify Link">Trackify Media</label>
                                    <select class="form-control" name="trackify_media" required>
                                        <option value="">Select</option>
                                        <option value="1"
                                            <?php echo (!isset($mail_template) || $mail_template->trackify_link_status == '1')? 'selected': '';?>> Yes
                                        </option>
                                        <option value="0"
                                            <?php echo (isset($mail_template) && $mail_template->trackify_link_status == '0')? 'selected': '';?>> No
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="menu_bg_color">Trackify Link</label>
                                    <input type="text" oninput="removeLeadingSpace(this)"
                                        class="form-control" name="trackify_link"
                                        placeholder="Trackify Link" required
                                        value="{{ old('trackify_link', isset($mail_template) && $mail_template->trackify_link
                                        ? $mail_template->trackify_link
                                        : 'https://pressbro.com/News/assets/img/mediaLogo.png') }}"
                                    >
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="menu_bg_color">Header Background Color</label>
                                    <input type="color" class="form-control" name="menu_bg_color"
                                        required value="{{ old('menu_bg_color',
                                            isset($mail_template) && $mail_template->menu_background_color ? $mail_template->menu_background_color: '#795492') }}"
                                    >
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="header_bg_color">Header Font Color</label>
                                    <input type="color" class="form-control" name="menu_font_color" placeholder="Header Font Color"
                                        required value="{{ old( 'menu_font_color',
                                            isset($mail_template) && $mail_template->menu_font_color ? $mail_template->menu_font_color: '#000000') }}"
                                    >
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="menu_bg_color">Header Font </label>
                                    <select name="header_font" class="form-control" id="HTBFont1" required>
                                        <option value="">Select</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Arial') ? 'selected' : ''; ?> value="Arial">Arial</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Helvetica') ? 'selected' : ''; ?> value="Helvetica">Helvetica</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'sans-serif') ? 'selected' : ''; ?> value="sans-serif">sans-serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Arial Black') ? 'selected' : ''; ?> value="Arial Black">Arial Black</option>
                                        <option value="Times New Roman" <?php echo (!isset($mail_template) ||$mail_template->menu_font === 'Times New Roman') ? 'selected' : '';?>>Times New Roman</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Gadget,sans-serif') ? 'selected' : ''; ?> value="Gadget,sans-serif">Gadget,sans-serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Comic Sans MS') ? 'selected' : ''; ?> value="Comic Sans MS">Comic Sans MS</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'cursive') ? 'selected' : ''; ?> value="cursive">cursive</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Courier New') ? 'selected' : ''; ?> value="Courier New">Courier New</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Courier') ? 'selected' : ''; ?> value="Courier">Courier</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'monospace') ? 'selected' : ''; ?> value="monospace">monospace</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Georgia') ? 'selected' : ''; ?> value="Georgia">Georgia</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'serif') ? 'selected' : ''; ?> value="serif">serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Impact') ? 'selected' : ''; ?> value="Impact">Impact</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Charcoal') ? 'selected' : ''; ?> value="Charcoal">Charcoal</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Lucida Console') ? 'selected' : ''; ?> value="Lucida Console">Lucida Console</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Monaco') ? 'selected' : ''; ?> value="Monaco">Monaco</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Lucida Sans Unicode') ? 'selected' : ''; ?> value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Lucida Grande') ? 'selected' : ''; ?> value="Lucida Grande">Lucida Grande</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Tahoma') ? 'selected' : ''; ?> value="Tahoma">Tahoma</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Geneva') ? 'selected' : ''; ?> value="Geneva">Geneva</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font == 'Verdana') ? 'selected' : ''; ?> value="Verdana">Verdana</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="menu_bg_color">Header Font Size</label>
                                    <select name="header_font_size" class="form-control" id="HTBFontSize1" required>
                                        <option value="">Select</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '1') ? 'selected' : ''; ?> value="1">1</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '2') ? 'selected' : ''; ?> value="2">2</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '3') ? 'selected' : ''; ?> value="3">3</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '4') ? 'selected' : ''; ?> value="4">4</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '5') ? 'selected' : ''; ?> value="5">5</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '6') ? 'selected' : ''; ?> value="6">6</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '7') ? 'selected' : ''; ?> value="7">7</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '8') ? 'selected' : ''; ?> value="8">8</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '9') ? 'selected' : ''; ?> value="9">9</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '10') ? 'selected' : ''; ?> value="10">10</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '11') ? 'selected' : ''; ?> value="11">11</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '12') ? 'selected' : ''; ?> value="12">12</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '13') ? 'selected' : ''; ?> value="13">13</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '14') ? 'selected' : ''; ?> value="14">14</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '15') ? 'selected' : ''; ?> value="15">15</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '16') ? 'selected' : ''; ?> value="16">16</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '17') ? 'selected' : ''; ?> value="17">17</option>
                                        <option value="18" <?php echo (!isset($mail_template) || $mail_template->menu_font_size == '18') ? 'selected' : '';?>>18</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '19') ? 'selected' : ''; ?> value="19">19</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_font_size == '20') ? 'selected' : ''; ?> value="20">20</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="title_name">Row Background</label>
                                    <input type="color" class="form-control" name="row_background" placeholder="Row Background"
                                        value="{{ old('menu_row_background', $mail_template->menu_row_background ?? '#8f50b9') }}" required >
                                </div>
                                <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="font_color">Row Font Color</label>
                                    <input type="color" class="form-control" name="row_font_color" placeholder="Row Font Color"
                                        value="{{ old('row_font_color', $mail_template->menu_row_font_color ?? '#000000') }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="header_bg_color">Row Font </label>
                                    <select name="row_font" class="form-control" id="HTBFont1" required>
                                        <option value="">Select</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Arial') ? 'selected' : ''; ?> value="Arial">Arial</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Helvetica') ? 'selected' : ''; ?> value="Helvetica">Helvetica</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'sans-serif') ? 'selected' : ''; ?> value="sans-serif">sans-serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Arial Black') ? 'selected' : ''; ?> value="Arial Black">Arial Black</option>
                                        <option value="Times New Roman" <?php echo (!isset($mail_template) || $mail_template->menu_row_font == 'Times New Roman') ? 'selected' : ''; ?>> Times New Roman</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Gadget,sans-serif') ? 'selected' : ''; ?> value="Gadget,sans-serif">Gadget,sans-serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Comic Sans MS') ? 'selected' : ''; ?> value="Comic Sans MS">Comic Sans MS</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'cursive') ? 'selected' : ''; ?> value="cursive">cursive</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Courier New') ? 'selected' : ''; ?> value="Courier New">Courier New</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Courier') ? 'selected' : ''; ?> value="Courier">Courier</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'monospace') ? 'selected' : ''; ?> value="monospace">monospace</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Georgia') ? 'selected' : ''; ?> value="Georgia">Georgia</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'serif') ? 'selected' : ''; ?> value="serif">serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Impact') ? 'selected' : ''; ?> value="Impact">Impact</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Charcoal') ? 'selected' : ''; ?> value="Charcoal">Charcoal</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Lucida Console') ? 'selected' : ''; ?> value="Lucida Console">Lucida Console</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Monaco') ? 'selected' : ''; ?> value="Monaco">Monaco</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Lucida Sans Unicode') ? 'selected' : ''; ?> value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Lucida Grande') ? 'selected' : ''; ?> value="Lucida Grande">Lucida Grande</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Tahoma') ? 'selected' : ''; ?> value="Tahoma">Tahoma</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Geneva') ? 'selected' : ''; ?> value="Geneva">Geneva</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font == 'Verdana') ? 'selected' : ''; ?> value="Verdana">Verdana</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="title_name">Row Font Size</label>
                                    <select name="row_font_size" class="form-control" id="HTBFontSize1" required>
                                        <option value="">Select</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '1') ? 'selected' : ''; ?> value="1">1</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '2') ? 'selected' : ''; ?> value="2">2</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '3') ? 'selected' : ''; ?> value="3">3</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '4') ? 'selected' : ''; ?> value="4">4</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '5') ? 'selected' : ''; ?> value="5">5</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '6') ? 'selected' : ''; ?> value="6">6</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '7') ? 'selected' : ''; ?> value="7">7</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '8') ? 'selected' : ''; ?> value="8">8</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '9') ? 'selected' : ''; ?> value="9">9</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '10') ? 'selected' : ''; ?> value="10">10</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '11') ? 'selected' : ''; ?> value="11">11</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '12') ? 'selected' : ''; ?> value="12">12</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '13') ? 'selected' : ''; ?> value="13">13</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '14') ? 'selected' : ''; ?> value="14">14</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '15') ? 'selected' : ''; ?> value="15">15</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '16') ? 'selected' : ''; ?> value="16">16</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '17') ? 'selected' : ''; ?> value="17">17</option>
                                        <option value="18" <?php echo (!isset($mail_template) || $mail_template->menu_row_font_Size == '18') ? 'selected' : ''; ?>>18</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '19') ? 'selected' : ''; ?> value="19">19</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_row_font_Size == '20') ? 'selected' : ''; ?> value="20">20</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="font_color">No News Text</label>
                                    <select name="no_news_text" class="form-control" id="HTBFontSize1" required>
                                        <option value="">Select</option>
                                        <option value="Yes"<?php echo (!isset($mail_template) || $mail_template->menu_no_news_text == 'Yes') ? 'selected' : ''; ?>> Yes</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->menu_no_news_text == 'No') ? 'selected' : ''; ?>  value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                    if (isset($mail_template) && $mail_template !== null) {
                        $mail_template2 = DB::table('quick_links')
                        ->where('quick_links.mail_template_id', $mail_template->mail_template_id)
                    ->select('quick_links.*')
                        ->get();

                        if ($mail_template2->isNotEmpty()) {
                            
                    @endphp
                        <div class="col-md-12 mt-3">
                            <div class="border-with-text" data-heading="Quick Links">
                                <div class="quick-links" id="quick-links-container">
                                    <div class="row quick-link">
                                        <div class="col-md-12 text-right">
                                        </div>
                                        @php
                                        foreach ($mail_template2 as $template) {
                                            if (!empty($template->quick_links_name)) {
                                            @endphp
                                            <input type="hidden" class="form-control" name="quick_links_id_old[]" value="{{ old('quick_links_id_old', isset($template) ? $template->quick_links_id : '') }}" >
                                            
                                        <div class="col-md-4">  
                                            <label class="px-1 font-weight-bold" for="media_type">Name </label>
                                            <input type="text" oninput="removeLeadingSpace(this)" class="form-control" name="quick_links_name_old[]" value="{{ old('quick_links_name_old', isset($template) ? $template->quick_links_name : '') }}" placeholder="Enter Name" >
                                        </div>
                                        <div class="col-md-4">
                                            <label class="px-1 font-weight-bold" for="media_type">URL </label>
                                            <input type="text" oninput="removeLeadingSpace(this)"  class="form-control" name="quick_link_url_old[]" value="{{ old('quick_link_url_old', isset($template) ? $template->quick_links_url : '') }}" placeholder="Enter URL" >
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex justify-content-between">
                                            <label class="px-1 font-weight-bold" for="media_type">Quick links Position  </label>
                                            <a class="fa fa-trash mt-2 remove-quick-link text-danger" style="display: none;"></a>
                                            </div>
                                            
                                            <select  class="form-control" name="quick_links_position_old[]" id="Quicklink1">
                                                <option  value="">Select</option>
                                                <option <?php echo ($template->quick_links_position == '1') ? 'selected' : ''; ?> value="1">Row 1</option>
                                                <option <?php echo ($template->quick_links_position == '2') ? 'selected' : ''; ?> value="2">Row 2</option>
                                                <option <?php echo ($template->quick_links_position == '3') ? 'selected' : ''; ?> value="3">Row 3</option>
                                                <option <?php echo ($template->quick_links_position == '4') ? 'selected' : ''; ?> value="4">Row 4</option>
                                                <option <?php echo ($template->quick_links_position == '5') ? 'selected' : ''; ?> value="5">Row 5</option>
                                            </select>
                                        </div>
                                        @php
                                        }}
                                        @endphp 
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        @php

                        }}
                    @endphp
                    <div class="col-md-12 mt-3">
                        <div class="border-with-text" data-heading="Add Quick Links">
                            <div class="quick-links" id="quick-links-container">
                                <div class="row quick-link">
                                    <div class="col-md-12 text-right">
                                    </div>
                                    <div class="col-md-4">  
                                        <label class="px-1 font-weight-bold" for="media_type">Name </label>
                                        <input type="text" class="form-control" oninput="removeLeadingSpace(this)" name="quick_links_name[]" placeholder="Enter Name " >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="px-1 font-weight-bold" for="media_type">URL </label>
                                        <input type="text" class="form-control"oninput="removeLeadingSpace(this)" name="quick_link_url[]" placeholder="Enter URL " >
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between">
                                        <label class="px-1 font-weight-bold" for="media_type">Quick links Position  </label>
                                        <a class="fa fa-trash mt-2 remove-quick-link text-danger" style="display: none;"></a>
                                        </div>
                                        
                                        <select  class="form-control" name="quick_links_position[]" id="Quicklink1">
                                            <option value="">Select</option>
                                            <option value="1">Row 1</option>
                                            <option value="2">Row 2</option>
                                            <option value="3">Row 3</option>
                                            <option value="4">Row 4</option>
                                            <option value="5">Row 5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <a id="add-more" class="mt-3 p-2">Add More</a>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="border-with-text" data-heading="Header Information">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="header_bg_color">Header Background Color</label>
                                    <input type="color" class="form-control" name="header_bg_color" placeholder="Background Color"
                                        value="{{ old('header_bg_color', isset($mail_template) ? $mail_template->header_background_color : '#795492') }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="logo_url">Logo Url</label>
                                    <input type="text" oninput="removeLeadingSpace(this)" class="form-control" name="logo_url" placeholder="Logo Url"
                                        value="{{ old('logo_url', isset($mail_template) ? $mail_template->header_logo_url : 'https://pressbro.com/News/assets/img/mediaLogo.png') }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="logo_position">Logo Position</label>
                                    <select class="form-control" name="logo_position" required>
                                        <option value="">Select</option>
                                        <option value="Left" <?php echo ((isset($mail_template) && $mail_template->logo_position == 'Left')|| !isset($mail_template)) ? 'selected' : '';?>> Left </option>
                                        <option <?php echo (isset($mail_template) && $mail_template->logo_position == 'Right') ? 'selected' : ''; ?> value="Right">Right</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->logo_position == 'Center') ? 'selected' : ''; ?> value="Center">Center</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="title_name">Title Name</label>
                                    <input type="text" class="form-control" oninput="removeLeadingSpace(this)" name="title_name" placeholder="Title Name"
                                        value="{{ old('title_name', isset($mail_template) ? $mail_template->header_title_name : '') }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="font_color">Title Font Color</label>
                                    <input type="color" class="form-control" name="font_color" placeholder="Font Color"
                                        value="{{ old('font_color', isset($mail_template) ? $mail_template->header_title_font_color : '#000000') }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="font_color">Title Font Size</label>
                                    <input type="number" oninput="removeLeadingSpace(this)" class="form-control" name="font_size" placeholder="Font Size"
                                        value="{{ old('font_size', isset($mail_template) ? $mail_template->header_title_font_size : 18) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
    //echo "<pre>";
    //print_r($get_edition); echo "</pre>";die;?>
                    <div class="col-md-12 mt-3">
                        <div class="border-with-text" data-heading="Content News">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">Publication</label>
                                    <select class="js-example-basic-multiple form-control" name="content_publication[]" multiple="multiple" required>
                                        <option value="select_all"
                                            @if(!isset($mail_template) || (isset($mail_template) && empty($mail_template->content_publication)))
                                                selected
                                            @endif
                                        >Select All</option> <!-- Select All Option -->

                                        @foreach($get_publication as $publication)
                                            <option value="{{ $publication->gidMediaOutlet }}"
                                                @if(isset($mail_template) && !is_null($mail_template->content_publication) && in_array($publication->gidMediaOutlet, (is_array($mail_template->content_publication) ? $mail_template->content_publication : explode(',', $mail_template->content_publication))))
                                                    selected="selected"
                                                @endif
                                            >
                                                {{ $publication->MediaOutlet }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">Edition</label>
                                    <select class="js-example-basic-multiple form-control" name="content_edition[]" multiple="multiple" required>
                                        <option value="select_all">Select All</option>
                                        @php
                                            $nashikSelected = false; // flag to select only first Nashik
                                        @endphp
                                        @foreach($get_edition as $edition)
                                            <option value="{{ $edition->gidEdition }}"
                                                @if(isset($mail_template) && !is_null($mail_template->content_edition) && in_array($edition->gidEdition, (is_array($mail_template->content_edition) ? $mail_template->content_edition : explode(',', $mail_template->content_edition))))
                                                    selected="selected"
                                                @elseif(!isset($mail_template) && $edition->Edition == 'Nashik' && !$nashikSelected)
                                                    selected="selected"
                                                    @php $nashikSelected = true; @endphp
                                                @endif
                                            >
                                                {{ $edition->Edition }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    $(document).ready(function () {
                                        // Initialize Select2 once
                                        $('select[name="content_publication[]"], select[name="content_edition[]"]').select2({
                                            placeholder: "Select Options",
                                            allowClear: true,
                                            width: '100%'
                                        });

                                        // On load: if "Select All" is selected, expand it to all options
                                        $('select[name="content_publication[]"], select[name="content_edition[]"]').each(function() {
                                            const selectElement = $(this);
                                            const selectedValues = selectElement.val() || [];

                                            if (selectedValues.includes("select_all")) {
                                                const allOptions = selectElement.find('option')
                                                    .not('[value="select_all"]')
                                                    .map(function() { return this.value; })
                                                    .get();
                                                selectElement.val(allOptions).trigger('change');
                                            }
                                        });

                                        // Handle selection change
                                        $('select[name="content_publication[]"], select[name="content_edition[]"]').on('change', function () {
                                            const selectElement = $(this);
                                            const selectedValues = selectElement.val() || [];
                                            const isPublication = selectElement.attr('name') === 'content_publication[]';
                                            const isEdition = selectElement.attr('name') === 'content_edition[]';

                                            if ((isPublication || isEdition) && selectedValues.includes("select_all")) {
                                                const allOptions = selectElement.find('option')
                                                    .not('[value="select_all"]')
                                                    .map(function () { return this.value; })
                                                    .get();
                                                selectElement.val(allOptions).trigger('change');
                                            } else {
                                                // Remove "Select All" if any other option is selected
                                                selectElement.find('option[value="select_all"]').prop('selected', false);
                                            }
                                        });

                                        // Optional: Handle "deselect" logic
                                        $('select[name="content_publication[]"], select[name="content_edition[]"]').on('select2:unselect', function (e) {
                                            const deselectedOption = e.params.data.id; // Get the deselected option's value
                                            const selectElement = $(this);

                                            if (deselectedOption === "select_all" || deselectedOption === "") {
                                                // If "Select All" or empty value is deselected, clear the entire selection
                                                selectElement.val(null).trigger('change');
                                            }
                                        });
                                    });

                                </script>
                                <style>
                                    /* .select2-container .select2-dropdown {
                                    max-height: 200px;
                                    overflow-y: auto;
                                } */
                                <style>
                                    .select2-container .select2-dropdown {
                                        max-height: 200px;
                                        overflow-y: auto;
                                    }

                                    .select2-container--default .select2-selection--multiple {
                                        max-height: 150px;
                                        overflow-y: auto;
                                    }
                                </style>
   
                                <script>
                                    $(document).ready(function() {
                                        $('.js-example-basic-multiple').select2({
                                            placeholder: "Select Edition",
                                            allowClear: true,
                                            width: '100%',
                                            closeOnSelect: false
                                        });
                                        // $('.js-example-basic-multiple').select2({
                                        //     placeholder: "Select Edition",
                                        //     width: '100%' // Ensures the dropdown fits within the container
                                        // });
                                    });
                                </script>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="author">News Summary Color</label>
                                    <input type="color" class="form-control" placeholder="Enter Summary Color" name="content_news_summary_color" 
                                        value="{{ old('content_news_summary_color', isset($mail_template) ? $mail_template->content_news_summary_color : '#000000') }}"  required>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">News Summary Font Size</label>
                                    <input type="number" oninput="removeLeadingSpace(this)" class="form-control" placeholder="Enter Font Size" name="content_news_summary_color_size" 
                                        value="{{ old('content_news_summary_color_size', isset($mail_template) ? $mail_template->content_news_summary_font_size : 18) }}" required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">Headline Color</label>
                                    <input type="color" class="form-control" placeholder="Enter Headline Color" name="content_headline_color" 
                                        value="{{ old('content_headline_color', isset($mail_template) ? $mail_template->content_headline_color : '#000000') }}" 
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">Headline Font </label>
                                    <select name="headline_font" class="form-control" id="MediaFont1" required>
                                        <option  value="1">Select</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Arial') ? 'selected' : ''; ?> value="Arial">Arial</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Helvetica') ? 'selected' : ''; ?> value="Helvetica">Helvetica</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'sans-serif') ? 'selected' : ''; ?> value="sans-serif">sans-serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Arial Black') ? 'selected' : ''; ?> value="Arial Black">Arial Black</option>
                                        <option value="Times New Roman" {{ (old('headline_font', isset($mail_template) ? $mail_template->content_headline_font : 'Times New Roman') == 'Times New Roman') ? 'selected' : '' }}>Times New Roman</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Gadget,sans-serif') ? 'selected' : ''; ?> value="Gadget,sans-serif">Gadget,sans-serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Comic Sans MS') ? 'selected' : ''; ?> value="Comic Sans MS">Comic Sans MS</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'cursive') ? 'selected' : ''; ?> value="cursive">cursive</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Courier New') ? 'selected' : ''; ?> value="Courier New">Courier New</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Courier') ? 'selected' : ''; ?> value="Courier">Courier</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'monospace') ? 'selected' : ''; ?> value="monospace">monospace</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Georgia') ? 'selected' : ''; ?> value="Georgia">Georgia</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'serif') ? 'selected' : ''; ?> value="serif">serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Impact') ? 'selected' : ''; ?> value="Impact">Impact</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Charcoal') ? 'selected' : ''; ?> value="Charcoal">Charcoal</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Lucida Console') ? 'selected' : ''; ?> value="Lucida Console">Lucida Console</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Monaco') ? 'selected' : ''; ?> value="Monaco">Monaco</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Lucida Sans Unicode') ? 'selected' : ''; ?> value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Lucida Grande') ? 'selected' : ''; ?> value="Lucida Grande">Lucida Grande</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Tahoma') ? 'selected' : ''; ?> value="Tahoma">Tahoma</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Geneva') ? 'selected' : ''; ?> value="Geneva">Geneva</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_headline_font == 'Verdana') ? 'selected' : ''; ?> value="Verdana">Verdana</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">Headline Font Size </label>
                                    <input type="number" oninput="removeLeadingSpace(this)" class="form-control" placeholder="Enter Font Size" name="headline_font_size" required 
                                        value="{{ old('headline_font_size', isset($mail_template) ? $mail_template->content_headline_font_size : 18) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">Media Details</label>
                                    <select name="media_details" class="form-control" accesskey="n" onkeyup="validateUserType('?text=' + this.value);" required>
                                        <option value="0">Select</option>
                                        <option value="Yes" {{ (old('media_details', isset($mail_template) ? $mail_template->content_media_details : 'Yes') == 'Yes') ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ (old('media_details', isset($mail_template) ? $mail_template->content_media_details : 'Yes') == 'No') ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">Media Color</label>
                                    <input type="color" class="form-control" placeholder="Enter Media Color" name="media_color" required 
                                        value="{{ old('media_color', isset($mail_template) ? $mail_template->content_media_color : '#000000') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="Time">Media Font </label>
                                    <select name="media_font" class="form-control" id="MediaFont1">
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Arial') ? 'selected' : ''; ?> value="Arial">Arial</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Helvetica') ? 'selected' : ''; ?> value="Helvetica">Helvetica</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'sans-serif') ? 'selected' : ''; ?> value="sans-serif">sans-serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Arial Black') ? 'selected' : ''; ?> value="Arial Black">Arial Black</option>
                                        <option value="Times New Roman" {{ (old('media_font', isset($mail_template) ? $mail_template->content_media_font : 'Times New Roman') == 'Times New Roman') ? 'selected' : '' }}>Times New Roman</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Gadget,sans-serif') ? 'selected' : ''; ?> value="Gadget,sans-serif">Gadget,sans-serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Comic Sans MS') ? 'selected' : ''; ?> value="Comic Sans MS">Comic Sans MS</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'cursive') ? 'selected' : ''; ?> value="cursive">cursive</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Courier New') ? 'selected' : ''; ?> value="Courier New">Courier New</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Courier') ? 'selected' : ''; ?> value="Courier">Courier</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'monospace') ? 'selected' : ''; ?> value="monospace">monospace</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Georgia') ? 'selected' : ''; ?> value="Georgia">Georgia</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'serif') ? 'selected' : ''; ?> value="serif">serif</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Impact') ? 'selected' : ''; ?> value="Impact">Impact</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Charcoal') ? 'selected' : ''; ?> value="Charcoal">Charcoal</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Lucida Console') ? 'selected' : ''; ?> value="Lucida Console">Lucida Console</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Monaco') ? 'selected' : ''; ?> value="Monaco">Monaco</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Lucida Sans Unicode') ? 'selected' : ''; ?> value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Lucida Grande') ? 'selected' : ''; ?> value="Lucida Grande">Lucida Grande</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Tahoma') ? 'selected' : ''; ?> value="Tahoma">Tahoma</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Geneva') ? 'selected' : ''; ?> value="Geneva">Geneva</option>
                                        <option <?php echo (isset($mail_template) && $mail_template->content_media_font == 'Verdana') ? 'selected' : ''; ?> value="Verdana">Verdana</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="Duration">Media Font Size</label>
                                    <input type="number" oninput="removeLeadingSpace(this)" class="form-control" placeholder="Enter Font Size" name="media_font_size" required 
                                        value="{{ old('media_font_size', isset($mail_template) ? $mail_template->content_media_font_size : 18) }}">
                                </div>
                            

                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="media_type">Context</label>
                                    <select name="context" class="form-control" accesskey="n" onkeyup="validateUserType('?text=' + this.value);" required>
                                        <option value="0">Select</option>
                                        <option value="Yes" {{ (old('context', isset($mail_template) ? $mail_template->content_context : 'Yes') == 'Yes') ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ (old('context', isset($mail_template) ? $mail_template->content_context : 'Yes') == 'No') ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="Time">Context Font</label>
                                    <select name="context_font" class="form-control" id="MediaFont1" required>
                                        <option value="1">Select</option>
                                        <option value="Arial" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Arial') ? 'selected' : ''; ?>>Arial</option>
                                        <option value="Helvetica" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Helvetica') ? 'selected' : ''; ?>>Helvetica</option>
                                        <option value="sans-serif" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'sans-serif') ? 'selected' : ''; ?>>sans-serif</option>
                                        <option value="Arial Black" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Arial Black') ? 'selected' : ''; ?>>Arial Black</option>
                                        <option value="Times New Roman" {{ (old('context_font', isset($mail_template) ? $mail_template->content_context_font : 'Times New Roman') == 'Times New Roman') ? 'selected' : '' }}>Times New Roman</option>
                                        <option value="Gadget,sans-serif" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Gadget,sans-serif') ? 'selected' : ''; ?>>Gadget,sans-serif</option>
                                        <option value="Comic Sans MS" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Comic Sans MS') ? 'selected' : ''; ?>>Comic Sans MS</option>
                                        <option value="cursive" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'cursive') ? 'selected' : ''; ?>>cursive</option>
                                        <option value="Courier New" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Courier New') ? 'selected' : ''; ?>>Courier New</option>
                                        <option value="Courier" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Courier') ? 'selected' : ''; ?>>Courier</option>
                                        <option value="monospace" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'monospace') ? 'selected' : ''; ?>>monospace</option>
                                        <option value="Georgia" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Georgia') ? 'selected' : ''; ?>>Georgia</option>
                                        <option value="serif" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'serif') ? 'selected' : ''; ?>>serif</option>
                                        <option value="Impact" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Impact') ? 'selected' : ''; ?>>Impact</option>
                                        <option value="Charcoal" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Charcoal') ? 'selected' : ''; ?>>Charcoal</option>
                                        <option value="Lucida Console" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Lucida Console') ? 'selected' : ''; ?>>Lucida Console</option>
                                        <option value="Monaco" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Monaco') ? 'selected' : ''; ?>>Monaco</option>
                                        <option value="Lucida Sans Unicode" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Lucida Sans Unicode') ? 'selected' : ''; ?>>Lucida Sans Unicode</option>
                                        <option value="Lucida Grande" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Lucida Grande') ? 'selected' : ''; ?>>Lucida Grande</option>
                                        <option value="Tahoma" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Tahoma') ? 'selected' : ''; ?>>Tahoma</option>
                                        <option value="Geneva" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Geneva') ? 'selected' : ''; ?>>Geneva</option>
                                        <option value="Verdana" <?php echo (isset($mail_template) && $mail_template->content_context_font == 'Verdana') ? 'selected' : ''; ?>>Verdana</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="Duration">Context Font Size</label>
                                    <input type="number" oninput="removeLeadingSpace(this)" class="form-control" placeholder="Context Font Size" name="context_font_size" required 
                                        value="{{ old('context_font_size', isset($mail_template) ? $mail_template->content_context_font_size : 18) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="border-with-text" data-heading="Footer Information">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="footer_bg_color">Footer Background Color</label>
                                    <input type="color" class="form-control" name="footer_bg_color" placeholder="Background Color" required 
                                        value="{{ old('footer_bg_color', isset($mail_template) ? $mail_template->footer_background_color : '#6f54bb') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="logo_url">Logo Url</label>
                                    <input type="text" oninput="removeLeadingSpace(this)" class="form-control" name="footer_logo_url" placeholder="Logo Url" required 
                                        value="{{ old('footer_logo_url', isset($mail_template) ? $mail_template->footer_logo_url : 'https://pressbro.com/News/assets/img/mediaLogo.png') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="logo_position">Logo Position</label>
                                    <select class="form-control" name="footer_logo_position" required>
                                        <option value="">Select</option>
                                        <option value="Left" {{ (old('footer_logo_position', isset($mail_template) ? $mail_template->footer_logo_position : 'Left') == 'Left') ? 'selected' : '' }}>Left</option>
                                        <option value="Right" {{ (old('footer_logo_position', isset($mail_template) ? $mail_template->footer_logo_position : 'Left') == 'Right') ? 'selected' : '' }}>Right</option>
                                        <option value="Center" {{ (old('footer_logo_position', isset($mail_template) ? $mail_template->footer_logo_position : 'Left') == 'Center') ? 'selected' : '' }}>Center</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="title_name">Title Name</label>
                                    <input type="text" oninput="removeLeadingSpace(this)" class="form-control" name="footer_title_name" placeholder="Title Name" required 
                                        value="{{ old('footer_title_name', isset($mail_template) ? $mail_template->footer_title_name : '') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="font_color">Title Font Color</label>
                                    <input type="color" class="form-control" name="footer_font_color" placeholder="Font Color" required 
                                        value="{{ old('footer_font_color', isset($mail_template) ? $mail_template->footer_title_font_color : '#000000') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="px-1 font-weight-bold" for="font_color">Title Font Size</label>
                                    <input type="number" oninput="removeLeadingSpace(this)" class="form-control" name="footer_font_size" placeholder="Font size" required
                                        value="{{ old('footer_font_size', isset($mail_template) ? $mail_template->footer_title_font_size : 18) }}">
                                </div>
                            </div>
                         </div>
                    </div>

                    <div class="col-md-12 text-right px-4 py-2">
                        <!-- <a  class="btn btn-success" data-toggle="modal" data-target="#tatamoters">Preview</a> -->
                        <button  class="btn btn-primary">Save Page</button>
                    </div>
        </form>
    </div>
</div>          
</div>

<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

 <script type="text/javascript">
   CKEDITOR.replace( 'editor1' );
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('#add-more').click(function(){
            var newQuickLink = $('.quick-link').first().clone();
            newQuickLink.find('input').val('');
            newQuickLink.find('select').val('');
            newQuickLink.find('.remove-quick-link').show(); 
            $('#quick-links-container').append(newQuickLink);
        });

        $(document).on('click', '.remove-quick-link', function(){
            $(this).closest('.quick-link').remove();
        });
    });
</script>
<script>
    function removeLeadingSpace(input) {
        // Remove leading spaces as user types
        input.value = input.value.replace(/^\s+/, '');
    }
</script>
@include('common/footer')
