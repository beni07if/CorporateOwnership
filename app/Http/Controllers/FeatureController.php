<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Consolidation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Group;
use App\Models\CompanyOwnership;

class FeatureController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
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

    
    public function groupFeature()
    {
        $subsidiary = Consolidation::all();
        $groupName = Consolidation::all();
        return view('content.en.feature.groupFeature', compact('subsidiary', 'groupName'));
    }
    public function subsidiaryFeature()
    {
        $subsidiary = Consolidation::all();
        $groupName = Consolidation::all();
        return view('content.en.feature.subsidiaryFeature', compact('subsidiary', 'groupName'));
    }
    public function shareholderFeature()
    {
        $subsidiary = Consolidation::all();
        $groupName = Consolidation::all();
        return view('content.en.feature.shareholderFeature', compact('subsidiary', 'groupName'));
    }
    public function sraFeature()
    {
        $subsidiary = Consolidation::all();
        $groupName = Consolidation::all();
        return view('content.en.feature.sraFeature', compact('subsidiary', 'groupName'));
    }

    
    public function searchFunctionQuickGroup(Request $request)
    {
        $query = $request->input('group_name');

        $groups = Group::select('group_name', 'group_status', 'controller', 'country_registration', 'management_name_and_position', 'business_address')
            ->where('group_name', 'LIKE', '%' . $query . '%')
            ->distinct()
            ->paginate(10);

        // Append the search query to the pagination links
        $groups->appends(['group_name' => $query]);

        return view('content.en.quickSearch.quickSearchGroup', compact('groups'));
    }

    public function searchFunctionQuickSubsidiary(Request $request)
    {
        $query = $request->input('subsidiary');

        $subsidiary = Consolidation::select('subsidiary', 'country_operation', 'province', 'regency')
            ->where('subsidiary', 'LIKE', '%' . $query . '%')
            ->distinct()
            ->paginate(10);

        // Append the search query to the pagination links
        $subsidiary->appends(['subsidiary' => $query]);

        return view('content.en.quickSearch.quickSearchSubsidiary', compact('subsidiary'));
    }

    public function searchFunctionQuickShareholder(Request $request)
    {
        $query = $request->input('shareholder_name');

        $shareholder = CompanyOwnership::select('shareholder_name', 'company_name', 'country_of_business_address')
            ->where('shareholder_name', 'LIKE', '%' . $query . '%')
            ->distinct()
            ->paginate(10);

        // Append the search query to the pagination links
        $shareholder->appends(['shareholder_name' => $query]);

        return view('content.en.quickSearch.quickSearchShareholder', compact('shareholder'));
    }
}