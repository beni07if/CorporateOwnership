<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScraperController extends Controller
{
    protected $scraper;

    public function __construct(MyScraper $scraper)
    {
        $this->scraper = $scraper;
    }

    public function scrape()
    {
        $this->scraper->scrapeWebsite();

        // Add any necessary response or redirection logic
    }
}
