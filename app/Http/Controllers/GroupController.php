<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Consolidation;
use App\Models\CompanyOwnership;
use App\Models\Subsidiary;
use App\Models\Group;
use App\Models\Message;
use App\Models\Chatbot;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use DOMDocument;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Storage;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $groups = Group::all();
        return view('admin.group.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'country_registration' => 'required|string|max:255',
            'controller' => 'required|string|max:255',
        ]);

        Group::create($request->all());

        return redirect()->route('groups.index')->with('success', 'Data group added successfully.');
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
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'country_registration' => 'required|string|max:255',
            'controller' => 'required|string|max:255',
        ]);

        $group->update($request->all());

        return redirect()->route('groups.index')->with('success', 'Data group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Data group deleted successfully.');
    }

    public function group2ShowStructure(Request $request)
    {
        $consol = Group::all();
        $coordinates = null; // Initialize coordinates variable
        $users = User::all();
        $consul = User::all();
        $subsidiaryName = $request->input('group_name');

        $input = $request->input('group_name'); // ambil input pesan dari userssss
        $subsidiaries = Group::where('group_name', 'like', '%' . $input . '%')->get(); // cari data subsidiary yang cocok dengan input

        // $distinctSubsidiary = Consolidation::where('subsidiary', $subsidiaryName)
        //     ->distinct('subsidiary')
        //     ->pluck('subsidiary');

        if ($subsidiaryName) {
            // Fetch the coordinate data from the database based on the subsidiary
            // $coordinates = DB::table('groups')->select('latitude', 'longitude')->where('subsidiary', $subsidiaryName)->first();
            $coordinates = DB::table('groups')->select('group_name', 'group_status', 'controller', 'country_registration', 'management_name_and_position')->where('group_name', $subsidiaryName)->get();
        }
        // return view('maps', compact('coordinates', 'consol', 'subsidiary'));

        $groups = DB::table('groups')
            ->where('group_name', $subsidiaryName)
            ->get();

        // foreach ($groups as $subs) {
        //     $number = intval($subs->sizebyeq);
        //     $formattedNumber = number_format($number);

        //     if ($number) {
        //         $subs->sizebyeq = $formattedNumber;
        //     } else {
        //         $subs->sizebyeq = '-';
        //     }
        // }

        // $regencies0 = [];
        // $provinces0 = [];
        // $countries0 = [];
        // $subsidiary0 = [];

        // foreach ($subsidiaries as $sub0) {
        //     if (!in_array($sub0->regency, $regencies0)) {
        //         $regencies0[] = $sub0->regency;
        //     }

        //     if (!in_array($sub0->province, $provinces0)) {
        //         $provinces0[] = $sub0->province;
        //     }

        //     if (!in_array($sub0->country_operation, $countries0)) {
        //         $countries0[] = $sub0->country_operation;
        //     }

        //     if (!in_array($sub0->subsidiary, $subsidiary0)) {
        //         $subsidiary0[] = $sub0->subsidiary;
        //     }
        // }

        // if ($subsidiaries->isNotEmpty()) {
        //     $subsidiary = $subsidiaries->first();
        //     $shareholders = explode(',', $subsidiary->shareholder_subsidiary);
        //     $shareholder_data = [];
        //     $total_share = 0;

        //     if (is_array($shareholders)) {
        //         foreach ($shareholders as $shareholder) {
        //             $share_info = explode('(', $shareholder);
        //             $shareholder_name = trim($share_info[0]);

        //             if (isset($share_info[1])) {
        //                 $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
        //                 $total_share += $share_percentage;
        //                 $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
        //             } else {
        //                 $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
        //             }
        //         }
        //     } else {
        //         $share_info = explode('(', $shareholders);
        //         $shareholder_name = trim($share_info[0]);

        //         if (isset($share_info[1])) {
        //             $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
        //             $total_share += $share_percentage;
        //             $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
        //         } else {
        //             $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
        //         }
        //     }

        //     usort($shareholder_data, function ($a, $b) {
        //         return $b['share_percentage'] <=> $a['share_percentage'];
        //     });

        //     $majority_shareholder = $shareholder_data[0]['name'];
        //     $majority_share_percentage = $shareholder_data[0]['share_percentage'];

        //     if ($subsidiary->group_type == 'Independent') {
        //         $group_narrative = 'is a company controlled by';
        //         $group_narrative2 = '';
        //     } else if ($subsidiary->group_type == 'Coop') {
        //         $group_narrative = 'is a cooperative controlled by';
        //         $group_narrative2 = '';
        //     } else {
        //         $group_narrative = 'is a subsidiary of the ';
        //         $group_narrative2 = ' group';
        //     }

        //     // narasi shareholder v1 with no link
        //     if (count($shareholder_data) > 1) {
        //         if ($total_share > 50) {
        //             $response = $subsidiary->group_name . ' is a group of companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //         } else {
        //             $response = $subsidiary->group_name . ' is a group companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //         }
        //     } else {
        //         // $response = $subsidiary->group_name . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' located at ' . $subsidiary->principal_activities . '.' . 'Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
        //         $response = $subsidiary->group_name . ' is a group companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //     }

        //     if (count($shareholder_data) > 0) {
        //         $perusahaan = implode(' and ', $subsidiaries->pluck('group_name')->unique()->toArray());
        //     } else {
        //         $perusahaan = '';
        //     }

        //     // end narasi shareholder v1 with no link
        // } else {
        //     $response = 'Subsidiary not found..';
        // }

        // $subsidiary = response()->json(['message' => $response]);
        // $subsidiary = $response;
        // return $subsidiary;
        // return view('content.en.test', compact('groups'));



        $consol0 = Consolidation::all();
        $coordinates0 = null; // Initialize coordinates variable
        $users0 = User::all();
        $consul0 = User::all();
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

        // // jangan dihapus, ini di hide karna jika diaktifkan maka ada beberapa group yang error pagenya
        // if ($subsidiaries->isNotEmpty()) {
        //     $subsidiary = $subsidiaries->first();
        //     $shareholders = explode(',', $subsidiary->shareholder_subsidiary);
        //     $shareholder_data = [];
        //     $total_share = 0;

        //     if (is_array($shareholders)) {
        //         foreach ($shareholders as $shareholder) {
        //             $share_info = explode('(', $shareholder);
        //             $shareholder_name = trim($share_info[0]);

        //             if (isset($share_info[1])) {
        //                 $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
        //                 $total_share += $share_percentage;
        //                 $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
        //             } else {
        //                 $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
        //             }
        //         }
        //     } else {
        //         $share_info = explode('(', $shareholders);
        //         $shareholder_name = trim($share_info[0]);

        //         if (isset($share_info[1])) {
        //             $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
        //             $total_share += $share_percentage;
        //             $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
        //         } else {
        //             $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
        //         }
        //     }

        //     usort($shareholder_data, function ($a, $b) {
        //         return $b['share_percentage'] <=> $a['share_percentage'];
        //     });

        //     $majority_shareholder = $shareholder_data[0]['name'];
        //     $majority_share_percentage = $shareholder_data[0]['share_percentage'];

        //     if ($subsidiary->group_type == 'Independent') {
        //         $group_narrative = 'is a company controlled by';
        //         $group_narrative2 = '';
        //     } else if ($subsidiary->group_type == 'Coop') {
        //         $group_narrative = 'is a cooperative controlled by';
        //         $group_narrative2 = '';
        //     } else {
        //         $group_narrative = 'is a subsidiary of the ';
        //         $group_narrative2 = ' group';
        //     }

        //     // narasi shareholder v1 with no link
        //     if (count($shareholder_data) > 1) {
        //         if ($total_share > 50) {
        //             $response = $subsidiary->group_name . ' is a group of companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //         } else {
        //             $response = $subsidiary->group_name . ' is a group companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //         }
        //     } else {
        //         // $response = $subsidiary->group_name . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' located at ' . $subsidiary->principal_activities . '.' . 'Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
        //         $response = $subsidiary->group_name . ' is a group companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //     }

        //     if (count($shareholder_data) > 0) {
        //         $perusahaan = implode(' and ', $subsidiaries->pluck('group_name')->unique()->toArray());
        //     } else {
        //         $perusahaan = '';
        //     }

        //     // end narasi shareholder v1 with no link
        // } else {
        //     $response = 'Subsidiary not found..';
        // }

        // // $subsidiary = response()->json(['message' => $response]);
        // $subsidiary = $response;
        // // end jangan dihapus

        return view('content.en.indexGroup2Structure', compact('groups'));
    }

    public function group2Show(Request $request)
    {

        $consol = Group::all();
        $coordinates = null; // Initialize coordinates variable
        $users = User::all();
        $consul = User::all();
        $subsidiaryName = $request->input('group_name');

        $input = $request->input('group_name'); // ambil input pesan dari userssss
        $subsidiaries = Group::where('group_name', 'like', '%' . $input . '%')->get(); // cari data subsidiary yang cocok dengan input

        // $distinctSubsidiary = Consolidation::where('subsidiary', $subsidiaryName)
        //     ->distinct('subsidiary')
        //     ->pluck('subsidiary');

        if ($subsidiaryName) {
            // Fetch the coordinate data from the database based on the subsidiary
            // $coordinates = DB::table('groups')->select('latitude', 'longitude')->where('subsidiary', $subsidiaryName)->first();
            $coordinates = DB::table('groups')->select('group_name', 'group_status', 'controller', 'country_registration', 'management_name_and_position')->where('group_name', $subsidiaryName)->get();
        }
        // return view('maps', compact('coordinates', 'consol', 'subsidiary'));

        $groups = DB::table('groups')
            ->where('group_name', $subsidiaryName)
            ->get();

        // foreach ($groups as $subs) {
        //     $number = intval($subs->sizebyeq);
        //     $formattedNumber = number_format($number);

        //     if ($number) {
        //         $subs->sizebyeq = $formattedNumber;
        //     } else {
        //         $subs->sizebyeq = '-';
        //     }
        // }

        // $regencies0 = [];
        // $provinces0 = [];
        // $countries0 = [];
        // $subsidiary0 = [];

        // foreach ($subsidiaries as $sub0) {
        //     if (!in_array($sub0->regency, $regencies0)) {
        //         $regencies0[] = $sub0->regency;
        //     }

        //     if (!in_array($sub0->province, $provinces0)) {
        //         $provinces0[] = $sub0->province;
        //     }

        //     if (!in_array($sub0->country_operation, $countries0)) {
        //         $countries0[] = $sub0->country_operation;
        //     }

        //     if (!in_array($sub0->subsidiary, $subsidiary0)) {
        //         $subsidiary0[] = $sub0->subsidiary;
        //     }
        // }

        // if ($subsidiaries->isNotEmpty()) {
        //     $subsidiary = $subsidiaries->first();
        //     $shareholders = explode(',', $subsidiary->shareholder_subsidiary);
        //     $shareholder_data = [];
        //     $total_share = 0;

        //     if (is_array($shareholders)) {
        //         foreach ($shareholders as $shareholder) {
        //             $share_info = explode('(', $shareholder);
        //             $shareholder_name = trim($share_info[0]);

        //             if (isset($share_info[1])) {
        //                 $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
        //                 $total_share += $share_percentage;
        //                 $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
        //             } else {
        //                 $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
        //             }
        //         }
        //     } else {
        //         $share_info = explode('(', $shareholders);
        //         $shareholder_name = trim($share_info[0]);

        //         if (isset($share_info[1])) {
        //             $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
        //             $total_share += $share_percentage;
        //             $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
        //         } else {
        //             $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
        //         }
        //     }

        //     usort($shareholder_data, function ($a, $b) {
        //         return $b['share_percentage'] <=> $a['share_percentage'];
        //     });

        //     $majority_shareholder = $shareholder_data[0]['name'];
        //     $majority_share_percentage = $shareholder_data[0]['share_percentage'];

        //     if ($subsidiary->group_type == 'Independent') {
        //         $group_narrative = 'is a company controlled by';
        //         $group_narrative2 = '';
        //     } else if ($subsidiary->group_type == 'Coop') {
        //         $group_narrative = 'is a cooperative controlled by';
        //         $group_narrative2 = '';
        //     } else {
        //         $group_narrative = 'is a subsidiary of the ';
        //         $group_narrative2 = ' group';
        //     }

        //     // narasi shareholder v1 with no link
        //     if (count($shareholder_data) > 1) {
        //         if ($total_share > 50) {
        //             $response = $subsidiary->group_name . ' is a group of companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //         } else {
        //             $response = $subsidiary->group_name . ' is a group companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //         }
        //     } else {
        //         // $response = $subsidiary->group_name . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' located at ' . $subsidiary->principal_activities . '.' . 'Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
        //         $response = $subsidiary->group_name . ' is a group companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //     }

        //     if (count($shareholder_data) > 0) {
        //         $perusahaan = implode(' and ', $subsidiaries->pluck('group_name')->unique()->toArray());
        //     } else {
        //         $perusahaan = '';
        //     }

        //     // end narasi shareholder v1 with no link
        // } else {
        //     $response = 'Subsidiary not found..';
        // }

        // $subsidiary = response()->json(['message' => $response]);
        // $subsidiary = $response;
        // return $subsidiary;
        // return view('content.en.test', compact('groups'));



        $consol0 = Consolidation::all();
        $coordinates0 = null; // Initialize coordinates variable
        $users0 = User::all();
        $consul0 = User::all();
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

        // // jangan dihapus, kalo ini diaktifkan maka ada beberpa group yang error pagenya, perlu di cek
        // if ($subsidiaries->isNotEmpty()) {
        //     $subsidiary = $subsidiaries->first();
        //     $shareholders = explode(',', $subsidiary->shareholder_subsidiary);
        //     $shareholder_data = [];
        //     $total_share = 0;

        //     if (is_array($shareholders)) {
        //         foreach ($shareholders as $shareholder) {
        //             $share_info = explode('(', $shareholder);
        //             $shareholder_name = trim($share_info[0]);

        //             if (isset($share_info[1])) {
        //                 $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
        //                 $total_share += $share_percentage;
        //                 $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
        //             } else {
        //                 $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
        //             }
        //         }
        //     } else {
        //         $share_info = explode('(', $shareholders);
        //         $shareholder_name = trim($share_info[0]);

        //         if (isset($share_info[1])) {
        //             $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
        //             $total_share += $share_percentage;
        //             $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
        //         } else {
        //             $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => null];
        //         }
        //     }

        //     usort($shareholder_data, function ($a, $b) {
        //         return $b['share_percentage'] <=> $a['share_percentage'];
        //     });

        //     $majority_shareholder = $shareholder_data[0]['name'];
        //     $majority_share_percentage = $shareholder_data[0]['share_percentage'];

        //     if ($subsidiary->group_type == 'Independent') {
        //         $group_narrative = 'is a company controlled by';
        //         $group_narrative2 = '';
        //     } else if ($subsidiary->group_type == 'Coop') {
        //         $group_narrative = 'is a cooperative controlled by';
        //         $group_narrative2 = '';
        //     } else {
        //         $group_narrative = 'is a subsidiary of the ';
        //         $group_narrative2 = ' group';
        //     }

        //     // narasi shareholder v1 with no link
        //     if (count($shareholder_data) > 1) {
        //         if ($total_share > 50) {
        //             $response = $subsidiary->group_name . ' is a group of companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //         } else {
        //             $response = $subsidiary->group_name . ' is a group companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //         }
        //     } else {
        //         // $response = $subsidiary->group_name . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' located at ' . $subsidiary->principal_activities . '.' . 'Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
        //         $response = $subsidiary->group_name . ' is a group companies operating in ' . $subsidiary->country_operation . ' and engaged in ' . $subsidiary->principal_activities . '.';
        //     }

        //     if (count($shareholder_data) > 0) {
        //         $perusahaan = implode(' and ', $subsidiaries->pluck('group_name')->unique()->toArray());
        //     } else {
        //         $perusahaan = '';
        //     }

        //     // end narasi shareholder v1 with no link
        // } else {
        //     $response = 'Subsidiary not found..';
        // }

        // // $subsidiary = response()->json(['message' => $response]);
        // $subsidiary = $response;
        // // end jangan dihapus

        // return $subsidiary;
        // return view('content.en.test', compact('consolidations'));
        // return view('content.en.indexGroup', compact('consolidations', 'perusahaan', 'subsidiary', 'users0', 'consul0', 'consol0', 'coordinates0'));
        
        return view('content.en.indexGroup2', compact('groups', 'users', 'consul', 'consol', 'consolidations', 'coordinates', 'users0', 'consul0', 'consol0', 'coordinates0'));
        // return view('maps', compact('coordinates', 'consol', 'subsidiary'));
        // end versi chat 
    }

}