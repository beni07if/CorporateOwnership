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
use App\Models\Landingpage;
use App\Models\OtherCompany;
use App\Models\Policy;
use App\Models\Termcondition;
use App\Models\Sra;

class ProfileController extends Controller
{
    public function index()
    {
        // $subsidiary = Consolidation::all();
        // $groupNameeee = Consolidation::all();
        $landingPages = Landingpage::all();
        return view('content.maintenanceMode', compact('landingPages'));
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

        $groups = Group::select('group_name', 'group_status', 'controller', 'country_registration', 'management_name_and_position', 'business_address')
            ->where('group_name', 'LIKE', '%' . $query . '%')
            ->distinct()
            ->paginate(10);

        // Append the search query to the pagination links
        $groups->appends(['group_name' => $query]);

        return view('content.en.searchGroup', compact('groups'));
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

    public function searchFunctionSubsidiary(Request $request)
    {
        $query = $request->input('query');

        // Cari data di tabel Consolidation
        $consolidations = Consolidation::select('subsidiary', 'status_operation', 'country_operation', 'province', 'regency')
            ->where('subsidiary', 'LIKE', '%' . $query . '%')
            ->distinct()
            ->paginate(10);

        // Jika tidak ditemukan di tabel Consolidation, cari di tabel OtherCompanies
        if ($consolidations->isEmpty()) {
            $otherCompanies = OtherCompany::select('badan_hukum')
                ->where('badan_hukum', 'LIKE', '%' . $query . '%')
                ->distinct()
                ->paginate(10);

            // Append the search query to the pagination links
            $otherCompanies->appends(['query' => $query]);

            return view('content.en.searchOtherCompany', compact('otherCompanies'));
        } else {
            // Append the search query to the pagination links
            $consolidations->appends(['query' => $query]);

            return view('content.en.searchSubsidiary', compact('consolidations'));
        }
    }


    public function searchFunctionShareholder(Request $request)
    {
        $query = $request->input('query');

        $shareholderNames = CompanyOwnership::select('shareholder_name', 'company_name', 'percentage_of_shares', 'position', 'date_of_birth')
            ->where('shareholder_name', 'LIKE', '%' . $query . '%')
            ->paginate(10);

        // Append the search query to the pagination links
        $shareholderNames->appends(['query' => $query]);

        return view('content.en.searchShareholder', compact('shareholderNames'));
    }

    public function searchFunctionSRA(Request $request)
    {
        $query = $request->input('group_name');

        $sras = Sra::select('group_name')
        ->where('group_name', 'LIKE', '%' . $query . '%')
        ->distinct()
        ->paginate(10);

        // Append the search query to the pagination links
        $sras->appends(['group_name' => $query]);

        return view('content.en.searchSra', compact('sras'));
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