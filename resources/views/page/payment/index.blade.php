@extends('layout.app')
@section('css-utilities')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .rating-1 {
        font-size: 80px;
        font-weight: 700;
        color: #125096;
    }

    .rating-2 {
        margin-left: 6px;
        font-size: 18px;
        font-weight: 500;
        color: #534D4D;
    }

    .review-1 {
        font-size: 18px;
        color: #534D4D;
    }

    .timeline {
        text-decoration: none;
        padding: 0;
        /* background-color: #B53333; */
    }

    .timeline::before {
        content: "";
        position: absolute;
        top: 0;
        left: 1.35rem;
        height: 100%;
        width: 0.25rem;
        background-color: #8495BD;
        border-radius: 0.25rem;
        z-index: 1;
    }

    .left-side {
        z-index: 2;
        /* background-color: #38CBA6; */
    }

    .input-form__country {
        position: relative;
    }

    .check-circle {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #007536;
        pointer-events: none;
    }

    .left-number {
        height: 48px;
        width: 48px;
        display: flex;
        background-color: #125096;
        justify-content: center;
        align-items: center;
        color: #FFF;
        border-radius: 50%;
        font-size: 1.25rem;
    }

    .right-side {
        width: 100%;
        height: auto;
        margin: 0 0 0 1rem;
    }

    .box-item {
        padding-block: 55px !important;
        background-color: #D5ECFE;
    }

    .box-item:hover {
        border: 2px solid #125096;
        background-color: #D5ECFE;
    }

    .box-item.active {
        position: relative;
        background-color: #D5ECFE;
        border: 2px solid #125096;
    }

    .box-item.active::before {
        content: "\2713";
        position: absolute;
        top: -5.5px;
        left: -2px;
        font-size: 15px;
        font-weight: bold;
        color: #FFFFFF;
        padding: 4px;
        transform-origin: top left;
        background-color: #125096;
        border-radius: 0 0 45px 0;
    }

    .p-font-small {
        font-size: 11px;
    }

    .p-font-small-2 {
        font-size: 13px;
    }

    .p-font-medium {
        font-size: 20px;
    }

    .p-font-medium-1 {
        font-size: 15px;
    }

    .channel-payment.active {
        outline: 2px solid #125096;
    }

    .channel-payment:hover {
        outline: 2px solid #125096;
    }

    .accordion-item-payment {
        background-color: #eceff6;
    }

    .accordion-button.payment-vendor::after {
        display: none;
    }

    /* modal */
    .modal-header {
        background-color: #0D0F3B;
    }

    .dashed-line {
        margin: 5% 0 5%;
        border-top: 3px dashed #82B7D8;
        width: 100%;
    }

    .dashed-line-gray {
        margin: 3% 0 3%;
        border-top: 2px dashed grey;
        width: 100%;
    }

    .link-href {
        color: #6242FC;
        text-decoration: underline;
    }

    .modal-body .card {
        background-color: #D5ECFE;
        border: 2px solid #82B7D8;
        color: #125096;
    }
</style>
@endsection

<?php
$user_id = null;
$user = null;

if (session('token')) {
    $api_token = session('token');
    $base_url = env('BASE_URL_API');

    $response = Http::withHeaders([
        'Authorization' => $api_token,
    ])->get($base_url . '/user');

    if ($response->status() == 200) {
        $result = $response->json();
        $user_id = $result['data']['user_id'];
        $user = $result['data'];
    }
} ?>

@section('content')

<div class="container">
    <div class="row my-4 justify-content-center">
        <div class="games-info__body col col-12 col-lg-6 order-last order-lg-first my-2">
            <div class="col">
                {{-- <img src="{{ $dataGame['cover'] }}" class="img-fluid" alt="icon-game"> --}}
                <img src="{{ $dataGame['banner'] }}" class="img-fluid" alt="icon-game">
            </div>
            <div class="col mt-4">
                <h2 class="games-info__title">{{ $dataGame['title'] }}</h2>
                <p class="mt-3 fs-6" style="text-align: justify;"><small>{{ $dataGame['about'] }}</small></p>
            </div>
            <div class="col mt-4">
                <h2 class="games-info__title-rating">Ratings and Reviews</h2>
                <span class="rating-1">4.3</span>
                <span class="rating-2">out of 5</span>
                <p class="review-1">2.58K Reviews</p>
                <div class="star-rating mb-4">
                    <div class="row d-flex align-items-center">
                        <div class="col col-12 col-md-3 d-flex justify-content-end my-1">
                            @for ($i = 0; $i < 5; $i++) <i class="fa-sharp fa-solid fa-star" style="color: #534D4D;">
                                </i>
                                @endfor
                        </div>
                        <div class="col col-12 col-md-6 my-1">
                            <div class="progress m-0">
                                <div class="progress-bar" role="progressbar"
                                    style="width: 80%; background-color: #534D4D;">
                                </div>
                            </div>
                        </div>
                        <div class="col col-12 col-md-3 my-1">
                        </div>
                    </div>
                    <div class="row d-flex align-items-center">
                        <div class="col col-12 col-md-3 d-flex justify-content-end my-1">
                            @for ($i = 0; $i < 4; $i++) <i class="fa-sharp fa-solid fa-star" style="color: #534D4D;">
                                </i>
                                @endfor
                        </div>
                        <div class="col col-12 col-md-6 my-1">
                            <div class="progress m-0">
                                <div class="progress-bar" role="progressbar"
                                    style="width: 20%; background-color: #534D4D;">
                                </div>
                            </div>
                        </div>
                        <div class="col col-12 col-md-3 my-1">
                        </div>
                    </div>
                    <div class="row d-flex align-items-center">
                        <div class="col col-12 col-md-3 d-flex justify-content-end my-1">
                            @for ($i = 0; $i < 3; $i++) <i class="fa-sharp fa-solid fa-star" style="color: #534D4D;">
                                </i>
                                @endfor
                        </div>
                        <div class="col col-12 col-md-6 my-1">
                            <div class="progress m-0">
                                <div class="progress-bar" role="progressbar"
                                    style="width: 35%; background-color: #534D4D;">
                                </div>
                            </div>
                        </div>
                        <div class="col col-12 col-md-3 my-1">
                        </div>
                    </div>
                    <div class="row d-flex align-items-center">
                        <div class="col col-12 col-md-3 d-flex justify-content-end my-1">
                            @for ($i = 0; $i < 2; $i++) <i class="fa-sharp fa-solid fa-star" style="color: #534D4D;">
                                </i>
                                @endfor
                        </div>
                        <div class="col col-12 col-md-6 my-1">
                            <div class="progress m-0">
                                <div class="progress-bar" role="progressbar"
                                    style="width: 50%; background-color: #534D4D;">
                                </div>
                            </div>
                        </div>
                        <div class="col col-12 col-md-3 my-1">
                        </div>
                    </div>
                    <div class="row d-flex align-items-center">
                        <div class="col col-12 col-md-3 d-flex justify-content-end my-1">
                            <i class="fa-sharp fa-solid fa-star" style="color: #534D4D;"></i>
                        </div>
                        <div class="col col-12 col-md-6 my-1">
                            <div class="progress m-0">
                                <div class="progress-bar" role="progressbar"
                                    style="width: 15%; background-color: #534D4D;">
                                </div>
                            </div>
                        </div>
                        <div class="col col-12 col-md-3 my-1">
                        </div>
                    </div>
                </div>
                <p class="review-1">Don't have the game yet? Download {{ Str::title($dataGame['title']) }} today!</p>
                <div class="download-now">
                    <div class="row">
                        <div class="col d-flex">
                            <a href="">
                                <img src="{{ asset('assets/img/download_playstore.png') }}" width="200" alt="icon-download">
                            </a>
                        </div>
                        <div class="col d-flex">
                            <a href="">
                                <img src="{{ asset('assets/img/download_appstore.png') }}" width="200" alt="icon-download">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-12 col-lg-6 order-first order-lg-last my-2">
            {{-- payment column --}}
            <div class="position-relative">
                <ul class="timeline">
                    <li class="d-flex p-0 mb-4">
                        <div class="left-side">
                            <div class="left-number left-number-1">1</div>
                        </div>
                        <div class="right-side">
                            <div class="card">
                                <div class="card-header fs-5 text-white" style="background-color: #8495BD">
                                    Enter Player ID
                                    <button type="button" class="btn btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal2">
                                        <i class="fa-solid fa-circle-question fa-lg"></i>
                                    </button>
                                </div>
                                <div class="card-body" style="background-color: #ECEFF6">
                                    <div class="row row-cols-lg">
                                        <div class="card-text">
                                            <small>Country <span class="text-danger">*</span></small>
                                        </div>
                                        <div class="input-form__country input-group mt-1"
                                            data-listcountry="{{ $countriesJSON }}">
                                            <span class="input-group-text">
                                                <i class="fa-solid fa-earth-asia"></i>
                                            </span>
                                            <select class="form-select" aria-label="Select countries"
                                                aria-placeholder="country" id="countrySelect" name="countrySelect">
                                                <option>Select Country</option>
                                                <option disabled>----------------------------</option>
                                                @foreach ($data_country_list as $country)
                                                <option selected value="{{ $country['country_id'] }}">
                                                    {{ $country['country'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-feedback input-country"></div>
                                    </div>
                                    <div class="row row-cols-lg">
                                        <div class="card-text">
                                            <small>Player ID <span class="text-danger">*</span></small>
                                        </div>
                                        <div class="input-form__country input-group mt-1">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            {{-- <input type="text" class="form-control" name="player_id" id="player_id"
                                                placeholder="KS1000000001" required> --}}

                                            <input type="text" class="form-control" name="player_id" id="player_id"
                                                placeholder="KS1000000001" required list="playerIds">
                                            <!-- Elemen datalist yang berisi opsi-opsi riwayat -->
                                            @if ($playerList)
                                            <datalist id="playerIds">
                                                @foreach ($playerList as $pl)
                                                <option value="{{ $pl['player_id'] }}">
                                                    @endforeach

                                                    <!-- Tambahkan lebih banyak opsi riwayat di sini -->
                                            </datalist>
                                            @endif

                                            <div id="loading-check"
                                                class="btn text-white rounded px-4 text-white d-none"
                                                style="background: #5138CB">
                                                <i class="fas fa-1x fa-sync-alt fa-spin"></i>
                                            </div>
                                            <button class="btn text-white" type="button" id="confirmButton"
                                                style="background: #5138CB" onclick="checkPlayer()">
                                                Check
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row row-cols-lg form-load-nickname d-none" id="nickname_player">
                                        <div class="card-text mt-2">
                                            <small>Nickname</small>
                                        </div>
                                        <div class="input-form__country input-group mt-1 input-with-icon">
                                            <span class="input-group-text">
                                                <i class="fa-solid fa-id-card"></i>
                                            </span>
                                            <input type="text" class="form-control" name="val_nickname"
                                                id="val_nickname" disabled>
                                            <i class="fas fa-check-circle check-circle"></i>
                                        </div>
                                    </div>
                                    <div class="input-country d-flex justify-content-end text-danger"
                                        style="font-size: 0.8rem; margin-top: 5px;">
                                        *required field
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex section-2 p-0 mb-4">
                        <div class="left-side">
                            <div class="left-number left-number-2">2</div>
                        </div>
                        <div class="right-side">
                            <div class="card">
                                <div class="card-header fs-5 text-white" style="background-color: #8495BD">
                                    Select Item
                                </div>
                                <div class="card-body" style="background-color: #ECEFF6">
                                    <div class="row row-cols-4 justify-content-center item-price__wrapperNew">
                                        <input type="text" id="box-input_countryid" value="{{ $country['country_id'] }}"
                                            hidden>

                                        @for ($i = 0; $i < count($data_response); $i++) <a
                                            class="btn col-2 box-item m-3 text-center" onclick="boxClicked(this)">
                                            <div class="col">
                                                <img src="{{ $data_response[$i]->img }}" alt="img-item-game">
                                            </div>
                                            <div class="box-item__ppid d-none" id="box-item__ppid_{{ $i }}">
                                                {{ $data_response[$i]->pricepoint_id }}</div>
                                            <div class="box-item__amount" id="box-item__amount_{{ $i }}">
                                                {{ $data_response[$i]->amount }}
                                                {{ $data_response[$i]->name_currency }}
                                            </div>
                                            <div class="box-item__price" id="box-item__price_{{ $i }}">
                                                <input type="text" id="box-item__pricee_{{ $i }}"
                                                    value="{{ $data_response[$i]->price }}" hidden>
                                                {{ $currency_code }}
                                                {{ number_format($data_response[$i]->price, 0, ',', '.') }}
                                            </div>
                                            </a>
                                            @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    {{-- processing payment --}}
                    <div class="overlay text-center mt-4 d-none">
                        <i class="fas fa-3x fa-sync-alt fa-spin" style="color: #125096;"></i>
                        <p>Processing...</p>
                    </div>
                    <li class="d-flex section-3 p-0 mb-4 d-none">
                        <div class="left-side">
                            <div class="left-number left-number-3">3</div>
                        </div>
                        <div class="right-side">
                            <div class="card">
                                <div class="card-header fs-5 text-white" style="background-color: #8495BD">
                                    Select Payment
                                </div>
                                <div class="card-body" style="background-color: #ECEFF6">
                                    <div class="accordion-collapse collapse show mt-3 pb-3 d-none"
                                        id="accordionPaymentStayOpenNew">
                                        <div class="accordion accordion-item-payment"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    {{-- processing details --}}
                    <div class="overlayForm text-center mt-4 d-none">
                        <i class="fas fa-3x fa-sync-alt fa-spin" style="color: #125096;"></i>
                        <p>Processing...</p>
                    </div>
                    <li class="d-flex section-4 p-0 mb-4 d-none">
                        <div class="left-side">
                            <div class="left-number left-number-4">4</div>
                        </div>
                        <div class="right-side">
                            <div class="card">
                                <div class="card-header fs-5 text-white" style="background-color: #8495BD">
                                    Enter Your Details
                                </div>
                                <div class="card-body" style="background-color: #ECEFF6">

                                    <form class="d-none" action="{{ route('payment.transaction') }}" method="post"
                                        id="detailsPayment">
                                        @csrf
                                        <div class="row">
                                            <small>Please enter your email to receive your invoice</small>

                                            <input type="hidden" name="game" class="game">
                                            <input type="hidden" name="user_id" class="user_id">
                                            <input type="hidden" name="player_id" class="player_id">
                                            <input type="hidden" name="nickname" class="nickname">
                                            <input type="hidden" name="pricepoint_id" class="pricepoint_id">
                                            <input type="hidden" name="price" class="price">
                                            <input type="hidden" name="payment_id" class="payment_id">
                                            <input type="hidden" name="amount" class="amount">

                                            @if (is_null($user))
                                            <div class="card-text mt-2">
                                                <small>Email <span class="text-danger">*</span></small>
                                            </div>
                                            <div class="input-group my-1">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-envelope"></i>
                                                </span>
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="mail@gmail.com" aria-label="email"
                                                    pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required>
                                            </div>
                                            <div class="card-text text-phone mt-2">
                                                <small>Phone <span id="phone_required"
                                                        class="danger-warn text-danger d-none">*</span></small>
                                            </div>
                                            <div class="input-group input-phone my-1">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-phone"></i>
                                                </span>

                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="081000111222" aria-label="phone" pattern="[0-9]{9,13}">
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" id="gridCheck"
                                                        name="remember">
                                                    <span><small>Remember Me</small></span>
                                                    <span>
                                                        <div class="input-country d-flex text-danger justify-content-end"
                                                            style="font-size: .8rem; margin-top: -25px;">
                                                            *required field</div>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="g-recaptcha d-flex justify-content-center mt-2"
                                                data-callback="reCaptchaCallback"
                                                data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                                            @else
                                            <div class="card-text mt-2">
                                                <small>Email <span class="text-danger">*</span></small>
                                            </div>
                                            <div class="input-group my-1">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-envelope"></i>
                                                </span>
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="mail@gmail.com" aria-label="email"
                                                    value="{{ $user['email'] }}"
                                                    pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required>
                                            </div>
                                            <div class="card-text text-phone mt-2">
                                                <small>Phone <span id="phone_required"
                                                        class="danger-warn text-danger d-none">*</span></small>
                                            </div>
                                            <div class="input-group input-phone my-1">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-phone"></i>
                                                </span>

                                                <input type="text" name="phone" class="form-control"
                                                    value="{{ $user['phone'] }}" placeholder="081000111222"
                                                    aria-label="phone" pattern="[0-9]{9,13}">
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input d-none" type="checkbox"
                                                        id="gridCheck" name="remember">
                                                    <span><small>&nbsp;</small></span>
                                                    <span>
                                                        <div class="input-country d-flex text-danger justify-content-end"
                                                            style="font-size: .8rem; margin-top: -25px;">
                                                            *required field</div>
                                                    </span>

                                                </div>
                                            </div>
                                            @endif


                                        </div>
                                        <div class="dashed-line-gray"></div>
                                        <div class="row">
                                            <h6 class="card-title mb-2"><strong>Terms &amp; Conditions:</strong></h6>
                                            <div class="col">
                                                <p class="p-font-small">By clicking “Buy Now”,<br>(i) &nbsp;I
                                                    acknowledge that I
                                                    have read and agree to
                                                    ESI Gameshop <a class="link-href"
                                                        href="https://policy.mncgames.com/" target="_blank">Terms &amp;
                                                        Conditions</a> and <a class="link-href"
                                                        href="https://policy.mncgames.com/" target="_blank">Privacy
                                                        Policy</a>
                                                    <br>(ii) I understand and agree that all sales are final and
                                                    non-refundable
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row rounded" style="background: #EAE8F7">
                                            <div class="col-md-6 d-grid align-items-center">
                                                <div class="d-flex">
                                                    <i class="fas fa-user my-auto"></i>
                                                    <span id="val_payment_pid" class="fw-bold my-auto ms-2"></span>
                                                </div>
                                                <div class="d-flex">
                                                    <i class="fa-solid fa-gem my-auto"></i>
                                                    <span id="val_items_qty" class="fw-bold my-auto ms-2"></span>
                                                </div>
                                                <div class="d-flex">
                                                    &nbsp;
                                                </div>
                                                <div class="d-flex">
                                                    <img class="w-50 rounded my-auto" id="icon-payment" src=""
                                                        alt="icon-payment">
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-grid align-items-center">
                                                <div class="d-flex">
                                                    <span id="val_total_payment"
                                                        class="ms-auto text-success fw-bold fs-5"></span>
                                                </div>
                                                <div id="loading" class="btn btn-modal text-white rounded d-none py-3"
                                                    style="background: #5138CB;">
                                                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-modal text-white rounded btn-lg btn-block py-3"
                                                    onclick="loader()" id="btn-modal-item" style="background: #A9A9A9">
                                                    <i class="fa-solid fa-sack-dollar me-2"></i>
                                                    Buy Now
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <div class="col mt-3 d-none" id="CouponSection">
                        <div class="row">
                            <div class="col">
                                Gunakan Kode Promo
                            </div>
                        </div>
                    </div>
                </ul>
            </div>

            <!-- Modal Detail-->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" style="background: grey;
    position: absolute;
  float: left;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);">
                    <img src="{{ $dataGame['tooltips'] }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>


@section('js-utilities')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Script -->
<script>
    const inputElement = document.getElementById('player_id');
        const confirmButton = document.getElementById('confirmButton');
    
        function toggleConfirmButton() {
            confirmButton.disabled = inputElement.value === '';
        }
        inputElement.addEventListener('input', toggleConfirmButton);
        toggleConfirmButton();
    
        window.addEventListener('DOMContentLoaded', () => {
            if (inputElement.value !== '') {
                confirmButton.disabled = false;
            }
        });
</script>

<script>
    let user_id = '{!! $user_id !!}'
    
        var activeButton = null;
        var activePayment = null;
        var currencyCodes = '{!! $currency_code !!}'
        let data = [];
        var pathArray = window.location.pathname.split('/');
        var isLoadingData = false;
    
        // verify reCaptcha
        function reCaptchaCallback() {
            $('#btn-modal-item').removeAttr('disabled');
        }
    
        function numberWithCommas(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    
        function showOverlay() {
            $(".overlay").removeClass("d-none");
            $(".section-3").addClass("d-none");
        }
    
        function closeOverlay() {
            $(".overlay").addClass("d-none");
            $(".section-3").removeClass("d-none");
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        }
    
        // func form
        function showOverlayForm() {
            $(".overlayForm").removeClass("d-none");
            $(".section-4").addClass("d-none");
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        }
    
        function closeOverlayForm() {
            $(".overlayForm").addClass("d-none");
            $(".section-4").removeClass("d-none");
        }
    
        // end
    
        window.onload = function() {
            let dt = JSON.parse(localStorage.getItem('myArray')) || [];
            notif(dt)
            checkRememberedData();
        };
    
        const rememberMeCheckbox = document.querySelector('#gridCheck');
        rememberMeCheckbox.addEventListener('change', function() {
            const emailInput = document.querySelector('input[name="email"]');
            const phoneInput = document.querySelector('input[name="phone"]');
            const player_id = document.querySelector('input[name="player_id"]');
            if (this.checked) {
                setRememberedData(emailInput.value, phoneInput.value, player_id.value);
            } else {
                setRememberedData('', '', '');
            }
        });
    
        function checkRememberedData() {
            const rememberedData = JSON.parse(localStorage.getItem('remembered_data'));
            if (rememberedData) {
                const emailInput = document.querySelector('input[name="email"]');
                const phoneInput = document.querySelector('input[name="phone"]');
                const player_id = document.querySelector('input[name="player_id"]');
    
                // Temukan elemen tombol dengan ID "confirmButton"
                var confirmButton = document.getElementById("confirmButton");
    
                // Hapus atribut "disabled"
                confirmButton.removeAttribute("disabled");
    
    
                emailInput.value = rememberedData.email;
                phoneInput.value = rememberedData.phone;
                player_id.value = rememberedData.player_id;
    
                rememberMeCheckbox.checked = true;
            }
        }
    
        function setRememberedData(email, phone, player_id) {
            if (email || phone || player_id) {
                const data = JSON.stringify({
                    email,
                    phone,
                    player_id
                });
                localStorage.setItem('remembered_data', data);
            } else {
                localStorage.removeItem('remembered_data');
            }
        }
    
        function checkPlayer() {
            const get_gameid = window.location.pathname.split('/')[2];
            const players_id = document.querySelector('input[name="player_id"]');
            const val_pid = players_id.value;
            // var urls = window.location.origin + '/payment/kiko-survivor/check/' + val_pid;
            var urls = window.location.origin + '/payment/' + (get_gameid === 'kiko-run' ? 'kiko-run' : 'kiko-survivor') +
                '/check/' + val_pid;
            var parameter = {
                player_id: val_pid,
                game_id: get_gameid
            };
    
            $('#loading-check').removeClass('d-none');
            $('#confirmButton').addClass('d-none');
    
            $.ajax({
                type: 'GET',
                url: urls,
                data: parameter,
                success: function(response) {
                    $('#loading-check').addClass('d-none');
                    $('#confirmButton').removeClass('d-none');
                    if (response.message != 200) {
                        $(".form-load-nickname").addClass("d-none");
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Player Data Not Found!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        const targetSection = document.querySelector('.section-2');
                        $(".form-load-nickname").removeClass("d-none");
                        $("#val_nickname").val(response.nickname);
                        window.scrollTo({
                            top: targetSection.offsetTop,
                            behavior: 'smooth'
                        });
                        $(".left-number-1").css("background-color", "#007536");
                    }
                },
                error: function(xhr, status, error) {
                    // console.log('Error sending PPID to the route:', error);
                }
            });
        }
    
        function boxClicked(element) {
            if (isLoadingData) {
                return; // If data is still loading, prevent clicking another box
            }
    
            var buttons = document.getElementsByClassName("box-item");
            var cidElement = document.getElementById("box-input_countryid").value;
            var playerElement = document.getElementById("player_id").value;
            var nicknameElement = document.getElementById("val_nickname").value;
    
            if (playerElement == '' || playerElement == null || nicknameElement == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Please Check your Player ID First!',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                var accordionItem = document.querySelector('.accordion-item-payment');
                var contentElements = Array.from(accordionItem.children).slice(0);
                contentElements.forEach(function(element) {
                    accordionItem.removeChild(element);
                });
    
                var lastActivePpid = '';
                var lastActiveAmount = '';
                var lastActivePrice = '';
    
                for (var i = 0; i < buttons.length; i++) {
                    if (buttons[i] == element) {
                        if (!buttons[i].classList.contains("active")) {
                            buttons[i].classList.add("active");
                            var ppidElement = document.getElementById('box-item__ppid_' + i);
                            var priceElement = document.getElementById('box-item__pricee_' + i);
                            var amountElement = document.getElementById('box-item__amount_' + i);
    
                            var ppid = ppidElement ? ppidElement.innerText : '';
                            var amount = amountElement ? amountElement.innerText : '';
                            var price = priceElement ? priceElement.value : '';
    
                            lastActivePpid = ppid;
                            lastActiveAmount = amount;
                            lastActivePrice = price;
                        } else {
    
                            buttons[i].classList.remove("active");
                            lastActivePpid = '';
                            lastActiveAmount = '';
                            lastActivePrice = '';
                            $(".section-3").addClass("d-none");
                        }
                    } else {
                        buttons[i].classList.remove("active");
                    }
                }
                if (lastActivePpid || lastActiveAmount || lastActivePrice) {
                    isLoadingData = true;
                    $(".left-number-2").css("background-color", "#007536");
                    $(".section-4").addClass("d-none");
                    sendPpidToRoute(cidElement, lastActivePpid, playerElement, lastActiveAmount, lastActivePrice,
                        nicknameElement);
                }
            }
        }
    
        function sendPpidToRoute(cid, ppid, pid, amount, price, nickname) {
            showOverlay();
            document.getElementById("detailsPayment").classList.add("d-none");
            var url = window.location.origin + '/payment/fight-of-legends/vendor/' +
                cid + '/' + ppid;
            var parameter = {
                ppid: ppid,
                cid: cid,
            };
    
            $.ajax({
                type: 'GET',
                url: url,
                data: parameter,
                success: function(response) {
                    console.log(response);
                    getCode = response.code;
                    getData = response.data;
                    showPaymentVendor(getCode, getData, pid, amount, price, ppid, nickname);
    
                },
                error: function(xhr, status, error) {
                    // console.log('Error sending PPID to the route:', error);
                },
                complete: function() {
                    closeOverlay();
                    isLoadingData = false;
                }
            });
        }
    
        function showPaymentVendor(code, data, pid, amount, price, ppid, nickname) {
    
            if (code == 200) {
                document.getElementById("accordionPaymentStayOpenNew").classList.remove("d-none");
                $(".section-4").addClass("d-none");
    
                var accordionItem = document.querySelector('.accordion-item-payment');
    
                for (var i = 0; i < data.length; i++) {
                    let result = [];
                    let seeStatus = [];
                    let seeCategory = [];
                    data[i].payment.forEach((el, index) => {
                        let disabledClass = el.status ? '' : 'disabled';
                        let colorClass = el.status ? '' : '#a9a9a9';
                        let paymentData =
                            `<div class="col"><a class="btn channel-payment border rounded p-1 d-flex justify-content-center align-items-center mt-3 ${disabledClass}" data-payment="${el.payment_id}" payment-name="${el.payment_name}" payment-icon="${el.logo}" data-index="${index}" style="background: ${colorClass}" "><img class="img-fluid" src="${el.logo}" alt="${el.logo}"></a></div>`;
                        result += paymentData;
                        seeStatus += (el.status + ",");
                    });
                    seeCategory += data[i].category;
    
                    var newDiv = document.createElement('div');
                    let collapsedAccordion = (i == 0) ? '' : 'collapsed';
                    let collapsedShowAccordion = (i == 0) ? 'collapse show' : 'collapse';
                    newDiv.innerHTML =
                        `<div class="accordion-collapse collapse show" id="accordionPaymentStayOpenNew-collapse${i}" aria-labelledby="accordionPaymentStayOpenNew-heading${i}">
                                                                                                            <div class="accordion-body text-end"><div class="accordion" id="accordionPaymentItemsStayOpenNew">
                                                                                                            <div class="accordion-item">
                                                                                                            <h2 class="accordion-header" id="paymentStayOpenNew-heading${i}">
                                                                                                            <button class="accordion-button accordion-button-${i} ${collapsedAccordion}" type="button" data-bs-toggle="collapse" data-bs-target="#paymentStayOpenNew-collapse${i}" aria-expanded="true" aria-controls="paymentStayOpenNew-collapse${i}">${data[i].category}
                                                                                                                </button>
                                                                                                            </h2><div class="accordion-collapse ${collapsedShowAccordion}" id="paymentStayOpenNew-collapse${i}" aria-labelledby="paymentStayOpenNew-heading${i}"><div class="accordion-body text-start" id="paymentStayOpenDesc${i}"><div class="row row-cols-4 g-3">${result}</div>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            </div> 
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            `;
                    accordionItem.appendChild(newDiv);
    
                    // Add event listener data-payment
                    const channelPayments = document.querySelectorAll('.channel-payment');
                    channelPayments.forEach((payment) => {
                        payment.addEventListener('click', function(e) {
                            channelPayments.forEach((p) => {
                                p.classList.remove('btn');
                                p.classList.remove('active');
                            });
                            const isDisabled = this.classList.contains('disabled');
                            if (isDisabled) {
                                document.getElementById('btn-modal-item').disabled = true;
                                document.getElementById('btn-modal-item').style.background = '#A9A9A9';
                                this.classList.add('disabled');
                                this.classList.remove('btn');
                                this.classList.remove('active');
                            } else {
                                document.getElementById('btn-modal-item').disabled = false;
                                document.getElementById('btn-modal-item').style.background = '#5138CB';
                                this.classList.add('btn');
                                this.classList.add('active');
                                window.scrollTo({
                                    top: document.body.scrollHeight,
                                    behavior: 'smooth'
                                });
                            }
    
                            if (activePayment !== this) {
    
                                const payment = this.getAttribute('data-payment');
                                const paymentName = this.getAttribute('payment-name');
                                const paymentIcon = this.getAttribute('payment-icon');
                                activePayment = this;
    
                                showOverlayForm()
                                setTimeout(() => {
                                    closeOverlayForm()
                                    document.getElementById("detailsPayment").classList.remove(
                                        "d-none");
                                    handleFormInput(pid, amount, price, paymentName, paymentIcon,
                                        payment, ppid,
                                        nickname);
                                    window.scrollTo({
                                        top: document.body.scrollHeight,
                                        behavior: 'smooth'
                                    });
                                }, 1000);
                                $(".left-number-3").css("background-color", "#007536");
                            }
    
                        });
                    });
    
                    const buttons = document.querySelectorAll(`#paymentStayOpenNew-collapse${i} .btn`);
                    buttons.forEach(button => {
                        const category = button.getAttribute('data-category');
                        button.addEventListener('click', (event) => {
                            handleButtonClick(category, button);
                        });
                    });
                }
                window.scrollTo({
                    top: document.body.scrollHeight,
                    behavior: 'smooth'
                });
            } else {
                $(".section-4").addClass("d-none");
            }
        }
    
        function handleButtonClick(category, button) {
            const buttonsInCategory = document.querySelectorAll(`[data-category="${category}"]`);
            buttonsInCategory.forEach(btn => {
                if (btn !== button) {
                    btn.classList.remove('active');
                }
            });
            button.classList.toggle('active');
        }
    
        function handleFormInput(playerValue, amountValue, priceValue, paymentValue, paymentIcon, payment_id, pricepoint_id,
            nickname) {
            if (paymentValue == 'Motion Pay') {
                $(".danger-warn").removeClass("d-none");
            } else {
                $(".danger-warn").addClass("d-none");
            }
    
            $("#val_items_qty").text(amountValue);
            $("#icon-payment").attr('src', paymentIcon).css({
                'background': 'white',
                'border': '2px solid #125096',
            });
            $("#val_player_id").text(playerValue);
            $("#val_price").text(currencyCodes + ' ' + numberWithCommas(priceValue));
            $("#val_total_payment").text(currencyCodes + ' ' + numberWithCommas(priceValue));
            $("#val_payment_pid").text(playerValue);
    
            $('.game').val(getSlugFromUrl());
            $(".player_id").val(playerValue);
            $(".nickname").val(nickname);
            $(".pricepoint_id").val(pricepoint_id);
            $(".payment_id").val(payment_id);
            $(".amount").val(amountValue);
            $(".price").val(priceValue);
    
    
            $(".user_id").val(user_id);
        }
    
        function getSlugFromUrl() {
            const url = window.location.href;
            const parts = url.split('/');
            const slug = parts.pop();
    
            return slug;
        }
    
        function loader() {
            $(".left-number-4").css("background-color", "#007536");
            $('#loading').removeClass('d-none');
            $('#btn-modal-item').addClass('d-none');
            setTimeout(() => {
                $('#btn-modal-item').removeClass('d-none');
                $('#loading').addClass('d-none');
            }, 10000);
    
        }
</script>


<script>
    $(document).ready(function() {
            $(".js-example-tags").select2({
                tags: true
            });
        });
</script>
@endsection
@endsection