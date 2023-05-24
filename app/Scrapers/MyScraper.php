<?php

namespace App\Scrapers;

use GuzzleHttp\Client;

class MyScraper
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function scrapeWebsite()
    {
        $response = $this->client->request('GET', 'http://www.beritanegara.co.id/');
        $html = $response->getBody()->getContents();

        // Add your parsing and data extraction logic here

        // Store the scraped data in your preferred format (database, file, etc.)
    }
}
