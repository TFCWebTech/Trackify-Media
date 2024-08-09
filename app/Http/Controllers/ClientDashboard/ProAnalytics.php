<?php

namespace App\Http\Controllers\ClientDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\clientDashboard\Pro_Analytics_Model;
class ProAnalytics extends Controller
{
    protected $Pro_Analytics_Model;

    public function __construct(Pro_Analytics_Model $Pro_Analytics_Model )
    {
        $this->Pro_Analytics_Model = $Pro_Analytics_Model;
    }
    public function index(){
        $client_list = DB::table('client')
        ->select('*')
        ->where('client_type', 'Company')
        ->get();
        return view('ClientDashboard.analytics_charts', compact('client_list'));
    }

    public function fetchAnalyticsData(Request $request)
    {
        $client_id = $request->input('select_client');
        $from = null; // Define $from as needed
        $to = null; // Define $to as needed

        $data = [
            'quantity_graph_daily' => $this->Pro_Analytics_Model->getDataByTimeframe('daily', $client_id, $from, $to),
            'quantity_graph_weekly' => $this->Pro_Analytics_Model->getDataByTimeframe('weekly', $client_id, $from, $to),
            'quantity_graph_monthly' => $this->Pro_Analytics_Model->getDataByTimeframe('monthly', $client_id, $from, $to),
        
            'media_graph_daily' => $this->Pro_Analytics_Model->get_media_data_by_timeframe_by_id('monthly', $client_id, $from, $to),
            'media_graph_weekly' => $this->Pro_Analytics_Model->get_media_data_by_timeframe_by_id('monthly', $client_id, $from, $to),
            'media_graph_monthly' => $this->Pro_Analytics_Model->get_media_data_by_timeframe_by_id('monthly', $client_id, $from, $to),
        ];

        return response()->json($data);
    }
}
