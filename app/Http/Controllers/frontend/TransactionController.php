<?php

namespace App\Http\Controllers\frontend;

use Carbon\Carbon;
use App\Models\Ppn;
use App\Models\Price;
use App\Models\Payment;
use App\Models\PpiList;
use App\Models\GameList;
use App\Models\PricePoint;
use App\Models\Transaction;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Request;
use App\Events\Transaction as EventsTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class TransactionController extends Controller
{

    private function _sendEmail($request)
    {
        EventsTransaction::dispatch($request->email);
        Mail::send('emails.invoice', ['email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Email Verification Mail');
        });
    }

    public function transaction(Request $request)
    {

        try {

            $base_url = env('BASE_URL_API');
            $api_Key  = env('API_KEY');

            $game          = $request->game;
            $player_id     = $request->player_id;
            $pricepoint_id = $request->pricepoint_id;
            $email         = $request->email;
            $phone         = $request->phone;
            $price         = $request->price;
            $username      = $request->nickname;
            $game_server   = $request->game_server ?? 'ID';
            $payment_id    = $request->payment_id;
            $amount        = \explode(' ', $request->amount);
            $id       = $request->user_id;

            $response = Http::withHeaders([
                'X-Api-Key' => $api_Key,
            ])->post($base_url . '/api/v1/transaction', [
                'game'          => $game,
                'player_id'     => $player_id,
                'pricepoint_id' => $pricepoint_id,
                'email'         => $email,
                'phone'         => $phone,
                'price'         => $price,
                'payment_id'    => $payment_id,
                'username'      => $username,
                'game_server'   => $game_server,
                'amount'        => $amount[0],
                'user_id'       => $id
            ]);



            $invoice = $response->json();


            if ($response->status() != 200) {

                $notif = array(
                    'message' => 'something went wrong',
                    'alert-info' => 'danger'
                );

                return redirect()->back()->with($notif);
            };



            $notif = array(
                'message' => 'Success Checkout',
                'alert-info' => 'success'
            );

            return redirect()->route('payment.confirmation', ['invoice' => $invoice['data']]);
        } catch (\Throwable $th) {
            Log::error('Error Get Payment List', ['DATA' => Carbon::now()->format('Y-m-d H:i:s') . ' | ERR ' . ' | Error Get Payment List']);
            $notif = array(
                'message' => 'Internal Server Error',
                'alert-info' => 'warning'
            );

            return redirect()->back()->with($notif);
        }
    }

    private function totalPrice($price)
    {
        // $ppn = Ppn::select('id_ppn as id', 'ppn')->get()->toArray();
        $ppn = 2000;
        $totalPrice = $price + $ppn;

        return $totalPrice;
    }
}
