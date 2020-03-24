<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function help() {
        return [
            "ok" => true,
            "message" => "Here are the current api routes :D",
            "routes" => [
                "/" => "Help, aka this page",
                "/languages" => "Get the languages used by the 100 trending public repos on GitHub",
                "/languages/{language}" => "Get the number and list of repos using this language. Example: /languages/JavaScript",
            ]
        ];
    }
}
