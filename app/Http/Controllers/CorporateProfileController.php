<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Some\Other\Namespace\Request as OtherRequest;
use Illuminate\Http\Response;
use App\Models\Consolidation;
use App\Models\CompanyOwnership;
use App\Models\OtherCompany;
use App\Models\Subsidiary;
use App\Models\Group;
use App\Models\Chatbot;
use App\Models\User;
use App\Models\Sra;
use Illuminate\Support\Facades\Http;
use DOMDocument;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class CorporateProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    // public function index(): Response
    public function maintenanceMode()
    {
        return view('content.maintenanceMode');
    }

    public function toggleMaintenance(OtherRequest $request)
    {
        if ($request->maintenance) {
            Artisan::call('down'); // Enable maintenance mode
            return response()->json(['maintenance' => true, 'message' => 'Maintenance mode enabled']);
        } else {
            Artisan::call('up'); // Disable maintenance mode
            return response()->json(['maintenance' => false, 'message' => 'Maintenance mode disabled']);
        }
    }

    public function showMaintenanceMode()
    {
        if (app()->isDownForMaintenance()) {  // Check if the app is in maintenance mode
            return view('content.en.maintenanceMode'); // Show maintenance mode page
        }
        return redirect()->route('showIndex'); // Redirect to index if not in maintenance mode
    }

    public function showIndex()
    {
        if (!app()->isDownForMaintenance()) {  // Check if the app is live
            return view('content.home'); // Show index page
        }
        return redirect()->route('maintenance.mode'); // Redirect to maintenance if in maintenance mode
    }

    public function index()
    {
        $subsidiary = Consolidation::all();
        $groupName = Consolidation::all();
        return view('content.home', compact('subsidiary', 'groupName'));
    }
    public function servePDF($filename)
    {
        $filePath = public_path('file/group-structure/' . $filename);

        if (!File::exists($filePath)) {
            abort(404, 'File not found');
        }

        $fileContent = File::get($filePath);
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Cache-Control' => 'public, max-age=0',
            'Pragma' => 'public',
        ];

        return response($fileContent, 200, $headers);
    }

    public function group2Show(Request $request)
    {
        $query = $request->input('group_name');

        $groups = Group::select('group_name', 'group_status', 'controller', 'country_registration', 'management_name_and_position')
            ->where('group_name', 'LIKE', '%' . $query . '%')
            ->distinct()
            ->paginate(10);

        // Append the search query to the pagination links
        $groups->appends(['group_name' => $query]);

        return view('content.en.indexGroup2', compact('groups'));
    }

    public function sraShow(Request $request)
    {
        $query = $request->input('group_name');

    $sras = Sra::select('group_name', 'transparency', 'percent_transparency', 'rspo_compliance', 'percent_rspo_compliance', 'ndpe_compliance', 'percent_ndpe_compliance', 'total', 'percent_total')
        ->where('group_name', 'LIKE', '%' . $query . '%')
        ->distinct()
        ->paginate(10);

    // Extracting data for chart
    $labels = ['Transparency', 'RSPO Compliance', 'NDPE Compliance', 'Overall'];
    $data = [];

    // Iterating through each Sra instance to populate $data array
    foreach ($sras as $sra) {
        $data[] = [
            $sra->percent_transparency,
            $sra->percent_rspo_compliance,
            $sra->percent_ndpe_compliance,
            $sra->percent_total
        ];
    }

    // Append the search query to the pagination links
    $sras->appends(['group_name' => $query]);

    return view('content.en.indexSra', compact('sras', 'data', 'labels'));
    }

    public function shareholderShow(Request $request)
{
    // Get the 'shareholder_name' and 'date_of_birth' from the request
    $name = $request->input('shareholder_name');
    $dob = $request->input('date_of_birth');

    // Retrieve shareholder details based on 'shareholder_name' and 'date_of_birth'
    $shareholderNames = CompanyOwnership::select(
            'shareholder_name', 
            'date_of_birth', 
            'ic_passport_comp_number', 
            'address', 
            'position', 
            'number_of_shares', 
            'total_of_shares', 
            'percentage_of_shares', 
            'currency', 
            'company_name', 
            'data_source',
            'data_update'
        )
        ->where('shareholder_name', $name) // Match the shareholder name
        ->where('date_of_birth', $dob) // Match the date of birth
        ->paginate(10); // Paginate results

    // Append the 'shareholder_name' and 'date_of_birth' to the pagination links
    $shareholderNames->appends(['shareholder_name' => $name, 'date_of_birth' => $dob]);

    // Return the view with the results
    return view('content.en.indexShareholder', compact('shareholderNames'));
}


    public function shareholderShowByCompany(Request $request)
    {
        // Get the 'shareholder_name' and 'date_of_birth' from the request
        $name = $request->input('shareholder_name');

        // Retrieve shareholder details based on 'shareholder_name' and 'date_of_birth'
        $shareholderNames = CompanyOwnership::select(
                'shareholder_name', 
                'date_of_birth', 
                'ic_passport_comp_number', 
                'address', 
                'position', 
                'number_of_shares', 
                'total_of_shares', 
                'percentage_of_shares', 
                'currency', 
                'company_name', 
                'data_source',
                'data_update'
            )
            ->where('shareholder_name', $name) // Match the shareholder name
            ->paginate(10); // Paginate results

        // Append the 'shareholder_name' and 'date_of_birth' to the pagination links
        $shareholderNames->appends(['shareholder_name' => $name]);

        // Return the view with the results
        return view('content.en.indexShareholder', compact('shareholderNames'));
    }

    public function subsidiaryList()
    {
        $Subsidiaries = Subsidiary::all();
        return view('content.en.subsidiaryList', compact('subsidiaries'));
    }

    public function subsidiaryShow0($id)
    {
        $subsidiary = Subsidiary::findOrFail($id);
        $pdfUrl = $this->getGoogleDriveUrl($subsidiary->pdf_file_id);
        return view('content.en.subsidiaryShow', compact('subsidiary', 'pdfUrl'));
    }

    private function getGoogleDriveUrl($fileId)
    {
        // Use the Google Drive API to get the file URL based on the file ID
        // Implement this function based on the Google Drive API documentation
        // You may use the google/apiclient package for this
        return "https://drive.google.com/file/d/$fileId/view";
    }

    // public function redirectToGoogle()
    // {
    //     return Socialite::driver('google')->redirect();
    // }

    // public function handleCallback()
    // {
    //     $user = Socialite::driver('google')->user();

    //     // Handle user data and token

    //     return redirect('/dashboard'); // Redirect to your desired route after authentication
    // }

    //

    public function otherCompanyShow(Request $request)
    {
        $badanHukum = $request->input('badan_hukum');

        $otherCompanies = DB::table('other_companies')
            ->where('badan_hukum', $badanHukum)
            ->get();

        // if ($badanHukum) {
        //     $companies = DB::table('other_companies')->where('badan_hukum', $badanHukum)->get();
        // }

        return view('content.en.indexOtherCompany', compact('otherCompanies', 'badanHukum'));
    }

    public function subsidiaryShow(Request $request)
    {

        $consol = Consolidation::all();
        $coordinates = null; // Initialize coordinates variable
        $users = User::all();
        $consul = User::all();
        $subsidiaryName = $request->input('subsidiary');
        // $distinctSubsidiary = Consolidation::where('subsidiary', $subsidiaryName)
        //     ->distinct('subsidiary')
        //     ->pluck('subsidiary');

        if ($subsidiaryName) {
            // Fetch the coordinate data from the database based on the subsidiary
            // $coordinates = DB::table('consolidations')->select('latitude', 'longitude')->where('subsidiary', $subsidiaryName)->first();
            // $companyOwnership = DB::table('company_ownerships')->where('company_name', $subsidiaryName)->get();
            $coordinates = DB::table('consolidations')->select('latitude', 'longitude', 'subsidiary', 'country_operation', 'province', 'regency', 'facilities', 'capacity', 'sizebyeq', 'estate', 'group_name', 'principal_activities')->where('subsidiary', $subsidiaryName)->get();

            // Pilih kolom-kolom yang diperlukan dari tabel corporate
            // $corporateData = DB::table('corporate')->select('nama_perusahaan', 'jenis_usaha', 'tanggal_berdiri', 'alamat')->where('subsidiary', $subsidiaryName)->get();
        }
        // return view('maps', compact('coordinates', 'consol', 'subsidiary'));

        $consolidations = DB::table('consolidations')->where('subsidiary', $subsidiaryName)->get();
        // $companyOwnership = DB::table('company_ownerships')->where('company_name', $subsidiaryName)->get();
        $companyOwnership = DB::table('company_ownerships')
        ->where('company_name', $subsidiaryName)
        ->union(
            DB::table('company_ownership_seconds')
                ->where('company_name', $subsidiaryName)
        )
        ->get();


            foreach ($consolidations as $subs) {
                $number = intval($subs->sizebyeq);
                $formattedNumber = number_format($number);

                if ($number) {
                    $subs->sizebyeq = $formattedNumber;
                } else {
                    $subs->sizebyeq = '-';
                }
            }

        // return view('content.en.indexSubsidiary', compact('consolidations', 'users', 'consul'));

        // // $subsidiary = $request->id;
        // // $shareholder = DB::table('consolidations')->where('subsidiary', $subsidiary)->value('shareholder_subsidiary');
        // // return view('subsidiary.show', compact('subsidiary', 'shareholder'));

        // // // Lakukan pemrosesan data sesuai kebutuhan Anda
        // // $subsidiaryData = Subsidiary::where('subsidiary', $subsidiary)->first();

        // // if ($subsidiaryData) {
        // //     // Jika data ditemukan, lakukan operasi logika atau tampilkan view
        // //     return view('content.en.indexSubsidiary', compact('subsidiaryData'));
        // // } else {
        // //     // Jika data tidak ditemukan, tampilkan pesan atau redirect
        // //     return redirect()->route('subsidiaryIndex')->with('error', 'Subsidiary not found.');
        // // }

        // // $subs = route('subsidiaryShow', ['subsidiary' => $subsidiary]);
        // // $subsidiary = Consolidation::where('subsidiary', $subs)->get();
        // // return view('content.en.indexSubsidiary', compact('subsidiary'));

        // // versi chat 
        $input = $request->input('subsidiary'); // ambil input pesan dari userssss
        $subsidiaries = Consolidation::where('subsidiary', 'like', '%' . $input . '%')->get(); // cari data subsidiary yang cocok dengan input

        $regencies0 = [];
        $provinces0 = [];
        $countries0 = [];

        foreach ($subsidiaries as $sub0) {
            if (!in_array($sub0->regency, $regencies0)) {
                $regencies0[] = $sub0->regency;
            }

            if (!in_array($sub0->province, $provinces0)) {
                $provinces0[] = $sub0->province;
            }

            if (!in_array($sub0->country_operation, $countries0)) {
                $countries0[] = $sub0->country_operation;
            }
        }

        if ($subsidiaries->isNotEmpty()) {
            $subsidiary = $subsidiaries->first();
            // $count = Consolidation::count();

            // // Not clickable shareholder 
            // $response = $subsidiary->subsidiary . ' adalah anak perusahaan dari group ' . $subsidiary->group_name . ' yang berlokasi di Kabupaten ' . implode(', Kabupaten ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '.';

            // $shareholders = explode(',', $subsidiary->shareholder_subsidiary);
            // $shareholder_data = [];
            // $total_share = 0;

            // foreach ($shareholders as $shareholder) {
            //     $share_info = explode('(', $shareholder);
            //     $shareholder_name = trim($share_info[0]);
            //     $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
            //     $total_share += $share_percentage;
            //     $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
            // }

            // usort($shareholder_data, function ($a, $b) {
            //     return $b['share_percentage'] <=> $a['share_percentage'];
            // });

            // $majority_shareholder = $shareholder_data[0]['name'];
            // $majority_share_percentage = $shareholder_data[0]['share_percentage'];

            // if ($subsidiary->group_type == 'Independent') {
            //     $group_narrative = 'adalah perusahaan yang dikendalikan oleh';
            // } else if ($subsidiary->group_type == 'Coop') {
            //     $group_narrative = 'adalah koperasi yang dikendalikan oleh';
            // } else {
            //     $group_narrative = 'adalah anak perusahaan dari group';
            // }

            // if (count($shareholder_data) > 1) {
            //     if ($total_share > 50) {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh ' . $majority_shareholder . ' sebesar ' . $majority_share_percentage . '% dan sisanya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //             return $data['name'] . ' (' . $data['share_percentage'] . '%)';
            //         }, array_slice($shareholder_data, 1))) . '. ';
            //     } else {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya didistribusikan di antara beberapa pemegang saham, yaitu ' . implode(', ', array_map(function ($data) {
            //             return $data['name'] . ' sebesar ' . $data['share_percentage'] . '%';
            //         }, $shareholder_data)) . '. ';
            //     }
            // } else {
            //     $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(
            //         function ($data) {
            //             return $data['name'] . ' sebesar ' . $data['share_percentage'] . '%';
            //         },
            //         $shareholder_data
            //     )) . '. ';
            // }
            // // End not clickable shareholder 

            // Clickable shareholder, Ini dipakai jika tabel shareholder data shareholdernya lengkap, karena shareholder name nya clickable biar pas klik tidak kosong atau memunculkan pesan error
            $shareholders = explode(',', $subsidiary->shareholder_subsidiary);
            $shareholder_data = [];
            $total_share = 0;

            if (is_array($shareholders)) {
                foreach ($shareholders as $shareholder) {
                    $share_info = explode('(', $shareholder);
                    $shareholder_name = trim($share_info[0]);

                    if (isset($share_info[1])) {
                        $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
                        $total_share += $share_percentage;
                        $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
                    } else {
                        $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
                    }
                }
            } else {
                $share_info = explode('(', $shareholders);
                $shareholder_name = trim($share_info[0]);

                if (isset($share_info[1])) {
                    $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
                    $total_share += $share_percentage;
                    $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
                } else {
                    $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
                }
            }

            usort($shareholder_data, function ($a, $b) {
                return $b['share_percentage'] <=> $a['share_percentage'];
            });

            $majority_shareholder = $shareholder_data[0]['name'];
            $majority_share_percentage = $shareholder_data[0]['share_percentage'];

            if ($subsidiary->group_type == 'Independent') {
                $group_narrative = 'is a company controlled by';
                $group_narrative2 = '';
            } else if ($subsidiary->group_type == 'Coop') {
                $group_narrative = 'is a cooperative controlled by';
                $group_narrative2 = '';
            } else {
                $group_narrative = 'is a subsidiary of the ';
                $group_narrative2 = ' group';
            }

            $response ='';

            // narasi shareholder v1 with no link
            if (auth()->check() && ($user_level = auth()->user()->user_level)) {
                if ($user_level === '1') {
                    if (count($shareholder_data) > 1) {

                        if ($total_share > 50) {
                            $response = $subsidiary->subsidiary . ' is a company engaged in the field of oil palm plantations located in ' . implode(', ', $regencies0) . ', ' . implode(', ', $countries0) . '. The majority of its shares are owned by ' . $majority_shareholder . ' by ' . $majority_share_percentage . '% and the rest are owned by ' . implode(', ', array_map(function ($data) {
                                return $data['name'] . ' ' . $data['share_percentage'] . '%';
                            }, array_slice($shareholder_data, 1))) . '. ';
                        } else {
                            $response = $subsidiary->subsidiary . ' is a company engaged in the field of oil palm plantations located in ' . implode(', ', $regencies0) . ', ' . implode(', ', $countries0) . '. Its share ownership is distributed among several shareholders, viz ' . implode(', ', array_map(function ($data) {
                                return $data['name'] . ' ' . $data['share_percentage'] . '%';
                            }, $shareholder_data)) . '. ';
                        }
                    } else {
                        // $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' located at ' . implode(', ', $regencies0) . ', ' . implode(', ', $countries0) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
                        $response = $subsidiary->subsidiary . ' is a company engaged in the field of oil palm plantations located in ' . implode(', ', $regencies0) . ', ' . implode(', ', $countries0) . '. Share ownership is owned by ' . implode(', ', array_map(function ($data) {
                            return $data['name'] . ' ' . $data['share_percentage'] . '%';
                        }, $shareholder_data)) . '. ';
                    }

                    if (count($shareholder_data) > 0) {
                        $perusahaan = implode(' and ', $subsidiaries->pluck('subsidiary')->unique()->toArray());
                    } else {
                        $perusahaan = '';
                    }
                }

                } else
                    if (count($shareholder_data) > 1) {

                        if ($total_share > 50) {
                            $response = $subsidiary->subsidiary . ' is a company engaged in the field of oil palm plantations located in ' . implode(', ', $regencies0) . ', ' . implode(', ', $countries0) . '. ';

                        } else {
                            $response = $subsidiary->subsidiary . ' is a company engaged in the field of oil palm plantations located in ' . implode(', ', $regencies0) . ', ' . implode(', ', $countries0) . '. ';
                        }
                    } else {
                        // $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' located at ' . implode(', ', $regencies0) . ', ' . implode(', ', $countries0) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
                        $response = $subsidiary->subsidiary . ' is a company engaged in the field of oil palm plantations located in ' . implode(', ', $regencies0) . ', ' . implode(', ', $countries0) . '. ';
                    }

                if (count($shareholder_data) > 0) {
                    $perusahaan = implode(' and ', $subsidiaries->pluck('subsidiary')->unique()->toArray());
                } else {
                    $perusahaan = '';
                }

            // end narasi shareholder v1 with no link
        } else {
            $response = '';
        }

        // $subsidiary = response()->json(['message' => $response]);
        $subsidiari = $response;
        // return view('content.en.test', compact('consolidations'));
        return view('content.en.indexSubsidiary', compact('companyOwnership', 'subsidiaryName', 'consolidations', 'subsidiari', 'users', 'consul', 'consol', 'coordinates'));
        // return view('maps', compact('coordinates', 'consol', 'subsidiary'));
        // end versi chat 
    }

    public function groupShow(Request $request)
    {

        $consol = Consolidation::all();
        $coordinates = null; // Initialize coordinates variable
        $users = User::all();
        $consul = User::all();
        $subsidiaryName = $request->input('group_name');

        $input = $request->input('group_name'); // ambil input pesan dari userssss
        $subsidiaries = Consolidation::where('group_name', 'like', '%' . $input . '%')->get(); // cari data subsidiary yang cocok dengan input

        // $distinctSubsidiary = Consolidation::where('subsidiary', $subsidiaryName)
        //     ->distinct('subsidiary')
        //     ->pluck('subsidiary');

        if ($subsidiaryName) {
            // Fetch the coordinate data from the database based on the subsidiary
            // $coordinates = DB::table('consolidations')->select('latitude', 'longitude')->where('subsidiary', $subsidiaryName)->first();
            $coordinates = DB::table('consolidations')->select('latitude', 'longitude', 'subsidiary', 'country_operation', 'province', 'regency', 'facilities', 'capacity', 'sizebyeq', 'estate', 'group_name', 'principal_activities')->where('group_name', $subsidiaryName)->get();
        }
        // return view('maps', compact('coordinates', 'consol', 'subsidiary'));

        $consolidations = DB::table('consolidations')
            ->where('group_name', $subsidiaryName)
            ->get();

        foreach ($consolidations as $subs) {
            $number = intval($subs->sizebyeq);
            $formattedNumber = number_format($number);

            if ($number) {
                $subs->sizebyeq = $formattedNumber;
            } else {
                $subs->sizebyeq = '-';
            }
        }

        $regencies0 = [];
        $provinces0 = [];
        $countries0 = [];
        $subsidiary0 = [];

        foreach ($subsidiaries as $sub0) {
            if (!in_array($sub0->regency, $regencies0)) {
                $regencies0[] = $sub0->regency;
            }

            if (!in_array($sub0->province, $provinces0)) {
                $provinces0[] = $sub0->province;
            }

            if (!in_array($sub0->country_operation, $countries0)) {
                $countries0[] = $sub0->country_operation;
            }

            if (!in_array($sub0->subsidiary, $subsidiary0)) {
                $subsidiary0[] = $sub0->subsidiary;
            }
        }

        if ($subsidiaries->isNotEmpty()) {
            $subsidiary = $subsidiaries->first();
            $shareholders = explode(',', $subsidiary->shareholder_subsidiary);
            $shareholder_data = [];
            $total_share = 0;

            if (is_array($shareholders)) {
                foreach ($shareholders as $shareholder) {
                    $share_info = explode('(', $shareholder);
                    $shareholder_name = trim($share_info[0]);

                    if (isset($share_info[1])) {
                        $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
                        $total_share += $share_percentage;
                        $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
                    } else {
                        $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
                    }
                }
            } else {
                $share_info = explode('(', $shareholders);
                $shareholder_name = trim($share_info[0]);

                if (isset($share_info[1])) {
                    $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
                    $total_share += $share_percentage;
                    $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
                } else {
                    $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
                }
            }

            usort($shareholder_data, function ($a, $b) {
                return $b['share_percentage'] <=> $a['share_percentage'];
            });

            $majority_shareholder = $shareholder_data[0]['name'];
            $majority_share_percentage = $shareholder_data[0]['share_percentage'];

            if ($subsidiary->group_type == 'Independent') {
                $group_narrative = 'is a company controlled by';
                $group_narrative2 = '';
            } else if ($subsidiary->group_type == 'Coop') {
                $group_narrative = 'is a cooperative controlled by';
                $group_narrative2 = '';
            } else {
                $group_narrative = 'is a subsidiary of the ';
                $group_narrative2 = ' group';
            }

            // narasi shareholder v1 with no link
            if (count($shareholder_data) > 1) {
                if ($total_share > 50) {
                    $response = $subsidiary->group_name . ' is a group of companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
                } else {
                    $response = $subsidiary->group_name . ' is a group companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
                }
            } else {
                // $response = $subsidiary->group_name . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' located at ' . $subsidiary->principal_activities . '.' . 'Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
                $response = $subsidiary->group_name . ' is a group companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
            }

            if (count($shareholder_data) > 0) {
                $perusahaan = implode(' and ', $subsidiaries->pluck('group_name')->unique()->toArray());
            } else {
                $perusahaan = '';
            }

            // end narasi shareholder v1 with no link
        } else {
            $response = 'Subsidiary not found..';
        }

        // $subsidiary = response()->json(['message' => $response]);
        $subsidiary = $response;
        return view('content.en.indexGroup', compact('consolidations', 'perusahaan', 'subsidiary', 'users', 'consul', 'consol', 'coordinates'));
        // return view('maps', compact('coordinates', 'consol', 'subsidiary'));
        // end versi chat 
    }

    public function groupShow2(Request $request)
    {
        $groupName = $request->input('group_name');

        $consolidations = DB::table('consolidations')
            ->where('group_name', $groupName)
            ->get();

        return view('content.en.indexSubsidiary', compact('consolidations'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $users = Chatbot::where('message', 'like', '%' . $keyword . '%')
            ->orWhere('reply', 'like', '%' . $keyword . '%')
            ->get();
        $consul = User::all();

        $consolidations = Consolidation::where('subsidiary', 'like', '%' . $keyword . '%')
            ->orWhere('group_name', 'like', '%' . $keyword . '%')
            ->get();

        return view('content.en.indexSubsidiary', compact('users', 'consul', 'consolidations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    public function maps(Request $request)
    {
        $consol = Consolidation::all();
        $subsidiary = $request->input('subsidiary');
        $coordinates = null; // Initialize coordinates variable

        if ($subsidiary) {
            // Fetch the coordinate data from the database based on the subsidiary
            $coordinates = DB::table('consolidations')->select('latitude', 'longitude')->where('subsidiary', $subsidiary)->first();
        }

        return view('maps', compact('coordinates', 'consol', 'subsidiary'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //
    }

    public function scrapingLatLong()
    {
        // Send a GET request to the URL
        $response = Http::get('https://app.maritimeoptima.com/?lat=11.322245742167155&lon=49.155221727790405&vessel=9007350&z=9.279270815398522');

        // Create a new DOM Document
        $dom = new DOMDocument();

        // Disable error handling
        libxml_use_internal_errors(true);

        // Load the HTML content from the response
        $dom->loadHTML($response->body());

        // Re-enable error handling
        libxml_use_internal_errors(false);

        // Find the latitude and longitude values on the webpage
        $latitudeElement = $dom->getElementById('lat');
        $longitudeElement = $dom->getElementById('lon');

        // Check if the elements exist before accessing their attributes
        if ($latitudeElement && $longitudeElement) {
            $latitude = $latitudeElement->getAttribute('value');
            $longitude = $longitudeElement->getAttribute('value');

            // Return the latitude and longitude as JSON response
            return response()->json([
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);
        } else {
            // Return an error response if the elements were not found
            return response()->json([
                'error' => 'Latitude and longitude elements not found'
            ], 500);
        }
    }
    

    public function faq()
    {
        $subsidiary = Consolidation::all();
        $groupName = Consolidation::all();
        return view('content.footer.faq', compact('subsidiary', 'groupName'));
    }
    public function termOfServices()
    {
        $subsidiary = Consolidation::all();
        $groupName = Consolidation::all();
        return view('content.footer.termOfServices', compact('subsidiary', 'groupName'));
    }

    public function userGuide()
    {
        $subsidiary = Consolidation::all();
        $groupName = Consolidation::all();
        return view('content.footer.userGuide', compact('subsidiary', 'groupName'));
    }
}