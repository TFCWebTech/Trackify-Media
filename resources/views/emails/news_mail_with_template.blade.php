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
        /* Hover underline (supported in some email clients; safe fallback elsewhere) */
        a.headline-link:hover,
        a.quick-link:hover {
            text-decoration: underline !important;
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
                        <th>Quick Links</th>
                        <th>Access Other Services</th>
                    </tr>
                    @php
                        $clientNewsCount = 0;
                        if (!empty($get_client_details[0]['client_news'])) {
                            foreach ($get_client_details[0]['client_news'] as $clientNews) {
                                if (!empty($clientNews['news']) && is_array($clientNews['news'])) {
                                    $clientNewsCount += count($clientNews['news']);
                                }
                            }
                        }

                        $competitorNewsCounts = [];
                        if (!empty($get_client_details[0]['compititors_data'])) {
                            foreach ($get_client_details[0]['compititors_data'] as $competitor) {
                                $competitorNewsCounts[] = !empty($competitor['news']) && is_array($competitor['news'])
                                    ? count($competitor['news'])
                                    : 0;
                            }
                        }

                        $industryNewsCounts = [];
                        if (!empty($get_client_details[0]['industry_data'])) {
                            foreach ($get_client_details[0]['industry_data'] as $industry) {
                                $industryNewsCounts[] = !empty($industry['news']) && is_array($industry['news'])
                                    ? count($industry['news'])
                                    : 0;
                            }
                        }

                        $anyQuickLinkRow = false;
                    @endphp

                    @if ($clientNewsCount > 0)
                        @php $anyQuickLinkRow = true; @endphp
                        <tr style="background-color:#DCD5D5;">
                            <td style="color:#ffffff;">
                                <a class="quick-link" href="#quick-client" style="color:#ffffff; text-decoration:none; display:inline-block;">
                                    {{ $details['client_name'] }} ({{ $clientNewsCount }})
                                </a>
                            </td>
                            <td><a href="{{ rtrim(config('app.url'), '/') }}/admin-login">Login</a></td>
                        </tr>
                    @endif

                    @if (!empty($get_client_details[0]['compititors_data']))
                        @foreach ($get_client_details[0]['compititors_data'] as $index => $compititor)
                            @php $count = $competitorNewsCounts[$index] ?? 0; @endphp
                            @if ($count > 0)
                                @php $anyQuickLinkRow = true; @endphp
                                <tr style="background-color:#DCD5D5;">
                                    <td style="color:#ffffff;">
                                        <a class="quick-link" href="#quick-comp-{{ $index }}" style="color:#ffffff; text-decoration:none; display:inline-block;">
                                            {{ $compititor['Competitor_name'] ?? 'Competitor' }} ({{ $count }})
                                        </a>
                                    </td>
                                    <td></td>
                                </tr>
                            @endif
                        @endforeach
                    @endif

                    @if (!empty($get_client_details[0]['industry_data']))
                        @foreach ($get_client_details[0]['industry_data'] as $i => $industry)
                            @php $count = $industryNewsCounts[$i] ?? 0; @endphp
                            @if ($count > 0)
                                @php $anyQuickLinkRow = true; @endphp
                                <tr style="background-color:#DCD5D5;">
                                    <td style="color:#ffffff;">
                                        <a class="quick-link" href="#quick-ind-{{ $i }}" style="color:#ffffff; text-decoration:none; display:inline-block;">
                                            {{ $industry['Industry_name'] ?? $industry['industry_name'] ?? 'Industry' }} ({{ $count }})
                                        </a>
                                    </td>
                                    <td></td>
                                </tr>
                            @endif
                        @endforeach
                    @endif

                    @if (!$anyQuickLinkRow)
                        <tr style="background-color:#DCD5D5;">
                            <td style="color:#ffffff;">No news available.</td>
                            <td><a href="{{ rtrim(config('app.url'), '/') }}/admin-login">Login</a></td>
                        </tr>
                    @endif
                    <tr style="background-color: #DCD5D5; color: #ffffff;">
                        <td></td>
                        <td><a href="mailto:customerservice@trackify.info">customerservice@trackify.info</a></td>
                    </tr>
                </table>
            </div>

            <div class="body-content">
                <a id="quick-client"></a>
                <h4 style="background-color: #6D6B6B; color: #ffffff; padding:4px;">{{ $details['client_name'] }}</h4>
                @php
                    $hasNews = false;
                    if (!empty($get_client_details[0]['client_news'])) {
                        foreach ($get_client_details[0]['client_news'] as $news2) {
                            if (!empty($news2['news']) && is_array($news2['news']) && count($news2['news']) > 0) {
                                $hasNews = true;
                                break;
                            }
                        }
                    }
                @endphp
                @if ($hasNews)
                    @foreach ($get_client_details[0]['client_news'] as $news2)
                        @if (!empty($news2['news']) && is_array($news2['news']))
                            @foreach ($news2['news'] as $news)
                                @php
                                    $headlineUrl = trim((string) ($news['website_url'] ?? ''));
                                    if ($headlineUrl === '' && !empty($news['news_details_id'])) {
                                        $headlineUrl = url('news-article/' . $news['news_details_id']);
                                    }
                                    if (preg_match('~^//~', $headlineUrl)) {
                                        $headlineUrl = 'https:' . $headlineUrl;
                                    } elseif ($headlineUrl !== '' && !preg_match('~^(https?://|mailto:|tel:)~i', $headlineUrl)) {
                                        $headlineUrl = 'https://' . $headlineUrl;
                                    }
                                @endphp
                                <h5>
                                    <a class="headline-link" href="{{ $headlineUrl ?: '#' }}" style="color: {{ $get_client_details[0]['content_headline_color'] }}; font-size: {{ $get_client_details[0]['content_headline_font_size'] }}px; font-family: {{ $get_client_details[0]['content_headline_font'] }}; text-decoration: none; display: inline-block;">
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
                                    Page No: <span style="color:blue;">{{ $news['page_no'] }}</span>
                                    
                                </p>
                                <hr>
                            @endforeach
                        @endif
                    @endforeach
                @else
                    <p style="text-align: center; padding: 20px; color: #666;">No news available for this company.</p>
                @endif
            </div>

            <div class="body-content">
                <h4 style="background-color: #6D6B6B; color: #ffffff; padding:4px;">Competition</h4>
                @foreach ($get_client_details[0]['compititors_data'] as $compititor)
                    <a id="quick-comp-{{ $loop->index }}"></a>
                    <h4 style="background-color: #6D6B6B; color: #ffffff; padding:4px;">{{ $compititor['Competitor_name'] }}</h4>
                    @if (!empty($compititor['news']) && is_array($compititor['news']) && count($compititor['news']) > 0)
                        @foreach ($compititor['news'] as $news)
                            @php
                                $headlineUrl = trim((string) ($news['website_url'] ?? ''));
                                if ($headlineUrl === '' && !empty($news['news_details_id'])) {
                                    $headlineUrl = url('news-article/' . $news['news_details_id']);
                                }
                                if (preg_match('~^//~', $headlineUrl)) {
                                    $headlineUrl = 'https:' . $headlineUrl;
                                } elseif ($headlineUrl !== '' && !preg_match('~^(https?://|mailto:|tel:)~i', $headlineUrl)) {
                                    $headlineUrl = 'https://' . $headlineUrl;
                                }
                            @endphp
                            <h5>
                                <a class="headline-link" href="{{ $headlineUrl ?: '#' }}" style="color: {{ $get_client_details[0]['content_headline_color'] }}; font-size: {{ $get_client_details[0]['content_headline_font_size'] }}px; font-family: {{ $get_client_details[0]['content_headline_font'] }}; text-decoration: none; display: inline-block;">
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
                                Page No: <span style="color:blue;">{{ $news['page_no'] }}</span>
                               
                            </p>
                            <hr>
                        @endforeach
                    @else
                        <p style="text-align: center; padding: 20px; color: #666;">No news available for this competitor.</p>
                    @endif
                @endforeach
            </div>

            <div class="body-content">
                <h4 style="background-color: #6D6B6B; color: #ffffff; padding:4px;">Industry News</h4>
 				@if(isset($get_client_details[0]['industry_data']) && !empty($get_client_details[0]['industry_data']))
 					@foreach ($get_client_details[0]['industry_data'] as $industry)
                        <a id="quick-ind-{{ $loop->index }}"></a>
 						<div class="body-content">
 							<h4 style="background-color: #6D6B6B; color: #ffffff; padding:4px;">{{ $industry['Industry_name'] ?? $industry['industry_name'] ?? 'N/A' }}</h4>
 							@if (!empty($industry['news']) && is_array($industry['news']) && count($industry['news']) > 0)
 								@foreach ($industry['news'] as $news)
                                    @php
                                        $headlineUrl = trim((string) ($news['website_url'] ?? ''));
                                        if ($headlineUrl === '' && !empty($news['news_details_id'])) {
                                            $headlineUrl = url('news-article/' . $news['news_details_id']);
                                        }
                                        if (preg_match('~^//~', $headlineUrl)) {
                                            $headlineUrl = 'https:' . $headlineUrl;
                                        } elseif ($headlineUrl !== '' && !preg_match('~^(https?://|mailto:|tel:)~i', $headlineUrl)) {
                                            $headlineUrl = 'https://' . $headlineUrl;
                                        }
                                    @endphp
 									<h5>
										<a class="headline-link" href="{{ $headlineUrl ?: '#' }}" style="color: {{ $get_client_details[0]['content_headline_color'] }}; font-size: {{ $get_client_details[0]['content_headline_font_size'] }}px; font-family: {{ $get_client_details[0]['content_headline_font'] }}; text-decoration: none; display: inline-block;">
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
										Page No: <span style="color:blue;">{{ $news['page_no'] }}</span>
										
									</p>
									<hr>
								@endforeach
							@else
								<p style="text-align: center; padding: 20px; color: #666;">No news available for this industry.</p>
							@endif
						</div>
					@endforeach
				@else
					<p>No industry data available.</p>
				@endif
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
