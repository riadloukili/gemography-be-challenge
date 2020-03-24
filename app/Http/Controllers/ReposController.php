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

    /**
     * Get repos for specific language
     * Route: /languages/:language
     * @param $language
     * @return array
     */
    public function get($language)
    {
        // To handle the case where JavaScript should be the same as JaVaScRiPt
        $language = strtolower($language);
        // Assume the language spelling is correct at first and then correct it later
        $correct_language = $language;
        $json_response = $this->getTrendingRepos(100);
        $repos = [];
        foreach ($json_response->items as $repo) {
            if (strtolower($repo->language) === $language) {
                $repos[] = [
                    'name' => $repo->full_name,
                    'description' => $repo->description,
                    'stars' => $repo->stargazers_count,
                    'issues' => $repo->open_issues,
                ];
                if($correct_language != $repo->language) $correct_language = $repo->language;
            }
        }
        return [
            'ok' => true,
            'language' => $correct_language,
            'repos' => $repos
        ];
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
