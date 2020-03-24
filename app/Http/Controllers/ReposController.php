<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class ReposController extends Controller
{
    /**
     * Get all languages
     * Route: /languages
     * @return array
     */
    public function all()
    {
        // Get first 100 repos
        $json_response = $this->getTrendingRepos(100);

        // Filter out all the repos with null in the language and count repos for each language
        $languages = [];
        foreach ($json_response->items as $repo) {
            if (!is_null($repo->language)) {
                if (isset($languages[$repo->language])) $languages[$repo->language]++;
                else $languages[$repo->language] = 1;
            }
        }

        // Make the response more presentable
        $response = [];
        foreach ($languages as $language => $count)
            $response[] = ['language' => $language, 'count' => $count];

        // Godspeed
        return [
            'ok' => true,
            'languages' => $response
        ];
    }

    public function get($language)
    {
    }

    /**
     * @param int $repos_per_page
     * @return \stdClass
     */
    private function getTrendingRepos(int $repos_per_page)
    {
        $date = date('Y-m-d', strtotime("30 days ago"));
        $endpoint = "https://api.github.com/search/repositories?q=created:>${date}&sort=stars&order=desc&per_page=${repos_per_page}";
        $client = new Client(['verify' => false]);
        $response = $client->request('GET', $endpoint);
        return json_decode($response->getBody());
    }
}
