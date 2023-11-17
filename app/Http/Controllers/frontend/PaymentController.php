<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
// use App\Services\Frontend\Invoice\InvoiceService;
// use App\Services\Frontend\Payment\PaymentService;
use App\Helpers\HelperPayment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class PaymentController extends Controller
{
    private $_invoiceService;
    private $_paymentService;
    private $_activeLink = 'payment';
    private $_dataset = [
        'infoTextInput' => [
            'idPlayer' => 'Please input your id.',
            'country' => 'Please choose your country.',
            'warning' => 'ID Player is required.',
            'playerNotFound' => 'Error, please try again.'
        ],
        'titleModal' => [
            'purchase' => 'Detail Purchases',
            'alertInfo' => 'Alert',
        ],
        'alert' => [
            'idPlayer' => 'Id player is required.',
            'checkIdPlayer' => 'Please check your id.',
            'country' => 'Country must be choosed.',
            'payment' => 'Payment must be choosed.',
            'phone' => 'Phone number is required.',
            'item' => 'Item must be choosed.',
            'notAvaliable' => 'Data not avaliable'
        ],
        'noPayment' => 'Payment not avaliable',
        'badRequest' => 'Trouble in internal system, please wait.'
    ];


    public function __construct()
    {
        // $this->_invoiceService = $invoiceService;
        // $this->_paymentService = $paymentService;

        $this->base_url        = env('BASE_URL_API');
        $this->base_url_ks     = env('BASE_URL_API_KS');
        $this->base_url_kr     = env('BASE_URL_API_KR');
        $this->api_Key         = env('API_KEY');
        $this->default_ppid    = 'f4319589-0838-4200-89ee-b46e5505332c';
        $this->default_country = '9326f906-b163-4e53-8a9c-568660a54139';
    }

    public function index(Request $request)
    {
        try {
            $activeLink = $this->_activeLink;
            if ($request->slug) {
                $playerList = [];
                $slug            = $request->slug;

                //hit api game
                $responseCountry = Http::withHeaders([
                    'X-Api-Key' =>  $this->api_Key
                ])->get($this->base_url . '/api/v1/gamedetail', [
                    'game' => $slug,
                ]);
                $data_game = $responseCountry->json();

                foreach ($data_game as $resc) {
                    $data_response_game = $resc;
                }
                foreach ($data_response_game as $drc) {
                    $data_country_list = $drc;
                }

                $country_code   = $data_country_list[0]['country_code'];
                $currency_code  = $data_country_list[0]['code_currency'];
                $countriesJSON  = json_encode($data_country_list);
                $textAttribute  = json_encode($this->_dataset);
                $dataGame       = [
                    'cover' => $data_response_game['game_detail']['cover'],
                    'title' => $data_response_game['game_detail']['game_title'],
                    'about' => $data_response_game['game_detail']['description'],
                    'banner' => $data_response_game['game_detail']['banner'],
                    'tooltips' => $data_response_game['game_detail']['tooltips'],
                ];


                // dd($data_game);


                // get player if login
                if (session('token')) {
                    $api_token = session('token');
                    $base_url = env('BASE_URL_API');

                    $response = Http::withHeaders([
                        'Authorization' => $api_token,
                    ])->get($base_url . '/user');

                    if ($response->status() == 200) {
                        $result = $response->json();
                        $user_id = $result['data']['user_id'];


                        // get player
                        $responsePlayer = Http::withHeaders([
                            'X-Api-Key' =>  $this->api_Key
                        ])->get($this->base_url . '/api/v1/getplayer', [
                            'game_id' => $data_response_game['game_detail']['game_id'],
                            'user_id' => $user_id
                        ]);

                        if ($responsePlayer->status() == 200) {
                            $pl = $responsePlayer->json();
                            $playerList = $pl['data'];
                        }
                    }
                }





                // hit api items
                $response = Http::withHeaders([
                    'X-Api-Key' =>  $this->api_Key
                ])->get($this->base_url . '/api/v1/pricepoint', [
                    'country_id' => $data_country_list[0]['country_id'],
                    'game_id' => $data_response_game['game_detail']['id'],
                ]);
                $responses  = json_decode($response);


                foreach ($responses as $resp) {
                    $data_response = $resp;
                }



                return view('page.payment.index', compact('countriesJSON', 'data_country_list', 'country_code', 'dataGame', 'activeLink', 'textAttribute',  'data_response', 'currency_code', 'playerList'));
            }
        } catch (\Throwable $error) {
            abort(408);
        }
    }

    public function getVendor(Request $request)
    {

        $get_ppid = $request->ppid;
        $get_cid  = $request->cid;

        $response = Http::withHeaders([
            'X-Api-Key' =>  $this->api_Key
        ])->get($this->base_url . '/api/v1/payment', [
            'country' => $get_cid,
            'pricepoint_id' => $get_ppid,
        ]);

        $responses  = json_decode($response);
        foreach ($responses as $resp) {
            $data_response = $resp;
        }

        $payload = [
            'code' => $responses->code,
            'data' => $data_response
        ];

        return $payload;
    }

    public function checkPlayer(Request $request)
    {
        $get_ppid = $request->player_id;
        $get_gameid = $request->game_id;
        if ($get_gameid == 'kiko-run') {
            $response = Http::get($this->base_url_kr . '/player/get_info', [
                'player_id' => $get_ppid,
            ]);

            $responses  = json_decode($response);
            return $responses;
        } else {
            $response = Http::get($this->base_url_ks . '/player/get_info', [
                'player_id' => $get_ppid,
            ]);
            $responses  = json_decode($response);
            return $responses;
        }
    }

    public function confirmation(Request $request)
    {
        try {
            // if (!$request->query('invoice')) return 'Not found';
            $invoice = $request->query('invoice');

            $response = Http::withHeaders([
                'X-Api-Key' =>  $this->api_Key
            ])->get($this->base_url . '/api/v1/confirmation?invoice=' . $invoice);

            $result                  = $response->json();
            $data                    = $result['data'];
            $email                   = $data['payment']['email'];
            $gameID                  = $data['payment']['game_id'];
            $playerID                = $data['payment']['user'];
            $subsID                  = $data['payment']['ppi'];
            $amountGems              = $data['payment']['amount'];
            $invoiceNo               = $data['payment']['invoice'];
            list($username, $domain) = explode('@', $email);
            $firstChar               = substr($username, 0, 2);
            $usernameLength          = strlen($username);
            $maskedUsername          = $firstChar . str_repeat('*', $usernameLength - 2) . substr($username, -2);
            $hide_email              = $maskedUsername . '@' . $domain;
            $phone                   = $data['payment']['phone'];
            $hide_phone              = (is_null($phone)) ? '-' : str_replace('0', '+62', 0) . substr($phone, 1, 3) . str_repeat('*', 4) . substr($phone, -4);

            $slug_game               = $data['game']['slug_game'];
            $left_Time               = $data['payment']['leftTime'];
            $channel_id              = $data['payment']['channel_id'];
            $trx_status              = $data['payment']['transaction_status'];

            $activeLink              = $this->_activeLink;
            $alert                   = $this->_dataset['alert']['notAvaliable'];

            if (!empty($data['attribute']['va_number'])) {
                $filePath = public_path('list_payment.json');
                $fileContent = json_decode(file_get_contents($filePath), true);
                foreach ($fileContent as $resp) {
                    $data_response = $resp;
                }
                $payment_accordion = $data_response[$channel_id];
                return view('frontend.payment.confirmation-va', compact('data', 'activeLink', 'alert', 'slug_game', 'left_Time', 'channel_id', 'payment_accordion', 'trx_status', 'hide_email', 'hide_phone'));
            }

            // sent into mailbox game - for category gems[0] & subscribe[1]
            if ($data['payment']['game_id'] == 'KIKORUN') {
                $url_api_game =  $this->base_url_kr;
                $this_game_id = '1';
            } elseif ($data['payment']['game_id'] == 'KIKOSURVIVOR') {
                $url_api_game =  $this->base_url_ks;
                $this_game_id = '4';
            }

            if ($data['payment']['category_item'] == 1) {
                if ($data['payment']['transaction_status'] == 1 && $gameID != "FOL") {
                    $response = Http::post($url_api_game . '/purchase/topup/reward/', [
                        'game_id'   => $this_game_id,
                        'player_id' => $playerID,
                        'gems'      => 0,
                        'invno'     => $invoiceNo,
                        'subs'      => $subsID,
                        'signature' => md5($invoiceNo . $this_game_id . $playerID)
                    ]);
                }
            } else {
                if ($data['payment']['transaction_status'] == 1 && $gameID != "FOL") {
                    $response = Http::post($url_api_game . '/purchase/topup/reward/', [
                        'game_id'   => $this_game_id,
                        'player_id' => $playerID,
                        'gems'      => $amountGems,
                        'diamond'   => $amountGems,
                        'invno'     => $invoiceNo,
                        'subs'      => '-',
                        'signature' => md5($invoiceNo . $this_game_id . $playerID)
                    ]);
                }
            }

            return response()->view('page.payment.confirmation', compact('data', 'activeLink', 'alert', 'slug_game', 'left_Time', 'trx_status', 'hide_email', 'hide_phone'));
        } catch (\Throwable $error) {
            abort(404);
        }
    }

    // public function showFile($channel)
    // {
    //     $filePath = public_path('list_payment.json');
    //     $fileContent = json_decode(file_get_contents($filePath), true);
    //     foreach ($fileContent as $resp) {
    //         $data_response = $resp;
    //     }
    //     $data_upload = $data_response[$channel];
    //     return $data_upload;
    // }

    public function parseToVendor(Request $request)
    {
        try {
            $urlRedirect = HelperPayment::redirectToPayment($request->code, $request->all());

            if ($urlRedirect) return redirect($urlRedirect);
        } catch (\Throwable $error) {
            abort($error->getCode(), $error->getMessage());
        }
    }

    // public function checkInvoice(Request $request)
    // {
    //     try {
    //         $activeLink = $this->_activeLink;

    //         if (!$request['id']) return view('frontend.payment.check-invoice', compact('activeLink'));

    //         $invoices = $this->_invoiceService->checkInvoice($request['id']);
    //         $messageInfo = [
    //             'notFound' => 'Data Not Found'
    //         ];
    //         return view('frontend.payment.check-invoice', compact('activeLink', 'invoices', 'messageInfo'));
    //     } catch (\Throwable $error) {
    //         abort($error->getCode(), $error->getMessage());
    //     }
    // }

    // public function confirmationMp()
    // {
    //     return view('frontend.payment.confirmation-motionpay');
    // }
}
