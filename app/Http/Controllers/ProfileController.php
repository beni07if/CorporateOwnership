<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Group;
use App\Models\Consolidation;
use App\Models\CompanyOwnership;
use App\Models\CompanyOwnershipSecond;
use App\Models\Landingpage;
use App\Models\OtherCompany;
use App\Models\Policy;
use App\Models\Termcondition;
use App\Models\Sra;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator; 

class ProfileController extends Controller
{
    public function index()
    {
        // $subsidiary = Consolidation::all();
        // $groupNameeee = Consolidation::all();
        $landingPages = Landingpage::all();
        return view('content.homeDinamic', compact('landingPages'));
    }
    public function lpd()
    {
        $landingPages = Landingpage::all();
        return view('content.homeDinamis', compact('landingPages'));
    }
    
    public function feature()
    {
        $subsidiary = Consolidation::all();
        $groupName = Consolidation::all();
        return view('content.en.feature.feature', compact('subsidiary', 'groupName'));
    }

    public function searchFunctionGroup(Request $request)
    {
        $query = $request->input('group_name');

        $groups = Group::select('group_name', 'country_registration', 'business_address')
            ->where('group_name', 'LIKE', '%' . $query . '%')
            ->distinct()
            ->paginate(10);

        // Append the search query to the pagination links
        $groups->appends(['group_name' => $query]);

        return view('content.en.searchGroup', compact('groups', 'query'));
    }


    // public function searchFunctionSubsidiary(Request $request)
    // {
    //     $query = $request->input('query');

    //     $consolidations = Consolidation::select('subsidiary')
    //         ->where('subsidiary', 'LIKE', '%' . $query . '%')
    //         ->distinct()
    //         ->paginate(10);

    //     // Append the search query to the pagination links
    //     $consolidations->appends(['query' => $query]);

    //     return view('content.en.searchSubsidiary', compact('consolidations'));
    // }

    // public function searchFunctionSubsidiary(Request $request)
    // {
    //     $query = $request->input('subsidiary');

    //     // Cari data di tabel Consolidation
    //     $consolidations = Consolidation::select('subsidiary', 'country_operation', 'province', 'regency')
    //         ->where('subsidiary', 'LIKE', '%' . $query . '%')
    //         ->distinct()
    //         ->paginate(10);
    //     $companyOwnerships= CompanyOwnership::select('company_name', 'country_of_business_address', 'business_address')
    //         ->where('company_name', 'LIKE', '%' . $query . '%')
    //         ->distinct()
    //         ->paginate(10);

    //     // Jika tidak ditemukan di tabel Consolidation, cari di tabel company ownership
    //     if ($consolidations->isEmpty()) {
    //         $companyOwnerships = CompanyOwnership::select('company_name', 'country_of_registered_address', 'registered_address')
    //             ->where('company_name', 'LIKE', '%' . $query . '%')
    //             ->distinct()
    //             ->paginate(10);

    //         // Append the search query to the pagination links
    //         $companyOwnerships->appends(['query' => $query]);

    //         return view('content.en.searchSubsidiaryCO', compact('companyOwnerships', 'query'));
    //     }

    //     // Jika tidak ditemukan di tabel Consolidation, cari di tabel OtherCompanies
    //     if ($consolidations->isEmpty()) {
    //         $otherCompanies = OtherCompany::select('badan_hukum')
    //             ->where('badan_hukum', 'LIKE', '%' . $query . '%')
    //             ->distinct()
    //             ->paginate(10);

    //         // Append the search query to the pagination links
    //         $otherCompanies->appends(['query' => $query]);

    //         return view('content.en.searchOtherCompany', compact('otherCompanies', 'query'));
    //     } else {
    //         // Append the search query to the pagination links
    //         $consolidations->appends(['query' => $query]);

    //         return view('content.en.searchSubsidiary', compact('consolidations', 'companyOwnerships', 'query'));
    //     }
    // }

    // public function searchFunctionSubsidiary(Request $request)
    // {
    //     // Ambil input dari request
    //     $query = $request->input('subsidiary');

    //     // Subquery untuk mendapatkan nama perusahaan unik
    //     $uniqueCompanyNames = CompanyOwnership::select('company_name')
    //         ->distinct()
    //         ->when($query, function ($q) use ($query) {
    //             return $q->where('company_name', 'LIKE', '%' . $query . '%');
    //         })
    //         ->pluck('company_name'); // Dapatkan hanya nama perusahaan sebagai array

    //     // Query utama dengan join untuk mendapatkan detail berdasarkan nama perusahaan unik
    //     $companyOwnerships = CompanyOwnership::select(
    //         'company_ownerships.company_name',
    //         'consolidations.subsidiary',
    //         'consolidations.country_operation',
    //         'consolidations.province',
    //         'consolidations.regency',
    //         'company_ownerships.country_of_business_address',
    //         'company_ownerships.business_address',
    //         'company_ownerships.registered_address'
    //     )
    //     ->leftJoin('consolidations', 'company_ownerships.company_name', '=', 'consolidations.subsidiary')
    //     ->whereIn('company_ownerships.company_name', $uniqueCompanyNames)
    //     ->groupBy(
    //         'company_ownerships.company_name',
    //         'consolidations.subsidiary',
    //         'consolidations.country_operation',
    //         'consolidations.province',
    //         'consolidations.regency',
    //         'company_ownerships.country_of_business_address',
    //         'company_ownerships.business_address',
    //         'company_ownerships.registered_address'
    //     )
    //     ->orderBy('company_ownerships.company_name')
    //     ->paginate(10);

    //     // Append parameter pencarian ke link pagination
    //     $companyOwnerships->appends(['subsidiary' => $query]);

    //     // Kembalikan ke view dengan nama variabel yang benar
    //     return view('content.en.searchSubsidiary', [
    //         'companyOwnerships' => $companyOwnerships,
    //         'query' => $query
    //     ]);
    // }

    public function searchFunctionSubsidiary(Request $request)
{
    // Ambil input dari request
    $query = $request->input('subsidiary');

    // Ambil data dari tabel CompanyOwnership
    $companyOwnerships = DB::table('company_ownerships')
        ->select(
            'company_ownerships.company_name',
            'consolidations.subsidiary',
            'consolidations.country_operation',
            'consolidations.province',
            'consolidations.regency',
            'company_ownerships.country_of_business_address',
            'company_ownerships.business_address',
            'company_ownerships.registered_address'
        )
        ->leftJoin('consolidations', 'company_ownerships.company_name', '=', 'consolidations.subsidiary')
        ->when($query, function ($q) use ($query) {
            return $q->where('company_ownerships.company_name', 'LIKE', '%' . $query . '%');
        });

    // Ambil data dari tabel CompanyOwnershipSecond
    $companyOwnershipsSecond = DB::table('company_ownership_seconds')
        ->select(
            'company_ownership_seconds.company_name',
            'consolidations.subsidiary',
            'consolidations.country_operation',
            'consolidations.province',
            'consolidations.regency',
            'company_ownership_seconds.country_of_business_address',
            'company_ownership_seconds.business_address',
            'company_ownership_seconds.registered_address'
        )
        ->leftJoin('consolidations', 'company_ownership_seconds.company_name', '=', 'consolidations.subsidiary')
        ->when($query, function ($q) use ($query) {
            return $q->where('company_ownership_seconds.company_name', 'LIKE', '%' . $query . '%');
        });

    // Gabungkan kedua query dengan UNION dan pastikan company_name unik
    $allCompanyOwnerships = $companyOwnerships
        ->union($companyOwnershipsSecond)
        ->distinct() // Menghilangkan duplikat berdasarkan semua kolom
        ->get()
        ->unique('company_name'); // Hapus duplikat berdasarkan company_name

    // Lakukan pagination manual
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $perPage = 10; // Set jumlah item per halaman
    $currentItems = $allCompanyOwnerships->slice(($currentPage - 1) * $perPage, $perPage)->all();
    $paginatedCompanyOwnerships = new LengthAwarePaginator($currentItems, $allCompanyOwnerships->count(), $perPage);
    $paginatedCompanyOwnerships->setPath($request->url());
    $paginatedCompanyOwnerships->appends(['subsidiary' => $query]);

    // Kembalikan ke view dengan data yang digabungkan
    return view('content.en.searchSubsidiary', [
        'companyOwnerships' => $paginatedCompanyOwnerships,
        'query' => $query
    ]);
}


    // public function searchFunctionShareholder(Request $request)
    // {
    //     $shareholder = $request->input('shareholder_name');
        
    //     $groups = DB::table('groups')
    //     ->where('shareholder_name1', $shareholder)
    //     ->orWhere('shareholder_name2', $shareholder)
    //     ->orWhere('shareholder_name3', $shareholder)
    //     ->orWhere('shareholder_name4', $shareholder)
    //     ->orWhere('shareholder_name5', $shareholder)
    //     ->get();  

    //     $shareholderNames = CompanyOwnership::select('id','shareholder_name', 'company_name', 'date_of_birth', 'ic_passport_comp_number', 'address')
    //         ->where('shareholder_name', 'LIKE', '%' . $shareholder . '%')
    //         ->paginate(10);

    //     // Append the search shareholder_name to the pagination links
    //     $shareholderNames->appends(['shareholder_name' => $shareholder]);

    //     return view('content.en.searchShareholder', compact('shareholderNames', 'shareholder', 'groups'));
    // }

    public function searchFunctionShareholder(Request $request)
    {
        $shareholder = $request->input('shareholder_name');

        // Ambil data dari tabel groups
        $groups = DB::table('groups')
            ->where('shareholder_name1', $shareholder)
            ->orWhere('shareholder_name2', $shareholder)
            ->orWhere('shareholder_name3', $shareholder)
            ->orWhere('shareholder_name4', $shareholder)
            ->orWhere('shareholder_name5', $shareholder)
            ->get();

        // Ambil data dari tabel CompanyOwnership
        $companyOwnerships = DB::table('company_ownerships')
            ->select('id', 'shareholder_name', 'company_name', 'date_of_birth', 'ic_passport_comp_number', 'address')
            ->where('shareholder_name', 'LIKE', '%' . $shareholder . '%');

        // Ambil data dari tabel CompanyOwnershipSecond
        $companyOwnershipsSecond = DB::table('company_ownership_seconds')
            ->select('id', 'shareholder_name', 'company_name', 'date_of_birth', 'ic_passport_comp_number', 'address')
            ->where('shareholder_name', 'LIKE', '%' . $shareholder . '%');

        // Gabungkan kedua query dengan UNION
        $allShareholderNames = $companyOwnerships
            ->union($companyOwnershipsSecond)
            ->orderBy('shareholder_name')
            ->paginate(10);

        // Append parameter pencarian ke link pagination
        $allShareholderNames->appends(['shareholder_name' => $shareholder]);

        // Kembalikan ke view dengan data yang digabungkan
        return view('content.en.searchShareholder', [
            'shareholderNames' => $allShareholderNames,
            'shareholder' => $shareholder,
            'groups' => $groups
        ]);
    }


    public function searchFunctionSRA(Request $request)
    {
        // Ambil input dari request
        $query = $request->input('group_name');

        // Mulai query untuk mengambil data
        $sras = Sra::select(
            'sras.group_name',
            'sras.percent_transparency',
            'sras.percent_ndpe_compliance',
            'sras.percent_rspo_compliance',
            'groups.business_address',
            'groups.country_registration' // Tambahkan country_registration
        )
        ->leftJoin('groups', 'sras.group_name', '=', 'groups.group_name')  // Join dengan table groups
        ->distinct();

        // Jika ada query pencarian, tambahkan kondisi where
        if (!empty($query)) {
            $sras = $sras->where('sras.group_name', 'LIKE', '%' . $query . '%');
        }

        // Paginate hasilnya
        $sras = $sras->paginate(10);

        // Append parameter pencarian ke link pagination
        $sras->appends(['group_name' => $query]);

        // Kembalikan ke view
        return view('content.en.searchSra', ['sras' => $sras, 'query' => $query]);
    }

    public function privacyPolicy()
    {
        $policies = Policy::all();
        return view('content.footer.privacyPolicy', compact('policies'));
    }

    public function termOfCondition()
    {
        $termOfCondition = Termcondition::all();
        return view('content.footer.termOfCondition', compact('termOfCondition'));
    }
    
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}