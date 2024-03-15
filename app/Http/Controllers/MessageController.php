<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Message;
use RealRashid\SweetAlert\Facades\Alert;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::all();
        return view('admin.message.index', compact('messages'));
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
        $message = new Message;
        $message->name = $request->name;
        $message->phone = $request->phone;
        $message->email = $request->email;
        $message->institution = $request->institution;
        $message->message = $request->message;
        $message->date_message = $request->date_message;
        $message->status = $request->status;
        $message->created_at = now();
        $message->updated_at = now();

        $message->save();

        // Set session flash untuk create_success
        // session()->flash('create_success', 'Data berhasil dibuat.');
        Alert::success('Success', 'Your message has been successfully sent.');
        return redirect('/');
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
        $messages = Message::find($id);
        $messages->name = $request->name;
        $messages->phone = $request->phone;
        $messages->email = $request->email;
        $messages->message = $request->message;
        $messages->date_message = $request->date_message;
        $messages->response = $request->response;
        $messages->date_response = $request->date_response;
        $messages->status = $request->status;
        $messages->updated_at = now();
        $messages->save();
    
        // Set session flash or use Laravel's Alert package
        // session()->flash('update_success', 'Data berhasil diperbarui.');
        Alert::success('Success', 'Data has been updated.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //
    }
}
