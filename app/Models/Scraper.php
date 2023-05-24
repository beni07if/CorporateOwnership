<?php

namespace App\Scrapers;

use Goutte\Client;

class MyScraper
{
    public function scrape()
    {
        $url = 'http://www.beritanegara.co.id/';
        $client = new Client();
        $crawler = $client->request('GET', $url);

        // Perform scraping operations using crawler methods
        // For example:
        $crawler->filter('h1')->each(function ($node) {
            echo $node->text() . "\n";
        });
    }
}
