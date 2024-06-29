<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Consolidation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FeatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
}
