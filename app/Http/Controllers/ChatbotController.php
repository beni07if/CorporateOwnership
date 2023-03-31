<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatbot;
use App\Models\Shareholder;
use App\Models\Consolidation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use Maatwebsite\Excel\Facades\Excel;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot');
    }
    public function chatbotCorporateProfile()
    {
        return view('CorporateProfile.chatbotCorporateProfile');
    }
    public function adminlte()
    {
        return view('corporateProfile');
        // return "test";
    }

    // public function chatbot(Request $request)
    // {
    //     $question = $request->input('message');
    //     $chatbot = Chatbot::where('question', 'like', '%' . $question . '%')->first();
    //     if ($chatbot) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => $chatbot->answer,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Sorry, I do not understand your question. Please try again.',
    //         ]);
    //     }
    // }

    public function store(Request $request)
    {
        // $message = $request->input('message');
        // $reply = Chatbot::where('message', 'like', '%' . str_replace(' ', '%', $message) . '%')->first();

        // if (!$reply) {
        //     $reply = "Maaf, data subsidiary yang anda cari tidak ditemukan..";
        // } else {
        //     $reply = $reply->reply;
        // }

        // // Chatbot::create([
        // //     'user_id' => 1,
        // //     'message' => $message,
        // //     'reply' => $reply,
        // // ]);

        // return response()->json([
        //     'message' => $reply,
        // ]);


        $message = $request->input('message');
        $words = explode(' ', $message);
        $chatbot = DB::table('chatbot')
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->orWhere('message', 'like', '%' . $word . '%');
                }
            })
            ->first();

        if (!$chatbot) {
            $reply = "Maaf, data subsidiary yang Anda cari tidak ditemukan.";
        } else {
            $reply = $chatbot->reply;
            // return $countSubsidiary;
        }

        return response()->json([
            'message' => $reply,
        ]);
    }

    public function store2(Request $request)
    {
        $duplikat = DB::table('chatbot')
            ->select('message')
            ->distinct()
            ->get();
        return view('CorporateProfile.chatbot2', compact('duplikat'));
    }

    public function chats(Request $request)
    {

        return view('CorporateProfile.chatbot3');
    }

    public function chat(Request $request)
    {
        // Ambil input dari pengguna
        $input = $request->input('message');

        // Query untuk mencari data pada tabel chatbot yang sesuai dengan input pengguna
        $result = DB::table('chatbot')
            ->select('reply')
            ->where('message', 'like', '%' . $input . '%')
            ->get();

        // Jika data ditemukan, tampilkan respons
        if (!$result->isEmpty()) {
            $response = 'Saat ini ' . $input . ' memiliki ';
            foreach ($result as $item) {
                $response .= $item->reply . ', ';
            }
            $response = rtrim($response, ', ') . '.';
        } else {
            // Jika data tidak ditemukan, tampilkan pesan error
            $response = 'Maaf, saya tidak dapat menemukan informasi yang Anda cari.';
        }

        // Return respons dalam format JSON
        return response()->json([
            'message' => $response
        ]);
    }

    public function chat4(Request $request)
    {

        return view('CorporateProfile.chatbot4');
    }

    // public function index()
    // {
    //     menampilkan halaman chatbot
    //     return view('CorporateProfile.chatbot4');
    // }

    public function response(Request $request)
    {
        // menerima input pesan dari user
        $pesan = strtolower($request->input('pesan'));

        // melakukan query ke database untuk mencari perusahaan yang diinginkan
        $perusahaan = Consolidation::where('subsidiary', 'like', "%{$pesan}%")
            ->orWhere('group_name', 'like', "%{$pesan}%")
            ->first();

        // menampilkan respon sesuai dengan kondisi yang diinginkan
        dd($perusahaan);
        if ($perusahaan) {
            $response = "{$perusahaan->subsidiary} adalah perusahaan kebun sawit yang terletak di country {$perusahaan->country} yang tersebar di province ";

            // menambahkan provinsi yang dimiliki perusahaan ke dalam respon
            $provinces = [];

            if ($perusahaan->province) {
                array_push($provinces, $perusahaan->province);
            }

            $otherPerusahaan = Consolidation::where('subsidiary', $perusahaan->subsidiary)
                ->where('province', '!=', $perusahaan->province)
                ->get();

            foreach ($otherPerusahaan as $other) {
                array_push($provinces, $other->province);
            }

            $provinces = array_unique($provinces);

            $response .= implode(', ', $provinces);

            // menambahkan informasi activity
            if ($perusahaan->activity) {
                $response .= " dan memiliki activity yaitu {$perusahaan->activity}";
            }

            // menambahkan informasi shareholder
            $shareholders = Consolidation::where('subsidiary', $perusahaan->subsidiary)
                ->where('shareholder', '!=', '')
                ->get();

            if ($shareholders->count() > 0) {
                $response .= ". Mayoritas kepemilikan saham dimiliki oleh {$shareholders[0]->shareholder}";

                for ($i = 1; $i < $shareholders->count(); $i++) {
                    $response .= " dan {$shareholders[$i]->shareholder}";
                }

                $response .= " yaitu sebesar {$shareholders[0]->saham}%";

                for ($i = 1; $i < $shareholders->count(); $i++) {
                    $response .= " dan {$shareholders[$i]->saham}%";
                }

                $response .= ".";
            }

            // menambahkan informasi member_rspo
            if ($perusahaan->member_rspo == 'yes') {
                $response .= " Selain itu {$perusahaan->subsidiary} sudah menjadi member_rspo";
            }
        } else {
            $response = "Maaf, perusahaan yang Anda cari tidak ditemukan.";
        }

        return response()->json(['response' => $response]);
    }

    public function getResponse(Request $request)
    {
        $input = strtolower($request->input('message'));

        $company = DB::table('consolidations')
            ->where('subsidiary', 'like', '%' . $input . '%')
            ->first();

        if (!$company) {
            $company = DB::table('consolidations')
                ->where('shareholder', 'like', '%' . $input . '%')
                ->first();
        }

        if (!$company) {
            return "Maaf, perusahaan yang Anda cari tidak ditemukan.";
        }

        $province_list = [];
        if ($company->province) {
            $province_list[] = $company->province;
        }
        if ($company->province2) {
            $province_list[] = $company->province2;
        }
        if ($company->province3) {
            $province_list[] = $company->province3;
        }
        $provinces = implode(', ', $province_list);

        $response = "{$company->subsidiary} adalah perusahaan kebun sawit yang terletak di {$company->country} yang tersebar di provinsi {$provinces}. {$company->subsidiary} memiliki activity yaitu {$company->activity}. Mayoritas kepemilikan saham dimiliki oleh {$company->shareholder} yaitu {$company->saham}%.";
        if ($company->shareholder2) {
            $response .= " Dan sisanya dimiliki oleh {$company->shareholder2}";
            if ($company->saham2) {
                $response .= " yaitu {$company->saham2}%";
            }
        }
        if ($company->member_rspo == 'yes') {
            $response .= " Selain itu, {$company->subsidiary} sudah menjadi anggota RSPO.";
        }

        return $response;
    }




    public function getSubsidiary0(Request $request)
    {
        $input = $request->input('message'); // ambil input pesan dari userssss
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
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="#">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '% dan sisanya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //             return '<a href="#">' . $data['name'] . '</a> (' . $data['share_percentage'] . '%)';
            //         }, array_slice($shareholder_data, 1))) . '. ';
            //     } else {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya didistribusikan di antara beberapa pemegang saham, yaitu ' . implode(', ', array_map(function ($data) {
            //             return '<a href="#">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //         }, $shareholder_data)) . '. ';
            //     }
            // } else {
            //     $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(
            //         function ($data) {
            //             return '<a href="#">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //         },
            //         $shareholder_data
            //     )) . '. ';
            // }


            // Clickable, Ini dipakai jika tabel shareholder data shareholdernya lengkap, karena shareholder name nya clickable biar pas klik tidak kosong atau memunculkan pesan error
            $shareholders = explode(',', $subsidiary->shareholder_subsidiary);
            $shareholder_data = [];
            $total_share = 0;

            foreach ($shareholders as $shareholder) {
                $share_info = explode('(', $shareholder);
                $shareholder_name = trim($share_info[0]);
                $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
                $total_share += $share_percentage;
                $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
            }

            usort($shareholder_data, function ($a, $b) {
                return $b['share_percentage'] <=> $a['share_percentage'];
            });

            $majority_shareholder = $shareholder_data[0]['name'];
            $majority_share_percentage = $shareholder_data[0]['share_percentage'];

            if ($subsidiary->group_type == 'Independent') {
                $group_narrative = 'adalah perusahaan yang dikendalikan oleh';
            } else if ($subsidiary->group_type == 'Coop') {
                $group_narrative = 'adalah koperasi yang dikendalikan oleh';
            } else {
                $group_narrative = 'adalah anak perusahaan dari group';
            }

            // // narasi 1 v1 
            // if (count($shareholder_data) > 1) {
            //     if ($total_share > 50) {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '% dan sisanya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //             return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //         }, array_slice($shareholder_data, 1))) . '. ';
            //     } else {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya didistribusikan di antara beberapa pemegang saham, yaitu ' . implode(', ', array_map(function ($data) {
            //             return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //         }, $shareholder_data)) . '. ';
            //     }
            // } else {
            //     // $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
            //     $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //         return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //     }, $shareholder_data)) . '. ';
            // }
            // // end narasi 1 v1 

            // narasi 1 v2 
            $principal_activities = $subsidiaries->pluck('principal_activities')->unique()->toArray();

            if (count($shareholder_data) >= 1) {
                // Calculate total share percentage owned by all shareholders
                $total_share = collect($shareholder_data)->sum('share_percentage');

                if ($total_share >= 50) {
                    if (in_array('Oil Palm Plantation', $principal_activities) && in_array('Palm Oil Mill', $principal_activities)) {
                        $principal_activity = ' perkebunan kelapa sawit dan pabrik kelapa sawit (PKS)';
                    } else if (in_array('Oil Palm Plantation & Mill', $principal_activities)) {
                        $principal_activity = ' perkebunan kelapa sawit dan pabrik kelapa sawit (PKS)';
                    } else if (in_array('Manufacturer', $principal_activities)) {
                        $principal_activity = ' manufaktur';
                    } else if (in_array('Palm Oil Mill', $principal_activities)) {
                        $principal_activity = ' pabrik kelapa sawit';
                    } else if (in_array('Oil Palm Plantation', $principal_activities)) {
                        $principal_activity = ' perkebunan kelapa sawit';
                    } else {
                        $principal_activity = implode(' dan ', $principal_activities);
                    }
                    $shareholder_data_formatted = array_map(function ($data) {
                        return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
                    }, $shareholder_data);
                    // Add majority shareholder to formatted shareholder data
                    array_unshift($shareholder_data_formatted, '<a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%');
                    $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . $principal_activity . '. Mayoritas kepemilikan sahamnya dimiliki oleh ' . implode(' dan ', $shareholder_data_formatted) . '. ';
                } else {
                    $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $principal_activities) . '. Kepemilikan sahamnya hanya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar 100%. ';
                }
            } else {
                $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $principal_activities) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(function ($data) {
                    return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
                }, $shareholder_data)) . '. ';
            }
            // end narasi 1 v2 
            // end clickable



            $estates = [];
            $facilities = [];
            $regencies = [];
            $provinces = [];
            $rspo_member = null;
            $rspo_certified = null;
            $total_sizebyeq = 0;
            $principal_activities = [];
            // $shareholder = [];

            foreach ($subsidiaries as $key => $sub) {
                if (in_array($sub->principal_activities, ["Oil Palm Plantation", "Rubber Plantation", "Nursery", "Smallholder"])) {

                    if (!in_array($sub->sizebyeq, $estates)) {
                        if ($sub->sizebyeq) {
                            $estates[] = $sub->sizebyeq;
                            if ($key == 0) {
                                $response .= '. ' . $sub->subsidiary . ' memiliki kebun ' . $sub->estate . ' di ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar.';
                            } else {
                                $response .= ', selain itu juga memiliki kebun ' . $sub->estate . ' di ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar.';
                            }
                            $total_sizebyeq += $sub->sizebyeq;
                        }
                    } else {
                        $total_sizebyeq += $sub->sizebyeq;
                        $response .= ', ' . $sub->regency;
                    }
                } elseif ($sub->principal_activities == "Oil Palm Plantation & Mill") {
                    $response .= ' ' . $sub->subsidiary . ' memiliki kebun kelapa sawit dengan luas ' . $sub->sizebyeq . ' hektar';
                    if (!empty($sub->capacity)) {
                        $response .= ' dan PKS dengan kapasitas ' . $sub->capacity . '.';
                    } else {
                        $response .= '.';
                    }
                } elseif (in_array($sub->principal_activities, ["Palm Oil Mill", "Manufacturer", "Refinery", "Rubber Factory", "Oleochemical", "Kernel Crhursing Plant", "Biodisel Plant"])) {
                    // $response .= ' ' . $sub->subsidiary . ' memiliki ' . $sub->principal_activities . ' dengan kapasitas ';
                    if (!empty($sub->capacity)) {
                        $response .= '. ' . $sub->subsidiary . ' memiliki ' . $sub->principal_activities . ' dengan kapasitas ' . $sub->capacity . '.';
                    } else {
                        $response .= '.';
                    }
                }

                if (!in_array($sub->principal_activities, $principal_activities)) {
                    $principal_activities[] = $sub->principal_activities;
                }


                if (!in_array($sub->regency, $regencies)) {
                    $regencies[] = $sub->regency;
                }

                if (!in_array($sub->province, $provinces)) {
                    $provinces[] = $sub->province;
                }
                // if (!in_array($sub->shareholder_subsidiary, $shareholder)) {
                //     $shareholder[] = $sub->shareholder_subsidiary;
                // }
            }


            // $response .= '. Kepemilikan saham  ' . $sub->subsidiary . ' dimiliki oleh ' . implode(', ', $shareholder) . '.';
            // $response .= '. Kepemilikan saham  ' . $sub->subsidiary . ' dimiliki oleh ' . implode(', ', $shareholder) . ' dan sisanya dimiliki oleh  ' . implode(', ', $shareholder) . '.';
            // $response .= ' Provinsi ' . implode(', ', $provinces) . ' Kabupaten ' . implode(', ', $regencies) . ' dan secara geografis terletak di koordinat ' . $subsidiary->latitude . ' (latitude) – ' . $subsidiary->longitude . ' (longitude).';
            // $response .= ' Aktivitas prinsipal perusahaan adalah ' . implode(' dan ', $principal_activities);
        } else {
            $response = 'Data subsidiary tidak ditemukan.';
        }

        return response()->json(['message' => $response]);
    }

    public function showShareholder($name)
    {
        $shareholders = Shareholder::where('shareholder_name', $name)->first();

        return view('CorporateProfile.shareholder', ['shareholder' => $shareholders]);
    }

    public function showSubsidiary($subsidiary)
    {
        $company = Consolidation::where('subsidiary', $subsidiary)->first();

        return view('CorporateProfile.chatbot5s', ['shareholder' => $company]);
    }


    public function chatbot6(Request $request)
    {

        return view('CorporateProfile.chatbot6');
    }

    public function getResponse6(Request $request)
    {
        $input = $request->input('input');

        // Lakukan query ke database untuk mencari data subsidiary yang cocok dengan input pengguna
        $sub = Consolidation::where('subsidiary', 'like', '%' . $input . '%')->first();

        if ($sub) {
            $response = $sub->subsidiary . ' merupakan perusahaan kelapa sawit yang memiliki activity ' . $sub->principal_activities . ' yang masuk dalam group ' . $sub->group_name . ' (status_group ' . $sub->group_status . ') berlokasi di country ' . $sub->country_registration . ' regency ' . $sub->regency . ' dan province ' . $sub->province . ' dan secara geografis terletak di latitude ' . $sub->latitude . ' - longitude ' . $sub->longitude . '. ' . $sub->subsidiary . ' memiliki kebun yang bernama estate ' . $sub->estate . ' dengan luas total sizebyeq ' . $sub->sizebyeq . ' hektar dan saat ini status_operation masih ' . $sub->status_operation . '. ' . $sub->subsidiary . ' belum terdaftar sebagai rspo_member dan belum memiliki rspo...';
        } else {
            $response = 'Data subsidiary tidak ditemukan';
        }

        return view('CorporateProfile.chatbot6', ['response' => $response]);
    }

    public function chatbot7(Request $request)
    {

        return view('CorporateProfile.chatbot7');
    }

    public function getSubsidiary7(Request $request)
    {
        $input = $request->input('message');
        $subsidiaries = Consolidation::where('subsidiary', 'like', '%' . $input . '%')->get();

        if ($subsidiaries->count() > 0) {
            $response = $input . ' berada di ';
            $regencies = [];

            foreach ($subsidiaries as $subsidiary) {
                $regencies[] = $subsidiary->regency;
            }

            $uniqueRegencies = array_unique($regencies);

            foreach ($uniqueRegencies as $regency) {
                $response .= $regency . ', ';
            }

            $response = rtrim($response, ', ');
            $response .= '.';
        } else {
            $response = 'Data subsidiary tidak ditemukan.';
        }

        return response()->json(['message' => $response]);
    }



    public function export()
    {
        // Mengambil data dari tabel di database
        $data = Chatbot::all();

        // Membuka file CSV untuk ditulis
        $handle = fopen('export.csv', 'w');

        // Menuliskan data ke dalam file CSV
        foreach ($data as $row) {
            fputcsv($handle, [
                $row->id,
                $row->user_id,

                $row->message,
                $row->reply,
                $row->created_at,
                $row->updated_at,
                // dan seterusnya...
            ]);
        }

        // Menutup file CSV
        fclose($handle);

        // Mengirim file CSV ke pengguna
        return response()->download('export.csv');
    }
    // end test import/export csv 


    public function importCsvForm()
    {
        return view('CorporateProfile.formImportCsvFileCorporateProfile');
    }

    public function importCsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            return redirect('/import-csv')
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();

            $file = fopen($path, 'r');

            // Menghapus data lama sebelum memasukkan data baru
            Chatbot::truncate();

            $header = fgetcsv($file);
            $csv = [];
            while (($row = fgetcsv($file)) !== false) {
                $csv[] = array_combine($header, $row);
            }
            fclose($file);

            $successCount = 0;
            $failedCount = 0;
            $failedRows = [];

            foreach ($csv as $row) {
                // Remove 'id', 'created_at', and 'updated_at' columns
                unset($row['id']);
                unset($row['created_at']);
                unset($row['updated_at']);

                $validator = Validator::make($row, [
                    'user_id' => 'required',
                    'message' => 'required',
                    'reply' => 'required'
                ]);

                if ($validator->fails()) {
                    $failedCount++;
                    $failedRows[] = $row;
                    continue;
                }

                Chatbot::create([
                    'user_id' => $row['user_id'],
                    'message' => $row['message'],
                    'reply' => $row['reply']
                ]);

                $successCount++;
            }

            if ($failedCount > 0) {
                return redirect('/import-csv')
                    ->with('warning', "{$failedCount} data failed to import.")
                    ->with('failedRows', $failedRows)
                    ->with('success', "{$successCount} data imported successfully.");
            } else {
                return redirect('/import-csv')->with('success', "{$successCount} data imported successfully.");
            }
        }

        return redirect('/import-csv')->with('error', 'Error importing data.');
    }



    public function importCsvFormConsolidation()
    {
        return view('CorporateProfile.formImportCsvFileConsolidation');
    }

    public function importCsvConsolidation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            return redirect('/import-csv-consolidation')
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('file')) {
            $path = $request->file('file')->getRealPath();

            $file = fopen($path, 'r');

            // Menghapus data lama sebelum memasukkan data baru
            Consolidation::truncate();

            $header = fgetcsv($file);
            $csv = [];
            while (($row = fgetcsv($file)) !== false) {
                $csv[] = array_combine($header, $row);
            }
            fclose($file);

            $successCount = 0;
            $failedCount = 0;
            $failedRows = [];

            foreach ($csv as $row) {
                // Remove 'id', 'created_at', and 'updated_at' columns
                unset($row['id']);
                unset($row['created_at']);
                unset($row['updated_at']);

                $validator = Validator::make($row, [
                    'user_id' => 'nullable',
                    'id_subsidiary' => 'nullable',
                    'id_group' => 'nullable',
                    'id_mill' => 'nullable',
                    'group_type' => 'nullable',
                    'group_name' => 'nullable',
                    'official_group_name' => 'nullable',
                    'owner' => 'nullable',
                    'group_status' => 'nullable',
                    'stock_exchange' => 'nullable',
                    'country_registration' => 'nullable',
                    'rspo_member' => 'nullable',
                    'ndpe_policy' => 'nullable',
                    'ownership_status' => 'nullable',
                    'shareholder_subsidiary' => 'nullable',
                    'subsidiary' => 'nullable',
                    'principal_activities' => 'nullable',
                    'facilities' => 'nullable',
                    'estate' => 'nullable',
                    'status_operation' => 'nullable',
                    'capacity' => 'nullable',
                    'latitude' => 'nullable',
                    'longitude' => 'nullable',
                    'country_operation' => 'nullable',
                    'province' => 'nullable',
                    'regency' => 'nullable',
                    'map_availability' => 'nullable',
                    'land_title' => 'nullable',
                    'sizebyeq' => 'nullable',
                    'rspo_certified' => 'nullable',
                    'mspo_certified' => 'nullable',
                    'ispo_certified' => 'nullable',
                    'data_source' => 'nullable',
                    'data_update' => 'nullable',
                    'complete_percen' => 'nullable',
                    'akta' => 'nullable',
                    'note' => 'nullable'
                ]);

                if ($validator->fails()) {
                    $failedCount++;
                    $failedRows[] = $row;
                    continue;
                }

                Consolidation::create([
                    'user_id' => $row['user_id'],
                    'id_subsidiary' => $row['id_subsidiary'],
                    'id_group' => $row['id_group'],
                    'id_mill' => $row['id_mill'],
                    'group_type' => $row['group_type'],
                    'group_name' => $row['group_name'],
                    'official_group_name' => $row['official_group_name'],
                    'owner' => $row['owner'],
                    'group_status' => $row['group_status'],
                    'stock_exchange' => $row['stock_exchange'],
                    'country_registration' => $row['country_registration'],
                    'rspo_member' => $row['rspo_member'],
                    'ndpe_policy' => $row['ndpe_policy'],
                    'ownership_status' => $row['ownership_status'],
                    'shareholder_subsidiary' => $row['shareholder_subsidiary'],
                    'subsidiary' => $row['subsidiary'],
                    'principal_activities' => $row['principal_activities'],
                    'facilities' => $row['facilities'],
                    'estate' => $row['estate'],
                    'status_operation' => $row['status_operation'],
                    'capacity' => $row['capacity'],
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                    'country_operation' => $row['country_operation'],
                    'province' => $row['province'],
                    'regency' => $row['regency'],
                    'map_availability' => $row['map_availability'],
                    'land_title' => $row['land_title'],
                    'sizebyeq' => $row['sizebyeq'],
                    'rspo_certified' => $row['rspo_certified'],
                    'mspo_certified' => $row['mspo_certified'],
                    'ispo_certified' => $row['ispo_certified'],
                    'data_source' => $row['data_source'],
                    'data_update' => $row['data_update'],
                    'complete_percen' => $row['complete_percen'],
                    'akta' => $row['akta'],
                    'note' => $row['note']
                ]);

                $successCount++;
            }

            if ($failedCount > 0) {
                return redirect('/import-csv-consolidation')
                    ->with('warning', "{$failedCount} data failed to import.")
                    ->with('failedRows', $failedRows)
                    ->with('success', "{$successCount} data imported successfully.");
            } else {
                return redirect('/import-csv-consolidation')->with('success', "{$successCount} data imported successfully.");
            }
        }

        return redirect('/import-csv-consolidation')->with('error', 'Error importing data.');
    }

    // get group en
    public function getGroupEn(Request $request)
    {
        $input = $request->input('message'); // ambil input pesan dari userssss
        $subsidiaries = Consolidation::where('group_name', 'like', '%' . $input . '%')->get(); // cari data subsidiary yang cocok dengan input

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
            $company = [];

            foreach ($shareholders as $shareholder) {
                $share_info = explode('(', $shareholder);
                $shareholder_name = trim($share_info[0]);
                $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
                $total_share += $share_percentage;
                $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
            }

            usort($shareholder_data, function ($a, $b) {
                return $b['share_percentage'] <=> $a['share_percentage'];
            });

            $majority_shareholder = $shareholder_data[0]['name'];
            $majority_share_percentage = $shareholder_data[0]['share_percentage'];

            if ($subsidiary->group_type == 'Independent') {
                $group_narrative2 = 'is the oil palm plantation industry that controls';
            } else if ($subsidiary->group_type == 'Coop') {
                $group_narrative2 = 'is the controlling cooperative';
            } else {
                $group_narrative2 = 'is a group of oil palm plantation industries that have subsidiaries namely';
            }

            // narasi shareholder v1 
            if (count($shareholder_data) > 1) {
                if ($total_share > 50) {
                    // narasi dengan subsidiary dengan link 
                    $subLinks = [];
                    $subCount = $subsidiaries->pluck('subsidiary')->unique()->count();
                    $subNarrative = '';
                    $i = 0;

                    foreach ($subsidiaries->pluck('subsidiary')->unique() as $subsidiaryName) {
                        $subLink =  $subsidiaryName;
                        // $subLink = '<a href="' . route('company', ['subsidiary' => $subsidiaryName]) . '">' . $subsidiaryName . '</a>';
                        if ($subCount > 1) {
                            $i++;
                            if ($i == $subCount) {
                                $subNarrative .= 'dan ' . $subLink;
                            } elseif ($i == $subCount - 1) {
                                $subNarrative .= $subLink . ' ';
                            } else {
                                $subNarrative .= $subLink . ', ';
                            }
                        } else {
                            $subNarrative = $subLink;
                        }
                    }

                    $response = sprintf('%s %s %s.', $subsidiary->group_name, $group_narrative2, $subNarrative);

                    // end narasi dengan subsidiary dengan link 

                    // // narasi dengan subsidiary tanpa link 
                    // $response = 'Grup ' . $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiaries->pluck('subsidiary')->unique()->toArray()) . '.';
                    // // end narasi dengan subsidiary tanpa link 

                    // $response = $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiary) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '% dan sisanya dimiliki oleh ' . implode(', ', array_map(
                    //     function ($data) {
                    //         return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> ' . $data['share_percentage'] . '%';
                    //     },
                    //     array_slice($shareholder_data, 1)
                    // )) . '. ';
                } else {
                    // narasi dengan subsidiary dengan link 
                    $subLinks = [];
                    $subCount = $subsidiaries->pluck('subsidiary')->unique()->count();
                    $subNarrative = '';
                    $i = 0;

                    foreach ($subsidiaries->pluck('subsidiary')->unique() as $subsidiaryName) {
                        $subLink = $subsidiaryName;
                        // $subLink = '<a href="' . route('company', ['subsidiary' => $subsidiaryName]) . '">' . $subsidiaryName . '</a>';
                        if ($subCount > 1) {
                            $i++;
                            if ($i == $subCount) {
                                $subNarrative .= 'dan ' . $subLink;
                            } elseif ($i == $subCount - 1) {
                                $subNarrative .= $subLink . ' ';
                            } else {
                                $subNarrative .= $subLink . ', ';
                            }
                        } else {
                            $subNarrative = $subLink;
                        }
                    }

                    $response = sprintf('%s %s %s.', $subsidiary->group_name, $group_narrative2, $subNarrative);

                    // end narasi dengan subsidiary dengan link 

                    // // narasi dengan subsidiary tanpa link 
                    // $response = 'Grup ' . $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiaries->pluck('subsidiary')->unique()->toArray()) . '.';
                    // // end narasi dengan subsidiary tanpa link 

                    // $response = $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiary) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya didistribusikan di antara beberapa pemegang saham, yaitu ' . implode(', ', array_map(
                    //     function ($data) {
                    //         return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
                    //     },
                    //     $shareholder_data
                    // )) . '. ';
                }
            } else {
                // narasi dengan subsidiary dengan link 
                $subLinks = [];
                $subCount = $subsidiaries->pluck('subsidiary')->unique()->count();
                $subNarrative = '';
                $i = 0;

                foreach ($subsidiaries->pluck('subsidiary')->unique() as $subsidiaryName) {
                    $subLink = $subsidiaryName;
                    // $subLink = '<a href="' . route('company', ['subsidiary' => $subsidiaryName]) . '">' . $subsidiaryName . '</a>';
                    if ($subCount > 1) {
                        $i++;
                        if ($i == $subCount) {
                            $subNarrative .= 'dan ' . $subLink;
                        } elseif ($i == $subCount - 1) {
                            $subNarrative .= $subLink . ' ';
                        } else {
                            $subNarrative .= $subLink . ', ';
                        }
                    } else {
                        $subNarrative = $subLink;
                    }
                }

                $response = sprintf('%s %s %s.', $subsidiary->group_name, $group_narrative2, $subNarrative);

                // end narasi dengan subsidiary dengan link 

                // // narasi dengan subsidiary tanpa link 
                // $response = 'Grup ' . $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiaries->pluck('subsidiary')->unique()->toArray()) . '.';
                // // end narasi dengan subsidiary tanpa link 

                // $response = $subsidiary->subsidiary . ' ' . $group_narrative2 . ' '. implode(', ', $subsidiary) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
                // $response = $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiary) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(function ($data) {
                //     return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
                // }, $shareholder_data)) . '. ';
            }
            // end narasi shareholder v1 

            // // narasi shareholder v2 
            // $principal_activities = $subsidiaries->pluck('principal_activities')->unique()->toArray();

            // if (count($shareholder_data) >= 1) {
            //     // Calculate total share percentage owned by all shareholders
            //     $total_share = collect($shareholder_data)->sum('share_percentage');

            //     if ($total_share >= 50) {
            //         if (in_array('Oil Palm Plantation', $principal_activities) && in_array('Palm Oil Mill', $principal_activities)) {
            //             $principal_activity = ' perkebunan kelapa sawit dan pabrik kelapa sawit (PKS)';
            //         } else if (in_array(
            //             'Oil Palm Plantation & Mill',
            //             $principal_activities
            //         )) {
            //             $principal_activity = ' perkebunan kelapa sawit dan pabrik kelapa sawit (PKS)';
            //         } else if (in_array('Manufacturer', $principal_activities)) {
            //             $principal_activity = ' manufaktur';
            //         } else if (in_array('Palm Oil Mill', $principal_activities)) {
            //             $principal_activity = ' pabrik kelapa sawit';
            //         } else if (in_array('Oil Palm Plantation', $principal_activities)) {
            //             $principal_activity = ' perkebunan kelapa sawit';
            //         } else {
            //             $principal_activity = implode(' dan ', $principal_activities);
            //         }
            //         $shareholder_data_formatted = array_map(function ($data) {
            //             return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //         }, $shareholder_data);
            //         // Add majority shareholder to formatted shareholder data
            //         array_unshift($shareholder_data_formatted, '<a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%');
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . $principal_activity . '. Mayoritas kepemilikan sahamnya dimiliki oleh ' . implode(' dan ', $shareholder_data_formatted) . '. ';
            //     } else {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $principal_activities) . '. Kepemilikan sahamnya hanya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar 100%. ';
            //     }
            // } else {
            //     $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $principal_activities) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //         return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //     }, $shareholder_data)) . '. ';
            // }
            // // end narasi shareholder v2 
            // end clickable



            $estates = [];
            $facilities = [];
            $regencies = [];
            $provinces = [];
            $rspo_member = null;
            $rspo_certified = null;
            $total_sizebyeq = 0;
            $principal_activities = [];
            // $shareholder = [];

            // foreach ($subsidiaries as $key => $sub) {
            //     if (in_array($sub->principal_activities, ["Oil Palm Plantation", "Rubber Plantation", "Nursery", "Smallholder"])) {

            //         if (!in_array($sub->sizebyeq, $estates)) {
            //             if ($sub->sizebyeq) {
            //                 $estates[] = $sub->sizebyeq;
            //                 if ($key == 0) {
            //                     $response .= '. ' . $sub->subsidiary . ' memiliki kebun ' . $sub->estate . ' di ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar.';
            //                 } else {
            //                     $response .= ', selain itu juga memiliki kebun ' . $sub->estate . ' di ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar.';
            //                 }
            //                 $total_sizebyeq += $sub->sizebyeq;
            //             }
            //         } else {
            //             $total_sizebyeq += $sub->sizebyeq;
            //             $response .= ', ' . $sub->regency;
            //         }
            //     } elseif ($sub->principal_activities == "Oil Palm Plantation & Mill") {
            //         $response .= ' ' . $sub->subsidiary . ' memiliki kebun kelapa sawit dengan luas ' . $sub->sizebyeq . ' hektar';
            //         if (!empty($sub->capacity)) {
            //             $response .= ' dan PKS dengan kapasitas ' . $sub->capacity . '.';
            //         } else {
            //             $response .= '.';
            //         }
            //     } elseif (in_array($sub->principal_activities, ["Palm Oil Mill", "Manufacturer", "Refinery", "Rubber Factory", "Oleochemical", "Kernel Crhursing Plant", "Biodisel Plant"])) {
            //         // $response .= ' ' . $sub->subsidiary . ' memiliki ' . $sub->principal_activities . ' dengan kapasitas ';
            //         if (!empty($sub->capacity)) {
            //             $response .= '. ' . $sub->subsidiary . ' memiliki ' . $sub->principal_activities . ' dengan kapasitas ' . $sub->capacity . '.';
            //         } else {
            //             $response .= '.';
            //         }
            //     }

            //     if (!in_array($sub->principal_activities, $principal_activities)) {
            //         $principal_activities[] = $sub->principal_activities;
            //     }


            //     if (!in_array($sub->regency, $regencies)) {
            //         $regencies[] = $sub->regency;
            //     }

            //     if (!in_array($sub->province, $provinces)) {
            //         $provinces[] = $sub->province;
            //     }
            //     // if (!in_array($sub->shareholder_subsidiary, $shareholder)) {
            //     //     $shareholder[] = $sub->shareholder_subsidiary;
            //     // }
            // }


            // $response .= '. Kepemilikan saham  ' . $sub->subsidiary . ' dimiliki oleh ' . implode(', ', $shareholder) . '.';
            // $response .= '. Kepemilikan saham  ' . $sub->subsidiary . ' dimiliki oleh ' . implode(', ', $shareholder) . ' dan sisanya dimiliki oleh  ' . implode(', ', $shareholder) . '.';
            // $response .= ' Provinsi ' . implode(', ', $provinces) . ' Kabupaten ' . implode(', ', $regencies) . ' dan secara geografis terletak di koordinat ' . $subsidiary->latitude . ' (latitude) – ' . $subsidiary->longitude . ' (longitude).';
            // $response .= ' Aktivitas prinsipal perusahaan adalah ' . implode(' dan ', $principal_activities);
        } else {
            $response = 'Group not found..';
        }

        return response()->json(['message' => $response]);
    }
    // end get group end

    // get group
    public function getGroup(Request $request)
    {
        $input = $request->input('message'); // ambil input pesan dari userssss
        $subsidiaries = Consolidation::where('group_name', 'like', '%' . $input . '%')->get(); // cari data subsidiary yang cocok dengan input

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
            $company = [];

            foreach ($shareholders as $shareholder) {
                $share_info = explode('(', $shareholder);
                $shareholder_name = trim($share_info[0]);
                $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
                $total_share += $share_percentage;
                $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
            }

            usort($shareholder_data, function ($a, $b) {
                return $b['share_percentage'] <=> $a['share_percentage'];
            });

            $majority_shareholder = $shareholder_data[0]['name'];
            $majority_share_percentage = $shareholder_data[0]['share_percentage'];

            if ($subsidiary->group_type == 'Independent') {
                $group_narrative2 = 'adalah industri perkebunan kelapa sawit yang mengontrol ';
            } else if ($subsidiary->group_type == 'Coop') {
                $group_narrative2 = 'adalah koperasi yang mengendalikan ';
            } else {
                $group_narrative2 = ' adalah group dari industri perkebunan kelapa sawit yang memiliki anak perusahaan yaitu ';
            }

            // narasi shareholder v1 
            if (count($shareholder_data) > 1) {
                if ($total_share > 50) {
                    // narasi dengan subsidiary dengan link 
                    $subLinks = [];
                    $subCount = $subsidiaries->pluck('subsidiary')->unique()->count();
                    $subNarrative = '';
                    $i = 0;

                    foreach ($subsidiaries->pluck('subsidiary')->unique() as $subsidiaryName) {
                        $subLink =  $subsidiaryName;
                        // $subLink = '<a href="' . route('company', ['subsidiary' => $subsidiaryName]) . '">' . $subsidiaryName . '</a>';
                        if ($subCount > 1) {
                            $i++;
                            if ($i == $subCount) {
                                $subNarrative .= 'dan ' . $subLink;
                            } elseif ($i == $subCount - 1) {
                                $subNarrative .= $subLink . ' ';
                            } else {
                                $subNarrative .= $subLink . ', ';
                            }
                        } else {
                            $subNarrative = $subLink;
                        }
                    }

                    $response = sprintf('%s %s %s.', $subsidiary->group_name, $group_narrative2, $subNarrative);

                    // end narasi dengan subsidiary dengan link 

                    // // narasi dengan subsidiary tanpa link 
                    // $response = 'Grup ' . $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiaries->pluck('subsidiary')->unique()->toArray()) . '.';
                    // // end narasi dengan subsidiary tanpa link 

                    // $response = $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiary) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '% dan sisanya dimiliki oleh ' . implode(', ', array_map(
                    //     function ($data) {
                    //         return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> ' . $data['share_percentage'] . '%';
                    //     },
                    //     array_slice($shareholder_data, 1)
                    // )) . '. ';
                } else {
                    // narasi dengan subsidiary dengan link 
                    $subLinks = [];
                    $subCount = $subsidiaries->pluck('subsidiary')->unique()->count();
                    $subNarrative = '';
                    $i = 0;

                    foreach ($subsidiaries->pluck('subsidiary')->unique() as $subsidiaryName) {
                        $subLink = $subsidiaryName;
                        // $subLink = '<a href="' . route('company', ['subsidiary' => $subsidiaryName]) . '">' . $subsidiaryName . '</a>';
                        if ($subCount > 1) {
                            $i++;
                            if ($i == $subCount) {
                                $subNarrative .= 'dan ' . $subLink;
                            } elseif ($i == $subCount - 1) {
                                $subNarrative .= $subLink . ' ';
                            } else {
                                $subNarrative .= $subLink . ', ';
                            }
                        } else {
                            $subNarrative = $subLink;
                        }
                    }

                    $response = sprintf('%s %s %s.', $subsidiary->group_name, $group_narrative2, $subNarrative);

                    // end narasi dengan subsidiary dengan link 

                    // // narasi dengan subsidiary tanpa link 
                    // $response = 'Grup ' . $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiaries->pluck('subsidiary')->unique()->toArray()) . '.';
                    // // end narasi dengan subsidiary tanpa link 

                    // $response = $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiary) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya didistribusikan di antara beberapa pemegang saham, yaitu ' . implode(', ', array_map(
                    //     function ($data) {
                    //         return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
                    //     },
                    //     $shareholder_data
                    // )) . '. ';
                }
            } else {
                // narasi dengan subsidiary dengan link 
                $subLinks = [];
                $subCount = $subsidiaries->pluck('subsidiary')->unique()->count();
                $subNarrative = '';
                $i = 0;

                foreach ($subsidiaries->pluck('subsidiary')->unique() as $subsidiaryName) {
                    $subLink = $subsidiaryName;
                    // $subLink = '<a href="' . route('company', ['subsidiary' => $subsidiaryName]) . '">' . $subsidiaryName . '</a>';
                    if ($subCount > 1) {
                        $i++;
                        if ($i == $subCount) {
                            $subNarrative .= 'dan ' . $subLink;
                        } elseif ($i == $subCount - 1) {
                            $subNarrative .= $subLink . ' ';
                        } else {
                            $subNarrative .= $subLink . ', ';
                        }
                    } else {
                        $subNarrative = $subLink;
                    }
                }

                $response = sprintf('%s %s %s.', $subsidiary->group_name, $group_narrative2, $subNarrative);

                // end narasi dengan subsidiary dengan link 

                // // narasi dengan subsidiary tanpa link 
                // $response = 'Grup ' . $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiaries->pluck('subsidiary')->unique()->toArray()) . '.';
                // // end narasi dengan subsidiary tanpa link 

                // $response = $subsidiary->subsidiary . ' ' . $group_narrative2 . ' '. implode(', ', $subsidiary) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
                // $response = $subsidiary->group_name . ' ' . $group_narrative2 . ' ' . implode(', ', $subsidiary) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(function ($data) {
                //     return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
                // }, $shareholder_data)) . '. ';
            }
            // end narasi shareholder v1 

            // // narasi shareholder v2 
            // $principal_activities = $subsidiaries->pluck('principal_activities')->unique()->toArray();

            // if (count($shareholder_data) >= 1) {
            //     // Calculate total share percentage owned by all shareholders
            //     $total_share = collect($shareholder_data)->sum('share_percentage');

            //     if ($total_share >= 50) {
            //         if (in_array('Oil Palm Plantation', $principal_activities) && in_array('Palm Oil Mill', $principal_activities)) {
            //             $principal_activity = ' perkebunan kelapa sawit dan pabrik kelapa sawit (PKS)';
            //         } else if (in_array(
            //             'Oil Palm Plantation & Mill',
            //             $principal_activities
            //         )) {
            //             $principal_activity = ' perkebunan kelapa sawit dan pabrik kelapa sawit (PKS)';
            //         } else if (in_array('Manufacturer', $principal_activities)) {
            //             $principal_activity = ' manufaktur';
            //         } else if (in_array('Palm Oil Mill', $principal_activities)) {
            //             $principal_activity = ' pabrik kelapa sawit';
            //         } else if (in_array('Oil Palm Plantation', $principal_activities)) {
            //             $principal_activity = ' perkebunan kelapa sawit';
            //         } else {
            //             $principal_activity = implode(' dan ', $principal_activities);
            //         }
            //         $shareholder_data_formatted = array_map(function ($data) {
            //             return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //         }, $shareholder_data);
            //         // Add majority shareholder to formatted shareholder data
            //         array_unshift($shareholder_data_formatted, '<a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%');
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . $principal_activity . '. Mayoritas kepemilikan sahamnya dimiliki oleh ' . implode(' dan ', $shareholder_data_formatted) . '. ';
            //     } else {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $principal_activities) . '. Kepemilikan sahamnya hanya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar 100%. ';
            //     }
            // } else {
            //     $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $principal_activities) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //         return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //     }, $shareholder_data)) . '. ';
            // }
            // // end narasi shareholder v2 
            // end clickable



            $estates = [];
            $facilities = [];
            $regencies = [];
            $provinces = [];
            $rspo_member = null;
            $rspo_certified = null;
            $total_sizebyeq = 0;
            $principal_activities = [];
            // $shareholder = [];

            // foreach ($subsidiaries as $key => $sub) {
            //     if (in_array($sub->principal_activities, ["Oil Palm Plantation", "Rubber Plantation", "Nursery", "Smallholder"])) {

            //         if (!in_array($sub->sizebyeq, $estates)) {
            //             if ($sub->sizebyeq) {
            //                 $estates[] = $sub->sizebyeq;
            //                 if ($key == 0) {
            //                     $response .= '. ' . $sub->subsidiary . ' memiliki kebun ' . $sub->estate . ' di ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar.';
            //                 } else {
            //                     $response .= ', selain itu juga memiliki kebun ' . $sub->estate . ' di ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar.';
            //                 }
            //                 $total_sizebyeq += $sub->sizebyeq;
            //             }
            //         } else {
            //             $total_sizebyeq += $sub->sizebyeq;
            //             $response .= ', ' . $sub->regency;
            //         }
            //     } elseif ($sub->principal_activities == "Oil Palm Plantation & Mill") {
            //         $response .= ' ' . $sub->subsidiary . ' memiliki kebun kelapa sawit dengan luas ' . $sub->sizebyeq . ' hektar';
            //         if (!empty($sub->capacity)) {
            //             $response .= ' dan PKS dengan kapasitas ' . $sub->capacity . '.';
            //         } else {
            //             $response .= '.';
            //         }
            //     } elseif (in_array($sub->principal_activities, ["Palm Oil Mill", "Manufacturer", "Refinery", "Rubber Factory", "Oleochemical", "Kernel Crhursing Plant", "Biodisel Plant"])) {
            //         // $response .= ' ' . $sub->subsidiary . ' memiliki ' . $sub->principal_activities . ' dengan kapasitas ';
            //         if (!empty($sub->capacity)) {
            //             $response .= '. ' . $sub->subsidiary . ' memiliki ' . $sub->principal_activities . ' dengan kapasitas ' . $sub->capacity . '.';
            //         } else {
            //             $response .= '.';
            //         }
            //     }

            //     if (!in_array($sub->principal_activities, $principal_activities)) {
            //         $principal_activities[] = $sub->principal_activities;
            //     }


            //     if (!in_array($sub->regency, $regencies)) {
            //         $regencies[] = $sub->regency;
            //     }

            //     if (!in_array($sub->province, $provinces)) {
            //         $provinces[] = $sub->province;
            //     }
            //     // if (!in_array($sub->shareholder_subsidiary, $shareholder)) {
            //     //     $shareholder[] = $sub->shareholder_subsidiary;
            //     // }
            // }


            // $response .= '. Kepemilikan saham  ' . $sub->subsidiary . ' dimiliki oleh ' . implode(', ', $shareholder) . '.';
            // $response .= '. Kepemilikan saham  ' . $sub->subsidiary . ' dimiliki oleh ' . implode(', ', $shareholder) . ' dan sisanya dimiliki oleh  ' . implode(', ', $shareholder) . '.';
            // $response .= ' Provinsi ' . implode(', ', $provinces) . ' Kabupaten ' . implode(', ', $regencies) . ' dan secara geografis terletak di koordinat ' . $subsidiary->latitude . ' (latitude) – ' . $subsidiary->longitude . ' (longitude).';
            // $response .= ' Aktivitas prinsipal perusahaan adalah ' . implode(' dan ', $principal_activities);
        } else {
            $response = 'Data subsidiary tidak ditemukan.';
        }

        return response()->json(['message' => $response]);
    }
    // end get group 

    // get subsidiary en
    public function getSubsidiaryEn(Request $request)
    {
        $input = $request->input('message'); // ambil input pesan dari userssss
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

            foreach ($shareholders as $shareholder) {
                $share_info = explode('(', $shareholder);
                $shareholder_name = trim($share_info[0]);
                $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
                $total_share += $share_percentage;
                $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
            }

            usort($shareholder_data, function ($a, $b) {
                return $b['share_percentage'] <=> $a['share_percentage'];
            });

            $majority_shareholder = $shareholder_data[0]['name'];
            $majority_share_percentage = $shareholder_data[0]['share_percentage'];

            if ($subsidiary->group_type == 'Independent') {
                $group_narrative = 'is a company controlled by';
            } else if ($subsidiary->group_type == 'Coop') {
                $group_narrative = 'is a cooperative controlled by';
            } else {
                $group_narrative = 'is a subsidiary of the group';
            }

            // narasi shareholder v1 with no link
            if (count($shareholder_data) > 1) {
                if ($total_share > 50) {
                    $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' located at ' . implode(', ', $regencies0) . ', Province ' . implode(', Province ', $provinces0) . ', ' . implode(', ', $countries0) . '. Principal activity of ' .  $subsidiary->subsidiary . ' is ' . implode(' and ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. The majority of its shares are owned by ' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '% dan sisanya dimiliki oleh ' . implode(', ', array_map(function ($data) {
                        return $data['name'] . $data['share_percentage'] . '%';
                    }, array_slice($shareholder_data, 1))) . '. ';
                } else {
                    $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' located at ' . implode(', ', $regencies0) . ', Province ' . implode(', Province ', $provinces0) . ', ' . implode(', ', $countries0) . '. Principal activity of ' .  $subsidiary->subsidiary . ' is ' . implode(' and ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Its share ownership is distributed among several shareholders, viz ' . implode(', ', array_map(function ($data) {
                        return $data['name'] . $data['share_percentage'] . '%';
                    }, $shareholder_data)) . '. ';
                }
            } else {
                // $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' located at ' . implode(', ', $regencies0) . ', Province ' . implode(', Province ', $provinces0) . ', ' . implode(', ', $countries0) . '. Principal activity of ' .  $subsidiary->subsidiary . ' is ' . implode(' and ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
                $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' located at ' . implode(', ', $regencies0) . ', Province ' . implode(', Province ', $provinces0) . ', ' . implode(', ', $countries0) . '. Principal activity of ' .  $subsidiary->subsidiary . ' is ' . implode(' and ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Share ownership is owned by ' . implode(', ', array_map(function ($data) {
                    return $data['name'] . $data['share_percentage'] . '%';
                }, $shareholder_data)) . '. ';
            }
            // end narasi shareholder v1 with no link

            // // narasi shareholder v1 with link
            // if (count($shareholder_data) > 1) {
            //     if ($total_share > 50) {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '% dan sisanya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //             return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> ' . $data['share_percentage'] . '%';
            //         }, array_slice($shareholder_data, 1))) . '. ';
            //     } else {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya didistribusikan di antara beberapa pemegang saham, yaitu ' . implode(', ', array_map(function ($data) {
            //             return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //         }, $shareholder_data)) . '. ';
            //     }
            // } else {
            //     // $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
            //     $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //         return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //     }, $shareholder_data)) . '. ';
            // }
            // // end narasi shareholder v1 with link

            // // narasi shareholder v2 
            // $principal_activities = $subsidiaries->pluck('principal_activities')->unique()->toArray();

            // if (count($shareholder_data) >= 1) {
            //     // Calculate total share percentage owned by all shareholders
            //     $total_share = collect($shareholder_data)->sum('share_percentage');

            //     if ($total_share >= 50) {
            //         if (in_array('Oil Palm Plantation', $principal_activities) && in_array('Palm Oil Mill', $principal_activities)) {
            //             $principal_activity = ' perkebunan kelapa sawit dan pabrik kelapa sawit (PKS)';
            //         } else if (in_array(
            //             'Oil Palm Plantation & Mill',
            //             $principal_activities
            //         )) {
            //             $principal_activity = ' perkebunan kelapa sawit dan pabrik kelapa sawit (PKS)';
            //         } else if (in_array('Manufacturer', $principal_activities)) {
            //             $principal_activity = ' manufaktur';
            //         } else if (in_array('Palm Oil Mill', $principal_activities)) {
            //             $principal_activity = ' pabrik kelapa sawit';
            //         } else if (in_array('Oil Palm Plantation', $principal_activities)) {
            //             $principal_activity = ' perkebunan kelapa sawit';
            //         } else {
            //             $principal_activity = implode(' dan ', $principal_activities);
            //         }
            //         $shareholder_data_formatted = array_map(function ($data) {
            //             return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //         }, $shareholder_data);
            //         // Add majority shareholder to formatted shareholder data
            //         array_unshift($shareholder_data_formatted, '<a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%');
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . $principal_activity . '. Mayoritas kepemilikan sahamnya dimiliki oleh ' . implode(' dan ', $shareholder_data_formatted) . '. ';
            //     } else {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $principal_activities) . '. Kepemilikan sahamnya hanya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar 100%. ';
            //     }
            // } else {
            //     $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $principal_activities) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //         return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //     }, $shareholder_data)) . '. ';
            // }
            // // end narasi shareholder v2 
            // end clickable



            $estates = [];
            $facilities = [];
            $regencies = [];
            $provinces = [];
            $rspo_member = null;
            $rspo_certified = null;
            $total_sizebyeq = 0;
            $principal_activities = [];
            // $shareholder = [];

            // foreach ($subsidiaries as $key => $sub) {
            //     if (in_array($sub->principal_activities, ["Oil Palm Plantation", "Rubber Plantation", "Nursery", "Smallholder"])) {

            //         if (!in_array($sub->sizebyeq, $estates)) {
            //             if ($sub->sizebyeq) {
            //                 $estates[] = $sub->sizebyeq;
            //                 if ($key == 0) {
            //                     $response .= '. ' . $sub->subsidiary . ' memiliki kebun ' . $sub->estate . ' di ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar.';
            //                 } else {
            //                     $response .= ', selain itu juga memiliki kebun ' . $sub->estate . ' di ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar.';
            //                 }
            //                 $total_sizebyeq += $sub->sizebyeq;
            //             }
            //         } else {
            //             $total_sizebyeq += $sub->sizebyeq;
            //             $response .= ', ' . $sub->regency;
            //         }
            //     } elseif ($sub->principal_activities == "Oil Palm Plantation & Mill") {
            //         $response .= ' ' . $sub->subsidiary . ' memiliki kebun kelapa sawit dengan luas ' . $sub->sizebyeq . ' hektar';
            //         if (!empty($sub->capacity)) {
            //             $response .= ' dan PKS dengan kapasitas ' . $sub->capacity . '.';
            //         } else {
            //             $response .= '.';
            //         }
            //     } elseif (in_array($sub->principal_activities, ["Palm Oil Mill", "Manufacturer", "Refinery", "Rubber Factory", "Oleochemical", "Kernel Crhursing Plant", "Biodisel Plant"])) {
            //         // $response .= ' ' . $sub->subsidiary . ' memiliki ' . $sub->principal_activities . ' dengan kapasitas ';
            //         if (!empty($sub->capacity)) {
            //             $response .= '. ' . $sub->subsidiary . ' memiliki ' . $sub->principal_activities . ' dengan kapasitas ' . $sub->capacity . '.';
            //         } else {
            //             $response .= '.';
            //         }
            //     }

            //     if (!in_array($sub->principal_activities, $principal_activities)) {
            //         $principal_activities[] = $sub->principal_activities;
            //     }


            //     if (!in_array($sub->regency, $regencies)) {
            //         $regencies[] = $sub->regency;
            //     }

            //     if (!in_array($sub->province, $provinces)) {
            //         $provinces[] = $sub->province;
            //     }
            //     // if (!in_array($sub->shareholder_subsidiary, $shareholder)) {
            //     //     $shareholder[] = $sub->shareholder_subsidiary;
            //     // }
            // }


            // $response .= '. Kepemilikan saham  ' . $sub->subsidiary . ' dimiliki oleh ' . implode(', ', $shareholder) . '.';
            // $response .= '. Kepemilikan saham  ' . $sub->subsidiary . ' dimiliki oleh ' . implode(', ', $shareholder) . ' dan sisanya dimiliki oleh  ' . implode(', ', $shareholder) . '.';
            // $response .= ' Provinsi ' . implode(', ', $provinces) . ' Kabupaten ' . implode(', ', $regencies) . ' dan secara geografis terletak di koordinat ' . $subsidiary->latitude . ' (latitude) – ' . $subsidiary->longitude . ' (longitude).';
            // $response .= ' Aktivitas prinsipal perusahaan adalah ' . implode(' dan ', $principal_activities);
        } else {
            $response = 'Subsidiary not found..';
        }

        return response()->json(['message' => $response]);
    }
    // end get subsidiary en

    // get subsidiary 
    public function getSubsidiary(Request $request)
    {
        $input = $request->input('message'); // ambil input pesan dari userssss
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

            foreach ($shareholders as $shareholder) {
                $share_info = explode('(', $shareholder);
                $shareholder_name = trim($share_info[0]);
                $share_percentage = str_replace(['%', ')'], '', $share_info[1]);
                $total_share += $share_percentage;
                $shareholder_data[] = ['name' => $shareholder_name, 'share_percentage' => $share_percentage];
            }

            usort($shareholder_data, function ($a, $b) {
                return $b['share_percentage'] <=> $a['share_percentage'];
            });

            $majority_shareholder = $shareholder_data[0]['name'];
            $majority_share_percentage = $shareholder_data[0]['share_percentage'];

            if ($subsidiary->group_type == 'Independent') {
                $group_narrative = 'adalah perusahaan yang dikendalikan oleh';
            } else if ($subsidiary->group_type == 'Coop') {
                $group_narrative = 'adalah koperasi yang dikendalikan oleh';
            } else {
                $group_narrative = 'adalah anak perusahaan dari group';
            }

            // narasi shareholder v1 with no link
            if (count($shareholder_data) > 1) {
                if ($total_share > 50) {
                    $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh ' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '% dan sisanya dimiliki oleh ' . implode(', ', array_map(function ($data) {
                        return $data['name'] . $data['share_percentage'] . '%';
                    }, array_slice($shareholder_data, 1))) . '. ';
                } else {
                    $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya didistribusikan di antara beberapa pemegang saham, yaitu ' . implode(', ', array_map(function ($data) {
                        return $data['name'] . $data['share_percentage'] . '%';
                    }, $shareholder_data)) . '. ';
                }
            } else {
                // $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
                $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(function ($data) {
                    return $data['name'] . $data['share_percentage'] . '%';
                }, $shareholder_data)) . '. ';
            }
            // end narasi shareholder v1 with no link

            // // narasi shareholder v1 with link
            // if (count($shareholder_data) > 1) {
            //     if ($total_share > 50) {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '% dan sisanya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //             return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> ' . $data['share_percentage'] . '%';
            //         }, array_slice($shareholder_data, 1))) . '. ';
            //     } else {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya didistribusikan di antara beberapa pemegang saham, yaitu ' . implode(', ', array_map(function ($data) {
            //             return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //         }, $shareholder_data)) . '. ';
            //     }
            // } else {
            //     // $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Mayoritas kepemilikan sahamnya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%. ';
            //     $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //         return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //     }, $shareholder_data)) . '. ';
            // }
            // // end narasi shareholder v1 with link

            // // narasi shareholder v2 
            // $principal_activities = $subsidiaries->pluck('principal_activities')->unique()->toArray();

            // if (count($shareholder_data) >= 1) {
            //     // Calculate total share percentage owned by all shareholders
            //     $total_share = collect($shareholder_data)->sum('share_percentage');

            //     if ($total_share >= 50) {
            //         if (in_array('Oil Palm Plantation', $principal_activities) && in_array('Palm Oil Mill', $principal_activities)) {
            //             $principal_activity = ' perkebunan kelapa sawit dan pabrik kelapa sawit (PKS)';
            //         } else if (in_array(
            //             'Oil Palm Plantation & Mill',
            //             $principal_activities
            //         )) {
            //             $principal_activity = ' perkebunan kelapa sawit dan pabrik kelapa sawit (PKS)';
            //         } else if (in_array('Manufacturer', $principal_activities)) {
            //             $principal_activity = ' manufaktur';
            //         } else if (in_array('Palm Oil Mill', $principal_activities)) {
            //             $principal_activity = ' pabrik kelapa sawit';
            //         } else if (in_array('Oil Palm Plantation', $principal_activities)) {
            //             $principal_activity = ' perkebunan kelapa sawit';
            //         } else {
            //             $principal_activity = implode(' dan ', $principal_activities);
            //         }
            //         $shareholder_data_formatted = array_map(function ($data) {
            //             return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //         }, $shareholder_data);
            //         // Add majority shareholder to formatted shareholder data
            //         array_unshift($shareholder_data_formatted, '<a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar ' . $majority_share_percentage . '%');
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . $principal_activity . '. Mayoritas kepemilikan sahamnya dimiliki oleh ' . implode(' dan ', $shareholder_data_formatted) . '. ';
            //     } else {
            //         $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $principal_activities) . '. Kepemilikan sahamnya hanya dimiliki oleh <a href="' . route('shareholder', ['name' => $majority_shareholder]) . '">' . $majority_shareholder . '</a> sebesar 100%. ';
            //     }
            // } else {
            //     $response = $subsidiary->subsidiary . ' ' . $group_narrative . ' ' . $subsidiary->group_name . ' yang berlokasi di ' . implode(', ', $regencies0) . ', Provinsi ' . implode(', Provinsi ', $provinces0) . ', ' . implode(', ', $countries0) . '. Aktivitas utama ' .  $subsidiary->subsidiary . ' adalah ' . implode(' dan ', $principal_activities) . '. Kepemilikan sahamnya dimiliki oleh ' . implode(', ', array_map(function ($data) {
            //         return '<a href="' . route('shareholder', ['name' => $data['name']]) . '">' . $data['name'] . '</a> sebesar ' . $data['share_percentage'] . '%';
            //     }, $shareholder_data)) . '. ';
            // }
            // // end narasi shareholder v2 
            // end clickable



            $estates = [];
            $facilities = [];
            $regencies = [];
            $provinces = [];
            $rspo_member = null;
            $rspo_certified = null;
            $total_sizebyeq = 0;
            $principal_activities = [];
            // $shareholder = [];

            // foreach ($subsidiaries as $key => $sub) {
            //     if (in_array($sub->principal_activities, ["Oil Palm Plantation", "Rubber Plantation", "Nursery", "Smallholder"])) {

            //         if (!in_array($sub->sizebyeq, $estates)) {
            //             if ($sub->sizebyeq) {
            //                 $estates[] = $sub->sizebyeq;
            //                 if ($key == 0) {
            //                     $response .= '. ' . $sub->subsidiary . ' memiliki kebun ' . $sub->estate . ' di ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar.';
            //                 } else {
            //                     $response .= ', selain itu juga memiliki kebun ' . $sub->estate . ' di ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar.';
            //                 }
            //                 $total_sizebyeq += $sub->sizebyeq;
            //             }
            //         } else {
            //             $total_sizebyeq += $sub->sizebyeq;
            //             $response .= ', ' . $sub->regency;
            //         }
            //     } elseif ($sub->principal_activities == "Oil Palm Plantation & Mill") {
            //         $response .= ' ' . $sub->subsidiary . ' memiliki kebun kelapa sawit dengan luas ' . $sub->sizebyeq . ' hektar';
            //         if (!empty($sub->capacity)) {
            //             $response .= ' dan PKS dengan kapasitas ' . $sub->capacity . '.';
            //         } else {
            //             $response .= '.';
            //         }
            //     } elseif (in_array($sub->principal_activities, ["Palm Oil Mill", "Manufacturer", "Refinery", "Rubber Factory", "Oleochemical", "Kernel Crhursing Plant", "Biodisel Plant"])) {
            //         // $response .= ' ' . $sub->subsidiary . ' memiliki ' . $sub->principal_activities . ' dengan kapasitas ';
            //         if (!empty($sub->capacity)) {
            //             $response .= '. ' . $sub->subsidiary . ' memiliki ' . $sub->principal_activities . ' dengan kapasitas ' . $sub->capacity . '.';
            //         } else {
            //             $response .= '.';
            //         }
            //     }

            //     if (!in_array($sub->principal_activities, $principal_activities)) {
            //         $principal_activities[] = $sub->principal_activities;
            //     }


            //     if (!in_array($sub->regency, $regencies)) {
            //         $regencies[] = $sub->regency;
            //     }

            //     if (!in_array($sub->province, $provinces)) {
            //         $provinces[] = $sub->province;
            //     }
            //     // if (!in_array($sub->shareholder_subsidiary, $shareholder)) {
            //     //     $shareholder[] = $sub->shareholder_subsidiary;
            //     // }
            // }


            // $response .= '. Kepemilikan saham  ' . $sub->subsidiary . ' dimiliki oleh ' . implode(', ', $shareholder) . '.';
            // $response .= '. Kepemilikan saham  ' . $sub->subsidiary . ' dimiliki oleh ' . implode(', ', $shareholder) . ' dan sisanya dimiliki oleh  ' . implode(', ', $shareholder) . '.';
            // $response .= ' Provinsi ' . implode(', ', $provinces) . ' Kabupaten ' . implode(', ', $regencies) . ' dan secara geografis terletak di koordinat ' . $subsidiary->latitude . ' (latitude) – ' . $subsidiary->longitude . ' (longitude).';
            // $response .= ' Aktivitas prinsipal perusahaan adalah ' . implode(' dan ', $principal_activities);
        } else {
            $response = 'Data subsidiary tidak ditemukan.';
        }

        return response()->json(['message' => $response]);
    }
    // end get subsidiary


    // get company 
    public function company(Request $request)
    {
        $subsidiary =
            $company = Consolidation::where('subsidiary', $subsidiary)->first();

        return view('CorporateProfile.shareholder', ['shareholder' => $company]);
    }
    // end get company

    public function chatbot5(Request $request)
    {
        return view('CorporateProfile.chatbot5');
    }

    public function chatbotSubsidiaryId()
    {
        return view('CorporateProfile.Id.ChatbotSubsidiaryId');
    }
    public function chatbotGroupId()
    {
        return view('CorporateProfile.Id.ChatbotGroupId');
    }

    public function chatbotSubsidiaryEn()
    {
        return view('CorporateProfile.En.ChatbotSubsidiaryEn');
    }
    public function chatbotGroupEn()
    {
        return view('CorporateProfile.En.ChatbotGroupEn');
    }
}
