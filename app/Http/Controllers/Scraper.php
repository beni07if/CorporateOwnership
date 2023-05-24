<?php

namespace App\Scrapers;

use Goutte\Client;

// class MyScraper
// {
//     public function scrape()
//     {
//         $url = 'http://www.beritanegara.co.id/';
//         $client = new Client();
//         $crawler = $client->request('GET', $url);

//         // Perform scraping operations using crawler methods
//         // For example:
//         $crawler->filter('h1')->each(function ($node) {
//             echo $node->text() . "\n";
//         });
//     }
// }

class Scraper extends \Goutte\Client
{
    protected $client;

    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    public function scrapeData($url)
    {
        $crawler = $this->client->request('GET', $url);

        $data = [];

        foreach ($crawler->filter('.some-class') as $element) {
            $data[] = $element->text();
        }

        return $data;
    }
}
