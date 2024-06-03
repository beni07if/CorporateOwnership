<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Consolidation;
use App\Models\CompanyOwnership;
use App\Models\OtherCompany;
use App\Models\Subsidiary;
use App\Models\Group;
use App\Models\Chatbot;
use App\Models\User;
use App\Models\Sra;
use Illuminate\Support\Facades\Http;
use DOMDocument;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function feature()
    {
        $subsidiary = Consolidation::all();
        $groupName = Consolidation::all();
        return view('content.en.feature.feature', compact('subsidiary', 'groupName'));
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
