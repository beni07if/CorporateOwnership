<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Consolidation;
use App\Models\Message;
use Illuminate\Http\Response;

class ConsolidationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consolidations = Consolidation::all();
        return view('admin.consolidation.index', compact('consolidations'));
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
            'subsidiary' => 'required|string|max:255',
            'country_operation' => 'required|string|max:255',
            'group_name' => 'required|string',
        ]);

        Consolidation::create($request->all());

        return redirect()->route('consolidations.index')->with('success', 'Data consolidation added successfully.');
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
    public function update(Request $request, Consolidation $consolidation)
    {
        $request->validate([
            'subsidiary' => 'required|string|max:255',
            'country_operation' => 'required|string|max:255',
            'group_name' => 'required|string',
        ]);

        $consolidation->update($request->all());

        return redirect()->route('consolidations.index')->with('success', 'Data consolidation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consolidation $consolidation)
    {
        $consolidation->delete();

        return redirect()->route('consolidations.index')->with('success', 'Data consolidation deleted successfully.');
    }
}