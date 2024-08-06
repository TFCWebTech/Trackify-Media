<!DOCTYPE html>
<html lang="en">
<head>
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
    </style>
</head>
<body>
    <div class="containers" >
        <div class="card">
            <table width="100%" cellpadding="0" cellspacing="0" style="width:100%; background-color: ; margin-top:10px;">
                <tr>
                    <td align="left" style="padding-top:50px; margin-right:5px;">   
                    </td>
                    <td align="center" style="margin-top:5px;">
                        {{ $details['client_name'] }} <br>
                        From: {{ date('d-m-Y', strtotime($from_date)) }} To: {{ date('d-m-Y', strtotime($to_date)) }}
                    </td>
                    <td align="right"></td>
                </tr>
            </table>
            <hr>
            @if (!empty($get_client_details))
                @foreach ($get_client_details as $news)
                    <h3>
                        <a href="{{ $news['website_url'] }}">
                            {{ $news['head_line'] }}
                        </a>
                    </h3>
                    <p>
                        Date: <span style="color:blue;">{{ date('d-m-Y', strtotime($news['create_at'])) }}</span>,
                        Publication: <span style="color:blue;">{{ $news['MediaOutlet'] }}</span>,
                        Journalist / Agency: <span style="color:blue;">{{ $news['Journalist'] }}</span>,
                        Edition: <span style="color:blue;">{{ $news['Edition'] }}</span>,
                        Supplement: <span style="color:blue;">{{ $news['Supplement'] }}</span>,
                        No of pages: <span style="color:blue;">{{ $news['page_count'] }}</span>,
                        Circulation Figure: <span></span>,
                        qAVE(Rs.): <span></span>
                    </p>
                    <p> <strong>Summary:</strong> </p>
                    <span>
                        @if (!empty($news['News_artical']))
                            @foreach ($news['News_artical'] as $article)
                                <span>{{ strip_tags($article['news_artical']) }}</span>
                            @endforeach
                        @endif
                    </span>
                    <hr>
                @endforeach
            @else
                <p>No record found</p>
            @endif
        </div>
    </div>
</body>
</html>
