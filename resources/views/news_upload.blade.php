@include('common/header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
.files input {
    outline: 2px dashed #92b0b3;
    outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear;
    padding: 18px 0px 60px 5%;
    text-align: center !important;
    margin: 0;
    width: 100% !important;
}
.files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
 }
.files{ position:relative}
.files:after {  pointer-events: none;
    position: absolute;
    top: 60px;
    left: 0;
    width: 50px;
    right: 0;
    content: "";
    /* background-image: url('https://image.flaticon.com/icons/png/128/109/109612.png'); */
    display: block;
    margin: 0 auto;
    background-size: 100%;
    background-repeat: no-repeat;
}
.color input{ background-color:#f1f1f1;}
.files:before {
    position: absolute;
    bottom: 10px;
    pointer-events: none;
    width: 100%;
    content: " or drag it here. ";
    display: block;
    margin: 0 20px;
    color: #2ea591;
    font-weight: 600;
    text-transform: capitalize;
}

.cke_notifications_area{
    display:none !important;
}
</style>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<div class="container" >
    <div class="card p-3">
        <!-- <form id="articleForm"  method="post">  -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h5 class="font-weight-bold text-uppercase text-color">Upload News</h5>
                        </div>  
                        <hr>
                    </div>
                    <div class="col-md-12 py-2 mt-3">
                        <div class="border-with-text" data-heading="Media Information">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="media_type">Media Type </label>
                                            <select class="form-control" name="media_type" id="media_type" onchange="checkSelection(this.value)">
                                            <option value="">Select</option>
                                                @foreach($media_type as $media)
                                                    <option value="{{ $media->gidMediaType }}">{{ $media->MediaType }}</option>
                                                @endforeach
                                            </select>
                                        </div>  
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="publication">Publication</label>
                                            <select class="form-control" name="publication" id="publication" onchange="changePublication(this.value)">
                                            <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="edition">Edition</label>
                                            <select class="form-control" name="edition" id="edition" onchange="changeEdition(this.value)">
                                            <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="SupplementId">Supplement</label>
                                            <select  class="form-control" name="SupplementId" id="SupplementId" accesskey="s">
                                           
                                            <option value="">Select</option>
                                            </select>
                                        </div>  
                                        <!-- <div class="col-md-2">
                                            <label class="px-1 font-weight-bold" for="publication_date">Publication Date</label>
                                            <input type="date" class="form-control" name="publication_date" id="publication_date">
                                        </div> -->
                        </div>
                    </div>
                    </div>
                    <div class="col-md-12 mt-3" >
                        <div class="border-with-text" data-heading="Journalist Information">
                                    <div class="row">
                                    <div class="col-md-3">
                                        <label class="px-1 font-weight-bold" name="journalist_name" for="journalist_name">Journalist / News Agencies</label>
                                        <select class="form-control" name="journalist_name" id="journalist_name">
                                            <option >Select</option>
                                            <optgroup label="News Agencies">
                                                @foreach ($get_agency as $values)
                                                <option value="{{$values -> gidAgency}}">{{$values -> Agency}}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Journalist Names">
                                                <!-- Journalist options will be appended here -->
                                            </optgroup>
                                        </select>
                                                </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="Author">Author </label>
                                            <input type="text" class="form-control" placeholder="Enter Author" name="author" id="author" >
                                        </div>
                                        <div class="col-md-3">
                                            <label class="px-1 font-weight-bold" for="news_position"> News Position</label>
                                            <select class="form-control" name="NewsPosition" id="NewsPosition" >
                                                <option value="0">Select</option>
                                                <option value="Bottom">Bottom<option>
                                                <option value="Bottom Center">Bottom Center</option>
                                                <option value="Bottom Left">Bottom Left</option>
                                                <option value="Bottom Right">Bottom Right</option>
                                                <option value="Fullpage">Fullpage</option>
                                                <option value="Half Page">Half Page</option>
                                                <option value="Internet">Internet</option>
                                                <option value="Middle">Middle</option>
                                                <option value="Middle Center">Middle Center</option>
                                                <option value="Middle Left">Middle Left</option>
                                                <option value="Middle Right">Middle Right</option>
                                                <option value="Not Known">Not Known</option>
                                                <option value="Quarter Page">Quarter Page</option>
                                                <option value="Top">Top</option>
                                                <option value="Top Center">Top Center</option>
                                                <option value="Top Left">Top Left</option>
                                                <option value="Top Right">Top Right</option>
                                                <option value="TV">TV</option>
                                                </select>
                                            </select>
                                        </div>
                                        <div class="col-md-3"> 
                                            <label class="px-1 font-weight-bold" for="NewsCity"> News City</label>
                                            <select  class="form-control"  name="NewsCity" id="NewsCity">
                                            <option disbled>Select</option>
                                            @foreach ($news_city as $city)
                                            <option value="{{ $city -> gidNewscity}}">{{ $city -> CityName}}</option>
                                            @endforeach   
                                            </select>
                                        </div>                                        
                                        <div class="col-md-6">
                                            <label class="px-1 font-weight-bold" for="HeadLine">HeadLine</label>
                                            <textarea  class="form-control" name="headline" rows="4" cols="50">
                                            </textarea>
                                        </div>  
                                        <div class="col-md-6">
                                            <label class="px-1 font-weight-bold" for="Summary">Summary</label>
                                            <textarea  class="form-control" name="Summary" rows="4" cols="50">
                                            </textarea>
                                        </div>
                                        <div class="col-md-12" id="show_url" style="display: none;">
                                            <label class="px-1 font-weight-bold" for="Summary">Website URL</label>
                                            <input type="text" class="form-control" placeholder="Enter Website URL" name="website_url" id="website_url">
                                        </div>
                                    </div>
                        </div>
                    </div>
                   
                    <div class="col-md-12 mt-3">
                        <div class="border-with-text" data-heading="Article Editing">
                        <div class="row">
                                
                                <div class="col-md-6 my-2">
                               
                                    <div class="form-group files">
                                        <label>Upload Your Image </label>
                                        <input type="file" class="form-control" multiple="" name="image_upload[]" id="image_upload">
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="form-group files">
                                        <label for="video_upload">Upload Your Video</label>
                                        <input type="file" class="form-control" name="video_upload" id="video_upload" accept="video/*">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="news_arr">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-right px-4 py-2">
                        <!-- <button  class="btn btn-success">Additional Page</button> -->
                        <button type="submit" class="btn btn-primary">Upload News</button>
                    </div>
            </div>  
        </form>
    </div>
</div>          
<!-- this div is for footer --->
</div>
<script>
   
function checkSelection(media) {
    console.log('Selected media:', media); // Log the selected media value
    if (media === '015304b714940c28695d592c9ac10355d0d9a45f') {
        // addMoreFields();
        console.log('this is online')
    } else {
        show_url.style.display = 'none'; // Hide the element if the value is not matched
        console.log('The selected value is not Online'); 
    }
  return new Promise((resolve, reject) => {
    $.ajax({
      url: '{{ route('getPublication') }}',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        media: media
      },
      success: function(response) {
        $('#publication').html(response.options);
        resolve();
      },
      error: function(xhr, status, error) {
        console.error('AJAX error:', error);
        reject(error);
      }
    });
  });
}
function changePublication(publication) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: '{{ route('getEditionAndJournalist') }}',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        publication: publication
      },
      success: function(response) {
        $('#edition').html(response.edition_options);
        $('#journalist_name').find('optgroup[label="Journalist Names"]').html(response.journalist_options);
        resolve();
      },
      error: function(xhr, status, error) {
        console.error('AJAX error:', error);
        reject(error);
      }
    });
  });
}
function changeEdition(edition) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: '{{ route('getSupplement') }}',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        edition: edition
      },
      success: function(response) {
        $('#SupplementId').html(response.options);
        resolve();
      },
      error: function(xhr, status, error) {
        console.error('AJAX error:', error);
        reject(error);
      }
    });
  });
}


</script>
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<!-- <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script> -->


 <script type="text/javascript">
   CKEDITOR.replace( 'editor1' );
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

$(document).ready(function() {
    let counter = 0; // Initialize the counter variable

    $('#image_upload').on('change', function() {
        console.log('asf');
        const files = this.files; 
        const formData = new FormData();

        // Function to read images and calculate dimensions
        function readImages(files, callback) {
            let images = [];
            let loadedImages = 0;

            Array.from(files).forEach(file => {
                const img = new Image();
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                };
                img.onload = function() {
                    console.log(`File: ${file.name}, Width: ${img.width}px, Height: ${img.height}px`);
                    images.push({
                        file: file,
                        width: img.width,
                        height: img.height
                    });
                    loadedImages++;
                    if (loadedImages === files.length) {
                        callback(images);
                    }
                };
                
                reader.readAsDataURL(file);
            });
        }

        readImages(files, function(images) {
            images.forEach(image => {
                formData.append('image_upload[]', image.file); // Append each file to FormData object
            });

            // Get CSRF token from meta tag
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            formData.append('_token', csrfToken); // Append CSRF token to FormData

            // Send AJAX request to store the images
            $.ajax({
                type: 'POST',
                url: "{{ route('newsUpload.saveArticalImage') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        var imageData = response.image_data;
                        console.log("Image Data:", imageData);
                        var i = 1;
                        imageData.forEach(function(image, index) {
                            var imageUrl = image.image_url;
                            var imageId = image.article_images_id;
                            console.log("Image URL:", imageUrl);
                            console.log("Image ID:", imageId);
                            
                            // Get dimensions from images array
                            var imageWidth = images[index].width;
                            var imageHeight = images[index].height;
                            
                            console.log(`Calling imageToText with URL: ${imageUrl}, Index: ${i}, ID: ${imageId}, Width: ${imageWidth}, Height: ${imageHeight}`);
                            
                            // Call imageToText function with dimensions
                            // imageToText(imageUrl, i, imageId, imageWidth, imageHeight);
                            // i++;
                        });
                    } else {
                        console.error("Error:", response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        });
    });
});


</script>
@include('common/footer')   
   