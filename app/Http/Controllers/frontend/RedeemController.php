<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RedeemController extends Controller
{
    private $activeLink = 'games';
    private $_generalRepository;

    public function __construct()
    {
        $this->base_url        = env('BASE_URL_API');
        $this->base_url_ks     = env('BASE_URL_API_KS');
        $this->base_url_kr     = env('BASE_URL_API_KR');
        $this->api_Key         = env('API_KEY');
    }

    public function index(Request $request)
    {
        // try {
        $slug_game = $request->slug;
        $responseCountry = Http::withHeaders([
            'X-Api-Key' =>  $this->api_Key
        ])->get($this->base_url . '/api/v1/gamedetail', [
            'game' => $slug_game,
        ]);
        $data_game = $responseCountry->json();
        foreach ($data_game as $resc) {
            $data_response_game = $resc;
        }

        foreach ($data_response_game as $drc) {
            $data_country_list = $drc;
        }

        $country_code   = $data_country_list[0]['country_code'];
        $countriesJSON  = json_encode($data_country_list);
        $dataGame       = [
            'cover' => $data_response_game['game_detail']['cover'],
            'title' => $data_response_game['game_detail']['game_title'],
            'about' => $data_response_game['game_detail']['description'],
            'banner' => $data_response_game['game_detail']['banner'],
            'tooltips' => $data_response_game['game_detail']['tooltips'],
        ];




        return view('page.redeem.index', compact('countriesJSON', 'data_country_list', 'country_code', 'dataGame'));
        // } catch (\Throwable $error) {
        //     abort(408);
        // }
    }

    public function gamelist()
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


            return view('page.redeem.gamelist', compact('games'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function redeemed(Request $request)
    {
        $kr = "kiko-run";
        $game = json_encode($kr);
        $dt_gameid = json_encode($request->game_id);
        if ($dt_gameid == $game) {
            $response = Http::post($this->base_url_kr . '/redeem/load', [
                'game_id'   => '1',
                'player_id' => $request->player_id,
                'uid'       => $request->uid,
                'code'      => $request->val_redeem_code,
                'platform'  => substr($request->player_id, 2, 1),
                'signature' => md5($request->val_redeem_code . '1' . $request->player_id . $request->uid),
            ]);
            $data_redeem =  $response->json();
            if ($data_redeem['message'] == 200) {
                $responses = Http::post($this->base_url_kr . 'redeem/reward', [
                    'game_id'   => '1',
                    'player_id' => $request->player_id,
                    'uid'       => $request->uid,
                    'link'      => $data_redeem['url'],
                    'code'      => $data_redeem['code'],
                    'src'       => '2_redeem',
                    'signature' => md5('1' . $request->player_id . $request->uid),
                ]);
            }
            return $data_redeem;
        } else {
            $response = Http::post($this->base_url_ks . '/redeem', [
                'game_id'   => '4',
                'player_id' => $request->player_id,
                'uid'       => $request->uid,
                'code'      => $request->val_redeem_code,
                'signature' => md5($request->val_redeem_code . '4' . $request->player_id . $request->uid),
                'src'       => '2_redeem',
            ]);
            $data_redeem =  $response->json();
            return $data_redeem;
        }
    }
}
