<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Sra;

class SraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sras =Sra::all();
        return view('admin.sra.index', compact('sras'));
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
            'group_name' => 'required|string|max:255',
            'percent_transparency' => 'required|string|max:255',
            'percent_rspo_compliance' => 'required|string|max:255',
            'percent_ndpe_compliance' => 'required|string|max:255',
            'percent_total' => 'required|string|max:255',
        ]);

        Sra::create($request->all());

        return redirect()->route('sras.index')->with('success', 'Data sra added successfully.');
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
    public function update(Request $request, Sra $sra)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'percent_transparency' => 'required|string|max:255',
            'percent_rspo_compliance' => 'required|string|max:255',
            'percent_ndpe_compliance' => 'required|string|max:255',
            'percent_total' => 'required|string|max:255',
        ]);

        $sra->update($request->all());

        return redirect()->route('sras.index')->with('success', 'Data sra updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sra $sra)
    {
        $sra->delete();

        return redirect()->route('sras.index')->with('success', 'Data sra deleted successfully.');
    }
}