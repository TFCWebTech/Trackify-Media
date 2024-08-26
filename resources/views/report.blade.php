@include('common/header')

<!-- Include the necessary CSS and JS libraries for DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

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
                                            <?php //foreach($clients as $values){?>
                                            <option value="<?php //echo $values['client_id'];?>"> <?php //echo $values['client_name'];?></option>
                                            <?php //}?>
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
                                            <?php //foreach($publication_type as $values){?>
                                            <option value="<?php// echo $values['gidPublicationType'];?>"> <?php //echo $values['PublicationType'];?></option>
                                            <?php //}?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="px-1 font-weight-bold" for="Cities">Cities</label>
                                    <select class="form-control" name="Cities" id="Cities">
                                    <option value="" disbled>Select</option>
                                            <?php //foreach($news_city as $values){?>
                                            <option value="<?php //echo $values['gidNewscity'];?>"> <?php //echo $values['CityName'];?></option>
                                            <?php //}?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="eDossier "> Download PDF </label> <br>
                                    <a onclick="downloadPDF()" class="btn border">Print</a>  
                                </div>
                                <div class="col-md-2">
                                    <label class="px-1 font-weight-bold" for="eDossier "> Download Excel </label> <br>
                                    <a onclick="downloadWord()" class="btn border">Excel</a>
                                </div>
                                <!-- <div class="col-md-2 mt-3 pt-2">
                                    <button class="btn btn-primary">Search</button>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

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
   </style>

   <div class="container" id="printData" style="display:none;">
        <div class="row">
            <div class="col-md-12 text-right mb-2">
                <a href="<?php //echo site_url('NewsLetter/sendMail/'.$details['client_id']);?>"> <i class="fa fa-send-o" style="font-size:36px;color:red"></i></a>
            </div>
        </div>
        <div class="card" style="background-color: #F9F9F9;">
            <div class="header" style="background-color: <?php //echo $get_client_details[0]['header_background_color']; ?>; padding:5px 10px;">
                <table cellpadding="0" cellspacing="0" style="width:100%;">
                    <tr>
                        <td align="left">
                            <?php 
                            //if ($get_client_details[0]['logo_position'] == 'Left') { ?>
                                <img src="<?php //echo $get_client_details[0]['header_logo_url']; ?>" alt="logo" style="width:100px;"> <br>
                            <?php// }
                          //  if ($get_client_details[0]['trackify_link_status'] == 1) { ?>
                                <a href="<?php// echo $get_client_details[0]['trackify_link']; ?>" style="font-size:12px; color:#ffffff;">powered by trackify media</a>
                            <?php// }
                            ?>
                        </td>
                        <td align="center">
                            <?php 
                            //if ($get_client_details[0]['logo_position'] == 'Center') { ?>
                                <img src="<?php// echo $get_client_details[0]['header_logo_url']; ?>" alt="logo" style="width:100px;"> <br>
                            <?php //}
                            ?>
                            <h5><a style="font-size:<?php// echo $get_client_details[0]['header_title_font_size'] ?>px; color:<?php //echo $get_client_details[0]['header_title_font_color'] ?>;"><?php //echo $get_client_details[0]['header_title_name']; ?></a><br>
                            <span style="display:block; font-size: 12px;"><?php //echo date('l, M d, Y'); ?><br>
                            </span>
                            </h5>
                        </td>
                        <td align="right">
                            <?php 
                            //if ($get_client_details[0]['logo_position'] == 'Right') { ?>
                                <img src="<?php //echo $get_client_details[0]['header_logo_url']; ?>" alt="logo" style="width:100px;"> <br>
                            <?php// }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12 mt-3 table-wrapper">
                <table>
                    <tr style="background-color: #6D6B6B; color: #ffffff;">
                        <th>Quick Links</th>
                        <th>Access Other Services</th>
                    </tr>
                    <?php //if (!empty($get_client_details)): ?>
                        <?php //foreach ($get_client_details as $detail): ?>
                            <?php //if ($detail['quick_links_position'] == '1'): ?>
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td>
                                        <p><?php// echo $detail['quick_links_name']; ?></p>
                                    </td>
                                    <td><a href="">Login</a></td>
                                </tr>
                            <?php //elseif ($detail['quick_links_position'] == '2'): ?>
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td>
                                        <?php //echo $detail['quick_links_name']; ?> (<?php// echo sizeof($detail['compititors_data']); ?>)
                                    </td>
                                    <td></td>
                                </tr>
                            <?php// elseif ($detail['quick_links_position'] == '3'): ?>
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td>
                                        <?php //echo $detail['quick_links_name']; ?> (<?php //echo sizeof($detail['industry_data']); ?>)
                                    </td>
                                    <td></td>
                                </tr>
                            <?php //elseif ($detail['quick_links_position'] == '4'): ?>
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td>
                                        <?php //echo $detail['quick_links_name']; ?> (<?php //echo sizeof($detail['compititors_data']); ?>)
                                    </td>
                                    <td></td>
                                </tr>
                            <?php //elseif ($detail['quick_links_position'] == '5'): ?>
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td>
                                        <?php //echo $detail['quick_links_name']; ?> (<?php //echo sizeof($detail['industry_data']); ?>)
                                    </td>
                                    <td></td>
                                </tr>
                            <?php //elseif ($detail['quick_links_position'] == '6'): ?>
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td>
                                        <?php //echo $detail['quick_links_name']; ?> (<?php //echo sizeof($detail['compititors_data']); ?>)
                                    </td>
                                    <td></td>
                                </tr>
                            <?php// endif; ?>
                        <?php //endforeach; ?>
                    <?php //endif; ?>
                    <tr style="background-color: #DCD5D5; color: #ffffff;">
                        <td></td>
                        <td><a href="">Customerservice@trackify.info</a></td>
                    </tr>
                </table>
            </div>
            <div class="body-content" style="padding:10px 15px 0px 15px;">
                <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;"><?php //echo $details['client_name']; ?></h4>
                <?php
                //foreach ($get_client_details[0]['client_news'] as $key => $news) { ?>
                    <h5><a href="<?php //echo site_url('NewsLetter/DisplayNews/'.$news['news_details_id']);?>" style="color: <?php //echo $get_client_details[0]['content_headline_color']; ?>;font-size: <?php //echo $get_client_details[0]['content_headline_font_size']; ?>;font-family: <?php //echo $get_client_details[0]['content_headline_font']; ?>"><?php //echo $news['head_line']; ?></a></h5>
                    <h6>Summary:</h6>
                    <p style="color: <?php// echo $get_client_details[0]['content_news_summary_color']; ?>;font-size: <?php //echo $get_client_details[0]['content_news_summary_font_size']; ?>;"><?php //echo $news['summary']; ?></p>
                    <p>Date: <?php// echo date('d-m-Y', strtotime($news['create_at'])); ?> ,
                                Publication :<span style="color:blue;"> <?php// echo $news['MediaOutlet']; ?></span>, Journalist / Agency :<span style="color:blue;"> <?php //echo $news['Journalist']; ?></span>  , 
                                Edition : <span style="color:blue;"> <?php //echo $news['Edition']; ?> </span>,  Supplement : <span style="color:blue;"> <?php //echo $news['Supplement']; ?> </span>, No of pages:<span style="color:blue;"> <?php// echo $news['page_count']; ?></span> , Circulation Figure:<span> </span>, qAVE(Rs.) :<span> </span> 
                            </p>
                    <hr>
                <?php //}
                ?>
            </div>
            <div class="body-content" style="padding:10px 15px 0px 15px;">
                <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;">Competition</h4>
            </div>
            <?php 
           // foreach ($get_client_details[0]['compititors_data'] as $key => $compititor) { ?>
                <div class="body-content" style="padding:10px 15px 0px 15px;">
                    <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;"><?php //echo $compititor['Competitor_name']; ?></h4>
                    <?php
                    //foreach ($compititor['news'] as $key => $news) { ?>
                        <h5><a href="<?php// echo site_url('NewsLetter/DisplayNews/'.$news['news_details_id']);?>" style="color: <?php //echo $get_client_details[0]['content_headline_color']; ?>;font-size: <?php //echo $get_client_details[0]['content_headline_font_size']; ?>;font-family: <?php// echo $get_client_details[0]['content_headline_font']; ?>"><?php //echo $news['head_line']; ?></a></h5>
                        <h6>Summary:</h6>
                        <p style="color: <?php //echo $get_client_details[0]['content_news_summary_color']; ?>;font-size: <?php// echo $get_client_details[0]['content_news_summary_font_size']; ?>;"><?php //echo $news['summary']; ?></p>
                        <p>Date: <?php //echo date('d-m-Y', strtotime($news['create_at'])); ?> ,
                                Publication :<span style="color:blue;"> <?php// echo $news['MediaOutlet']; ?></span>, Journalist / Agency :<span style="color:blue;"> <?php//echo $news['Journalist']; ?></span>  , 
                                Edition : <span style="color:blue;"> <?php// echo $news['Edition']; ?> </span>,  Supplement : <span style="color:blue;"> <?php// echo $news['Supplement']; ?> </span>, No of pages:<span style="color:blue;"> <?php //echo $news['page_count']; ?></span> , Circulation Figure:<span> </span>, qAVE(Rs.) :<span> </span> 
                            </p>
                        <hr>
                    <?php //}
                    ?>
                </div>
            <?php //}
            ?>
            <div class="body-content" style="padding:10px 15px 0px 15px;">
                <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;">Industry</h4>
            </div>
            <?php 
           // foreach ($get_client_details[0]['industry_data'] as $key => $Industry) { ?>
                <div class="body-content" style="padding:10px 15px 0px 15px;">
                    <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;"><?php //echo $Industry['Industry_name']; ?></h4>
                    <?php
                    //foreach ($compititor['news'] as $key => $news) { ?>
                        <h5><a href="<?php //echo site_url('NewsLetter/DisplayNews/'.$news['news_details_id']);?>" style="color: <?php //echo $get_client_details[0]['content_headline_color']; ?>;font-size: <?php //echo $get_client_details[0]['content_headline_font_size']; ?>;font-family: <?php //echo $get_client_details[0]['content_headline_font']; ?>"><?php //echo $news['head_line']; ?></a></h5>
                        <h6>Summary:</h6>
                        <p style="color: <?php //echo $get_client_details[0]['content_news_summary_color']; ?>;font-size: <?php //echo $get_client_details[0]['content_news_summary_font_size']; ?>;"><?php //echo $news['summary']; ?></p>
                        <p>Date: <?php //echo date('d-m-Y', strtotime($news['create_at'])); ?> ,
                        Publication :<span style="color:blue;"><?php //echo $news['publication_id']; ?></span>, Journalist / Agency :<span style="color:blue;"><?php //echo $news['journalist_id']; ?></span>,
                        Edition : <span style="color:blue;"><?php //echo $news['edition_id']; ?></span>, Supplement : <span style="color:blue;"><?php //echo $news['supplement_id']; ?></span>, No of pages:<span style="color:blue;"><?php //echo $news['page_count']; ?></span>, Circulation Figure:<span></span>, qAVE(Rs.) :<span></span></p>
                        <hr>
                    <?php// }
                    ?>
                </div>
            <?php //}
            ?>
            <div class="col-md-12 news-footer" style="background-color: <?php// echo $get_client_details[0]['footer_background_color']; ?>;">
                <div class="d-flex justify-content-between">
                    <div class="logo" style="text-align:left;">
                        <?php 
                        //if ($get_client_details[0]['footer_logo_position'] == 'Left') { ?>
                            <img src="<?php //echo $get_client_details[0]['footer_logo_url']; ?>" alt="logo" style="width:100px; padding:5px;"> <br>
                        <?php //}
                        ?>
                    </div>
                    <div class="footer" style="text-align:center;">
                        <?php 
                       // if ($get_client_details[0]['footer_logo_position'] == 'Center') { ?>
                            <img src="<?php //echo $get_client_details[0]['footer_logo_url']; ?>" alt="logo" style="width:100px; padding:5px;"> <br>
                        <?php //}
                        ?>
                    </div>
                    <div class="footer" style="text-align:end;">
                        <?php 
                        //if ($get_client_details[0]['footer_logo_position'] == 'Right') { ?>
                            <img src="<?php //echo $get_client_details[0]['footer_logo_url']; ?>" alt="logo" style="width:100px; padding:5px;"> <br>
                        <?php //}
                        ?>
                    </div>
                </div>
                <p style="font-size:<?php// echo $get_client_details[0]['footer_title_font_size'] ?>px; color:<?php //echo $get_client_details[0]['footer_title_font_color'] ?>;text-align: center"><?php //echo $get_client_details[0]['footer_title_name']; ?></p>
                <p><span style="color:red; font-weight:bold;">This is an auto generated email – please do not reply to this email id</span></p>
            </div>
        </div>
    </div>
    </div>
<script>

function downloadWord() {
    var from_date = document.getElementById('from_date').value;
    var to_date = document.getElementById('to_date').value;
    var publication_type = document.getElementById('publication_type').value;
    var Cities = document.getElementById('Cities').value;

    console.log('From Date:', from_date); // Debugging line
    console.log('To Date:', to_date); // Debugging line
    console.log('Publication Type:', publication_type); // Debugging line
    console.log('Cities:', Cities); // Debugging line

    $.ajax({
        type: "POST",
        url: "<?php //echo site_url('Report/exportWord'); ?>",
        dataType: 'json', // Expecting JSON response
        data: {
            from_date: from_date,
            to_date: to_date,
            publication_type: publication_type,
            Cities: Cities,
        },
        success: function(response) {
    console.log("Update successful", response);

    var clientName = response.client_name;
    var fromDate = response.from_date;
    var toDate = response.to_date;
    var data = response.data;

    // Construct CSV content from JSON data
    var csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "Client Name: " + clientName + "\n";
    csvContent += "Date Range: " + fromDate + " to " + toDate + "\n\n";
    csvContent += "News Date, Headline, Edition, Supplement, Page No, Height, Width\n";

    data.forEach(function(row) {
        var createDate = new Date(row.create_at);
        var formattedDate = createDate.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        csvContent += (row.create_at ? formattedDate : "NA") + "," +
                      (row.head_line || "NA") + "," +
                      (row.Edition || "NA") + "," +
                      (row.Supplement || "NA") + "," +
                      (row.page_no || "NA") + "," +
                      (row.image_height || "NA") + "," +
                      (row.image_width || "NA") + "\n";
    });

    // Create a hidden link element to trigger the download
    var encodedUri = encodeURI(csvContent);
    var link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "data.csv");
    document.body.appendChild(link); // Required for FF
    link.click();

    // Remove the link from the body
    document.body.removeChild(link);
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
    console.log('select client:', select_client);
    console.log('From Date:', from_date); // Debugging line
    console.log('To Date:', to_date); // Debugging line
    console.log('Publication Type:', publication_type); // Debugging line
    console.log('Cities:', Cities); // Debugging line

    $.ajax({
        type: "POST",
        url: "<?php //echo site_url('Report/downloadPDF'); ?>",
        dataType: 'json', // Expecting JSON response
        data: {
            select_client: select_client,
            from_date: from_date,
            to_date: to_date,
            publication_type: publication_type,
            Cities: Cities,
        },
        success: function(response) {
            // Log the response to see what's coming back
            console.log(response);

            // Check if the response indicates success and contains a valid PDF URL
            if (response.success && response.pdf_url) {
                // Use JavaScript to initiate the download
                var link = document.createElement('a');
                link.href = response.pdf_url;
                link.download = 'downloaded_pdf.pdf'; // Optional: Specify the filename for download
                link.click();
                window.open(response.pdf_url, '_blank'); 
            } else {
                // Handle error or no valid PDF URL case
                alert('Failed to generate PDF or PDF URL is invalid.');
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX error
            console.error('AJAX Error:', status, error);
            alert('AJAX Error: Failed to fetch PDF data.');
        }
    });
}
</script>

<!-- <script>
function downloadPDF() {
    // Get the content of the div
    var divToPrint = document.getElementById('printData');
    
    // Create a new window
    var newWin = window.open('', 'Print-Window');
    
    // Write the content to the new window
    newWin.document.open();
    newWin.document.write('<html><head><title>Print</title>');
    newWin.document.write('<style>/* Include any necessary CSS here */</style>');
    newWin.document.write('</head><body onload="window.print()">');
    newWin.document.write(divToPrint.innerHTML);
    newWin.document.write('</body></html>');
    newWin.document.close();
    
    // Set a timeout to close the new window after printing
    setTimeout(function() { newWin.close(); }, 10);
}
</script> -->

@include('common/footer')