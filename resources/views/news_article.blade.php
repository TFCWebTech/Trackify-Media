@include('common\header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<style>
.lightbox {
    display: none;
    position: fixed;
    z-index: 999;
    width: 100%;
    height: 100%;
    text-align: center;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.8);
}

.lightbox img {
    max-width: 90%;
    max-height: 80%;
    margin-top: 2%;
}

.lightbox:target {
    /* Show the lightbox */
    display: block;
}
.close {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 3em;
    color: #fff;
    text-decoration: none;
}

.thumbnail {
    max-width: 180px;
}

.thumbnail-wrapper {
    display: flex;
    align-items: left;
    justify-content: center;
}
body {
    background-color: #fbffdd;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
        /* CSS to temporarily hide elements */
        /* .no-pdf {
            display: none;
        } */
        /* .show_in_pdf {
            display: none;
        } */
#generatePDF {
            background-color: #0080FF ;
            color: #ffffff;
            border-color: #0080FF ;
            border-radius: 5px;
        }
        #wrapper #content-wrapper #content-2 {
    flex: 1 0 auto !important;
}
       
</style>
  <!-- Include Font Awesome for icons -->
  <div class="container">
    <div class="row no-pdf">
        <div class="col-md-12 text-right mb-2">
            <button id="generatePDF"><i class="fa fa-download"></i></button>
        </div>
    </div>
    <div class="card no-pdf">
    @if (!empty($newsDetail))
    <div class="row p-2">
        <div class="col-md-12 pt-1"> 
            <h5 style="color:blue;">
                <a href="{{ $newsDetail['website_url'] }}">{{ $newsDetail['head_line'] }}</a>
            </h5>
            <label for="">Summary</label> <br>
            <p>{{ $newsDetail['summary'] }}</p>
            <p>
                Publication: <span style="color:blue;">{{ $newsDetail['media_outlet']['MediaOutlet'] }}</span>, 
                Journalist / Agency: <span style="color:blue;">{{ $newsDetail['journalist']['Journalist'] ?? $newsDetail['agency']['Agency'] }}</span>, 
                Edition: <span style="color:blue;">{{ $newsDetail['edition']['Edition'] }}</span>, 
                Supplement: <span style="color:blue;">{{ $newsDetail['supplement']['Supplement'] }}</span>
                @if (!empty($newsDetail['news_articles']) && isset($newsDetail['news_articles'][0]['page_no']))
                    , Page No: <span style="color:blue;">{{ $newsDetail['news_articles'][0]['page_no'] }}</span>
                @endif
                , Circulation Figure:<span> </span>, qAVE(Rs.):<span> </span> Date: <span style="color:blue;">{{ $newsDetail['create_at'] }}</span>
            </p>
            <hr>
        </div>
    </div>
    @foreach ($newsDetail['news_articles'] as $index => $article)
        @php
            $lightboxId = "img" . $index;
            $imageUrl = !empty($article['article_images']['artical_images_name']) ? asset('storage/uploads/' . $article['article_images']['artical_images_name']) : '';
        @endphp
        <div class="row p-2">
            <div class="col-md-3">
                @if (!empty($article['article_images']['artical_images_name']))
                    <div class="download-icon text-right px-4">
                        <a href="{{ $imageUrl }}" download>
                            <i class="fa fa-download text-primary" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="thumbnail-wrapper">
                        <a href="#{{ $lightboxId }}" aria-label="Click to enlarge image">
                            <img src="{{ $imageUrl }}" class="thumbnail" alt="Thumbnail Image">
                        </a>
                    </div>
                    <div id="{{ $lightboxId }}" class="lightbox">
                        <a href="#" class="close">&times;</a>
                        <img src="{{ $imageUrl }}" alt="Popup Image">
                    </div>
                @endif
            </div>
            <div class="col-md-9 pt-1">
            <h6>{{ strip_tags($article['news_artical']) }}</h6>
            </div>
        </div>  
        <hr>
    @endforeach
@endif
        <div class="card" id="content-2" style="display:none;">
            @if (!empty($newsDetail))
                <div class="row p-2">
                    <div class="col-md-12 pt-1"> 
                        <h5 style="color:blue;"><a href="{{ $newsDetail['website_url'] }}">{{ $newsDetail['head_line'] }}</a></h5>
                        <label for="">Summary</label> <br>
                        <p>{{ $newsDetail['summary'] }}</p>
                        <p>
                            Publication: <span style="color:blue;">{{ $newsDetail['media_outlet']['MediaOutlet'] }}</span>, 
                            Journalist / Agency: <span style="color:blue;">{{ $newsDetail['journalist']['Journalist'] ?? $newsDetail['agency']['Agency'] }}</span>, 
                            Edition: <span style="color:blue;">{{ $newsDetail['edition']['Edition'] }}</span>, 
                            Supplement: <span style="color:blue;">{{ $newsDetail['supplement']['Supplement'] }}</span>
                            @if (!empty($newsDetail['news_articles']))
                                , Page No: <span style="color:blue;">{{ $newsDetail['news_articles'][0]['page_no'] }}</span>
                            @endif
                            , Circulation Figure:<span> </span>, qAVE(Rs.):<span> </span> Date: <span style="color:blue;">{{ $newsDetail['create_at'] }}</span>
                        </p>
                        <hr>
                    </div>
                    @foreach ($newsDetail['news_articles'] as $index => $article)
                    @php
                        $lightboxId = "img" . $index;
                        $imageUrl = !empty($article['artical_images_name']) ? asset('storage/uploads/' . $article['artical_images_name']) : '';
                    @endphp
                        <div class="col-md-12 pt-1">
                            <h6>{{ $article['news_artical'] }}</h6>
                        </div>
                        <hr>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
</div>
    <!-- Include html2pdf.js -->
<script>
        lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>
   
<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script>
    document.getElementById('generatePDF').addEventListener('click', function() {
        var element = document.getElementById('content-2');
        var show_in_pdf = document.querySelectorAll('#show_in_pdf');

        element.style.display = 'block';
        // Hide header and footer and show PDF-specific content
        document.querySelectorAll('.no-pdf').forEach(function(el) {
            el.style.display = 'none';
        });
        show_in_pdf.forEach(function(el) {
            el.style.display = 'block';
        });

        var opt = {
            margin: [0, 0, 0, 0],
            filename: 'document.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
            pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
        };

        html2pdf().from(element).set(opt).save().then(function() {
            // Restore header and footer and hide PDF-specific content
            document.querySelectorAll('.no-pdf').forEach(function(el) {
                el.style.display = 'block';
            });
            element.style.display = 'none';
            show_in_pdf.forEach(function(el) {
                el.style.display = 'none';
            });
        });
    });
    </script>
    @include('common\footer')