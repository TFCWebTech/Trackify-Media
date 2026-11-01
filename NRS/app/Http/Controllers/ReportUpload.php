<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Reporter;
class ReportUpload extends Controller
{
    //
    public function index(){
        return view('report_upload');
    }

    public function addArtical(Request $request)
    {
        $validation = [
            'media_type' => ['required'],
            'publication' => ['required'],
            'edition' => ['required'],
            'SupplementId' => ['required'],
            'publication_date' => ['required'],
            'journalist_name' => ['required'],
            'journalist_email' => ['required', 'email'],
            'author' => ['required'],
            'page_no' => ['required', 'numeric'],
            'width' => ['required', 'numeric'],
            'Height' => ['required', 'numeric'],
            'AgencyId' => ['required'],
            'NewsPositionId' => ['required'],
            'NewsCityID' => ['required'],
            'category' => ['required'],
            'current_time' => ['required'],
            'Duration' => ['required'],
        ];

        $validator = Validator::make($request->all(), $validation);
        
        if ($validator->fails()) {
            // Return back with error messages
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                $reporter_upload = new Reporter;
                $reporter_upload->media_type = $request['media_type'];
                $reporter_upload->publication = $request['publication'];
                // $reporter_upload->edition = $request['edition'];
                // $reporter_upload->supplement = $request['SupplementId'];
                // $reporter_upload->publication_date = $request['publication_date'];
                // $reporter_upload->journalist_name = $request['journalist_name'];
                // $reporter_upload->journalist_email = $request['journalist_email'];
                // $reporter_upload->author = $request['author'];
                // $reporter_upload->page_no = $request['page_no'];
                // $reporter_upload->width = $request['width'];
                // $reporter_upload->height = $request['Height'];
                // $reporter_upload->agency_id = $request['AgencyId']; 
                // $reporter_upload->news_position = $request['NewsPositionId'];
                // $reporter_upload->news_city = $request['NewsCityID'];
                // $reporter_upload->category = $request['category'];
                // $reporter_upload->time = $request['current_time'];
                // $reporter_upload->duration = $request['Duration'];
               
                $reporter_upload->save();
                 
                // Success message
                return redirect()->back()->with('success', 'Article added successfully.');
            } catch (\Exception $e) {
                // Error message
                return redirect()->back()->with('error', 'Failed to add article. ' . $e->getMessage());
            }
        }
    }

    public function reporterOldUpload(){
        return view('report_upload');
    }
}
