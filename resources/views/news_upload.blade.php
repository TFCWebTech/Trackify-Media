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
        <form action="{{ route('newsUpload.store') }}" method="post" enctype="multipart/form-data">
        @csrf    
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
                                                <option value="">Select</option>
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
                                            <textarea class="form-control" name="headline" rows="4" cols="50">
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
   
function checkSelection(media) 
{
    console.log('Selected media:', media); // Log the selected media value
    if (media === '015304b714940c28695d592c9ac10355d0d9a45f') {
        addMoreFields();
        console.log('this is online');
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

function changePublication(publication) 
{
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

function changeEdition(edition) 
{
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
$(document).ready(function() 
{
    let counter = 0; // Initialize the counter variable

    $('#image_upload').on('change', function() {
        console.log('File input changed');
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
                            imageToText(imageUrl, i, imageId, imageWidth, imageHeight);
                            i++;
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

    function imageToText(imageUrl, index, imageId, width, height) {
    console.log(`Image URL: ${imageUrl}, Index: ${index}, Image ID: ${imageId}, Width: ${width}, Height: ${height}`);
    
    fetch(imageUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.blob();
        })
        .then(blob => {
            const reader = new FileReader();
            reader.onloadend = function() {
                const base64data = reader.result.split(',')[1];

                $.ajax({
                    type: 'POST',
                    url: 'https://vision.googleapis.com/v1/images:annotate?key=AIzaSyBjnr10MeuuR2VECFkJvZB6jDZIkSzljCA',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "requests": [
                            {
                                "image": {
                                    "content": base64data
                                },
                                "features": [
                                    {
                                        "type": "TEXT_DETECTION"
                                    }
                                ]
                            }
                        ]
                    }),
                    success: function(response) {
                        if (response && response.responses && response.responses.length > 0) {
                            if (response.responses[0].textAnnotations && response.responses[0].textAnnotations.length > 0) {
                                var description = response.responses[0].textAnnotations[0].description;
                                console.log(description);

                                var textareaId = 'editor_' + index; // Unique ID for textarea
                                var editorId = 'editor_instance_' + index; // Unique ID for CKEditor instance
                                let data = '<div class="col-md-6"><div class="row mt-2">';
                                data += '<div class="col-md-12">';
                                data += '<input type="text" name="height' + index + '" class="form-control" value="' + height + '" hidden>';
                                data += '<input type="text" name="width' + index + '" class="form-control" value="' + width + '" hidden>';
                                data += '<input type="text" name="image_id' + index + '" class="form-control" value="' + imageId + '" hidden>';
                                data += '<textarea class="form-control" name="editor' + index + '" id="getNews' + editorId + '"></textarea>';
                                data += '</div></div>';
                                data += '<div class="col-md-12" id="keyword_container_' + index + '"></div>'; // Placeholder for keywords
                                data += '<div class="col-md-12" id="client_container_' + index + '"></div>';
                                data += '<div class="col-md-12" id="getCompData' + index + '"></div>';
                                data += '<div class="col-md-6">';
                                data += '<label>Page Number </label>';
                                data += '<input type="number" name="page_no' + index + '" class="form-control" placeholder="page no">';
                                data += '</div></div>';

                                // Increment the counter
                                counter++;
                                // Append the hidden input field with the updated counter value
                                data += '<input type="text" value="' + counter + '" name="index" id="index_value" hidden>';
                                // Append the textarea to the container
                                $('#news_arr').append(data);
                                // Initialize CKEditor for the new textarea
                                var img = CKEDITOR.replace('editor' + index);
                                img.setData(description);
                                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken
                                    }
                                });

                                // Fetch keywords for the description
                                var getKeywords = Object.values(@json($getKeywords));
                                console.log("getKeywords:", getKeywords); // Debugging log
                                $.ajax({
                                    type: 'POST',
                                    url: "{{ route('newsUpload.searchKeywords') }}",
                                    data: { description: description },
                                    success: function(response) {
                                        console.log("Response:", response);
                                        try {
                                            var keywords = response;
                                            console.log("Parsed Keywords:", keywords);

                                            if (!Array.isArray(getKeywords)) {
                                                console.error("getKeywords is not an array:", getKeywords);
                                                return;
                                            }

                                            if (keywords.length > 0) {
                                                var formattedKeywords = keywords.join(', ');
                                                console.log("Matching Keywords:", formattedKeywords);
                                                let f_keys = formattedKeywords.split(',').map(keyword => keyword.trim());
                                                let selectOptions = '';
                                                
                                                getKeywords.forEach(keyword => {
                                                    if (f_keys.includes(keyword)) {
                                                        selectOptions += `<option value="${keyword}" selected>${keyword}</option>`;
                                                    } else {
                                                        selectOptions += `<option value="${keyword}">${keyword}</option>`;
                                                    }
                                                });

                                                let keywordData = '<div class="row">';
                                                keywordData += '<div class="col-md-12">';
                                                keywordData += '<label>Keywords </label>';
                                                keywordData += '<select class="js-example-basic-multiple form-control" name="getKeys' + index + '[]" id="getKeys' + index + '" multiple="multiple">';
                                                keywordData += '<option disabled>Select</option>';
                                                keywordData += selectOptions; // Add select options here
                                                keywordData += '</select>';
                                                keywordData += '</div>';
                                                keywordData += '</div>';
                                                
                                                $('#keyword_container_' + index).html(keywordData);
                                                $('#getKeys' + index).select2();
                                                $('#getKeys' + index).on('change', function() {
                                                    let selectedKeywords = $(this).val(); // Get all selected keywords
                                                    sendKeywordData(index, selectedKeywords);
                                                });
                                                $('#getKeys' + index).trigger('change');
                                            } else {
                                                console.log("No matching keywords found.");
                                            }
                                        } catch (error) {
                                            console.error("Error parsing response:", error);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            } else {
                                console.error('No text annotations found in the response.');
                            }
                        } else {
                            console.error('Invalid response format or no responses received.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            };
            reader.readAsDataURL(blob);
        })
        .catch(error => {
            console.error('Error fetching and converting image:', error);
        });
}
});

var index = 0;
function addMoreFields() {
    index++;
    var show_url = document.getElementById('show_url');
    show_url.style.display = 'block';
    var textareaId = 'editor_' + index; 
    // Create a new textarea element
    let data = '<div class="col-md-6"><div class="row mt-2">';
    data += '<div class="col-md-12">';
    data += '<input type="text" id="company' + index + '" name="company' + index + '" hidden>'
    data += '<input type="text" id="competitor' + index + '" name="competitor' + index + '" hidden>'
    data += '<input type="text" id="industry' + index + '" name="industry' + index + '"hidden>'
    data += '<input type="text" value=" '+ index+' " name="index" hidden>'
    data += '<textarea class="form-control" name="editor' + index + '" id="' + textareaId + '"></textarea>';
    data += '</div></div>';
    data += '<div class="col-md-12" id="keyword_container_' + index + '"></div>'; // Placeholder for keywords
    data += '<div class="col-md-12" id="client_container_' + index + '"></div>';
    data += '<div class="col-md-12" id="getCompData' + index + '"></div>';
    
    data += '<div class="col-md-6">';
    data += '<label>Page Number </label>';
    data += '<input type="number" name="page_no' + index + '" class="form-control" placeholder="page no">';
    data += '</div></div>';

    // Append the textarea to the container
    $('#news_arr').append(data);
    CKEDITOR.replace(textareaId);
    // Listen for changes in CKEditor
    CKEDITOR.instances[textareaId].on('change', function() {
        getKeywords(textareaId);
    });
}
function getKeywords(textareaId) {
    console.log(textareaId);
    var editor = CKEDITOR.instances[textareaId]; // Get CKEditor instance
    var description = editor.getData(); // Get content from CKEditor instance
    console.log("Description:", description);

    // Retrieve keywords from Blade template and ensure it's an array
    var getKeywords = Object.values(@json($getKeywords)); // Convert object to array
    console.log("getKeywords:", getKeywords); // Debugging log

    $.ajax({
        type: 'POST',
        url: "{{ route('newsUpload.searchKeywords') }}",
        data: {
            description: description,
            _token: "{{ csrf_token() }}" // Include CSRF token for security
        },
        success: function(response) {
            console.log("Response:", response); // Log the response object to the console
            try {
                var keywords = response; // Assuming response is already an array
                console.log("Parsed Keywords:", keywords);

                if (!Array.isArray(getKeywords)) {
                    console.error("getKeywords is not an array:", getKeywords);
                    return;
                }

                if (keywords.length > 0) {
                    var f_keys = keywords.map(keyword => keyword.trim());
                    console.log("Formatted Keywords:", f_keys);

                    let selectOptions = '';

                    // Iterate over the getKeywords array
                    getKeywords.forEach(keyword => {
                        let trimmedKeyword = keyword.trim(); // Ensure there are no extra spaces
                        if (f_keys.includes(trimmedKeyword)) {
                            selectOptions += `<option value="${trimmedKeyword}" selected>${trimmedKeyword}</option>`;
                        } else {
                            selectOptions += `<option value="${trimmedKeyword}">${trimmedKeyword}</option>`;
                        }
                    });

                    // Construct the HTML for select element
                    let keywordData = '<div class="row">';
                    keywordData += '<div class="col-md-12">';
                    keywordData += '<label>Keywords </label>';
                    keywordData += '<select class="js-example-basic-multiple form-control" name="getKeys' + index + '[]" id="getKeys' + index + '" multiple="multiple">';
                    keywordData += '<option disabled>Select</option>';
                    keywordData += selectOptions; // Add select options here
                    keywordData += '</select>';
                    keywordData += '</div>';
                    keywordData += '</div>';

                    // Log HTML to check if it is correctly formed
                    console.log("Generated HTML:", keywordData);

                    // Append the keyword data to the placeholder container
                    $('#keyword_container_' + index).html(keywordData);

                    // Verify if the container is correctly updated
                    console.log("Container HTML:", $('#keyword_container_' + index).html());

                    // Reinitialize Select2 on the newly added select element
                    $('#getKeys' + index).select2();
                    $('#getKeys' + index).on('change', function() {
                        let selectedKeywords = $(this).val(); // Get all selected keywords
                        sendKeywordData(index, selectedKeywords);
                    });

                    // Trigger change event programmatically to call sendKeywordData immediately
                    $('#getKeys' + index).trigger('change');
                } else {
                    console.log("No matching keywords found.");
                }
            } catch (error) {
                console.error("Error parsing response:", error);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
}


function sendKeywordData(index, selectedKeywords) {
    console.log('Selected Keywords:', selectedKeywords);

    // Create a comma-separated string of selected keywords
    var keywordData = selectedKeywords.join(',');
    console.log('Keyword Data:', keywordData);
    const clients = @json($get_clients);
    // AJAX request
    $.ajax({
        type: 'POST',
        url: "{{ route('newsUpload.getClientsFromKeywords') }}", // Use Laravel route helper
        data: {
            keywordData: keywordData,
            _token: '{{ csrf_token() }}' // Include CSRF token for security
        },
        success: function(response) {
        console.log('Data sent successfully:', response);

        // Convert the response into an array of client IDs
        let clientIDs = response;

        let selectOptions = '';

        // Iterate through the list of all clients using the JavaScript object
        clients.forEach(client => {
            let clientId = client.client_id;
            let clientName = client.client_name;

            // Check if the clientId is in the clientIDs array
            if (clientIDs.includes(clientId)) {
                selectOptions += `<option value="${clientId}" selected>${clientName}</option>`;
            } else {
                selectOptions += `<option value="${clientId}">${clientName}</option>`;
            }
        });

        // Construct the HTML for the select element
        let selectHTML = '<div class="row">';
        selectHTML += '<div class="col-md-12">';
        selectHTML += '<label> Clients </label>';
        selectHTML += '<select class="js-example-basic-multiple form-control" name="getclient' + index + '[]" id="getclient' + index + '" multiple="multiple">';
        selectHTML += '<option disabled>Select</option>';
        selectHTML += selectOptions; // Add select options here
        selectHTML += '</select>';
        selectHTML += '</div>';
        selectHTML += '</div>';

        // Append the select element to the placeholder container
        $('#client_container_' + index).html(selectHTML);

        // Reinitialize Select2 on the newly added select element
        $('#getclient' + index).select2();
        $('#getclient' + index).on('change', function() {
            let selectedClients = $(this).val(); // Get all selected clients
            sendClientData(index, selectedClients);
        });

        // Trigger change event programmatically to call sendClientData immediately
        $('#getclient' + index).trigger('change');
    },
        error: function(xhr, status, error) {
            console.error('Error sending data:', status, error);
        }
    });
}

function sendClientData(index, selectedClients) {
    console.log('client name ', selectedClients);
    
    var clientsData = selectedClients.join(',');
    console.log('client new data= ', clientsData);

    $.ajax({
        type: 'POST',
        url: "{{ route('newsUpload.getCompitetorsFromClients') }}", // Laravel route
        data: {
            clientsData: clientsData,
            _token: '{{ csrf_token() }}' // Include CSRF token for security
        },
        success: function(response) {
            // Assuming the response is JSON
            let data = response;
            console.log('Data competitor successfully:', data);
            
            // Initialize the HTML string
            let getComp = '<div class="row">';
            let displayedClients = new Set(); // Set to keep track of displayed client names
            $('#company' + index).val('');
            $('#competitor' + index).val('');
            $('#industry' + index).val('');

            data.forEach(function(item, i) { // Using a different variable for the inner index
                if (!displayedClients.has(item.client_name)) {
                    displayedClients.add(item.client_name); // Add client name to the set

                    getComp += '<div class="col-md-12">';
                    getComp += '<label> Client </label> <br>';
                    getComp += '<input name="get_company_data_id' + i + '" id="get_company_id' + i + '" value="' + item.client_id + '" disabled hidden> ';
                    getComp += '<input name="get_company_data' + i + '" id="get_company' + i + '" value="' + item.client_name + '" disabled>';
                    getComp += '</div>';
                }

                getComp += '<div class="col-md-6">';
                getComp += '<label> Competitors </label>';
                getComp += '<input name="getcompetitor_data_id' + i + '" id="getcompetitor_id' + i + '" value="' + item.competitor_id + '" disabled hidden> ';
                getComp += '<input name="getcompetitor_data' + i + '" id="getcompetitor' + i + '" value="' + item.competitor_name + '" disabled>';
                getComp += '</div>';
                getComp += '<div class="col-md-6">';
                getComp += '<label> Industry </label>';
                getComp += '<input name="getIndustry_data_id' + i + '" id="getIndustry_id' + i + '" value="' + item.industry_id + '" disabled hidden> ';
                getComp += '<input name="getIndustry_data' + i + '" id="getIndustry' + i + '" value="' + item.industry_name + '" disabled>';
                getComp += '</div>';

                // Update input fields
                var inputField = $('#competitor' + index);
                var currentValue = inputField.val();
                var newValue = item.competitor_id;

                inputField.val(currentValue ? currentValue + ', ' + newValue : newValue);

                var inputIndField = $('#industry' + index);
                var currentIndValue = inputIndField.val();
                var newIndValue = item.industry_id;

                inputIndField.val(currentIndValue ? currentIndValue + ', ' + newIndValue : newIndValue);

                var inputCompField = $('#company' + index);
                var currentComValue = inputCompField.val();
                var newComValue = item.client_id;

                inputCompField.val(currentComValue ? currentComValue + ', ' + newComValue : newComValue);
            });

            getComp += '</div>';

            // Append the generated HTML to the placeholder container
            $('#getCompData' + index).html(getComp);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error: ' + textStatus + ', ' + errorThrown);
        }
    });
}
</script>
@include('common/footer')   
   