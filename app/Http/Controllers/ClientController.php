<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client_Model;
use App\Models\Competitor_Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AddUserMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index(){
       $clients = DB::table('client')
        ->leftJoin('sector', 'client.sector_id', '=', 'sector.id')  // Left Join ensures clients without a sector are included
        ->where('client.client_type', 'Company')
        ->select(
            'client.*',
            DB::raw('COALESCE(sector.sector_name, "No Sector") as sector_name')  // Fallback to "No Sector" if sector.name is null
        )
        ->get();
        $get_sector = DB::table('sector')
        ->select('*')
        ->get();
        return view('client', compact('clients','get_sector'));
    }

    public function viewClientsCompetitors($id)
{
    $client = DB::table('client')->where('client_id', $id)->first();   
    $competitors = DB::table('competitor')->where('client_id', $id)->get(); 
    return view('view_clients_competitors', compact('competitors', 'client'));
}

public function viewUser($id)
{
    $user = DB::table('users_mails')->where('client_id', $id)->get();
	$c_id =$id;
        $get_client_email = Client_Model::getClientsForEmail();
        $client_emails = [];
        $client_ids = [];

        foreach ($get_client_email as $client) {
            if (!empty($client['clients'])) {
                $clients_array = explode(',', $client['clients']);
                if (in_array($c_id, $clients_array)) {
                    $client_emails[] = ['client_email' => $client['email']];
                    $client_ids[] = $client['client_id'];
                }
            }
        }

        $client_ids = array_unique($client_ids);
        $allclients = DB::table('client')->whereIn('client_id', $client_ids)->get();
     	$client = DB::table('client')->where('client_id', $id)->first();
        return view('view_user', compact('user', 'client','allclients'));
}

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'client_name' => 'required|string|max:255',
            'Keywords' => 'required|array',
            'Keywords.*' => 'string|max:45',
            'is_active' => 'required|boolean',
            // 'Sector' is not required, so it will default to null if not present
        ]);
    
        // Process keywords
        $keywords = $request->input('Keywords');
        $keywords_string = implode(',', $keywords);
    
        try {
            // Create a new client record
            $client = Client_Model::create([
                'client_name' => $request->input('client_name'),
                'client_keywords' => $keywords_string,
                'cilent_status' => $request->input('is_active'),
                'sector_id' => $request->input('Sector') ?? null, // Default to null if not provided
                'create_at' => now(),
                'client_type' => 'Company'
            ]);
    
            return redirect()->back()->with('success', 'Client added successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to add client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add client. Please try again.');
        }
    }
	
	public function update(Request $request, $id)
	{
		// Validate the form data
		$request->validate([
			'client_name' => 'required|string|max:255',
			'Keywords' => 'required|array',
			'Keywords.*' => 'string|max:45',
			'is_active' => 'required|boolean',
		]);

		// Process keywords
		$keywords = $request->input('Keywords');
		$keywords_string = implode(',', $keywords);

		try {
			// Find the client record
			$client = Client_Model::findOrFail($id);

			// Update the client details
			$client->update([
				'client_name' => $request->input('client_name'),
				'client_keywords' => $keywords_string,
				'cilent_status' => $request->input('is_active'),
				'sector_id' => $request->input('Sector') ?? null, // Default to null if not provided
				'updated_at' => now(),
			]);

			return redirect()->back()->with('success', 'Client updated successfully.');
		} catch (\Exception $e) {
			Log::error('Failed to update client: ' . $e->getMessage());
			return redirect()->back()->with('error', 'Failed to update client. Please try again.');
		}
	}

    
    public function addCompetitor(Request $request) 
{
    // Validate the request
    $request->validate([
        'client_id' => 'required|integer',
        'Competitor_name' => 'required|string|max:255',
        'is_active' => 'required|boolean',
        'CompetetorKeywords' => 'required|array',
        'CompetetorKeywords.*' => 'string|max:255',
    ]);

    // Convert the array of keywords to a comma-separated string
    $keywords = implode(', ', $request->input('CompetetorKeywords'));

    // Prepare data for insertion
    $data = [
        'client_id' => $request->input('client_id'),
        'Competitor_name' => $request->input('Competitor_name'),
        'Keywords' => $keywords, // Simple comma-separated text format
        'is_active' => $request->input('is_active'),
    ];

    // Insert into the database
    DB::table('competitor')->insert($data);

    return redirect()->back()->with('success', 'Competitor added successfully!');
}

public function editCompetitor(Request $request)
{
    // Validate the request
    $request->validate([
        'competitor_id' => 'required|integer',
        'client_id' => 'required|integer',
        'Competitor_name' => 'required|string|max:255',
        'is_active' => 'required|boolean',
        'CompetetorKeywords' => 'required|array', // Required array
        'CompetetorKeywords.*' => 'string|max:255', // Each keyword must be a string
    ]);

    // Convert the array of keywords to a comma-separated string
    $keywords = implode(', ', $request->input('CompetetorKeywords'));

    // Prepare data for updating
    $data = [
        'client_id' => $request->input('client_id'),
        'Competitor_name' => $request->input('Competitor_name'),
        'Keywords' => $keywords, // Simple comma-separated text format
        'is_active' => $request->input('is_active'),
    ];

    // Update the competitor in the database
    $updated = DB::table('competitor')
        ->where('competitor_id', $request->input('competitor_id'))
        ->update($data);

    // Return a response
    if ($updated) {
        return redirect()->back()->with('success', 'Competitor updated successfully!');
    } else {
        return redirect()->back()->with('error', 'No changes were made or competitor not found.');
    }
}

public function updateCompetitor(Request $request)
{
    // Validate the request
    $request->validate([
        
        'competitor_name' => 'required|string|max:255',
        'is_active' => 'required|boolean',
        'competitor_keywords' => 'required|array',
        'competitor_keywords.*' => 'string|max:255', // Validate each keyword
    ]);

    // Convert keywords array to a comma-separated string
    $keywords = implode(', ', $request->input('competitor_keywords'));

    // Update the competitor in the database
    DB::table('competitor')
        ->where('competitor_id', $request->input('competitor_id'))
        ->update([
            'Competitor_name' => $request->input('competitor_name'),
            'is_active' => $request->input('is_active'),
            'Keywords' => $keywords,
        ]);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Competitor updated successfully!');
}


 public function addUsersEmail(Request $request)  
{
	
     $request->validate([
        'client_id_1' => 'required|integer',
        'client_email' => 'required|email',
        'report_service' => 'required|boolean'
    ]);

    
    $clientId = $request->input('client_id_1');
    $clientEmail = $request->input('client_email');
    $reportService = $request->input('report_service');
    $randomString = Str::random(10);

   
      $existingClient = DB::table('client')
    ->where('email', $clientEmail)
    ->Where('client_type', "User")
    ->first();
    $randomString = Str::random(10);
    if ($existingClient) {
       $clients= $existingClient->clients;
       // print_r($existingClient);die;
        $checkexistingClient = DB::table('client')
    ->where('email', $clientEmail)
    ->whereRaw("FIND_IN_SET(?, clients)", [$clientId])
    ->first();
		 $randomString = Str::random(10);
    if (!$checkexistingClient) {
       
        $existingClientData = $existingClient->clients;

    if ($existingClientData) {
        // Check if 'clients' field already contains values (it might be null or empty)
        $currentClients = $existingClientData;
       // print_r($currentClients);die;
        if ($currentClients) {
            // Split the current 'clients' list into an array
            $clientsArray = explode(',', $currentClients);
            
            // Append the new clientId (18) if it's not already in the list
            if (!in_array($clientId, $clientsArray)) {
                $clientsArray[] = $clientId;
            }
           
            // Convert the array back to a comma-separated string
            $updatedClients = implode(',', $clientsArray);
            //print_r($updatedClients);die;
        } else {
            // If no existing clients, set the new clientId as the first in the list
            $updatedClients = $clientId;
        }
        //print_r($updatedClients);die;
        // Prepare data to update in the database
        $data2 = [
            'clients' => $updatedClients,
        ];
       
        // Update the client record with the new 'clients' list
        DB::table('client')->where('client_id', $existingClient->client_id)->update($data2);
       
    }

    }}
    
    else{
       
            
             $lastInsertedId = DB::table('client')->insertGetId([
        'email' => $clientEmail,
        'clients' => $clientId,
        'client_type' => "User",  // Assuming 'User' is the default client type
        'report_service' => $reportService,
        'token' => $randomString,
    ]);
		if($reportService =="1"){
		Mail::to($clientEmail)->send(new AddUserMail($lastInsertedId,$clientEmail, $randomString));
    }


            
}
   
    $client = DB::table('users_mails')->where('users_mails', $clientEmail)->first();

    if ($client) {
       
        $data = [
            'client_id' => $clientId,
            'report_service' => $reportService,
           
        ];

        DB::table('users_mails')->where('users_mails_id', $client->users_mails_id)->update($data);

        return redirect()->back()->with('success', 'User Email updated successfully!');
    } else {
       
        $randomString = Str::random(10);

        
        DB::table('users_mails')->insert([
            'users_mails' => $clientEmail,
            'client_id' => $clientId,
            'report_service' => $reportService,
            // 'password' => bcrypt('defaultPassword'), 
            'token' => $randomString,
          
        ]);

       

       
        // Mail::to($clientEmail)->send(new AddUserMail($clientEmail, $randomString));

        return redirect()->back()->with('success', 'User Email added successfully!');
    }        
    
   


}
    public function addUsersEmail_old(Request $request)  
{
    
    $request->validate([
        'client_id_1' => 'required|integer',
        'client_email' => 'required|email',
        'report_service' => 'required|boolean'
    ]);

    
    $clientId = $request->input('client_id_1');
    $clientEmail = $request->input('client_email');
    $reportService = $request->input('report_service');

   
    $client = DB::table('users_mails')->where('users_mails', $clientEmail)->first();

    if ($client) {
       
        $data = [
            'client_id' => $clientId,
            'report_service' => $reportService,
           
        ];

        DB::table('users_mails')->where('users_mails_id', $client->users_mails_id)->update($data);

        return redirect()->back()->with('success', 'User Email updated successfully!');
    } else {
       
        $randomString = Str::random(10);

        
        DB::table('users_mails')->insert([
            'users_mails' => $clientEmail,
            'client_id' => $clientId,
            'report_service' => $reportService,
            // 'password' => bcrypt('defaultPassword'), 
            'token' => $randomString,
          
        ]);

       
        // Mail::to($clientEmail)->send(new AddUserMail($clientEmail, $randomString));

        return redirect()->back()->with('success', 'User Email added successfully!');
    }
}



	public function editUsersEmail(Request $request)
{
    // Validate the request
    // $request->validate([
    //     'client_id' => 'required|integer',
    //     'email' => 'required|email',
    //     'report_service' => 'required|boolean',
    // ]);
   
    // Retrieve data from the request
    $userId = $request->input('client_id');
    $userEmail = $request->input('users_mails');
    $reportService = $request->input('report_service');
   
    // Update the user record in the database
    $updated = DB::table('client')->where('client_id', $userId)->update([
        'email' => $userEmail,
        'report_service' => $reportService,
    ]);

    // Return with a success or error message
    if ($updated) {
        return redirect()->back()->with('success', 'User details updated successfully!');
    } else {
        return redirect()->back()->with('error', 'Failed to update user details. Please try again.');
    }
}

    public function ganerateUserPassword(Request $request, $id, $token){
        $User = Client_Model::findOrFail($id);

        // Check if the token matches
       
        $userId = $User->client_id;
        $userEmail = $User->email;
        return view('emails.set_user_password', compact('User'));
    }
    public function setPassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'client_id' => 'required|integer|exists:client,client_id',
            'password1' => 'required|string|min:6',
            'password2' => 'required|string|same:password1', // Ensure passwords match
            'token' => 'required|string' // Ensure token is present
        ]);
    
        // Retrieve the user by client_id and token
        $User = Client_Model::where('client_id', $request->input('client_id'))
                            ->where('token', $request->input('token'))
                            ->first();
    
        // Check if user exists and token matches
        if (!$User) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    
        // Update the password securely
        $User->password = Hash::make($request->input('password1'));
        // Invalidate the token after password reset
        $User->token = null;
        $User->save(); // Save the changes
    
        return redirect()->route('ClientLogin')->with('success', 'Password updated successfully! Please log in.');
    }
}
