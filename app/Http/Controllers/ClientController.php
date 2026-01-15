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

            if($client){
                $template = $this->AddTemplate($client->client_id);
            }
    
            return redirect()->back()->with('success', 'Client added successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to add client: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add client. Please try again.');
        }
    }

    public function AddTemplate($clientId)
    {
        
        // $clientId = $request->input('client_id'); // only dynamic value

        // Set static/default values for all fields
        $staticData = [
            'trackify_link_status' => '1',
            'trackify_link' => 'trackifymedia.com',
            'menu_background_color' => '#795492',
            'menu_font_color' => '#000000',
            'menu_font' => 'Times New Roman',
            'menu_font_size' => '18',
            'menu_row_background' => '#8f50b9',
            'menu_row_font_color' => '#000000',
            'menu_row_font' => 'Times New Roman',
            'menu_row_font_Size' => '18',
            'menu_no_news_text' => 'Yes',
            'quick_links' => 'null',
            'quick_links_url' => 'null',
            'quick_links_position' => 'null',
            'header_background_color' => '#795492',
            'header_logo_url' => 'https://pressbro.com/News/assets/img/mediaLogo.png',
            'logo_position' => 'Left',
            'header_title_name' => 'TATA MOTERS',
            'header_title_font_color' => '#000000',
            'header_title_font_size' => '18',
            'content_category' => 'null',
            'content_publication' => '00e4ec4bfb1c95d3c971f8725f4b70ab1784f92f,01ccf0812277874a28801e249e318ca6bfcd7514,01D99B9A-82CF-4549-BFD3-19384690F02E,0249fe768ed025f39a1fc2f214c19b101227c451,0280e93c705dd016250f44354cbb4bbc4d545464,04b73e5859cabcabfef27ce6dd9cc4d6d0858017,06dd3146bc20dfb7870b8ca01e641aa48f0a9980,072685fecd36a4d8d06a3b9eeb4abe8aa286c29f,080fe6467de9aa7149faf7bcca33c1a266d62cc8,09196139b479788616556b71841b674d1204795c,0a8016d296bf2b299209b359424a26a884419898,0a8c794e5fb868cfd6fa3b88c7ecc2476d440b0f,0CF6333D-C367-4D67-A961-E2FF0C90CBA3,0e6d085ea642d86a08f35ec1077f172de6ebabac,0fa9fde8e323daa039f7f5a2ebc54099ac715fa5,103aadc8defcdf518a651013ac3f83217e55038d,107879ac4a85ff804e3ae00477b2029f2b956368,10975547cc9ebc59eb9894d401a09d582583c06f,1206a8ea87e5c0fd44e476b5ebad54ecb6c382be,12e94a51bf75cb375cf9a2ec27cf48d34042a073,183134e00f691b7a5c0c7e5f7625d8c9e0fe3bee,183217fdcb19d0b710999870c342f69931c9249c,1A4FDF35-CB4B-4FB2-9464-B036CB724F3A,1b7685b5bbc5f776e72708418a1d478995f2d460,1c07fdf0cd2767b3bafeaed00a3441f6aeb17c2d,1D435B2E-1F43-4AEE-8C9E-B80E9A45D5C7,20fbbfec8621eebca73f526dbe222919fe18af1c,246E5106-6B3F-4618-A013-9E115A7FC77E,280aafc55516274cac7a6afb112b941fffedd7f0,28f1c70a43f52f461fcfa940a185dba9821ab543,29110361778f176cfcb53053cbe14fa0c8c60ab7,29AEF2F1-1138-46DE-B066-7ACF16F7D378,2a8fb2810e1077c7c2363076a1077709bf44baa6,2cd9232dcce77f62b4b937e42ef7209a1ae3647e,2cf5e63240c590d8f912f6c290592d97f0497207,30850656-FB1B-4086-B4B7-787259E8B479,3131d77a2c9c7b2e896fac9afe1576a174d2cbf2,33BD66B9-D2B9-481B-9EE0-30A24B590A04,3486B909-EAB3-411B-AC45-F4D32FF5A048,363ac223159eb06687d9249c5c3f7104407f2673,37D3B646-CB26-4C3E-9D65-F9C3EEA17D4C,38083316dfc57d20ba18fee2a7d941c48b5f539d,3811872C-0833-4B8E-9AC2-19FE8F8BA00F,3931ab79aa91f96502214df93cddb87d2d346490,3aea892cee79dad4ed319fe31264e77226e89255,3c8ae1b84353e1b2c270d9bf168516b05cf881b3,3d1efddc006d63206a675e8a4a32dbfc78d888f8,3d8e33e5aa0a739725b465eac26bd035c849d991,3e7d15863b911ba98e0011e5142524b954678353,3e9a3c99c0ab909a0f1bb793e6796370922816b8,40678C76-B04D-4243-9660-364287C3CDEA,40B21417-431D-4899-9394-78BD3B7C9C59,427d335f9a86943d855e7a7b53cb86c68dc1e3ff,42c080445dfccd5a222febf6aaee06fa7b5d9de4,4584b0421b3f311d5d7812028f5dc4b3ef92c505,45978C74-E3BF-41A3-A057-0D2A1AF1A521,46019fe8b9ba37896d220b9ecead8583f4a7f799,4878be7bb028027f383cb86507c866318ad1f4e8,48d1499714d7a29739eb47087241f701ca40c6e2,4a801e85e01f260e0680cf5fd20d9df0b83fbda6,4b53eb61b1744ba5fb05a711f8a509b73055c0e9,4b6edc456e5a4755b4ba889a49632848348bfa6c,4C41682D-D94A-4D18-A871-CA3063FC0F9C,4C604CF7-C7CB-4998-B56E-9D024FABBDCB,4cabdb37853d369ef559f389f71b009c0c374021,4d44503e8b1f7bbe4cd6218a6d027579cb96ed98,5029721acea1db17c82ff39d3406b520bfb7b6f3,50c906e611d0648e4d883313e752256072e87884,52a969e4fd9d5dc3e3a68f8556c8cdbeacaaaf90,52bf5e9f031c2e20a52055661412b107ea0e4a3d,54a9e29993997822be8ab57b3c701ae2349ab771,55618a7d2be4bdf94aac25740bf4861fb772d07b,559f3af2414c075618c976ab335205e178d16ba8,564c922509737cab9228c5e37a3b64dc8db0147a,5806d7bed84114fe2231dc96d1b85c56def2bc8c,59af9ddf09b9b830419101ab3dfbc1bb7b0c88f0,5D5C62CA-8380-4A70-86DC-74A51955A91C,60F43916-315A-4F58-9B05-23873B089466,6436E632-D819-4F90-A922-7B00BB6F73FC,657C5E9E-A463-48F0-A9A8-4079D3E7B47B,65845241d072594b8d8868aeba810a2603bff98b,67412526836fe5215b9ba92243deaff39bc74e81,67ccec1baabfc4a23f548ca3a28fa702657cabb8,69acb5b1a0d13e0615cda5c38b6987001cd206a3,6B810D45-65D9-4633-AD8C-919578E359CB,71154c69460ea7df5f7b56140d02a56b86941c8d,736bd6f2d6eaa337c444ad87531638ae2d61a19c,74602749-0218-4E48-87CF-6BDA24E54A81,787B3392-1682-4BC1-BCE3-6A5644A24C46,7B06CFB5-3A0D-4264-918D-66AA32DD5B7B,7cb2ba5b47b7a34bd50248df55ee9ded9e9e31fb,7d2aa268f00b9dd4cd04bb1c15e95102a2c6e68c,7d725659ff53aeda52bd1805cbce5e0d2eb4ee05,7e8f13e4eb52b25e2c2956d80300b3da0bc84b8b,813b775e8261bb09fdd72c73feeef3318eb85687,82582A95-D595-4731-9E1E-8F8B92D04DCB,82d454184200260633784d3f140b2f2adc0b0bd5,844ab7fde4ebcb9d4e148a6120c1f3a7d2aa16cf,846994fd77724868888a13de2adbf97162193c31,84eb2ed9ab262b8ea5025f99c46f4cf304e4847b,84fcbd0f9e0ca3c04e938ed943cb7da8a53b3555,878b7511f89620fcc4b9caea742b7136981762dd,88b2cc4ec6436b81decd129383b1ca54664aecaf,89397317-C76B-45E8-A72A-A1B475FC7CC3,8a6a62c296e67bb3c3648ac69c500bb39025d9d9,8b70c614dc4467a88bf92ef1f753b58a0477d113,8bb38fedb1c806bbf4c9f7892d77b990b3f8dfd5,8D142492-3F08-468E-9D18-80FA34997C47,8d3c9a8703562d9cb4488ef92a9ea750e92ea70d,8e88360742df0f3a341dc710d8d05cc901a60e4d,8efdf195c6bfe99f11891f5d672463638fbb034a,909077f50c0d08d4d65a1b4251b4596171c68124,90f25fda96892f6e56829b91408fe816899a6b9d,913B6237-BF43-4A91-A039-3BE020553FDF,918d99e031371a1ecfbb9215d7c35a70f3d1dd9b,93a2659ab7d1771ea66cd13ea0fe5ae49404d3e3,9405f876f518117a1bbdf423155443a339df83c1,942B0695-158C-46C3-8501-65BACAB177D3,99139e136154eb4ac0a003ad517d11ac4b17f23f,9ada01ca6f5a23646bb76842575d327f644a1df8,9bef6def4073a6e2d9fcd8c387cb7bf0ebe12be9,9C992029-C440-46C0-A783-6538A386588A,9E1C4F30-3327-429B-8FE9-BD66CC511FDD,9edd8b3e6a08f16a6a50e13aaefd7a8fb9b283d4,a091a34ca3126c42afca637e12f161fe71005737,a27e1af3024c3bafb4796ec3ae4702293e282dbe,a2e861a7028304afcacc0bfba79fa99643ba0509,a40fe0a38eb714952a4e430d6cfc33d15744e161,a523d4c44690a617cf02bbde4dcab2d13a57591c,a52e561a4df0b8d9fb4d8409ef75ceb21bcc8c6f,a53bedbb0ba0937f7377c78d70234279c8c9f88f,a60e6db029e6730ffa1b9d3cc55215921060a75f,A7427B31-53FC-47A6-BA80-B33BCF3E83AB,a7fb08d7abe3a49763809bb369c6de6356889107,A855D266-5ADC-49B2-BF70-BDA8BD9F6D62,a8cabc1d2d4a172648a4a6e10d575238c87c6c61,a905d64387328518e84dd065c1190fd4d55dce2b,ab9497834e27ccc1d0dc3de8ff063cb9c7e56042,AD633149-A426-427C-A284-0041B1B239FA,ae2273428030cf5cad0d1b4b3ed8746d875d8f58,ae44f8f1810fb0cffcea7142e322791cdcb454b6,AF238CD0-87DE-4C59-BABC-5B6F7DB31E55,af832f7b83fc66e437625c8313c28b26aa4f43db,AFBCF3F6-683C-45ED-AE09-53176E412052,B17B8098-633D-4615-86BD-85AB3442705E,b53cae7663544e7eb067fe2aa4d8f59b4f29f5e2,b6bb9190644b5fcaa19a01df93c0da9dd8ac0682,B6DD4229-377F-425F-BA59-23C3B6B9C56F,b6e6d41e582c76ecdc0caf6e85bec8471eaa222c,b8cf06a66255f70f1811463bf17d0d68ec13b0ec,BAC1CB10-E629-48AD-9491-C362A7A0BC39,bb97ac757ec8c1d15e1aa13fd15a352098adf9c6,bf49db9e34eb0da7210c7637e6557ed457110062,c0cad840ec3c546627f40be52ad84f300dfca401,c0dcd44b4ff386a59ad9c3280678e651d1fe317a,C3C5F735-5293-4B85-8A48-32936A6804A8,C3D62836-0DD7-4AA7-9A35-AC0488DAFAEE,c46c0d9b2ac3ae5ea31e328becc3f71192766b71,c4782c0b51e0c95ee5b6aac7bc18f4313d4163db,c501cd09494a29b2fbeba93524dc23c3d3cd86f3,c6d9095522ed5f6eee9cd14ff28da774fb645d51,c71847e5662527d86a7f38af6732a8e444bb44e0,c80460e15cccce2e20a95c0a8cc2700ad914396e,c92b4646291aff58ad6708afadc96f752c012094,ca3bf89a5ff87ffb4f3e4c9cc552f9f134e6af94,CA683FFA-D7A9-4B9E-AB7E-1555ABEB7D25,cb70b56354319784a81baad9fad3c43db8ef940f,cbafb1a74ff7170ee418642fa3e39f9d368c0f36,cd4fa9a08e7ad9b28385f7d20da0e4a745787b07,cdf35f0ae83cb2c3b10bb97ebde81f840880c2d0,cf0c92c9a4973e16ac7adb6b9e7c3cd77b1f395b,cfd63bec3dea342e3b4dd4bf6d1b0ed5cfc05198,d07744f30612aa2258d94f5bb17e6619af24b471,d6296a7c1f3c087c4ede2b96c440613bd0d76b50,d6d2ad643c4ec7c6ee58b1827a04960d34640351,d772eb47c78850bc9945425a855141bae5ef80a3,D7AA8661-FA28-455F-BD19-CF900A06873D,D8421DE4-26E2-47F8-8A15-B72527D44C5B,D8463BF7-1C5E-4699-9275-9FA9E9BD6ADD,d990c0ced51491b01066bac38654b4ebcbe90bb3,da2ab26235cd71f2e87de6af36268779887b7d66,da3342b86d26689cf48648b673f6002be4c0caf8,da83af8d31ab4a12c125ab1c072c24ab85b0eade,dc876ab0d656aa3106d259c4fe8ae7246911e495,dcd7277b65fac791b9098b1f65c3179539703db3,de623920a2a839ae53ec45844c5a5a1862bdbd5b,e1db8b3440167c50721c6c78a4ab69dc3c0ff997,E20766C9-2851-4BBF-AABB-E0DE0C710507,e24e0dd5b56ba5774c2cbec4436c9cc395461c65,e2962c7fcf18812423c42378b067e84a523ee5a1,e386e328ca8a9d09613bb586b35176d96f0052e0,e9314d46ece9013fc574b59e0c43527e56aa62c1,ea3fdd08406993f2d598a8000e0885dac385646a,EA931CCE-757C-43E5-9AA4-2F4E22A443F2,ec457cd1732c7078fc3ee7a293cff30b2e296c7f,ef8d53aa9153bf2274664dd08dcd21358c9a01cb,f082b05d65bf0e75e09b4d9c635ec51ce6d357ec,f0b775b98f5f6b6afa1cd4890c9fd819efdefe9f,f0e67930bc4341158d86a61bdea99d19d61d9c45,F1164D88-B8EF-4CBF-A885-2450B8894C17,f3148e3c3190d3d6b065183452d10e611316fc43,F432C707-F215-4605-8603-74E5F09A28F3,F5870637-70BB-4309-A04F-A8C30CE158B4,F5890737-E1F2-474F-A8A6-42DCA445E850,f99fcbca7737c67402e112b027ffd7883267b2ef,fac67fcef0cf66633556ed12a34e9543b7a3b462,fd76db38f706e7d58b266881fc6e150bfceac920,6a1263f4bd7bfb5be9c05a35d1a1730b7066e77d,8a04f675ea591ff590af84e0e84787afa9b4f363,f68a7ff621db4ce8aef1d043ffb8812214718568',
            'content_edition' => 'e27ae51134c066a481ee6eb0dc35d0d91cf3d70a',
            'content_news_summary_color' => '#000000',
            'content_news_summary_font_size' => '18',
            'content_headline_font' => 'Times New Roman',
            'content_headline_color' => '#000000',
            'content_headline_font_size' => '18',
            'content_media_details' => 'Yes',
            'content_media_color' => '#000000',
            'content_media_font' => 'Times New Roman',
            'content_media_font_size' => '18',
            'content_context' => 'Yes',
            'content_context_font' => 'Times New Roman',
            'content_context_font_size' => '18',
            'footer_background_color' => '#6f54bb',
            'footer_logo_url' => 'https://pressbro.com/News/assets/img/mediaLogo.png',
            'footer_logo_position' => 'Left',
            'footer_title_name' => 'TATA MOTERS',
            'footer_title_font_color' => '#000000',
            'footer_title_font_size' => '18',
        ];

        // Create new template
        $staticData['client_id'] = $clientId;
        $templateId = DB::table('mail_template')->insertGetId($staticData);

        if ($templateId) {
            return redirect()->route('addNewsTemplate', $clientId)
                ->with('success', 'Template Added Successfully');
        } else {
            return redirect()->route('addNewsTemplate', $clientId)
                ->with('error', 'Something Went Wrong');
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
