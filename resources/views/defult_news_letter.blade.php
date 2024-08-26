@include('common/header')
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
<style>
   
.table-wrapper {
    overflow-x: auto;
}

table {
    border-collapse: collapse;
    width: 100%;
}

td {
    padding: 5px;
    width: 33%;
}

th {
    text-align: center;
    padding: 5px;
}

.table-wrapper > table,
.table-wrapper > table td,
.table-wrapper > table th {
    border: 2px solid #ffffff;
}
.header_contert {
            display: flex;
            justify-content: space-between;
        }

        @media (max-width: 725px) {
            .header_contert {
                display: block;
                text-align: center;
            }
        }
        p{
            margin-top:0px !important;
            margin-bottom:0px !important;
        }
        h5 , h6{
            margin-top: 0px !important;
            margin-bottom: 0px !important;
        }
        #generatePDF , .send-button, #edit, #getEmailButton{
            background-color: #0080FF ;
            color: #ffffff;
            border-color: #0080FF ;
            border-radius: 5px;
        }
        .fa-send-o {
            font-size:16px;
            /* color:#ffffff; */
        }
        .showEdit {
            display: none;
        }
</style>
<div class="container">
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

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('error') }}
    </div>
@endif
    <div class="row" id="hideThis">
    <div class="col-md-12 text-right mb-2">
            <!-- <button id="generatePDF"> <i class="fa fa-download"></i></button> &nbsp; -->
            <button id="edit" onclick="editFuncation()"> <i class="fa fa-edit"></i></button> &nbsp;
            <button id="getEmailButton" onclick="getEmail('{{ $get_client_data['client_id'] }}')"> 
    <i class="fa fa-send"></i>
  </button>
        </div>
    </div>
    <div class="card" id="content" style="background-color: #F9F9F9;">
        <div class="header" style="background-color: ; padding:5px 10px;">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left">   
                        <img src="https://pressbro.com/News/assets/img/mediaLogo.png" alt="logo" style="width:100px;"> <br>
                        <a href="#" style="font-size:12px; color:#000000;">powered by trackify media</a>
                    </td>
                    <td align="center">
                        <h5>
                            <a style="font-size:; color:;">{{ $get_client_data['client_name'] }}</a><br>
                            <span style="display:block; font-size: 12px;">{{ \Carbon\Carbon::now()->format('l, M d, Y') }}</span>
                        </h5>
                    </td>
                    <td align="right"> 
                    </td>
                </tr>
            </table>
        </div>    
        <hr>
        <div class="col-md-12 mt-3 table-wrapper">
            <table>
                <tr style="background-color: #6D6B6B; color: #ffffff;">
                    <th>Quick Links</th>
                    <th>Access Other Services</th>
                </tr>
                <tr style="background-color: #DCD5D5; color: #ffffff;">
                    <td></td>
                    <td><a href="">Login</a></td>
                </tr>
                <tr style="background-color: #DCD5D5; color: #ffffff;"></tr>
                <tr style="background-color: #DCD5D5; color: #ffffff;">
                    <td></td>
                    <td><a href="">Customerservice@trackifyMedia.info</a></td>
                </tr>
            </table>
        </div>
        <div class="body-content" style="padding:10px 15px 0px 15px;">
            <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;">{{ $get_client_data['client_name'] }}</h4>
            @foreach ($get_news_details as $news)
                <div id="clientnewsContent-{{ $news['news_details_id'] }}" style="display: block;">
                    <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                        <h5>
                            <a href="{{ url('news-article/'.$news['news_details_id']) }}" style="color: ;font-size: ;font-family:">{{ $news['head_line'] }}</a>
                        </h5>
                        <h6 class="showEdit">
                            <div style="d-flex">
                                <a onclick="toggleNewsContent('{{ $news['news_details_id'] }}')"> Edit News</a>|
                                <a onclick="hideNews('{{ $news['news_details_id'] }}', '{{ $get_client_data['client_id'] }}')"> Hide</a> | 
                                <a style="color:red;" onclick="deleteNews('{{ $news['news_details_id'] }}', '{{ $get_client_data['client_id'] }}')">Delete</a> 
                            </div>
                        </h6>
                    </div>
                    <h6>Summary:</h6>
                    <p style="color: ;font-size: ;">
                        {{ $news['summary'] }}
                    </p>
                    <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }},
                        Publication :<span style="color:blue;"> {{ $news['MediaOutlet'] }}</span>, Journalist / Agency :<span style="color:blue;"> {{ $news['Journalist'] ?: $news['Agency'] }}</span>, 
                        Edition : <span style="color:blue;"> {{ $news['Edition'] }} </span>,  Supplement : <span style="color:blue;"> {{ $news['Supplement'] }} </span>, No of pages:<span style="color:blue;"> {{ $news['page_count'] }}</span>, Circulation Figure:<span> </span>, qAVE(Rs.) :<span> </span> 
                    </p>
                    <hr>
                </div>

                <div id="clientnewsContentEdit-{{ $news['news_details_id'] }}" style="display: none;">
                    <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                        <div class="headline" style="width: 500px;">
                            <h6>Headline:</h6>
                            <textarea name="" id="update_headline_{{ $news['news_details_id'] }}" class="form-control">{{ $news['head_line'] }}</textarea>
                        </div>
                        
                        <h6 class="showEdit2">
                            <div style="d-flex">
                                <a class="btn border" onclick="updateNewsContent('{{ $news['news_details_id'] }}', '{{ $get_client_data['client_id'] }}')"> Update News</a> 
                            </div>
                        </h6>
                    </div>
                
                    <h6>Summary:</h6>
                    <textarea name="" id="update_summary_{{ $news['news_details_id'] }}" class="form-control">{{ $news['summary'] }}</textarea>
                    <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }},
                        Publication :<span style="color:blue;"> {{ $news['MediaOutlet'] }}</span>, Journalist / Agency :<span style="color:blue;"> {{ $news['Journalist'] ?: $news['Agency'] }}</span>, 
                        Edition : <span style="color:blue;"> {{ $news['Edition'] }} </span>,  Supplement : <span style="color:blue;"> {{ $news['Supplement'] }} </span>, No of pages:<span style="color:blue;"> {{ $news['page_count'] }}</span>, Circulation Figure:<span> </span>, qAVE(Rs.) :<span> </span> 
                    </p>
                    <hr>
                </div>
            @endforeach
    </div>
            <!-- Competitors -->
            <div class="body-content" style="padding:10px 15px 0px 15px;">
                <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;"> Competition</h4>
            </div>

            @foreach ($get_comp_data as $compititor)
                <div class="body-content" style="padding:10px 15px 0px 15px;">
                    <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;"> {{ $compititor['Competitor_name'] }}</h4>
                    @foreach ($compititor['news'] as $news)
                        <div id="competitornewsContent-{{ $news['news_details_id'] }}-{{ $compititor['competitor_id'] }}" style="display: block;">
                            <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                                <h5>
                                    <a href="{{ url('news-article/'.$news['news_details_id']) }}" style="color: ;font-size: ;font-family: ;">  
                                        {{ $news['head_line'] }} 
                                    </a>
                                </h5>
                                <h6 class="showEdit">
                                    <div style="d-flex">
                                        <a onclick="toggleNewsContent2('{{ $news['news_details_id'] }}', '{{ $compititor['competitor_id'] }}')"> Edit News</a> |
                                        <a onclick="hideNews('{{ $news['news_details_id'] }}', '{{ $get_client_data['client_id'] }}')"> Hide</a> | 
                                        <a style="color:red;" onclick="deleteNews('{{ $news['news_details_id'] }}', '{{ $get_client_data['client_id'] }}')">Delete</a> 
                                    </div>
                                </h6>
                            </div> 
                            <h6>Summary:</h6>
                            <p style="color: ;font-size:;">
                                {{ $news['summary'] }}
                            </p>
                            <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }},
                                Publication :<span style="color:blue;"> {{ $news['MediaOutlet'] }}</span>, Journalist / Agency :<span style="color:blue;"> {{ $news['Journalist'] ?: $news['Agency'] }}</span>, 
                                Edition : <span style="color:blue;"> {{ $news['Edition'] }} </span>,  Supplement : <span style="color:blue;"> {{ $news['Supplement'] }} </span>, No of pages:<span style="color:blue;"> {{ $news['page_count'] }}</span>, Circulation Figure:<span> </span>, qAVE(Rs.) :<span> </span> 
                            </p>
                            <hr>
                        </div>

                        <div id="competitornewsContentEdit-{{ $news['news_details_id'] }}-{{ $compititor['competitor_id'] }}" style="display: none;">
                            <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                                <div class="headline" style="width: 500px;">
                                    <h6>Headline:</h6>
                                    <textarea name="" id="update_headline_{{ $news['news_details_id'] }}_{{ $compititor['competitor_id'] }}" class="form-control">{{ $news['head_line'] }}</textarea>
                                </div>
                                
                                <h6 class="showEdit2">
                                    <div style="d-flex">
                                        <a class="btn border" onclick="updateNewsContent2('{{ $news['news_details_id'] }}', '{{ $compititor['competitor_id'] }}', '{{ $get_client_data['client_id'] }}')"> Update News</a> 
                                    </div>
                                </h6>
                            </div>
                        
                            <h6>Summary:</h6>
                            <textarea name="" id="update_summary_{{ $news['news_details_id'] }}_{{ $compititor['competitor_id'] }}" class="form-control">{{ $news['summary'] }}</textarea>
                            <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }},
                                Publication :<span style="color:blue;"> {{ $news['MediaOutlet'] }}</span>, Journalist / Agency :<span style="color:blue;"> {{ $news['Journalist'] ?: $news['Agency'] }}</span>, 
                                Edition : <span style="color:blue;"> {{ $news['Edition'] }} </span>,  Supplement : <span style="color:blue;"> {{ $news['Supplement'] }} </span>, No of pages:<span style="color:blue;"> {{ $news['page_count'] }}</span>, Circulation Figure:<span> </span>, qAVE(Rs.) :<span> </span> 
                            </p>
                            <hr>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <!-- This is for Industry -->
<div class="body-content" style="padding:10px 15px 0px 15px;">
    <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;">Industry</h4>
</div>

@foreach ($get_industry_data as $industry)
    <div class="body-content" style="padding:10px 15px 0px 15px;">
        <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;">{{ $industry['Industry_name'] }}</h4>
        @foreach ($industry['news'] as $news)
            <div id="IndustrynewsContent-{{ $news['news_details_id'] }}-{{ $industry['Industry_id'] }}" style="display: block;">
                <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                    <h5>
                        <a href="{{ url('news-article/'.$news['news_details_id']) }}" style="color:;">  
                            {{ $news['head_line'] }} 
                        </a>
                    </h5>
                    <h6 class="showEdit">
                        <div style="d-flex">
                            <a href="javascript:void(0);" onclick="toggleNewsContent3('{{ $news['news_details_id'] }}', '{{ $industry['Industry_id'] }}')"> Edit News</a> |
                            <a href="javascript:void(0);" onclick="hideNews('{{ $news['news_details_id'] }}', '{{ $get_client_data['client_id'] }}')"> Hide</a> | 
                            <a href="javascript:void(0);" style="color:red;" onclick="deleteNews('{{ $news['news_details_id'] }}', '{{ $get_client_data['client_id'] }}')">Delete</a> 
                        </div>
                    </h6>
                </div> 
                <h6>Summary:</h6>
                <p style="color: ;">
                    {{ $news['summary'] }}
                </p>
                <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }}, 
                    Publication: <span style="color:blue;">{{ $news['MediaOutlet'] }}</span>, 
                    Journalist / Agency: <span style="color:blue;">{{ $news['Journalist'] }}</span>, 
                    Edition: <span style="color:blue;">{{ $news['Edition'] }}</span>,  
                    Supplement: <span style="color:blue;">{{ $news['Supplement'] }}</span>, 
                    No of pages: <span style="color:blue;">{{ $news['page_count'] }}</span>, 
                    Circulation Figure: <span></span>, 
                    qAVE(Rs.): <span></span> 
                </p>               
                <hr>
            </div>  
            
            <div id="IndustrynewsContentEdit-{{ $news['news_details_id'] }}-{{ $industry['Industry_id'] }}" style="display: none;">
                <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                    <div class="headline" style="width: 500px;">
                        <h6>Headline:</h6>
                        <textarea id="industry_update_headline_{{ $news['news_details_id'] }}" class="form-control">{{ $news['head_line'] }}</textarea>
                    </div>
                    
                    <h6 class="showEdit2">
                        <div style="d-flex">
                            <a class="btn border" href="javascript:void(0);" onclick="updateNewsContent3('{{ $news['news_details_id'] }}', '{{ $get_client_data['client_id'] }}')"> Update News</a> 
                        </div>
                    </h6>
                </div>
            
                <h6>Summary:</h6>
                <textarea id="industry_update_summary_{{ $news['news_details_id'] }}" class="form-control">{{ $news['summary'] }}</textarea>
                <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }},
                    Publication: <span style="color:blue;">{{ $news['MediaOutlet'] }}</span>, 
                    Journalist / Agency: <span style="color:blue;">{{ $news['Journalist'] }}</span>, 
                    Edition: <span style="color:blue;">{{ $news['Edition'] }}</span>,  
                    Supplement: <span style="color:blue;">{{ $news['Supplement'] }}</span>, 
                    No of pages: <span style="color:blue;">{{ $news['page_count'] }}</span>, 
                    Circulation Figure: <span></span>, 
                    qAVE(Rs.): <span></span> 
                </p>
                <hr>
            </div>
        @endforeach
    </div>
@endforeach
<hr>
<div class="col-md-12 news-footer">
    <div class="d-flex justify-content-between">
        <div class="logo" style="text-align:left;">
            <img src="https://pressbro.com/News/assets/img/mediaLogo.png" alt="logo" style="width:100px; padding:5px;"> 
        </div>
        <div class="footer" style="text-align:center;">
            <!-- <p style="font-size:; color:;">{{ $get_client_data['client_name'] }}</p> -->
        </div>
        <div class="footer" style="text-align:end;">
        </div>
    </div>
    <p><span style="color:red; font-weight:bold;">This is an auto generated email – please do not reply to this email id</span></p>
</div>
        </div>
    </div>
</div>
<div class="modal fade" id="getEmailsModal" tabindex="-1" role="dialog" aria-labelledby="getEmailsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="getEmailsLabel">Emails</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="sendEmailForm" action="{{ route('sendEmail') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <!-- Dynamically filled checkboxes will be added here -->
                    </div>
                    <div class="text-right pt-2">
                        <button type="button" id="sendEmailButton" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>  

function deleteNews(news_details_id, client_id) {
    console.log("news id :", news_details_id);
    console.log("client_id :", client_id);
    
    $.ajax({
        type: "POST",
        url: "{{ route('deleteNews') }}",
        dataType: 'json',
        data: {
            news_details_id: news_details_id,
            client_id: client_id,
            type: 'delete',
            _token: '{{ csrf_token() }}' // Include CSRF token
        },
        success: function(response) {
            if (response.status === 'success') {
                // alert(response.message);
                location.reload(); // Uncomment if you want to reload the page
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
}

    function hideNews(news_details_id, client_id)
    {

        console.log("news id :", news_details_id);
        console.log("client_id :", client_id);
    
        $.ajax({
            type: "POST",
            url: "{{ route('deleteNews') }}",
            dataType: 'json',
            data: {
                news_details_id: news_details_id,
                client_id: client_id,
                type: 'hide',
                _token: '{{ csrf_token() }}' // Include CSRF token
            },
            success: function(response) {
                if (response.status === 'success') {
                    // alert(response.message);
                    location.reload(); // Uncomment if you want to reload the page
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

</script>
<script>


 function editFuncation()
    {
        $('.showEdit').toggle();
    }
   
    function toggleNewsContent(newsDetailsId) 
    {
        console.log(newsDetailsId);
        var content = document.getElementById('clientnewsContent-' + newsDetailsId);
        var contentEdit = document.getElementById('clientnewsContentEdit-' + newsDetailsId);
        
        if (content.style.display === "none") {
            content.style.display = "block";
            contentEdit.style.display = "none";
        } else {
            content.style.display = "none";
            contentEdit.style.display = "block";
        }
    }
    function toggleNewsContent2(newsDetailsId, competitorId) 
    {
        var content = document.getElementById('competitornewsContent-' + newsDetailsId + '-' + competitorId);
        var contentEdit = document.getElementById('competitornewsContentEdit-' + newsDetailsId + '-' + competitorId);
        
        if (content.style.display === "none") {
            content.style.display = "block";
            contentEdit.style.display = "none";
        } else {
            content.style.display = "none";
            contentEdit.style.display = "block";
        }
    }

    function updateNewsContent(news_details_id, client_id) 
    {
    var headline = document.getElementById('update_headline_' + news_details_id).value;
    var summary = document.getElementById('update_summary_' + news_details_id).value;

    // Debugging: Output the retrieved values to console
    console.log("news_details_id :", news_details_id);
    console.log("Headline:", headline);
    console.log("Summary:", summary);

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $.ajax({
        type: "POST",
        url: "{{ route('updateNews') }}", // Ensure this route is defined in Laravel
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        dataType: 'json',
        data: {
            news_details_id: news_details_id,
            client_id: client_id,
            headline: headline,
            summary: summary
        },
        success: function(response) {
            // Handle success response
            console.log("Update successful", response);
            location.reload(); // Reload the page to see the changes
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error("Update failed", status, error);
        }
    });
}

function updateNewsContent2(news_details_id) 
{
    console.log("Function called");
    var headline = document.getElementById('com_update_headline_' + news_details_id).value;
    var summary = document.getElementById('com_update_summary_' + news_details_id).value;
    // Debugging: Output the retrieved values to console
    console.log("Headline:", headline);
    console.log("Summary:", summary);
    console.log("News Details ID:", news_details_id);
    
}
function getEmail(client_id) 
{
      console.log("client_id:", client_id);
      $.ajax({
        type: "POST",
        url: "{{ route('getEmail') }}",
        dataType: 'json',
        data: {
          client_id: client_id,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          console.log("Response:", response);
          // Clear previous email checkboxes
          $('#getEmailsModal .modal-body .form-group').empty();
          var i = 0;
          // Append hidden fields for client_id and client_ids outside the loop
          $('#getEmailsModal .modal-body .form-group').append(
            '<input type="hidden" name="client_id" value="' + response.c_id + '">' +
            '<input type="hidden" name="client_ids" value="' + response.client_ids.join(",") + '">' 
          );

          // Handle the response data
          if (response && response.emails && response.emails.length > 0) {
            response.emails.forEach(function(email) {
              console.log("Email:", email.client_email);
              i++;
              console.log("i value:", i);

              $('#getEmailsModal .modal-body .form-group').append(
                '<input type="hidden" name="index" value="' + i + '">' +
                '<div class="form-check">' +
                  '<label class="form-check-label justify-content-between">' +
                    '<input type="checkbox" name="clientMails' + i + '[]" class="form-check-input" value="' + email.client_email + '">' + email.client_email +
                  '</label>' +
                '</div>'
              );
            });
          } else {
            console.log("No emails found for this client.");
            $('#getEmailsModal .modal-body .form-group').append('<p>No emails found for this client.</p>');
          }

          // Show the modal
          $('#getEmailsModal').modal('show');
        },
        error: function(xhr, status, error) {
          console.error("AJAX error:", status, error);
        }
      });
    }
    $(document).ready(function() {
    $('#sendEmailButton').click(function() {
        var formData = $('#sendEmailForm').serialize();

        $.ajax({
            type: "POST",
            url: "{{ route('sendEmail') }}",
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    location.reload(); // Reload the page to show the success message
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", status, error);
                alert("An error occurred. Please try again.");
            }
        });
    });
});
</script>


@include('common/footer')