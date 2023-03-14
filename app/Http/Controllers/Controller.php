<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // public function getSubsidiary(Request $request)
    // {
    //     $input = $request->input('message'); // ambil input pesan dari user
    //     $subsidiaries = Consolidation::where('subsidiary', 'like', '%' . $input . '%')->get(); // cari data subsidiary yang cocok dengan input

    //     if ($subsidiaries->isNotEmpty()) {
    //         $subsidiary = $subsidiaries->first();
    //         $response = $subsidiary->subsidiary . ' merupakan perusahaan di bidang kelapa sawit khususnya ' . $subsidiary->principal_activities . ' yang merupakan bagian dari group ' . $subsidiary->group_name . '.  Perusahaan ini terletak di ' . $subsidiary->country_registration . ', ';

    //         // // cek jika country_registration adalah "Indonesia"
    //         // if ($subsidiary->country_operation == "Indonesia") {
    //         //     // cek jika ispo_certified bernilai "No" atau "Yes"
    //         //     if ($subsidiary->ispo_certified == "No") {
    //         //         $response .= " dan belum memiliki sertifikat ispo";
    //         //     } else if ($subsidiary->ispo_certified == "Yes") {
    //         //         $response .= " dan memiliki sertifikat ispo";
    //         //     }
    //         // }

    //         // // cek jika country_registration adalah "Indonesia"
    //         // if ($subsidiary->country_operation == "Malaysia") {
    //         //     // cek jika ispo_certified bernilai "No" atau "Yes"
    //         //     if ($subsidiary->mspo_certified == "No") {
    //         //         $response .= " dan belum memiliki sertifikat mspo";
    //         //     } else if ($subsidiary->mspo_certified == "Yes") {
    //         //         $response .= " dan memiliki sertifikat mspo";
    //         //     }
    //         // }

    //         $response .= ', ';

    //         $regencies = [];
    //         $provinces = [];
    //         $estate = null;
    //         $rspo_member = null;
    //         $rspo_certified = null;
    //         $total_sizebyeq = 0;
    //         $principal_activities = [];

    //         foreach ($subsidiaries as $key => $sub) {
    //             if (!$estate || $sub->estate != $estate) {
    //                 if ($sub->estate) {
    //                     if ($key == 0) {
    //                         $response .= ' memiliki kebun ' . $sub->estate;
    //                     } else {
    //                         $response .= ', ' . $sub->subsidiary . ' memiliki kebun ' . $sub->estate;
    //                     }
    //                     if ($key == 0) {
    //                         $total_sizebyeq = $sub->sizebyeq;
    //                     } else {
    //                         // $total_sizebyeq += $sub->sizebyeq;
    //                         $total_sizebyeq = $sub->sizebyeq;
    //                     }
    //                     $response .= ' dengan luas kebun ' . $total_sizebyeq . ' hektar dan saat ini status operasionalnya ' . $sub->status_operation . '.';
    //                 }
    //                 $estate = $sub->estate;
    //             } else {
    //                 $total_sizebyeq += $sub->sizebyeq;
    //             }

    //             if (in_array($sub->principal_activities, ['Oil Palm Plantation', 'Oil Palm Plantation & Mill'])) {
    //                 if ($sub->rspo_member == "Yes") {
    //                     if ($rspo_member != "Yes") {
    //                         $response .= ' ' . $sub->subsidiary . ' telah terdaftar sebagai anggota RSPO dan ';
    //                     }
    //                     $rspo_member = "Yes";
    //                 } else {
    //                     if ($rspo_member != "No") {
    //                         $response .= ' ' . $sub->subsidiary . ' belum terdaftar sebagai anggota RSPO dan ';
    //                     }
    //                     $rspo_member = "No";
    //                 }

    //                 if ($sub->rspo_certified == "Yes") {
    //                     if ($rspo_certified != "Yes") {
    //                         $response .= ' ' . $sub->subsidiary . ' sudah mendapatkan sertifikasi RSPO.';
    //                     }
    //                     $rspo_certified = "Yes";
    //                 } else {
    //                     if ($rspo_certified != "No") {
    //                         $response .= ' ' . $sub->subsidiary . ' belum mendapatkan sertifikasi RSPO.';
    //                     }
    //                     $rspo_certified = "No";
    //                 }
    //             }



    //             if (!in_array($sub->principal_activities, $principal_activities)) {
    //                 $principal_activities[] = $sub->principal_activities;
    //             }

    //             if (!in_array($sub->regency, $regencies)) {
    //                 $regencies[] = $sub->regency;
    //             }

    //             if (!in_array($sub->province, $provinces)) {
    //                 $provinces[] = $sub->province;
    //             }
    //         }

    //         $response .= ' Provinsi ' . implode(', ', $provinces) . ' Kabupaten ' . implode(', ', $regencies) . ' dan secara geografis terletak di koordinat ' . $subsidiary->latitude . ' (latitude) – ' . $subsidiary->longitude . ' (longitude).';
    //         $response .= ' Aktivitas prinsipal perusahaan adalah ' . implode(' dan ', $principal_activities);
    //     } else {
    //         $response = 'Data subsidiary tidak ditemukan.';
    //     }

    //     return response()->json(['message' => $response]);
    // }

    // backup bise v1 
    // public function getSubsidiary(Request $request)
    // {
    //     $input = $request->input('message'); // ambil input pesan dari user
    //     $subsidiaries = Consolidation::where('subsidiary', 'like', '%' . $input . '%')->get(); // cari data subsidiary yang cocok dengan input

    //     if ($subsidiaries->isNotEmpty()) {
    //         $subsidiary = $subsidiaries->first();
    //         $response = $subsidiary->subsidiary . ' adalah perusahaan di bidang kelapa sawit khususnya ' . implode(' dan ', $subsidiaries->pluck('principal_activities')->unique()->toArray()) . ' yang saat ini menjadi bagian dari group ' . $subsidiary->group_name . '.  Perusahaan ini terletak di ';

    //         $countries = [];
    //         foreach ($subsidiaries as $sub) {
    //             if (!in_array($sub->country_operation, $countries)) {
    //                 $countries[] = $sub->country_operation;
    //             }
    //         }

    //         $response .= implode(' dan ', $countries) . '. ';

    //         $estates = [];
    //         $regencies = [];
    //         $provinces = [];
    //         $rspo_member = null;
    //         $rspo_certified = null;
    //         $total_sizebyeq = 0;
    //         $principal_activities = [];

    //         foreach ($subsidiaries as $key => $sub) {
    //             if (!in_array($sub->sizebyeq, $estates)) {
    //                 if ($sub->sizebyeq) {
    //                     $estates[] = $sub->sizebyeq;
    //                     if ($key == 0) {
    //                         $response .= $sub->subsidiary . ' memiliki kebun ' . $sub->estate . ' di Kabupaten ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar dan saat ini status operasionalnya ' . $sub->status_operation;
    //                     } else {
    //                         $response .= ', selain itu juga memiliki kebun ' . $sub->estate . ' di Kabupaten ' . $sub->regency . ' dengan luas ' . $sub->sizebyeq . ' hektar dan saat ini status operasionalnya ' . $sub->status_operation;
    //                     }
    //                     $total_sizebyeq += $sub->sizebyeq;
    //                 }
    //             } else {
    //                 $total_sizebyeq += $sub->sizebyeq;
    //                 $response .= ', ' . $sub->regency;
    //             }

    //             if (in_array($sub->principal_activities, ['Oil Palm Plantation', 'Oil Palm Plantation & Mill'])) {
    //                 if ($sub->rspo_member == "Yes") {
    //                     if ($rspo_member != "Yes") {
    //                         $response .= '. ' . $sub->subsidiary . ' telah terdaftar sebagai anggota RSPO dan ';
    //                     }
    //                     $rspo_member = "Yes";
    //                 } else {
    //                     if ($rspo_member != "No") {
    //                         $response .= '. ' . $sub->subsidiary . ' belum terdaftar sebagai anggota RSPO dan ';
    //                     }
    //                     $rspo_member = "No";
    //                 }

    //                 if ($sub->rspo_certified == "Yes") {
    //                     if ($rspo_certified != "Yes") {
    //                         $response .= ' sudah mendapatkan sertifikasi RSPO.';
    //                     }
    //                     $rspo_certified = "Yes";
    //                 } else {
    //                     if ($rspo_certified != "No") {
    //                         $response .= ' belum mendapatkan sertifikasi RSPO.';
    //                     }
    //                     $rspo_certified = "No";
    //                 }
    //             }

    //             if (!in_array($sub->principal_activities, $principal_activities)) {
    //                 $principal_activities[] = $sub->principal_activities;
    //             }

    //             if (!in_array($sub->regency, $regencies)) {
    //                 $regencies[] = $sub->regency;
    //             }

    //             if (!in_array($sub->province, $provinces)) {
    //                 $provinces[] = $sub->province;
    //             }
    //         }

    //         $response .= ' Provinsi ' . implode(', ', $provinces) . ' Kabupaten ' . implode(', ', $regencies) . ' dan secara geografis terletak di koordinat ' . $subsidiary->latitude . ' (latitude) – ' . $subsidiary->longitude . ' (longitude).';
    //         $response .= ' Aktivitas prinsipal perusahaan adalah ' . implode(' dan ', $principal_activities);
    //     } else {
    //         $response = 'Data subsidiary tidak ditemukan.';
    //     }

    //     return response()->json(['message' => $response]);
    // }
    // end backup bise v1
}
