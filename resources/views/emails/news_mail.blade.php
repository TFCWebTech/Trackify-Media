<!DOCTYPE html>
<html>
<head>
    <title>Client Email</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            width: 100%;
            padding: 15px;
            box-sizing: border-box;
            background-color: #ffffff;
        }
        .card {
            background-color: #F9F9F9;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid gray;
        }
        .header {
            background-color: #ffffff;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .header img {
            width: 100px;
        }
        .header a {
            font-size: 12px;
            color: #000000;
            text-decoration: none;
        }
        .header h5 {
            margin: 0;
            text-align: center;
        }
        .table-wrapper {
            width: 100%;
            margin: 15px 0;
        }
        .table-wrapper table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-wrapper th, .table-wrapper td {
            width: 200px;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .table-wrapper th {
            background-color: #6D6B6B;
            color: #ffffff;
        }
        .table-wrapper td {
            background-color: #DCD5D5;
        }
        .body-content {
            padding: 10px 15px;
        }
        .body-content h4 {
            background-color: #cfbbbb;
            color: #ffffff;
            padding: 10px;
            margin: 0;
        }
        .body-content h5, .body-content h6 {
            margin: 0;
        }
        .showEdit a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .showEdit a:hover {
            text-decoration: underline;
        }
        .news-footer {
            padding: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
        }
        .news-footer .logo img {
            width: 100px;
        }
        .news-footer p {
            font-size: 12px;
            color: #000000;
            margin: 0;
        }
        .ImageLogo {
            width: 100px; /* Set a default width for the image */
            height: auto; /* Maintain aspect ratio */
        }
        .mobile-stack a{
            font-size: 12px;
        }
        
        /* Mobile Styles */
        @media screen and (max-width: 600px) {
            .mobile-stack {
                display: block;
                width: 100% !important;
                text-align: center; /* Center-align text and images */
            }
            .mobile-stack img {
                display: inline-block;
                width: 100px !important;
                max-width: 100px !important;
                height: auto !important;
            }
            .mobile-stack a{
            font-size: 8px;
        }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card" id="content">
            <div class="header">
            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
        <tr>
            <td class="mobile-stack" align="left" style="padding: 10px;">
                <img src="https://pressbro.com/News/assets/img/mediaLogo.png" class="ImageLogo" alt="logo"> <br>
                <a href="#" style=" color: #000000; text-decoration: none;">powered by trackify media</a>
            </td>
            <td class="mobile-stack" align="center" style="padding: 10px;">
                <h3 style="margin: 0;">
                    {{ $get_client_data['client_name'] }}<br>
                    <span style="font-size: 14px;">{{ \Carbon\Carbon::now()->format('l, M d, Y') }}</span>
                </h3>
            </td>
            <td class="mobile-stack" align="right" style="padding: 10px; width: 230px;">
                <h5 style="margin: 0;"></h5>
            </td>
        </tr>
    </table>
            </div>
            <hr>
            <div class="table-wrapper">
                <table>
                    <tr>
                        <th>Quick Links</th>
                        <th>Access Other Services</th>
                    </tr>
                    <tr>
                        <td> </td>
                        <td><a href="">Login</a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="mailto:Customerservice@trackifyMedia.info">Customerservice@trackifyMedia.info</a></td>
                    </tr>
                </table>
            </div>
            <div class="body-content">
                <h4>{{ $get_client_data['client_name'] }}</h4>
                @foreach ($get_news_details as $news)
                    <div id="clientnewsContent-{{ $news['news_details_id'] }}">
                        <div style="display:flex; justify-content: space-between; padding: 0 10px;">
                            <h3>
                                <a href="{{ url('NewsLetter/DisplayNews/'.$news['news_details_id']) }}">{{ $news['head_line'] }}</a>
                            </h3>
                        </div>
                        <h5>Summary:</h5>
                        <p>{{ $news['summary'] }}</p>
                        <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }},
                            Publication: <span style="color:blue;">{{ $news['MediaOutlet'] }}</span>,
                            Journalist / Agency: <span style="color:blue;">{{ $news['Journalist'] ?: $news['Agency'] }}</span>,
                            Edition: <span style="color:blue;">{{ $news['Edition'] }}</span>,
                            Supplement: <span style="color:blue;">{{ $news['Supplement'] }}</span>,
                            No of pages: <span style="color:blue;">{{ $news['page_count'] }}</span>,
                            Circulation Figure:<span> </span>, qAVE(Rs.) :<span> </span>
                        </p>
                        <hr>
                    </div>
                @endforeach
            </div>
            <div class="body-content">
                <h4>Competition</h4>
                <br>
                @foreach ($get_comp_data as $compititor)
                    <div>
                        <h4>{{ $compititor['Competitor_name'] }}</h4>
                        @foreach ($compititor['news'] as $news)
                            <div id="competitornewsContent-{{ $news['news_details_id'] }}-{{ $compititor['competitor_id'] }}">
                                <div style="display:flex; justify-content: space-between; padding: 0 10px;">
                                    <h5>
                                        <a href="{{ url('NewsLetter/DisplayNews/'.$news['news_details_id']) }}">{{ $news['head_line'] }}</a>
                                    </h5>
                                   
                                </div>
                                <h5>Summary:</h5>
                                <p>{{ $news['summary'] }}</p>
                                <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }},
                                    Publication: <span style="color:blue;">{{ $news['MediaOutlet'] }}</span>,
                                    Journalist / Agency: <span style="color:blue;">{{ $news['Journalist'] ?: $news['Agency'] }}</span>,
                                    Edition: <span style="color:blue;">{{ $news['Edition'] }}</span>,
                                    Supplement: <span style="color:blue;">{{ $news['Supplement'] }}</span>,
                                    No of pages: <span style="color:blue;">{{ $news['page_count'] }}</span>
                                    , Circulation Figure:<span> </span>, qAVE(Rs.) :<span> </span>
                                </p>
                                <hr>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <!-- Industry -->
            <div class="body-content">
                <h4>Industry</h4>
                <br>
                @foreach ($get_industry_data as $industry)
                    <div>
                        <h4>{{ $industry['Industry_name'] }}</h4>
                        @foreach ($industry['news'] as $news)
                            <div id="IndustrynewsContent-{{ $news['news_details_id'] }}-{{ $industry['Industry_id'] }}">
                                <div style="display:flex; justify-content: space-between; padding: 0 10px;">
                                    <h5>
                                        <a href="{{ url('NewsLetter/DisplayNews/' . $news['news_details_id']) }}" style="color: {{ $get_client_details[0]['content_headline_color'] }}; font-size: {{ $get_client_details[0]['content_headline_font_size'] }}; font-family: {{ $get_client_details[0]['content_headline_font'] }}">{{ $news['head_line'] }}</a>
                                    </h5>
                                    
                                </div>
                                <h5>Summary:</h5>
                                <p style="color: {{ $get_client_details[0]['content_news_summary_color'] }}; font-size: {{ $get_client_details[0]['content_news_summary_font_size'] }};">
                                    {{ $news['summary'] }}
                                </p>
                                <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }},
                                    Publication: <span style="color:blue;">{{ $news['MediaOutlet'] }}</span>,
                                    Journalist / Agency: <span style="color:blue;">{{ $news['Journalist'] }}</span>,
                                    Edition: <span style="color:blue;">{{ $news['Edition'] }}</span>,
                                    Supplement: <span style="color:blue;">{{ $news['Supplement'] }}</span>,
                                    No of pages: <span style="color:blue;">{{ $news['page_count'] }}</span>
                                    , Circulation Figure:<span> </span>, qAVE(Rs.) :<span> </span>
                                </p>
                                <hr>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <hr>
            <div class="news-footer">
                <div class="logo">
                    <img src="https://pressbro.com/News/assets/img/mediaLogo.png" alt="logo">
                </div>
                <p><span style="color:red; font-weight:bold;">This is an auto-generated email – please do not reply to this email id</span></p>
            </div>
        </div>
    </div>
</body>
</html>
