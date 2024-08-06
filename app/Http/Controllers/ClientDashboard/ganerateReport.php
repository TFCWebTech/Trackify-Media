<?php

namespace App\Http\Controllers\ClientDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client_Model;
use App\Models\NewsUpload_Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use TCPDF;
class ganerateReport extends Controller
{
    public function index(){
        $client_list = DB::table('client')
        ->select('*')
        ->where('client_type', 'Company')
        ->get();

        $publication_type = DB::table('publicationtype')
        ->select('*')
        ->get();

        $news_cities = DB::table('newscity')
        ->select('*')
        ->get();
        return view('ClientDashboard.ganerate-report', compact('client_list','publication_type','news_cities'));
    }

   
    public function getNewsArticleData(Request $request)
    {
        try {
            // Collect necessary POST data
            $select_client = $request->input('select_client');
            $from_date = $request->input('from_date');
            $to_date = $request->input('to_date');
            $publication_type = $request->input('publication_type');
            $Cities = $request->input('Cities');

            $details = $this->getClientById($select_client);
            $get_client_details = $this->getNewsDetails3($select_client, $from_date, $to_date, $publication_type, $Cities);

            $data = [
                'details' => $details,
                'get_client_details' => $get_client_details,
                'from_date' => $from_date, // Pass the from_date to the view
                'to_date' => $to_date // Pass the to_date to the view
            ];

            // Create PDF object
            $pdf = new TCPDF();

            // Set properties of the PDF
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle('Your PDF Title');

            // Load the view file into HTML
            $html = view('ClientDashboard.dowload_pdf', $data)->render(); // Assuming 'dowload_pdf.blade.php' is your view file

            // Add a page to the PDF
            $pdf->AddPage();

            // Set font
            $pdf->SetFont('times', 'N', 12);

            // Add the HTML content to the PDF
            $pdf->writeHTML($html, true, false, true, false, '');

            // Save the PDF to a folder on the server
            $pdfPath = public_path('download_pdf/'); // Ensure 'download_pdf' folder exists and is writable
            if (!is_dir($pdfPath)) {
                mkdir($pdfPath, 0777, true); // Create directory if it doesn't exist
            }
            $pdfName = 'downloaded_pdf.pdf'; // Name of the PDF file
            $outputPath = $pdfPath . $pdfName;

            // Save PDF to file
            $pdf->Output($outputPath, 'F');

            // Prepare response for AJAX
            $response = [
                'success' => true,
                'pdf_url' => url('download_pdf/' . $pdfName) // URL to download the PDF
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error generating PDF: ' . $e->getMessage());
            // Return a JSON response with the error
            return response()->json(['success' => false, 'error' => 'Error generating PDF.']);
        }
    }

    public function getClientById($client_id)
    {
        return Client_Model::find($client_id);
    }

    public function getNewsDetails3($client_id, $from_date = null, $to_date = null, $publication_type = null, $Cities = null)
    {
        $query = NewsUpload_Model::select('news_details.*', 'mediaoutlet.*', 'edition.gidEdition', 'edition.Edition', 'supplements.gidSupplement', 'supplements.Supplement', 'journalist.gidJournalist', 'journalist.Journalist')
            ->distinct()
            ->leftJoin('mediaoutlet', 'news_details.publication_id', '=', 'mediaoutlet.gidMediaOutlet')
            ->leftJoin('edition', 'news_details.edition_id', '=', 'edition.gidEdition')
            ->leftJoin('supplements', 'news_details.supplement_id', '=', 'supplements.gidSupplement')
            ->leftJoin('journalist', 'news_details.journalist_id', '=', 'journalist.gidJournalist')
            ->where('news_details.is_send', '1');

        if ($from_date && $to_date) {
            $query->whereBetween('news_details.create_at', [$from_date, $to_date]);
        }

        if ($Cities) {
            $query->where('news_details.news_city_id', $Cities);
        }

        $query->where(function ($query) use ($client_id) {
            $query->where('news_details.company', 'LIKE', '%' . $client_id . '%');
        });

        $query->whereNotExists(function ($query) use ($client_id) {
            $query->select(DB::raw(1))
                ->from('delete_news')
                ->whereRaw('delete_news.news_details_id = news_details.news_details_id')
                ->where('delete_news.client_id', $client_id);
        });

        $result = $query->get();

        // Fetch quick links for each mail template
        foreach ($result as $News) {
            $News->News_artical = $News->newsArticles()->get();
        }
        return $result;
    }

    public function getNewsArticleInword(Request $request)
    {
        $select_client = $request->input('select_client');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $publication_type = $request->input('publication_type');
        $Cities = $request->input('Cities');
    
        // Get client details
        $details = $this->getClientById($select_client);
    
        // Get news details
        $get_client_details = $this->getNewsDetails3($select_client, $from_date, $to_date, $publication_type, $Cities);
    
        // Check if details object has the name property
        if ($details) {
            $client_name = $details->client_name; // Ensure 'name' is the correct field
        } else {
            $client_name = 'Unknown Client';
        }
    
        // Prepare data for the response
        $data = [
            'details' => [
                'client_name' => $client_name // Ensure clientName is properly passed
            ],
            'get_client_details' => $get_client_details,
            'from_date' => $from_date,
            'to_date' => $to_date
        ];
    
        return response()->json($data);
    }
}
