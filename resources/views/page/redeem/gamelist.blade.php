@extends('layout.app')

@section('css-utilities')
<style>
    /* ribbon */
    .ribbon {
        position: absolute;
        width: 160px;
        height: auto;
        bottom: 0;
        padding: 0.25rem;
        text-align: center;
        font-weight: 600;
        border-radius: 0 10px 0 0;
        background-color: #FFC107;
        color: #0D0F3B;
    }

    .ribbon2 {
        position: absolute;
        width: 140px;
        height: auto;
        left: 0;
        bottom: 0;
        padding: 0.1rem;
        text-align: center;
        font-weight: 600;
        border-radius: 0 10px 0 0;
        background-color: #0D0F3B;
        color: #FFC107;
    }
</style>
@endsection

@section('content')


    <section class="section-games container-fluid my-5">
        <div class="row">
            <div class="container">
                {{-- <div class="label-section">TOP UP GAMES</div> --}}
                @isset($games)
                    @if (empty($games))
                        <div class="col d-flex justify-content-center align-items-center">
                            Games are not available.
                        </div>
                    @else
                        <div class="row gy-4 gy-md-5 py-3 py-lg-3">
                            <div class="col col-12 my-2">
                                <div class="label-section">REEDEM GAMES</div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="row row-cols-3">
                                    @foreach ($games as $game)
                                        <div class="col">
                                            <a href="{{ route('redeem.games', $game['slug_game']) }}">
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
