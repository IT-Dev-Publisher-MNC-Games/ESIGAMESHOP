@extends('layout.app')

<?php

$data = null;

if (session('token')) {
    $api_token = session('token');
    $base_url = env('BASE_URL_API');

    $response = Http::withHeaders([
        'authorization' => $api_token,
    ])->get($base_url . '/api/v1/gethistory');

    $res = $response->json();
    if ($response->status() == 200) {
        $data = $res['data'] ?? null;
    }
}
?>


@section('css-utilities')
<style>
     #loginTab {
        background-color: #D5ECFE;
        border: 1px solid #82B7D8;
    }

    #loginTab .nav-item .active {
        background-color: #0D0F3B;
        color: #FFFFFF;
    }

    #loginTab .nav-item a {
        width: 100%;
        height: auto;
        padding: 0.5rem 0;
        color: #125096;
    }

    .media {
        margin-bottom: 10px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 15px;
    }

    .media:last-child {
        border-bottom: none;
        margin-bottom: -35px;
    }

    .media img {
        width: 60px;
        float: left;
        margin-top: -10px;
        margin-right: 5px;
    }

    .media .img-game {
        width: 48px;
        float: left;
        margin-top: 0px;
        margin-right: 6px;
    }

    .media .media-body {
        position: relative;
        overflow: hidden;
    }

    .float-end {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .media-title {
        font-weight: bold;
    }

    .text-small {
        font-size: 14px;
    }

    .text-muted {
        color: #6c757d;
    }

    .link-href {
        color: #6242FC;
        text-decoration: underline;
    }
    .box-item {
        background-color: #D5ECFE;
        pointer-events: none;
    }

    .box-item:hover {
        pointer-events: none;
    }

    .games-cards {
        display: flex;
        flex-direction: column;
        height: 17rem;
        color: #fff;
        overflow: hidden;
        transition: .3s ease-in-out color, .3s linear box-shadow;
    }

    .zebra-color {
        background: #e5e5e7;
    }
</style>
@endsection

@section('content')
   

    <section class="section">
        <div class="section-header justify-content-between">
            <div class="row mt-5">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">History</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="nav nav-tabs rounded-pill d-flex p-1 my-2" id="loginTab" role="tablist">
                <div class="col text-center nav-item">
                    <a href="{{ route('history') }}" type="button" class="rounded-pill active" aria-selected="false">Payment</a>
                </div>
                <div class="col text-center nav-item">
                    <a href="{{ route('redeem.history') }}" class="rounded-pill" type="button"
                        aria-selected="true">Redeem</a>
                </div>
            </div>
            <hr>
            <h2 class="mt-2"><span id="trx-title">Payment</span> History</h2>
            <div class="row">
                <div class="col-2">
                    <h4>
                        <div class="form-group">
                            <select name="status_payment" id="status_payment" class="form-select" required>
                                <option value="all">All Status
                                </option>
                                <option disabled>--------------</option>
                                <option value="1">Success</option>
                                <option value="3">Expired</option>
                                <option value="0">Waiting For Payment</option>
                            </select>
                        </div>
                    </h4>
                </div>

                <div class="col-2">
                    <h4>
                        <div class="form-group">
                            <select name="game_list" id="game_list" class="form-select" required>
                                <option value="all">All Games
                                </option>
                                <option disabled>--------------</option>
                                <option value="Fight Of Legends">Fight Of Legends
                                <option value="KIKO SURVIVOR">Kiko Survivor
                                </option>
                            </select>
                        </div>
                    </h4>
                </div>

                <div class="col-2 d-none">
                    <h4>
                        <div class="form-group">
                            <select name="all_payment" id="category" class="form-select" required>
                                <option value="">Category</option>
                                <option disabled>--------------</option>
                                <option value="1">Transaction</option>
                                <option value="2">Redeem</option>
                            </select>
                        </div>
                    </h4>
                </div>

            </div>
        </div>
        <div class="section-body mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3" id="activity">
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border" id="activity-data">

                            </ul>
                        </div>
                    </div>

                    <div class="card mb-3 bg-warning" id="not-found">
                        <div class="card-body">
                            <div class="float-right pt-1 pb-1 text-center">
                                <div class="row">
                                    <div class="col">
                                    </div>
                                    <div class="col-6 d-flex">
                                        <h2 class="my-auto text-white">Boost your gameplay and get ahead of the competition,
                                            top up diamonds now!</h2>
                                    </div>
                                    <div class="col">
                                        <img class="w-100" src="{{ asset('assets/img/history-not-found.png') }}"
                                            alt="img-character-transaction">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js-utilities')
    <script>
        // Function fillter status

        function filterByStatus(status) {
            let checkHistory = {!! json_encode($data) !!}
            let dt = null;
            if (checkHistory) {
                dt = checkHistory
            } else {
                dt = JSON.parse(localStorage.getItem('myArray')) || [];
            }
            let filteredData = [];

            if (status === 'all') {
                history(dt);
                return;
            }

            dt.forEach(el => {
                if (el.status === status) {
                    filteredData.push(el);
                }
            });

            history(filteredData);
        }

        function filterByGame(game) {
            let checkHistory = {!! json_encode($data) !!}
            let dt = null;
            if (checkHistory) {
                dt = checkHistory
            } else {
                dt = JSON.parse(localStorage.getItem('myArray')) || [];
            }
            let filteredData = [];

            if (game === 'all') {
                history(dt);
                return;
            }

            dt.forEach(el => {
                if (el.game === game) {
                    filteredData.push(el);
                }
            });

            history(filteredData);
        }

        // filter catgeory
        function filterCategory(category) {
            let dt = null;

            if (category == 1) {
                let checkHistory = {!! json_encode($data) !!}

                if (checkHistory) {
                    dt = checkHistory
                } else {
                    $('#trx-title').html('Redeem');
                    dt = JSON.parse(localStorage.getItem('myArray')) || [];
                }

                history(dt);
                return;
            } else {
                $('#trx-title').html('Redeem');
                dt = JSON.parse(localStorage.getItem('data_redeem')) || [];
                redeem(dt);
                return
            }
        }

        function formatDateTime(inputDateTime) {
            const months = [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ];

            const [datePart, timePart] = inputDateTime.split(" ");
            const [day, monthIndex, year] = datePart.split("/");
            const [hour, minute] = timePart.split(":");

            const formattedDate = `${day} ${months[parseInt(monthIndex) - 1]} ${year}`;
            const formattedTime = `${hour}:${minute}`;

            return `${formattedDate}, ${formattedTime}`;
        }

        // Payment status
        document.getElementById('status_payment').addEventListener('change', function() {
            let selectedStatus = this.value;
            filterByStatus(selectedStatus);
        });

        // game list
        document.getElementById('game_list').addEventListener('change', function() {
            let selectedStatus = this.value;
            filterByGame(selectedStatus);
        });

        // category list
        document.getElementById('category').addEventListener('change', function() {
            let selectedStatus = this.value;
            filterCategory(selectedStatus);
        });

        // history
        function history(data) {
            var url = '{!! env('FE_URL') !!}'
            var base_url = "{{ url('/payment/') }}";
            let result = '';
            let notifDiv = document.querySelector('ul#activity-data');
            let status = '';
            let ic_status = '';
            var game_url = 'payment/confirmation?invoice=';

            let notFound = document.getElementById('not-found');

            if (data.length > 0) {
                document.querySelector('#activity').classList.remove('d-none');
                notFound.classList.add('d-none')
            } else {
                document.querySelector('#activity').classList.add('d-none');
                notFound.classList.remove('d-none')
            }

            data.forEach(el => {


                if (el.game == 'KIKO SURVIVOR') {
                    img_src = 'assets/img/battles_ks.png'
                } else {
                    img_src = 'assets/img/fol.png'
                }

                if (el.status == '0') {
                    game_url = url + 'payment/confirmation?invoice=' + el.invoice;
                    status =
                        '<i class="fa-solid fa-circle-exclamation" style="color: #FE8A06"></i>&nbsp;<span style="color:#FD7F2C"><b>Waiting For Payment</b></span>';
                    ic_status = '<i class="fas fa-hourglass-half" style="color: #FE8A06;"></i>';
                    btn_status =
                        `<a type="button" class="btn btn-success btn-pay-now m-auto w-100 py-3" href="${game_url}" style="font-size: 1.35rem;">Pay Now</a>`;
                } else if (el.status == '1') {
                    game_url = el.slug;
                    status =
                        '<i class="fa-solid fa-circle-check" style="color: #007536"></i>&nbsp;<span style="color:#007536"><b>Success</b></span>';
                    ic_status = '<i class="fas fa-sync-alt" style="color: #007536"></i>';
                    btn_status =
                        `<a type="button" class="btn btn-primary btn-buy-again m-auto w-100 py-3" href="${game_url}" style="font-size: 1.35rem;">Buy Again</a>`;
                } else if (el.status == '3') {
                    game_url = el.slug;
                    status =
                        '<i class="fa-solid fa-circle-xmark" style="color: #FF2600"></i>&nbsp;<span style="color:#FF2600"><b>Expired</b></span>';
                    ic_status = '<i class="fas fa-redo-alt" style="color: #FF2600"></i>'
                    btn_status =
                        `<a type="button" class="btn btn-primary btn-buy-again m-auto w-100 py-3" href="${game_url}" style="font-size: 1.35rem;">Buy Again</a>`;
                }

                let notif = `
                    <li class="media">
                        <div class="row">
                            <div class="col col-5">
                                <div class="row">
                                    <div class="col d-flex">
                                        <img class="img-fluid m-auto"
                                            src="{{ url('${img_src}') }}"
                                            alt="img-game">
                                        <img class="img-fluid m-auto"
                                            src="{{ url('assets/img/bill.png') }}"
                                            alt="img-transaction" style="width: 35%">
                                    </div>
                                    <div class="col-8 d-grid">
                                        <div class="my-auto fw-bold">
                                            <a href=""><i class="fa-solid fa-gem"></i> <span
                                                    style="font-size: 20px;">${el.item}</span></a><span class="text-muted text-uppercase"> | ${el.game}</span>
                                        </div>
                                        <div class="my-auto">
                                            <span class="text-muted">${el.invoice}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-7">
                                <div class="row h-100 d-flex justify-content-end">
                                    <div class="col-4 my-auto">
                                        <p class="my-auto text-end">
                                            <a href="">${status}</a>
                                        </p>
                                        <p class="my-auto text-end" style="color: #5138CB">${formatDateTime(el.date)}</p>
                                    </div>
                                    <div class="col-3 d-flex">
                                        ${btn_status}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                `;

                result += notif;
            });

            notifDiv.innerHTML = result;
        }

        // // redeem
        // function redeem(data) {
        //     let result = '';
        //     let status = '';
        //     let url_redeem = 'redeem/kiko-survivor';
        //     let notifDiv = document.querySelector('ul#activity-data');
        //     let notFound = document.getElementById('not-found');


        //     if (data.length > 0) {
        //         document.querySelector('#activity').classList.remove('d-none');
        //         notFound.classList.add('d-none')
        //     } else {
        //         document.querySelector('#activity').classList.add('d-none');
        //         notFound.classList.remove('d-none')
        //     }

        //     data.forEach(el => {
        //         let data = JSON.parse(el);

        //         if (data.http_code === 200) {
        //             status =
        //                 '<i class="fa-solid fa-circle-check" style="color: #007536"></i>&nbsp;<span style="color:#007536"><b>Success</b></span>'
        //         }

        //         img_src = 'assets/website/images/logo/battles_ks.png';
        //         game = 'KIKO SURVIVOR';
        //         btn_redeem_game =
        //             `<a type="button" class="btn btn-primary m-auto w-100 py-3" href="${url_redeem}" style="font-size: 1.2rem;"><small>Redeem More</small></a>`

        //         let notif = `
    //             <li class="media">
    //                 <div class="row">
    //                     <div class="col col-5">
    //                         <div class="row">
    //                             <div class="col d-flex">
    //                                 <img class="img-fluid m-auto"
    //                                     src="{{ url('${img_src}') }}"
    //                                     alt="img-game">
    //                                 <img class="img-fluid m-auto"
    //                                     src="{{ url('assets/website/images/logo/redeem.png') }}"
    //                                     alt="img-transaction" style="width: 35%">
    //                             </div>
    //                             <div class="col-8 d-grid">
    //                                 <div class="my-auto fw-bold">
    //                                     <i class="fas fa-ticket"></i>&nbsp;<span style="font-size: 20px;">${data.value_code}</span><span class="text-muted text-uppercase"> | ${game}</span>
    //                                 </div>
    //                                 <div class="my-auto">
    //                                     <span class="text-muted">${data.value_player_id}</span>
    //                                 </div>
    //                             </div>
    //                         </div>
    //                     </div>
    //                     <div class="col col-7">
    //                         <div class="row h-100 d-flex justify-content-end">
    //                             <div class="col-4 my-auto">
    //                                 <p class="my-auto text-end">
    //                                     <a href="">${status}</a>
    //                                 </p>
    //                                 <p class="my-auto text-end" style="color: #5138CB">
    //                                     ${data.formattedDate}
    //                                 </p>
    //                             </div>
    //                             <div class="col-3 d-flex">
    //                                 ${btn_redeem_game}
    //                             </div>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </li>
    //         `;

        //         result += notif;
        //     });

        //     notifDiv.innerHTML = result;
        // }

        window.onload = function() {

            let checkHistory = {!! json_encode($data) !!}
            let dt = null;
            if (checkHistory) {
                dt = checkHistory
            } else {
                dt = JSON.parse(localStorage.getItem('myArray')) || [];
            }
            history(dt)
            notif(dt)


        };
    </script>
@endsection
