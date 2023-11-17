<?php
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


@section('css-utilities')
<style>
    .wider-space .dropdown-item {
        min-width: 350px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 0.5rem 1.5rem;
    }

    .wider-space {
        transform: translateX(-50%);
        left: 50%;
    }

    .bullhorn-size {
        position: absolute;
        top: -8px;
        left: -18px;
        transform: scaleX(-1);
        font-size: 12px;
        border: 1px solid #ffc107;
        border-radius: 50%;
        padding: 4px;
    }

    .dropdown-toggle-notif {
        display: none;
    }

    .nav-item {
        display: flex;
        align-items: center;
    }

    .nav-link {
        margin-right: 10px;
    }

    .nav-text {
        margin-left: 10px;
        color: white;
    }

    .user-dropdown {
        display: flex;
        align-items: center;
    }

    .dropdown-icon {
        margin-left: 5px;
    }
</style>
@endsection

<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img height="75vh" src="{{ asset('assets/img/esi.png') }}" alt="icon-logo">
            </a>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <ul class="navbar-nav text-uppercase">
                    <li class="nav-item d-flex">
                        <a class="nav-link mx-auto me-3 @if (request()->segment(1) == '') active @endif"
                            href="{{ url('/') }}">
                            <h2 class="fw-bold mt-2">GAME SHOP</h2>
                        </a>
                        <a class="nav-link d-flex mx-auto me-3 @if (request()->segment(1) == 'payment') active @endif"
                            href="{{ url('/') }}">
                            <h4 class="my-auto">TOP UP</h4>
                        </a>
                        <a class="nav-link d-flex mx-auto me-3 @if (request()->segment(1) == 'redeem') active @endif"
                            href="{{ url('/redeem/') }}">
                            <h4 class="my-auto">REDEEM</h4>
                        </a>
                    </li>
                    <li class="nav-item d-flex d-none">
                        <a class="nav-link mx-auto"
                            href="{{ url()->current() === url('/') ? '#support' : url('/#support') }}">
                            SUPPORT
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav text-uppercase ms-auto">

                    <li class="nav-item dropdown d-flex d-none">
                        <a class="nav-link dropdown-toggle mx-auto" href="#" id="navbarDarkDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-globe fa-lg" style="color: #ffffff;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li>
                                <a class="dropdown-item active" href="#">
                                    <img class="w-25" src="{{ asset('image/flag/id.png') }}" alt="icon-flag">
                                    ID
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <img class="w-25" src="{{ asset('image/flag/uk.png') }}" alt="icon-flag">
                                    EN
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown d-flex mx-2">
                        <a class="nav-link mx-auto" href="#" id="navbarDarkDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bullhorn fa-lg me-1"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown d-flex mx-2">
                        <a class="nav-link mx-auto" href="#" id="notif-toogle" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bell fa-lg"></i>
                        </a>
                        <ul class="dropdown-menu wider-space w-8" aria-labelledby="navbarDarkDropdownMenuLink"
                            id="notif">
                        </ul>
                    </li>

                    <li class="nav-item dropdown d-flex mx-2">
                        <a class="nav-link" href="#" id="navbarDarkDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-dropdown">
                                <i class="fa-solid fa-user fa-lg" style="color: #ffffff;"></i>
                                <span class="nav-text">
                                    @if ($user)
                                        @if ($user['name'])
                                            <span class="dropdown-toggle">
                                                {{ $user['name'] }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="dropdown-toggle">Guest</span>
                                    @endif
                                </span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDarkDropdownMenuLink"
                            style="width: 16vw">
                            @isset($user)
                                <li class="row my-3" id="user-data">
                                    <div class="col-12 d-flex">
                                        @if ($user['profile'])
                                            <img class="preview w-50 m-auto rounded-circle" src="{{ $user['profile'] }}" alt="icon-user">
                                        @else
                                            <img class="preview w-50 m-auto rounded-circle"
                                                src="{{ asset('assets/img/user.png') }}" alt="icon-user">
                                        @endif
                                    </div>
                                    <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                                        <p class="my-auto mt-2">Hi</p>
                                        @if ($user)
                                            @if ($user['name'])
                                                <p>{{ $user['name'] }}</p>
                                            @endif
                                        @else
                                            <p>Guest</p>
                                        @endif

                                    </div>

                                </li>
                                <hr>
                                <li class="row ms-3 my-3">
                                    <div class="col-2 d-flex">
                                        <i class="fa-solid fa-user m-auto"></i>
                                    </div>
                                    <div class="col d-flex">
                                        <a class="my-auto" href="">Profile</a>
                                    </div>
                                </li>
                                <li id="redeem_histories" class="row ms-3 my-3">
                                    <div class="col-2 d-flex">
                                        <i class="fa-solid fa-rectangle-list m-auto"></i>
                                    </div>
                                    <div class="col d-flex">
                                        <a class="my-auto" href="{{ route('history') }}">History</a>
                                    </div>
                                </li>

                                <li class="row justify-content-center">
                                    <div class="col-10 d-flex">
                                        <a class="my-auto btn btn-danger btn-block w-100" href="">
                                            <i class="fas fa-right-from-bracket"></i>&nbsp;&nbsp;Logout
                                        </a>
                                    </div>
                                </li>
                            @else
                                <li class="row my-3" id="user-data">
                                    <div class="col-12 d-flex">
                                        <img class="w-50 m-auto" src="{{ asset('assets/img/user.png') }}"
                                            alt="icon-user">
                                    </div>
                                    <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                                        <p class="my-auto mt-2">Hi, </p>

                                        @if ($user)
                                            @if ($user['name'])
                                                <p>{{ $user['name'] }}</p>
                                            @endif
                                        @else
                                            <p>Guest</p>
                                        @endif
                                    </div>
                                </li>
                                <hr>
                                <li class="row
                                    justify-content-center">
                                    <div class="col-10 d-flex">
                                        <a class="my-auto btn btn-primary btn-block w-100" href="{{ route('login') }}">
                                            <i class="fas fa-sign-in-alt"></i>&nbsp;&nbsp;Login
                                        </a>
                                    </div>
                                </li>
                                <div id="hide-history">
                                    <li class="row ms-3 my-3">
                                        <div class="col-2 d-flex">
                                            <i class="fa-solid fa-rectangle-list m-auto"></i>
                                        </div>
                                        <div class="col d-flex">
                                            <a class="my-auto" href="{{ route('history') }}">History</a>
                                        </div>
                                    </li>
                                    <li class="row ms-3 my-3">
                                        <div class="col-2 d-flex">
                                            <i class="fa-solid fa-trash-can m-auto"></i>
                                        </div>
                                        <div class="col d-flex">
                                            <a class="my-auto" href="#" onclick="clearData()">Clear Data</a>
                                        </div>
                                    </li>
                                </div>

                            @endisset
                        </ul>
                    </li>
                </ul>
            </div>
            {{-- collapse button --}}
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</header>
