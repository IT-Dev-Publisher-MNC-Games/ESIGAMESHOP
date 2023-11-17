@extends('layout.app')

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
        $user = $result['data'];
    }
} ?>

@section('content')
    <section class="section-games container-fluid my-5">
        <div class="row">
            <div class="container">
                @isset($games)
                    @if (empty($games))
                        <div class="col d-flex justify-content-center align-items-center">
                            Games are not available.
                        </div>
                    @else
                        <div class="row gy-4 gy-md-5 py-3 py-lg-3">
                            <div class="col col-12 my-2">
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </symbol>
                                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                    </symbol>
                                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </symbol>
                                </svg>
                            
                                @if (!$user)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                            <use xlink:href="#info-fill" />
                                        </svg>
                                        <strong>Take the next step!</strong> Register and Log in Now to Unlock Exclusive Benefits...
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @else
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                                            <use xlink:href="#check-circle-fill" />
                                        </svg>
                                        <strong>Hi, {{ $user['name'] }}. &nbsp; </strong> Thanks for signing up. Discover exclusive deals, and Happy
                                        shopping at ESI Game Shop
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div class="col col-12 my-2">
                                <div class="label-section">TOP UP GAMES</div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="row row-cols-3">
                                    @foreach ($games as $game)
                                        <div class="col">
                                            <a href="{{ route('payment.games', $game['slug_game']) }}">
                                                <div class="games-card h-100">
                                                    <div class="games-card__footer p-1">
                                                        <div class="games-card__footer-text">
                                                            <small>{{ $game['game_title'] }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="games-card__body position-relative">
                                                        <img src="{{ $game['cover'] }}" alt="{{ $game['game_title'] }}" class="img-fluid">
                                                        <span class="ribbon2">{{ $game['category'] }}</span>
                                                    </div>
                                                    <div class="games-card__footer bg-light p-0">
                                                        <div class="text-dark" style="font-size: 0.8rem">
                                                            <i class="fa-solid fa-cart-shopping fa-xs"></i> Sold 10.5K +
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div id="carouselExampleIndicators" class="carousel slide h-100" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                                            aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                            aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                            aria-label="Slide 3"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                                            aria-label="Slide 4"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4"
                                            aria-label="Slide 5"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <a href="https://bit.ly/DiscordFOL" target="_blank">
                                                <img src="{{ asset('assets/img/banner/socmed_1.png') }}" class="d-block w-100" alt="img-slider-home"
                                                    style="border-radius: 20px;">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://bit.ly/Youtube_FOL" target="_blank">
                                                <img src="{{ asset('assets/img/banner/socmed_2.png') }}" class="d-block w-100" alt="img-slider-home"
                                                    style="border-radius: 20px;">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://bit.ly/FOLWebFB" target="_blank">
                                                <img src="{{ asset('assets/img/banner/socmed_3.png') }}" class="d-block w-100" alt="img-slider-home"
                                                    style="border-radius: 20px;">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://bit.ly/FOLWebIG" target="_blank">
                                                <img src="{{ asset('assets/img/banner/socmed_4.png') }}" class="d-block w-100" alt="img-slider-home"
                                                    style="border-radius: 20px;">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://bit.ly/FOLWebTiktok" target="_blank">
                                                <img src="{{ asset('assets/img/banner/socmed_5.png') }}" class="d-block w-100" alt="img-slider-home"
                                                    style="border-radius: 20px;">
                                            </a>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12">
                                <img class="w-100" src="{{ asset('assets/img/icon_separator.png') }}" alt="icon-separator">
                                <div class="label-section">FEATURED GAMES</div>
                            </div>
                            <div class="col col-12 col-md-12">
                                <div class="container section-download position-relative d-flex p-0">
                                    <div class="row py-1 m-auto">
                                        <div class="col col-12 col-md-12 d-flex justify-content-center my-2">
                                            <img class="icon_fol_2" src="{{ asset('assets/img/fol_2.png') }}" alt="icon-logo"
                                                style="margin-left: -3vw">
                                        </div>
                                        <div class="col col-12 col-md-12 d-flex justify-content-center my-2">
                                            <h2 class="section-heading text-uppercase features-title text-white">Play For Free</h2>
                                        </div>
                                        <div class="col col-12 col-md-6 d-flex justify-content-center justify-content-md-end my-2">
                                            <a href="">
                                                <img src="{{ asset('assets/img/download_appstore.png') }}" alt="icon-download">
                                            </a>
                                        </div>
                                        <div class="col col-12 col-md-6 d-flex justify-content-center justify-content-md-start my-2">
                                            <a href="">
                                                <img src="{{ asset('assets/img/download_playstore.png') }}" alt="icon-download">
                                            </a>
                                        </div>
                                    </div>
                                    <span class="ribbon">5 V 5</span>
                                </div>
                                <div class="container section-socmed py-1">
                                    <div class="row py-2">
                                        <div class="socmed d-flex justify-content-between w-50 mx-auto p-2">
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebDiscord" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-discord"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebYoutubeNew" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-youtube"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebFB" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-facebook-f"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebIG" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-instagram"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebTiktok" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-tiktok"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="container section-download position-relative d-flex p-0">
                                    <div class="row py-1 m-auto">
                                        <div class="col col-12 col-md-12 d-flex justify-content-center my-2">
                                            <img class="icon_fol_2 w-50" src="{{ asset('assets/img/fol_2.png') }}"
                                                alt="icon-logo">
                                        </div>
                                        <div class="col col-12 col-md-12 d-flex justify-content-center my-2">
                                            <h2 class="section-heading text-uppercase features-title text-white">Play For Free</h2>
                                        </div>
                                        <div class="col col-12 col-md-6 d-flex justify-content-center justify-content-md-end my-2">
                                            <a href="">
                                                <img src="{{ asset('assets/img/download_appstore.png') }}" alt="icon-download">
                                            </a>
                                        </div>
                                        <div class="col col-12 col-md-6 d-flex justify-content-center justify-content-md-start my-2">
                                            <a href="">
                                                <img src="{{ asset('assets/img/download_playstore.png') }}" alt="icon-download">
                                            </a>
                                        </div>
                                    </div>
                                    <span class="ribbon">5 V 5</span>
                                </div>
                                <div class="container section-socmed py-1">
                                    <div class="row py-2">
                                        <div class="socmed d-flex justify-content-between w-75 mx-auto p-2">
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebDiscord" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-discord"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebYoutubeNew" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-youtube"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebFB" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-facebook-f"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebIG" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-instagram"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebTiktok" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-tiktok"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="container section-download position-relative d-flex p-0">
                                    <div class="row py-1 m-auto">
                                        <div class="col col-12 col-md-12 d-flex justify-content-center my-2">
                                            <img class="icon_fol_2 w-50" src="{{ asset('assets/img/fol_2.png') }}"
                                                alt="icon-logo">
                                        </div>
                                        <div class="col col-12 col-md-12 d-flex justify-content-center my-2">
                                            <h2 class="section-heading text-uppercase features-title text-white">Play For Free</h2>
                                        </div>
                                        <div class="col col-12 col-md-6 d-flex justify-content-center justify-content-md-end my-2">
                                            <a href="">
                                                <img src="{{ asset('assets/img/download_appstore.png') }}" alt="icon-download">
                                            </a>
                                        </div>
                                        <div class="col col-12 col-md-6 d-flex justify-content-center justify-content-md-start my-2">
                                            <a href="">
                                                <img src="{{ asset('assets/img/download_playstore.png') }}" alt="icon-download">
                                            </a>
                                        </div>
                                    </div>
                                    <span class="ribbon">5 V 5</span>
                                </div>
                                <div class="container section-socmed py-1">
                                    <div class="row py-2">
                                        <div class="socmed d-flex justify-content-between w-75 mx-auto p-2">
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebDiscord" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-discord"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebYoutubeNew" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-youtube"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebFB" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-facebook-f"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebIG" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-instagram"></i>
                                                </div>
                                            </a>
                                            <a class="btn-socmed" href="https://bit.ly/FOLWebTiktok" target="_blank">
                                                <div class="socmed-item">
                                                    <i class="socmed-icon fa-brands fa-tiktok"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12">
                                <div class="ticket bg-danger text-center">
                                    <div class="wraps">
                                        <h4 class="mx-auto text-center w-25" style="color: #743F2F">CAN'T FIND WHAT
                                            YOU'RE LOOKING FOR?</h4>
                                        <a class="text-decoration-none" href="">
                                            <div class="btn btn-warning">SUBMIT A TICKET</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                    @endif
                @endisset
            </div>
        </div>
    </section>
   
    <section class="section-support container-fluid py-3 d-none">
        @include('template.section-support')
    </section>
@endsection

@section('js-utilities')
    <script>
        window.onload = function() {

            let dt = JSON.parse(localStorage.getItem('myArray')) || [];
            notif(dt)

        };
    </script>
@endsection
