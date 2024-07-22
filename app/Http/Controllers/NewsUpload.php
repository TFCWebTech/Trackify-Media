<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\NewsUpload_Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\ArticalImage; 
class NewsUpload extends Controller
{
    public function index(){
        $media_type = DB::table('mediatype')
        ->select('*')   
        ->get();  
        return view('news_upload', compact('media_type'));
    }

    public function saveArticalImage(Request $request)
    {
        $response = [];

        if ($request->hasFile('image_upload')) {
            $image_data = [];

            foreach ($request->file('image_upload') as $file) {
                $file_name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $mtime = uniqid(microtime(), true);
                $uniqueid = substr(md5($mtime), 0, 8);
                $currentDate = date('Y-m-d');
                $image_upload = 'image_upload_' . $currentDate . $uniqueid . '.' . $ext;

                $path = $file->storeAs('', $image_upload, 'uploads');

                if ($path) {
                    // Insert image name into the database
                    $articalImage = ArticalImage::create([
                        'artical_images_name' => $image_upload,
                    ]);

                    $image_data[] = [
                        'image_url' => Storage::disk('uploads')->url($image_upload),
                        'article_images_id' => $articalImage->id,
                    ];
                }
            }

            if (!empty($image_data)) {
                $response['success'] = true;
                $response['image_data'] = $image_data;
            } else {
                $response['success'] = false;
                $response['error'] = 'Failed to upload files';
            }
        } else {
            $response['success'] = false;
            $response['error'] = 'No files uploaded';
        }

        return response()->json($response);
    }

    
}
