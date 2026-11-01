<?php

namespace App\Http\Controllers\ClientDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\clientDashboard\Pro_Compare_model;
use App\Models\clientDashboard\Report;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProCompare extends Controller
{
    protected $Report;
    protected $Pro_Compare_model;
    public function __construct(Pro_Compare_model $Pro_Compare_model, Report $Report)
    {
        $this->Report = $Report;
        $this->Pro_Compare_model = $Pro_Compare_model;
    }

    public function index(){
        $client_list = DB::table('client')
        ->select('*')
        ->where('client_type', 'Company')
        ->get();
        return view('ClientDashboard.compare_charts', compact('client_list'));
    }

    public function fetchClientData(Request $request)
{
    $client_id = $request->input('select_client');
    $from_date = $request->input('from_date');
    $to_date = $request->input('to_date');

    $from = $from_date ?: null;
    $to = $to_date ?: null;

    // Get client name and news count
    $client_name_array = $this->Pro_Compare_model->getClientName($client_id);
    $client_name = $client_name_array ? $client_name_array->client_name : '';
    $clients_news_count = $this->Pro_Compare_model->getClientNewsCount('daily', $client_id, $from, $to);

    // Prepare data structure for the current client
    $client_data = [
        'label' => $client_name, // Use the fetched client name
        'count' => $clients_news_count['news_count'],
        'ave' => $clients_news_count['total_ave'],
    ];

    // Get competitors data
    $competitors_data = $this->Pro_Compare_model->getCompDataQ('daily', $client_id, $from, $to);
    $competitors_data[] = $client_data; // Append client data to competitors' data

    // Initialize arrays to hold the combined data for each client
    $media_data = $this->Pro_Compare_model->getMediaDataByID('daily', $client_id, $from, $to);
    $publication_data = $this->Pro_Compare_model->getPublicationDataByID('daily', $client_id, $from, $to);
    $geography_data = $this->Pro_Compare_model->getGeographyDataByID('daily', $client_id, $from, $to);
    $journalist_data = $this->Pro_Compare_model->getJournalistDataByID('daily', $client_id, $from, $to);
    $ave_data = $this->Pro_Compare_model->getAVEDataByID('daily', $client_id, $from, $to);
    $size_data = $this->Pro_Compare_model->getSizeDataCompByID('daily', $client_id, $from, $to);

    // Prepare response data
    $data = [
        'get_quantity_compare_data' => $competitors_data, // Correct variable name used here
        'media_data' => $media_data,
        'publication_data' => $publication_data,
        'geography_data' => $geography_data,
        'journalist_data' => $journalist_data,
        'ave_data' => $ave_data,
        'size_data' => $size_data,
    ];

    // Return JSON response
    return response()->json($data);
}

}
