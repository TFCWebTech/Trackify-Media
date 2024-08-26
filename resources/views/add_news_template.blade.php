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
                            <h5 class="font-weight-bold text-uppercase text-color">Add Email Tempate</h5>
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-12" >
                        <div class="border-with-text" data-heading="Menu Information">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <input type="hidden" name="client_id" value="{{ $client_id }}">
                                            <label class="px-1 font-weight-bold" for="Trackify Link">Trackify Media</label>
                                            <select class="form-control" name="trackify_media">
                                                <option value="">Select</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="menu_bg_color">Trackify Link</label>
                                            <input type="text" class="form-control" name="trackify_link" placeholder="Trackify Link">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="menu_bg_color">Header Background Color</label>
                                            <input type="color" class="form-control" name="menu_bg_color" placeholder="Background Color">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="header_bg_color">Header Font Color</label>
                                            <input type="color" class="form-control" name="menu_font_color" placeholder="Header Font Color">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="menu_bg_color">Header Font </label>
                                            <select name="header_font" class="form-control" id="HTBFont1">
                                                            <option value="1">Select</option>
                                                            <option value="Arial" selected="">Arial</option>
                                                            <option value="Helvetica">Helvetica</option>
                                                            <option value="sans-serif">sans-serif</option>
                                                            <option value="Arial Black">Arial Black</option>
                                                            <option value="Times New Roman">Times New Roman</option>
                                                            <option value="Gadget,sans-serif">Gadget,sans-serif</option>
                                                            <option value="Comic Sans MS">Comic Sans MS</option>
                                                            <option value="cursive">cursive</option>
                                                            <option value="Courier New">Courier New</option>
                                                            <option value="Courier">Courier</option>
                                                            <option value="monospace">monospace</option>
                                                            <option value="Georgia">Georgia</option>
                                                            <option value="serif">serif</option>
                                                            <option value="Impact">Impact</option>
                                                            <option value="Charcoal">Charcoal</option>
                                                            <option value="Lucida Console">Lucida Console</option>
                                                            <option value="Monaco">Monaco</option>
                                                            <option value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                                            <option value="Lucida Grande">Lucida Grande</option>
                                                            <option value="Tahoma">Tahoma</option>
                                                            <option value="Geneva">Geneva</option>
                                                            <option value="Verdana">Verdana</option>
                                                        </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="menu_bg_color">Header Font Size</label>
                                            <select name="header_font_size" class="form-control" id="HTBFontSize1">
                                                            <option value="">Select</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3" selected="">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                        </select>
                                        </div>
                                       
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="title_name">Row Background </label>
                                            <input type="color" class="form-control" name="row_background" placeholder="Row Background ">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="font_color">Row Font Color</label>
                                            <input type="color" class="form-control" name="row_font_color" placeholder="Row Font Color">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="header_bg_color">Row Font </label>
                                            <select name="row_font" class="form-control" id="HTBFont1">
                                                            <option value="1">Select</option>
                                                            <option value="Arial" selected="">Arial</option>
                                                            <option value="Helvetica">Helvetica</option>
                                                            <option value="sans-serif">sans-serif</option>
                                                            <option value="Arial Black">Arial Black</option>
                                                            <option value="Times New Roman">Times New Roman</option>
                                                            <option value="Gadget,sans-serif">Gadget,sans-serif</option>
                                                            <option value="Comic Sans MS">Comic Sans MS</option>
                                                            <option value="cursive">cursive</option>
                                                            <option value="Courier New">Courier New</option>
                                                            <option value="Courier">Courier</option>
                                                            <option value="monospace">monospace</option>
                                                            <option value="Georgia">Georgia</option>
                                                            <option value="serif">serif</option>
                                                            <option value="Impact">Impact</option>
                                                            <option value="Charcoal">Charcoal</option>
                                                            <option value="Lucida Console">Lucida Console</option>
                                                            <option value="Monaco">Monaco</option>
                                                            <option value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                                            <option value="Lucida Grande">Lucida Grande</option>
                                                            <option value="Tahoma">Tahoma</option>
                                                            <option value="Geneva">Geneva</option>
                                                            <option value="Verdana">Verdana</option>
                                                        </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="title_name">Row Font Size</label>
                                            <select name="row_font_size" class="form-control" id="HTBFontSize1">
                                                            <option value="">Select</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3" selected="">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                        </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="font_color">No News Text</label>
                                            <select name="no_news_text" class="form-control" id="HTBFontSize1">
                                                            <option value="">Select</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                            </select>
                                        </div>
                                       
                                    </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="border-with-text" data-heading="Quick Links">
                            <div class="quick-links" id="quick-links-container">
                                <div class="row quick-link">
                                    <div class="col-md-12 text-right">
                                    </div>
                                    <div class="col-md-4">  
                                        <label class="px-1 font-weight-bold" for="media_type">Name </label>
                                        <input type="text" class="form-control" name="quick_links_name[]" placeholder="Enter Name ">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="px-1 font-weight-bold" for="media_type">URL </label>
                                        <input type="text" class="form-control" name="quick_link_url[]" placeholder="Enter URL ">
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
                                            <input type="color" class="form-control" name="header_bg_color" placeholder="Background Color">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="logo_url">Logo Url</label>
                                            <input type="text" class="form-control" name="logo_url" placeholder="Logo Url">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="logo_position">Logo Position</label>
                                            <select class="form-control" name="logo_position" >
                                                <option value="">Select</option>
                                                <option value="Left">Left</option>
                                                <option value="Right">Right</option>
                                                <option value="Center">Center</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="title_name">Title Name</label>
                                            <input type="text" class="form-control" name="title_name" placeholder="Title Name">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="font_color">Title Font Color</label>
                                            <input type="color" class="form-control" name="font_color" placeholder="Font Color">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="font_color">Title Font Size</label>
                                            <input type="text" class="form-control" name="font_size" placeholder="Font Color">
                                        </div>
                                       
                                    </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="border-with-text" data-heading="Content News">
                            <div class="row">
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Publication</label>
                                            <select class="js-example-basic-multiple form-control" name="content_publication[]" multiple="multiple">
                                               <option value=""></option>
                                                @foreach($get_publication as $publication)
                                                    <option value="{{$publication -> gidMediaOutlet}}">{{$publication -> MediaOutlet }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Edition</label>
                                            <select class="js-example-basic-multiple form-control" name="content_edition[]" multiple="multiple">
                                                <option value="">Select</option>
                                                @foreach($get_edition as $edition)
                                                    <option value="{{$edition -> gidEdition}}">{{$edition -> Edition }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="author">News Summary Color</label>
                                            <input type="color" class="form-control" placeholder="Enter Summary Color" name="content_news_summary_color">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">News Summary Font Size</label>
                                            <input type="text" class="form-control" placeholder="Enter Font Size" name="content_news_summary_color_size">
                                        </div>
                                       
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Headline Color </label>
                                            <input type="color" class="form-control" placeholder="Enter Headline Color" name="content_headline_color">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Headline Font </label>
                                            <select name="headline_font" class="form-control" id="MediaFont1">
                                                            <option value="1">Select</option>
                                                            <option value="Arial">Arial</option>
                                                            <option value="Helvetica">Helvetica</option>
                                                            <option value="sans-serif">sans-serif</option>
                                                            <option value="Arial Black">Arial Black</option>
                                                            <option value="Times New Roman">Times New Roman</option>
                                                            <option value="Gadget,sans-serif">Gadget,sans-serif</option>
                                                            <option value="Comic Sans MS">Comic Sans MS</option>
                                                            <option value="cursive">cursive</option>
                                                            <option value="Courier New">Courier New</option>
                                                            <option value="Courier">Courier</option>
                                                            <option value="monospace">monospace</option>
                                                            <option value="Georgia">Georgia</option>
                                                            <option value="serif">serif</option>
                                                            <option value="Impact">Impact</option>
                                                            <option value="Charcoal">Charcoal</option>
                                                            <option value="Lucida Console">Lucida Console</option>
                                                            <option value="Monaco">Monaco</option>
                                                            <option value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                                            <option value="Lucida Grande">Lucida Grande</option>
                                                            <option value="Tahoma">Tahoma</option>
                                                            <option value="Geneva">Geneva</option>
                                                            <option value="Verdana">Verdana</option>
                                                        </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Headline Font Size </label>
                                            <input type="text" class="form-control" placeholder="Enter Font Size " name="headline_font_size">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Media Details </label>
                                            <select name="media_details"  class="form-control" accesskey="n" onkeyup="validateUserType('?text=' + this.value);">
                                            <option value="0">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Media Color </label>
                                            <input type="color" class="form-control" placeholder="Enter Media Color" name="media_color">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="Time">Media Font </label>
                                            <select name="media_font" class="form-control" id="MediaFont1">
                                                            <option value="1">Select</option>
                                                            <option value="Arial">Arial</option>
                                                            <option value="Helvetica">Helvetica</option>
                                                            <option value="sans-serif">sans-serif</option>
                                                            <option value="Arial Black">Arial Black</option>
                                                            <option value="Times New Roman">Times New Roman</option>
                                                            <option value="Gadget,sans-serif">Gadget,sans-serif</option>
                                                            <option value="Comic Sans MS">Comic Sans MS</option>
                                                            <option value="cursive">cursive</option>
                                                            <option value="Courier New">Courier New</option>
                                                            <option value="Courier">Courier</option>
                                                            <option value="monospace">monospace</option>
                                                            <option value="Georgia">Georgia</option>
                                                            <option value="serif">serif</option>
                                                            <option value="Impact">Impact</option>
                                                            <option value="Charcoal">Charcoal</option>
                                                            <option value="Lucida Console">Lucida Console</option>
                                                            <option value="Monaco">Monaco</option>
                                                            <option value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                                            <option value="Lucida Grande">Lucida Grande</option>
                                                            <option value="Tahoma">Tahoma</option>
                                                            <option value="Geneva">Geneva</option>
                                                            <option value="Verdana">Verdana</option>
                                                        </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="Duration">Media Font Size</label>
                                            <input type="text" class="form-control" placeholder="Enter Font Size" name="media_font_size">
                                        </div>
                                    

                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Context  </label>
                                            <select name="context"  class="form-control" accesskey="n" onkeyup="validateUserType('?text=' + this.value);">
                                            <option value="0">Select</option>
                                            <option value="Yes" >Yes</option>
                                            <option value="No" >No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="Time">Context Font</label>
                                            <select name="context_font" class="form-control" id="MediaFont1">
                                                            <option value="1">Select</option>
                                                            <option value="Arial">Arial</option>
                                                            <option value="Helvetica">Helvetica</option>
                                                            <option value="sans-serif">sans-serif</option>
                                                            <option value="Arial Black">Arial Black</option>
                                                            <option value="Times New Roman">Times New Roman</option>
                                                            <option value="Gadget,sans-serif">Gadget,sans-serif</option>
                                                            <option value="Comic Sans MS">Comic Sans MS</option>
                                                            <option value="cursive">cursive</option>
                                                            <option value="Courier New">Courier New</option>
                                                            <option value="Courier">Courier</option>
                                                            <option value="monospace">monospace</option>
                                                            <option value="Georgia">Georgia</option>
                                                            <option value="serif">serif</option>
                                                            <option value="Impact">Impact</option>
                                                            <option value="Charcoal">Charcoal</option>
                                                            <option value="Lucida Console">Lucida Console</option>
                                                            <option value="Monaco">Monaco</option>
                                                            <option value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                                            <option value="Lucida Grande">Lucida Grande</option>
                                                            <option value="Tahoma">Tahoma</option>
                                                            <option value="Geneva">Geneva</option>
                                                            <option value="Verdana">Verdana</option>
                                                        </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="Duration">Context Font Size</label>
                                            <input type="text" class="form-control" placeholder="Context Font Size" name="context_font_size">
                                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="border-with-text" data-heading="Footer Information">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="footer_bg_color">Footer Background Color</label>
                                            <input type="color" class="form-control" name="footer_bg_color" placeholder="Background Color">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="logo_url">Logo Url</label>
                                            <input type="text" class="form-control" name="footer_logo_url" placeholder="Logo Url">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="logo_position">Logo Position</label>
                                            <select class="form-control" name="footer_logo_position" >
                                                <option value="">Select</option>
                                                <option value="Left">Left</option>
                                                <option value="Right">Right</option>
                                                <option value="Center">Center</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="title_name">Title Name</label>
                                            <input type="text" class="form-control" name="footer_title_name" placeholder="Title Name">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="font_color">Title Font Color</label>
                                            <input type="color" class="form-control" name="footer_font_color" placeholder="Font Color">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="font_color">Title Font Size</label>
                                            <input type="text" class="form-control" name="footer_font_size" placeholder="Font size">
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
@include('common/footer')