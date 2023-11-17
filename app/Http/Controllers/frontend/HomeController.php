<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
    private $_activeLink = 'home';


    public function index()
    {
        try {
            $games = [];

            $limit = 5;

            $base_url = env('BASE_URL_API');
            $api_Key  = env('API_KEY');


            $response = Http::withHeaders([
                'X-Api-Key' => $api_Key,
            ])->get($base_url . '/api/v1/gamelist?limit=' . $limit);

            $result = $response->json();

            $games = $result['data'];


            return view('page.home.index', compact('games'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
