<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Group;
use App\Models\Consolidation;
use App\Models\CompanyOwnership;
use App\Models\Message;
use App\Models\Sra;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupCounts = Group::select('group_name')
        ->distinct()
        ->count('group_name');

        $consolidationCounts = Consolidation::select('subsidiary')
        ->count('subsidiary');
        $consolidationCountsDistinct = Consolidation::select('subsidiary')
        ->distinct()
        ->count('subsidiary');

        $shareholderCounts = CompanyOwnership::select('shareholder_name')
        ->count('shareholder_name');
        $shareholderCountsDistinct = CompanyOwnership::select('shareholder_name')
        ->distinct()
        ->count('shareholder_name');

        $sraCounts = Sra::select('group_name')
        ->count('group_name');
        $sraCountsDistinct = Sra::select('group_name')
        ->distinct()
        ->count('group_name');

        // Ambil semua data jumlah country_of_registered_address dari tabel group
        $allGroupCountes = Group::select('country_registration', \DB::raw('COUNT(DISTINCT group_name) as count'))
        ->groupBy('country_registration')
        ->orderBy('count', 'desc') // Urutkan berdasarkan count secara descending
        ->get();

        // Ambil 5 terbanyak untuk legenda
        $top5GroupCountes = Group::select('country_registration', \DB::raw('COUNT(DISTINCT group_name) as count'))
        ->groupBy('country_registration')
        ->orderBy('count', 'desc')
        ->take(5)
        ->get();

        // Ambil semua data jumlah country_of_registered_address dari tabel consolidation
        $allSubsidiaryCountes = Consolidation::select('country_registration', \DB::raw('COUNT(DISTINCT subsidiary) as count'))
        ->groupBy('country_registration')
        ->orderBy('count', 'desc') // Urutkan berdasarkan count secara descending
        ->get();

        // Ambil 5 terbanyak untuk legenda
        $top5SubsidiaryCountes = Consolidation::select('country_registration', \DB::raw('COUNT(DISTINCT subsidiary) as count'))
        ->groupBy('country_registration')
        ->orderBy('count', 'desc')
        ->take(5)
        ->get();

        // Ambil semua data jumlah country_of_registered_address dari tabel company ownership
        $allShareholderCountes = CompanyOwnership::select('company_name', \DB::raw('COUNT(DISTINCT shareholder_name) as count'))
        ->groupBy('company_name')
        ->orderBy('count', 'desc') // Urutkan berdasarkan count secara descending
        ->get();

        // Ambil 5 terbanyak untuk legenda
        $top5ShareholderCountes = CompanyOwnership::select('company_name', \DB::raw('COUNT(DISTINCT shareholder_name) as count'))
        ->groupBy('company_name')
        ->orderBy('count', 'desc')
        ->take(3)
        ->get();

        $messages = Message::all();
        $groups = Message::all();

        if (auth()->user()->email === 'admin@gmail.com') {
            // Logic for admin dashboard
            return view('admin.dashboard', compact('groupCounts', 'sraCounts', 'sraCountsDistinct', 'allGroupCountes', 'top5GroupCountes', 'allSubsidiaryCountes', 'top5SubsidiaryCountes', 'allShareholderCountes', 'top5ShareholderCountes', 'consolidationCounts', 'consolidationCountsDistinct', 'shareholderCounts', 'shareholderCountsDistinct', 'messages', 'groups'));
        }
        return redirect('/');
    }

    public function inbox()
    {
        return view('admin.dashboard');
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
}