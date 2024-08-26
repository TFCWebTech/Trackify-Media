@include('common/clientDashboard-header')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx-style/0.8.13/xlsx-style.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
table.dataTable th,
table.dataTable td {
  white-space: nowrap;
}
.dataTables_wrapper .dataTables_filter input, .dataTables_wrapper .dataTables_length select{
padding: 2px !important;
margin-bottom: 5px !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button{
    padding: .2em .3em !important;
}
.form-group {
    margin-bottom: 0rem !important;
}
.modal-body{
    padding: 0rem .5rem .5rem .5rem  !important;
}
/* @media (min-width: 768px) { */
        .table-container-responsive{
            overflow-x: auto;
        }
    /* } */
    
   
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

</style>
<div class="container" >
    <div class="row">
        <div class="col-md-12">
            <h6 class="text-primary font-weight-bold p-2">
                Reports
            </h6>
        </div>
    </div>
        <!-- <div class="card p-3 my-2"  id="headlineSearchSection" > -->
            <form>
                <div class="row">
                    <div class="col-md-12 card p-3">
                        <div class="row ">
                            <div class="col-md-6 d-flex">
                                    <label class="px-1 font-weight-bold mt-1" for="publication_type">Select Client</label>
                                    <select class="form-control" name="select_client" id="select_client" style="width:200px;">
                                    <option disbled>Select</option>
                                            @foreach($client_list as $list)
                                                <option value="{{$list->client_id}}">{{$list->client_name}}</option>
                                            @endforeach
                                    </select>
                            </div>
                            <div class="col-md-6 text-right d-flex">
                                <label class="px-2 font-weight-bold mt-1" >Date </label>
                                <input type="date" name="from_date" id="from_date" class="form-control px-2 mx-1"> 
                                <input type="date" name="to_date" id="to_date" class="form-control px-2 mx-1"> 
                            </div>
                        </div>
                        <div class="border-with-text mt-3" data-heading="Filter Options">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="px-1 font-weight-bold" for="publication_type">Publication Type</label>
                                    <select class="form-control" name="publication_type" id="publication_type">
                                    <option value="" disbled>Select</option>
                                           @foreach($publication_type as $publication_type_list)
                                                <option value="{{ $publication_type_list-> gidPublicationType_id}}">{{ $publication_type_list-> PublicationType }}</option>
                                           @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="px-1 font-weight-bold" for="Cities">Cities</label>
                                    <select class="form-control" name="Cities" id="Cities">
                                    <option value="" disbled>Select</option>
                                    @foreach($news_cities as $news_cities_list)
                                                <option value="{{ $news_cities_list-> gidNewscity_id}}">{{ $news_cities_list-> CityName }}</option>
                                           @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="eDossier"> Download PDF </label> <br>
                                    <a onclick="downloadPDF()" class="btn border">Print</a>  
                                </div>
                                <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="eDossier "> Download Excel </label> <br>
                                    <a onclick="downloadWord()" class="btn border">Excel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
<script>
function downloadWord() {
    var select_client = document.getElementById('select_client').value;
    var from_date = document.getElementById('from_date').value;
    var to_date = document.getElementById('to_date').value;
    var publication_type = document.getElementById('publication_type').value;
    var Cities = document.getElementById('Cities').value;

    console.log('select_client :', select_client);
    console.log('From Date:', from_date);
    console.log('To Date:', to_date);
    console.log('Publication Type:', publication_type);
    console.log('Cities:', Cities);

    $.ajax({
        type: "POST",
        url: "{{ route('getNewsArticleInWord') }}",
        dataType: 'json',
        data: {
            select_client: select_client,
            from_date: from_date,
            to_date: to_date,
            publication_type: publication_type,
            Cities: Cities,
            _token: '{{ csrf_token() }}' // Add CSRF token for security
        },
        success: function(response) {
            console.log("Update successful", response);

            // Ensure to adjust according to actual response structure
            var client_name = response.details.client_name || 'Unknown Client';
            var fromDate = response.from_date;
            var toDate = response.to_date;
            var data = response.get_client_details;

            var worksheetData = [
                [{ v: "Client Name: " + client_name, s: { alignment: { horizontal: "center", vertical: "center" } } }],
                [{ v: "Date Range: " + fromDate + " to " + toDate, s: { alignment: { horizontal: "center", vertical: "center" } } }],
                [],
                ["News Date", "Headline", "Edition", "Supplement", "Page No", "Height", "Width", "Total AVE"]
            ];

            var headerStyle = { font: { bold: true }, alignment: { horizontal: "center", vertical: "center" } };
            var centerStyle = { alignment: { horizontal: "center", vertical: "center" } };

            data.forEach(function(row) {
                var createDate = new Date(row.create_at);
                var formattedDate = createDate.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });

                if (row.news_articles && row.news_articles.length > 0) {
                    row.news_articles.forEach(function(article) {
                        worksheetData.push([
                            { v: row.create_at ? formattedDate : "NA" },
                            { v: row.head_line || "NA", s: headerStyle, l: { Target: row.website_url || '#' } },
                            { v: row.Edition || "NA" },
                            { v: row.Supplement || "NA" },
                            { v: article.page_no || "NA" },
                            { v: article.image_height || "NA" },
                            { v: article.image_width || "NA" },
                            { v: row.total_ave || "NA" }
                        ]);
                    });
                } else {
                    worksheetData.push([
                        { v: row.create_at ? formattedDate : "NA" },
                        { v: row.head_line || "NA", s: headerStyle, l: { Target: row.website_url || '#' } },
                        { v: row.Edition || "NA" },
                        { v: row.Supplement || "NA" },
                        { v: "NA" },
                        { v: "NA" },
                        { v: "NA" },
                        { v: row.total_ave || "NA" }
                    ]);
                }
            });

            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.aoa_to_sheet(worksheetData);

            for (var i = 0; i < worksheetData.length; i++) {
                var row = worksheetData[i];
                for (var j = 0; j < row.length; j++) {
                    if (row[j].s) {
                        ws[XLSX.utils.encode_cell({ r: i, c: j })].s = row[j].s;
                    }
                }
            }

            ws['A1'].s = centerStyle;
            ws['A2'].s = centerStyle;

            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
            XLSX.writeFile(wb, "data.xlsx");
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

</script>

<script>
    $('table').DataTable();
</script>

<script>
 function downloadPDF() {
    var select_client = document.getElementById('select_client').value;
    var from_date = document.getElementById('from_date').value;
    var to_date = document.getElementById('to_date').value;
    var publication_type = document.getElementById('publication_type').value;
    var Cities = document.getElementById('Cities').value;
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
console.log('select_client :', select_client);
    console.log('From Date:', from_date);
    console.log('To Date:', to_date);
    console.log('Publication Type:', publication_type);
    console.log('Cities:', Cities);
    $.ajax({
        type: "POST",
        url: "{{ route('getNewsArticleData') }}",
        dataType: 'json', // Expecting JSON response
        data: {
            select_client: select_client,
            from_date: from_date,
            to_date: to_date,
            publication_type: publication_type,
            Cities: Cities,
            _token: csrfToken // Include the CSRF token
        },
        success: function(response) {
            console.log(response);

            if (response.success && response.pdf_url) {
                var link = document.createElement('a');
                link.href = response.pdf_url;
                link.download = 'downloaded_pdf.pdf';
                link.click();
                window.open(response.pdf_url, '_blank'); 
            } else {
                alert('Failed to generate PDF or PDF URL is invalid.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.error('Response:', xhr.responseText);
            alert('AJAX Error: Failed to fetch PDF data.');
        }
    });
}

</script>
@include('common/clientDashboard_footer')