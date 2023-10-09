<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Consolidation;
use App\Models\Chatbot;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use DOMDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientCorporateProfileController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource.
     */
    // public function index(): Response
    public function index()
    {
        $subsidiary = Consolidation::all();
        $groupName = Consolidation::all();
        return view('content.home', compact('subsidiary', 'groupName'));
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

    public function subsidiaryShow(Request $request)
    {
        // $userLevel = auth()->user()->user_level;
        $user = Auth::user();

        $consol = Consolidation::all();
        $coordinates = null; // Initialize coordinates variable
        $users = User::all();
        $consul = User::all();
        $subsidiaryName = $request->input('subsidiary');
        // $distinctSubsidiary = Consolidation::where('subsidiary', $subsidiaryName)
        //     ->distinct('subsidiary')
        //     ->pluck('subsidiary');

        // Logika dan data untuk view corporate_profile.blade.php berdasarkan level pengguna
        if ($user && $user->user_level == "Admin") { // Admin
            $content = "Ini adalah konten untuk admin.";
        } elseif ($user && $user->user_level == "Premium") { // User Level 1
            $loginBy = "User Premium";
            if ($subsidiaryName) {
                // Fetch the coordinate data from the database based on the subsidiary
                // $coordinates = DB::table('consolidations')->select('latitude', 'longitude')->where('subsidiary', $subsidiaryName)->first();
                $coordinates = DB::table('consolidations')->select('latitude', 'longitude', 'subsidiary', 'country_operation', 'province', 'regency', 'facilities', 'capacity', 'sizebyeq', 'estate', 'group_name', 'principal_activities')->where('subsidiary', $subsidiaryName)->get();
            }
            // return view('maps', compact('coordinates', 'consol', 'subsidiary'));

            $consolidations = DB::table('consolidations')
                ->where('subsidiary', $subsidiaryName)
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

                // narasi shareholder v1 with no link
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

                // end narasi shareholder v1 with no link
            } else {
                $response = 'Subsidiary not found..';
            }

            // $subsidiary = response()->json(['message' => $response]);
            $subsidiary = $response;
            // return $subsidiary;
            // return view('content.en.test', compact('consolidations'));
            return view('content.en.indexSubsidiary', compact('consolidations', 'perusahaan', 'subsidiary', 'users', 'consul', 'consol', 'coordinates', 'loginBy'));
            // return view('maps', compact('coordinates', 'consol', 'subsidiary'));
            // end versi chat 
        } elseif ($user && $user->user_level == "Standard") { // User Level 2
            $loginBy = "User Standard";
            if ($subsidiaryName) {
                // Fetch the coordinate data from the database based on the subsidiary
                // $coordinates = DB::table('consolidations')->select('latitude', 'longitude')->where('subsidiary', $subsidiaryName)->first();
                $coordinates = DB::table('consolidations')->select('latitude', 'longitude', 'subsidiary', 'country_operation', 'province', 'regency', 'facilities', 'capacity', 'sizebyeq', 'estate', 'group_name', 'principal_activities')->where('subsidiary', $subsidiaryName)->get();
            }
            // return view('maps', compact('coordinates', 'consol', 'subsidiary'));

            $consolidations = DB::table('consolidations')
                ->where('subsidiary', $subsidiaryName)
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

                // narasi shareholder v1 with no link
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

                // end narasi shareholder v1 with no link
            } else {
                $response = 'Subsidiary not found..';
            }

            // $subsidiary = response()->json(['message' => $response]);
            $subsidiary = $response;
            // return $subsidiary;
            // return view('content.en.test', compact('consolidations'));
            return view('content.en.indexSubsidiary', compact('consolidations', 'perusahaan', 'subsidiary', 'users', 'consul', 'consol', 'coordinates', 'loginBy'));
            // return view('maps', compact('coordinates', 'consol', 'subsidiary'));
            // end versi chat 
        } else { // Default jika tidak ada level yang sesuai
            // $content = "Anda tidak memiliki akses ke konten ini.";
            return "Basic login";
        }

        // return view('corporate_profile', ['content' => $content]);

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
        // return $subsidiary;
        // return view('content.en.test', compact('consolidations'));
        return view('content.en.indexGroup', compact('consolidations', 'perusahaan', 'subsidiary', 'users', 'consul', 'consol', 'coordinates'));
        // return view('maps', compact('coordinates', 'consol', 'subsidiary'));
        // end versi chat 
    }

}