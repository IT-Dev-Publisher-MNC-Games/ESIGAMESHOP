@extends('layout.app')

@section('css-utilities')
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
</style>
@endsection

@section('content')
    

    <div class="container">
        <div class="row my-4 justify-content-center">
            <div class="games-info__body col col-12 col-lg-6 order-last order-lg-first my-2">
                <div class="col">
                    <img src="{{ $dataGame['banner'] }}" class="img-fluid" alt="icon-game" style="width:600px; height:247px;">
                </div>
                <div class="col mt-4">
                    <h2 class="games-info__title">{{ $dataGame['title'] }}</h2>
                    <p class="mt-3 fs-6" style="text-align: justify;"><small>{{ $dataGame['about'] }}</small></p>
                </div>
                <div class="col mt-4">
                    <h2 class="games-info__title-rating">About Code Redemption</h2>
                    <p class="fs-6 my-1" style="text-align: justify;">
                        1. <small><strong>Prepare:</strong> Fill out your <span class="text-danger">{{ $dataGame['title'] }}
                                Player Info</span> to avoid code issues.</small>
                    </p>
                    <p class="fs-6 my-1" style="text-align: justify;">
                        2. <small><strong>Claim Rewards:</strong> Redeemed items sent
                            <span class="text-danger">via in-game mailbox around 3 mins</span>. Log in to <span
                                style="color: #007536;">Claim</span>.</small>
                    </p>
                    <p class="fs-6 my-1" style="text-align: justify;">
                        3. <small><strong>Validity Matters:</strong> Watch conditions and code <span
                                class="text-danger">validity</span>. Expired codes <span class="text-danger">can't</span> be
                            redeemed.</small>
                    </p>
                    <p class="fs-6 my-1" style="text-align: justify;">
                        4. <small><strong>One-Time Use:</strong> Each code is <span class="text-danger">one-shot</span>.
                            Players can't reuse same code type.</small>
                    </p>
                    <p class="fs-6 my-1" style="text-align: justify;">
                        5. <small><strong>Think Before Redeem:</strong> Used code <span class="text-danger">can't</span> be
                            undone. <span class="text-danger">Double-check</span> before redeeming.</small>
                    </p>
                    <p class="fs-6 my-1" style="text-align: justify;">
                        6. <small><strong>Need Help? Contact Us:</strong> For redemption
                            issues, contact our <span style="color: #007536;">Support</span>.</small>
                    </p>

                    <div class="mt-5"></div>
                    <p class="review-1">Don't have the game yet? Download {{ Str::title($dataGame['title']) }} today!</p>
                    <div class="download-now">
                        <div class="row">
                            <div class="col d-flex">
                                <a href="">
                                    <img src="{{ asset('assets/img/download_playstore.png') }}" width="200"
                                        alt="icon-download">
                                </a>
                            </div>
                            <div class="col d-flex">
                                <a href="">
                                    <img src="{{ asset('assets/img/download_appstore.png') }}" width="200"
                                        alt="icon-download">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-12 col-lg-6 order-first order-lg-last my-2">
                @include('page.redeem._redeem-column')
            </div>
        </div>
    </div>
@endsection
