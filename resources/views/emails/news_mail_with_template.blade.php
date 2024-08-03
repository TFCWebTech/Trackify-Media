<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .header_content {
            display: flex;
            justify-content: space-between;
        }
        @media (max-width: 725px) {
            .header_content {
                display: block;
                text-align: center;
            }
        }
        .body-content {
            padding: 0px 6px 0px 6px;
        }
        .footer {
            background-color: #6D6B6B;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card" style="background-color: #F9F9F9;">
            <div class="header" style="background-color: {{ $get_client_details[0]['header_background_color'] }}; padding:5px 10px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left">
                            @if ($get_client_details[0]['logo_position'] === 'Left')
                                <img src="{{ $get_client_details[0]['header_logo_url'] }}" alt="logo" style="width:100px;"> <br>
                            @endif
                            @if ($get_client_details[0]['trackify_link_status'] == 1)
                                <a href="{{ $get_client_details[0]['trackify_link'] }}" style="font-size:12px; color:#ffffff;">powered by trackify media</a>
                            @endif
                        </td>
                        <td align="center">
                            @if ($get_client_details[0]['logo_position'] === 'Center')
                                <img src="{{ $get_client_details[0]['header_logo_url'] }}" alt="logo" style="width:100px;"> <br>
                            @endif
                            <h5>
                                <a style="font-size:{{ $get_client_details[0]['header_title_font_size'] }}px; color:{{ $get_client_details[0]['header_title_font_color'] }};">
                                    {{ $get_client_details[0]['header_title_name'] }}
                                </a><br>
                                <span style="display:block; font-size: 12px;">{{ date('l, M d, Y') }}</span>
                            </h5>
                        </td>
                        <td align="right">
                            @if ($get_client_details[0]['logo_position'] === 'Right')
                                <img src="{{ $get_client_details[0]['header_logo_url'] }}" alt="logo" style="width:100px;"> <br>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-md-12 mt-3 table-wrapper">
                <table>
                    <tr style="background-color: #6D6B6B; color: #ffffff;">
                        <th></th>
                        <th>Access Other Services</th>
                    </tr>
                    @if (!empty($get_client_details[0]['get_quick_links']))
                        @foreach ($get_client_details[0]['get_quick_links'] as $detail)
                            @if ($detail['quick_links_position'] == '1')
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td><p>{{ $detail['quick_links_name'] }} ({{ count($get_client_details[0]['client_news']) }})</p></td>
                                    <td><a href="#">Login</a></td>
                                </tr>
                            @elseif ($detail['quick_links_position'] == '2')
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td>{{ $detail['quick_links_name'] }} ({{ count($get_client_details[0]['compititors_data']) }})</td>
                                    <td></td>
                                </tr>
                            @elseif ($detail['quick_links_position'] == '3')
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td>{{ $detail['quick_links_name'] }} ({{ count($get_client_details[0]['industry_data']) }})</td>
                                    <td></td>
                                </tr>
                            @elseif ($detail['quick_links_position'] == '4')
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td>{{ $detail['quick_links_name'] }} ({{ count($get_client_details[0]['compititors_data']) }})</td>
                                    <td></td>
                                </tr>
                            @elseif ($detail['quick_links_position'] == '5')
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td>{{ $detail['quick_links_name'] }} ({{ count($get_client_details[0]['industry_data']) }})</td>
                                    <td></td>
                                </tr>
                            @elseif ($detail['quick_links_position'] == '6')
                                <tr style="background-color: #DCD5D5; color: #ffffff;">
                                    <td>{{ $detail['quick_links_name'] }} ({{ count($get_client_details[0]['compititors_data']) }})</td>
                                    <td></td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    <tr style="background-color: #DCD5D5; color: #ffffff;">
                        <td></td>
                        <td><a href="mailto:customerservice@trackify.info">customerservice@trackify.info</a></td>
                    </tr>
                </table>
            </div>

            <div class="body-content">
                <h4 style="background-color: #6D6B6B; color: #ffffff; padding:4px;">{{ $details['client_name'] }}</h4>
                @foreach ($get_client_details[0]['client_news'] as $news)
                    <h5>
                        <a href="{{ $news['website_url'] }}" style="color: {{ $get_client_details[0]['content_headline_color'] }}; font-size: {{ $get_client_details[0]['content_headline_font_size'] }}px; font-family: {{ $get_client_details[0]['content_headline_font'] }};">
                            {{ $news['head_line'] }}
                        </a>
                    </h5>
                    <h6>Summary:</h6>
                    <p style="color: {{ $get_client_details[0]['content_news_summary_color'] }}; font-size: {{ $get_client_details[0]['content_news_summary_font_size'] }}px;">
                        {{ $news['summary'] }}
                    </p>
                    <p>
                        Date: {{ date('d-m-Y', strtotime($news['create_at'])) }},
                        Publication: <span style="color:blue;">{{ $news['MediaOutlet'] }}</span>,
                        Journalist / Agency: <span style="color:blue;">{{ $news['Journalist'] ?: $news['Agency'] }}</span>,
                        Edition: <span style="color:blue;">{{ $news['Edition'] }}</span>,
                        Supplement: <span style="color:blue;">{{ $news['Supplement'] }}</span>,
                        No of pages: <span style="color:blue;">{{ $news['page_count'] }}</span>,
                        Circulation Figure: <span></span>, qAVE(Rs.): <span></span>
                    </p>
                    <hr>
                @endforeach
            </div>

            <div class="body-content">
                <h4 style="background-color: #6D6B6B; color: #ffffff; padding:4px;">Competition</h4>
                @foreach ($get_client_details[0]['compititors_data'] as $compititor)
                        <h4 style="background-color: #6D6B6B; color: #ffffff; padding:4px;">{{ $compititor['Competitor_name'] }}</h4>
                        @foreach ($compititor['news'] as $news)
                            <h5>
                                <a href="{{ $news['website_url'] }}" style="color: {{ $get_client_details[0]['content_headline_color'] }}; font-size: {{ $get_client_details[0]['content_headline_font_size'] }}px; font-family: {{ $get_client_details[0]['content_headline_font'] }};">
                                    {{ $news['head_line'] }}
                                </a>
                            </h5>
                            <h6>Summary:</h6>
                            <p style="color: {{ $get_client_details[0]['content_news_summary_color'] }}; font-size: {{ $get_client_details[0]['content_news_summary_font_size'] }}px;">
                                {{ $news['summary'] }}
                            </p>
                            <p>
                                Date: {{ date('d-m-Y', strtotime($news['create_at'])) }},
                                Publication: <span style="color:blue;">{{ $news['MediaOutlet'] }}</span>,
                                Journalist / Agency: <span style="color:blue;">{{ $news['Journalist'] ?: $news['Agency'] }}</span>,
                                Edition: <span style="color:blue;">{{ $news['Edition'] }}</span>,
                                Supplement: <span style="color:blue;">{{ $news['Supplement'] }}</span>,
                                No of pages: <span style="color:blue;">{{ $news['page_count'] }}</span>,
                                Circulation Figure: <span></span>, qAVE(Rs.): <span></span>
                            </p>
                            <hr>
                        @endforeach
                @endforeach
            </div>

            <div class="body-content">
                <h4 style="background-color: #6D6B6B; color: #ffffff; padding:4px;">Industry News</h4>
                @foreach ($get_client_details[0]['industry_data'] as $industry)
                    <div class="body-content">
                        <h4 style="background-color: #6D6B6B; color: #ffffff; padding:4px;">{{ $industry['industry_name'] }}</h4>
                        @foreach ($industry['news'] as $news)
                            <h5>
                                <a href="{{ $news['website_url'] }}" style="color: {{ $get_client_details[0]['content_headline_color'] }}; font-size: {{ $get_client_details[0]['content_headline_font_size'] }}px; font-family: {{ $get_client_details[0]['content_headline_font'] }};">
                                    {{ $news['head_line'] }}
                                </a>
                            </h5>
                            <h6>Summary:</h6>
                            <p style="color: {{ $get_client_details[0]['content_news_summary_color'] }}; font-size: {{ $get_client_details[0]['content_news_summary_font_size'] }}px;">
                                {{ $news['summary'] }}
                            </p>
                            <p>
                                Date: {{ date('d-m-Y', strtotime($news['create_at'])) }},
                                Publication: <span style="color:blue;">{{ $news['MediaOutlet'] }}</span>,
                                Journalist / Agency: <span style="color:blue;">{{ $news['Journalist'] ?: $news['Agency'] }}</span>,
                                Edition: <span style="color:blue;">{{ $news['Edition'] }}</span>,
                                Supplement: <span style="color:blue;">{{ $news['Supplement'] }}</span>,
                                No of pages: <span style="color:blue;">{{ $news['page_count'] }}</span>,
                                Circulation Figure: <span></span>, qAVE(Rs.): <span></span>
                            </p>
                            <hr>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="footer">
                <p>
                    <span style="color:red;">This is an auto generated email – please do not reply to this email id </span>  
                    Thank you for reading. If you have any questions, please contact us at <br>
                    <a href="mailto:customerservice@trackify.info" style="color: #ffffff;">customerservice@trackify.info</a>.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
