<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController as HomeFrontend;
use App\Http\Controllers\frontend\PaymentController as PaymentFrontend;
use App\Http\Controllers\frontend\TransactionController as FrontendTransactionController;
use App\Http\Controllers\frontend\RedeemController as FrontendRedeemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeFrontend::class, 'index'])->name('home');

Route::prefix('payment')->group(function () {
    Route::prefix('confirmation')->group(function () {
        Route::get('/', [PaymentFrontend::class, 'confirmation'])->name('payment.confirmation');
        Route::post('/va', [PaymentFrontend::class, 'vaPayment'])->name('payment.confirmation.va');
        Route::get('/codapay', function () {
            return 'codapay';
        })->name('payment.confirmation.coda');
    });

    Route::get('/{slug}', [PaymentFrontend::class, 'index'])->name('payment.games');
    Route::get('/{slug}/vendor/{cid}/{ppid}', [PaymentFrontend::class, 'getVendor'])->name('payment.get.vendor');
    Route::get('/{slug}/check/{player}', [PaymentFrontend::class, 'checkPlayer'])->name('payment.cek.player');
});

Route::post('/transaction', [FrontendTransactionController::class, 'transaction'])->name('payment.transaction');
Route::post('/payment-vendor/{code}', [PaymentFrontend::class, 'parseToVendor'])->name('payment.parse.vendor');

Route::get('/history', function (Request $request) {
    return view('page.payment.transactions-history');
})->name('history');


Route::prefix('redeem')->group(function () {
    Route::get('/', [FrontendRedeemController::class, 'gamelist'])->name('redem.gameslist');
    Route::get('/history', function (Request $request) {
        return view('page.redeem.redeem-history');
    })->name('redeem.history');
    Route::get('/{slug}', [FrontendRedeemController::class, 'index'])->name('redeem.games');
});
Route::post('/redeemed', [FrontendRedeemController::class, 'redeemed'])->name('redeem.games.redeemed');


Route::get('/login', function () {
    return view('frontend.auth.login');
})->name('login');
