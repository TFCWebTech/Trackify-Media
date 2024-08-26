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
class ClientController extends Controller
{
    public function index(){
        $clients = DB::table('client')
        ->where('client_type','Company')
        ->select('*')
        ->get();
      
        return view('client', compact('clients'));
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
    
    public function addCompetitor(Request $request)
    {
        // Validate the form data
        $request->validate([
            'Competitor_name' => 'required|string|max:255',
            'client_id' => 'required|integer',
            'CompetetorKeywords' => 'required|array',
            'CompetetorKeywords.*' => 'string|max:45',
            'is_active' => 'required|boolean',
            // 'Sector' is not required, so it will default to null if not present
        ]);

        // Process keywords
        $keywords = $request->input('CompetetorKeywords');
        $keywords_string = implode(',', $keywords);

        try {
            // Create a new competitor record
            $competitor = Competitor_Model::create([
                'Competitor_name' => $request->input('Competitor_name'),
                'client_id' => $request->input('client_id'),
                'is_active' => $request->input('is_active'),
                'Keywords' => $keywords_string,  // Fixed the typo here
            ]);

            return redirect()->back()->with('success', 'Competitor added successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to add competitor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add competitor. Please try again.');
        }
    }

    public function addUsersEmail(Request $request)
    {
        // Validate the request
        $request->validate([
            'client_id_1' => 'required|integer',
            'client_email' => 'required|email',
            'report_service' => 'required|string'
        ]);

        // Retrieve posted data
        $clientId = $request->input('client_id_1');
        $clientEmail = $request->input('client_email');
        $reportService = $request->input('report_service');

        // Retrieve client email data from the database
        $client = Client_Model::where('email', $clientEmail)->first();

        if ($client) {
            $existingClientId = $client->client_id;
            $clients = $client->clients;

            // Merge the new client_id with the existing clients
            $clientsArray = explode(',', $clients);
            if (!in_array($clientId, $clientsArray)) {
                $clientsArray[] = $clientId;
            }
            $updatedClients = implode(',', $clientsArray);

            // Prepare data for updating
            $data = [
                'email' => $clientEmail,
                'client_type' => 'User',
                'report_service' => $reportService,
                'clients' => $updatedClients,
            ];

            // Update the client record
            Client_Model::where('client_id', $existingClientId)->update($data);
            return redirect()->back()->with('success', 'User Mail added successfully!');
        } else {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';

            for ($i = 0; $i < 10; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }

            $userEmail = Client_Model::create([
                'email' => $clientEmail,
                'client_type' => 'User',
                'report_service' => $reportService,
                'clients' => $clientId,
                'token' => $randomString,
                'create_at' => now()
            ]);

            Mail::to($clientEmail)->send(new AddUserMail($userEmail->client_id, $clientEmail, $randomString));

            return redirect()->back()->with('success', 'Email added successfully!');
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
    
        return redirect()->route('login')->with('success', 'Password updated successfully! Please log in.');
    }
}
