<?php

namespace App\Http\Controllers;

use App\Models\CompanyOwnership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Message;

class ShareholderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shareholders = CompanyOwnership::all();
        return view('admin.shareholder.index', compact('shareholders'));
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
            'shareholder_name' => 'required|string|max:255',
            'date_of_birth' => 'required|string|max:255',
            'company_name' => 'required|string',
        ]);

        CompanyOwnership::create($request->all());

        return redirect()->route('shareholders.index')->with('success', 'Data shareholder added successfully.');
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
    public function update(Request $request, CompanyOwnership $shareholder)
    {
        $request->validate([
            'shareholder_name' => 'required|string|max:255',
            'date_of_birth' => 'required|string|max:255',
            'company_name' => 'required|string',
        ]);

        $shareholder->update($request->all());

        return redirect()->route('shareholders.index')->with('success', 'Data shareholder updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyOwnership $shareholder)
    {
        $shareholder->delete();

        return redirect()->route('shareholders.index')->with('success', 'Data shareholder deleted successfully.');
    }
}