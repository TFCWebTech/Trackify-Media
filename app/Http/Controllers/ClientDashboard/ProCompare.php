<?php

namespace App\Http\Controllers\ClientDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client_Model;
use App\Models\clientDashboard\Report;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProCompare extends Controller
{
    protected $Report;
    protected $Client_Model;
    public function __construct(Client_Model $Client_Model, Report $Report)
    {
        $this->Report = $Report;
        $this->Client_Model = $Client_Model;
    }

    // public function index(){
    //     return view('ClientDashboard.compare_charts');
    // }

    public function index(Request $request, $from = null, $to = null)
    {
        set_time_limit(90);

        $client_id = $request->session()->get('client_id');
        $clients = $request->session()->get('clients');
        $client_ids = explode(',', $clients);

        // Fetch competitors' data
        $competitors_data = [];
        foreach ($client_ids as $id) {
            $comp_data = $this->Report->getCompDataM('daily', $id, $from, $to, '');
            $competitors_data = array_merge($competitors_data, $comp_data);
        }

        // Get news count and average for the current client
        $clients_news_count = $this->Report->getClientNewsCount('daily', $client_id, $from, $to);

        // Prepare data structure for the current client
        $client_data = [
            'label' => $request->session()->get('client_name'),
            'count' => $clients_news_count['news_count'],
            'ave' => $clients_news_count['total_ave'],
        ];

       
        // Append the current client's data to the competitors' data array
        $competitors_data[] = $client_data;

        // Initialize arrays to hold the combined data for each client
        $media_data = [];
        $publication_data = [];
        $geography_data = [];
        $journalist_data = [];
        $ave_data = [];
        $size_data = [];

        foreach ($client_ids as $id) {
            $media_data = array_merge($media_data, $this->Report->getMediaData('daily', $id, $from, $to));
          
        }

        $data = [
            'get_quantity_compare_data' => $competitors_data,
            'media_data' => $media_data,
            'publication_data' => $publication_data,
            'geography_data' => $geography_data,
            'journalist_data' => $journalist_data,
            'ave_data' => $ave_data,
            'size_data' => $size_data,
            // 'clients' => $this->newsData->getClients($client_ids)
        ];

        // echo '<pre>';
        // print_r($client_data);
        // echo '</pre>';

        return view('ClientDashboard.compare_charts', $data);
    }
}
