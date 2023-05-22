<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Consolidation;
use Illuminate\Support\Facades\DB;

class CorporateProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(): Response
    public function index()
    {
        $subsidiary = Consolidation::all();
        return view('content.home', compact('subsidiary'));
    }

    public function subsidiaryShow(Request $request)
    {
        $subsidiaryName = $request->input('subsidiary');

        $consolidations = DB::table('consolidations')
            ->where('subsidiary', $subsidiaryName)
            ->get();

        return view('content.en.indexSubsidiary', compact('consolidations'));

        // $subsidiary = $request->id;
        // $shareholder = DB::table('consolidations')->where('subsidiary', $subsidiary)->value('shareholder_subsidiary');
        // return view('subsidiary.show', compact('subsidiary', 'shareholder'));

        // // Lakukan pemrosesan data sesuai kebutuhan Anda
        // $subsidiaryData = Subsidiary::where('subsidiary', $subsidiary)->first();

        // if ($subsidiaryData) {
        //     // Jika data ditemukan, lakukan operasi logika atau tampilkan view
        //     return view('content.en.indexSubsidiary', compact('subsidiaryData'));
        // } else {
        //     // Jika data tidak ditemukan, tampilkan pesan atau redirect
        //     return redirect()->route('subsidiaryIndex')->with('error', 'Subsidiary not found.');
        // }

        // $subs = route('subsidiaryShow', ['subsidiary' => $subsidiary]);
        // $subsidiary = Consolidation::where('subsidiary', $subs)->get();
        // return view('content.en.indexSubsidiary', compact('subsidiary'));
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
