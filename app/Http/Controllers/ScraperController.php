<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function index()
    {
        $scraper = new Scraper();

        $data = $scraper->scrapeData('https://example.com');

        dd($data);
    }
}
