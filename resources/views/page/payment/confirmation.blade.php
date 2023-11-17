@extends('layout.app')
@section('css-utilities')
<style>
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
<section class="container-fluid container-lg py-3">
    <div class="row justify-content-center pt-3">
        <div class="col-12 col-md-10">
            <div class="row p-2">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('/payment/' . $slug_game) }}">Top up</a></li>
                            <li class="breadcrumb-item">Invoice</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="alert alert-warning alert-dismissible fade show text-center" id="id_alert" role="alert"
                style="display: none;">
                <i class="fa-solid fa-stopwatch bi flex-shrink-0 me-1" id="i_alert" width="24" height="24"></i>
                <strong id="pre_title_warning"></strong> <span id="inside_title_warning"></span> <span
                    id="timer_expired"></span>
            </div>


            @if ($data['payment']['transaction_status'] == 1)
            <div class="row">
                <div class="col col-12 col-md-12">
                    <div class="alert alert-success text-center" role="alert">
                        <h3>Congrats!</h3>
                        <p>Your payments successfully, please check to Game Mailbox</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="box-invoice bg-light" id="invoice-to-export">
                @if ($data)
                <div class="box-invoice__header">
                    <div class="row">
                        <div class="col-lg-2 d-flex">
                            <a href="{{ url('/payment/' . $slug_game) }}" class="btn btn-primary my-auto">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </div>
                        <div class="col-lg-8 d-flex text-center">
                            <h4 class="m-auto btn-copy-in"><span class="no-in" id="invoice-no">{{
                                    $data['payment']['invoice'] }} <i class="far fa-copy fa-sm"></i></span></b>
                                <br>
                                <small><span class="text-center" id="time_created" style="font-size: 16px;">{{ date('d M
                                        Y, H:s', strtotime($data['payment']['created_at'])) . ' (GMT+7)'
                                        }}</span></small>
                            </h4>
                        </div>
                        <div class="col-lg-2">
                            @if ($data['invoice']['transaction_status'] == 1)
                            <a href="{{ route('export.data', 'invoice=' . $data['payment']['invoice']) }}"
                                class="btn btn-primary float-end" target="_blank" id="export-pdf-button"><i
                                    class="fa-solid fa-1x fa-file-pdf"></i></a>
                            @endif
                        </div>
                    </div>
                </div>

                <form id="formInvoice">
                    @csrf
                    <div class="box-invoice__body">
                        <div class="row row-cols-1 row-cols-sm-2 py-1">
                            <div class="col-6 games-cards">
                                <div class="games-card__footer p-1">
                                    <div class="games-card__footer-text">
                                        <small>{{ $data['invoice']['gamelist']['game_title'] }}</small>
                                    </div>
                                </div>
                                <div class="games-card__body position-relative">
                                    <img src="{{ url($data['payment']['game_thumbnail']) }}" alt="img-cover-game"
                                        class="img-fluid">
                                    <span class="ribbon2"></span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row row-payment justify-content-between zebra-color">
                                    <div class="col d-flex">
                                        <p class="my-auto">Via</p>
                                    </div>
                                    <div class="col text-end">
                                        <img class="w-20 rounded" src="{{ $data['payment']['logo'] }}"
                                            alt="logo_payment" style="background: white; border: 2px solid #125096;">
                                    </div>
                                </div>
                                <div class="row row-player justify-content-between mt-2">
                                    <div class="col d-flex">
                                        <p class="my-auto">Player ID</p>
                                    </div>
                                    <div class="col text-end">
                                        <small>{{ $data['payment']['user'] }}</small>
                                    </div>
                                </div>
                                <div class="row row-username justify-content-between mt-2 zebra-color">
                                    <div class="col d-flex">
                                        <p class="my-auto">Username</p>
                                    </div>
                                    <div class="col text-end">
                                        <small>{{ $data['invoice']['transaction_detail']['player_name'] }}</small>
                                    </div>
                                </div>
                                <div class="row row-email justify-content-between mt-2">
                                    <div class="col d-flex">
                                        <p class="my-auto">Email</p>
                                    </div>
                                    <div class="col text-end">
                                        <small style="text-transform: lowercase;">{{ $hide_email }}</small>
                                    </div>
                                </div>
                                <div class="row row-phone justify-content-between mt-2 zebra-color">
                                    <div class="col d-flex">
                                        <p class="my-auto">Phone</p>
                                    </div>
                                    <div class="col text-end">
                                        <small>{{ $hide_phone }}</small>
                                    </div>
                                </div>
                                <div class="row row-item justify-content-between mt-2">
                                    <div class="col d-flex">
                                        <p class="my-auto">Product</p>
                                    </div>
                                    <div class="btn col-2 box-item text-center mt-2 me-2">
                                        <div class="col">
                                            <img src="{{ $data['payment']['logo_ppi'] }}" alt="img-item-game">
                                        </div>
                                        <div class="box-item__amount">
                                            <strong>{{ $data['payment']['amount'] }}
                                                {{ $data['payment']['name'] }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-3 border border-bottom border-dark"></div>

                        <div class="row row-cols-1 row-cols-sm-2 py-1">
                            <div class="col-6">
                                <h4>Total Payment </h4>
                            </div>
                            <div class="col-6 text-end">
                                <h4><strong>{{ $data['payment']['country'] }}
                                        {{ number_format($data['invoice']['total_price'], 0, ',', '.') }}</strong>
                                </h4>
                            </div>
                        </div>
                        <small class="text-danger font-small" id="text-small-warning"></small>
                        @if ($data['invoice']['transaction_status'] == 0)
                        <div id="elementAttribute" data-element-input="{{ $data['attribute'] }}"></div>
                        @endif
                    </div>
                    <div class="box-invoice__footer row d-flex justify-content-center" id="box-invoice-pay-now">

                        <div class="d-grid gap-2 col-3 mx-auto p-3">
                            <button type="submit" class="btn text-white rounded py-4" id="btnPay"
                                style="display: none; background: #5138CB; font-size: 22px;">
                                <i class="fas fa-money-bill-wave-alt"></i>
                                &nbsp;&nbsp;Pay Now</button>

                            <a type="button" href="{{ url('/payment/' . $slug_game) }}"
                                class="btn text-white rounded py-4" id="btnPayback"
                                style="display: none; background: #5138CB; font-size: 22px;">
                                <i class="fas fa-redo-alt"></i>
                                &nbsp;&nbsp;Redo</a>

                            <small class="text-center" id="payment_date" style="display: none;"><strong>{{ date('d M Y
                                    H:s', strtotime($data['invoice']['paid_time'])) . ' (GMT+7)' }}</strong></small>
                            <a type="button" href="{{ url('/payment/' . $slug_game) }}"
                                class="btn text-white btn-success rounded py-4" id="btnSuccessPayment"
                                style="font-size: 19px; display: none;">
                                <i class="fas fa-check-circle"></i>
                                &nbsp;&nbsp;Payment Success</a>

                            <div id="loading" class="btn rounded py-4 overlay text-white d-none"
                                style="background: #5138CB;">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>

                    </div>
                </form>
                @else
                Data is not avaliable
                @endif
            </div>
            <div class="text-center d-none" id="text-redirect">
                <p>You Will be redirected to merchant....</p>
            </div>

        </div>
    </div>
</section>
@endsection

@section('js-utilities')
<script>
    var leftTime = '{!! $left_Time !!}'
        var trxStats = '{!! $trx_status !!}'
        var interval;
        var initialTime = parseInt(leftTime, 10);
        var url = '{!! env('BASE_URL_API') !!}'
        var apiKey = '{!! env('BACKEND_API_KEY') !!}'

        // Mengambil elemen dengan ID "invoice-no"
        var invoice = '{!! $data['invoice']['invoice'] !!}'
        var game = '{!! $data['invoice']['gamelist']['game_title'] !!}'
        var dateTransaction = '{!! $data['invoice']['created_at'] !!}'
        var status = '{!! $data['invoice']['transaction_status'] !!}'
        var item = '{!! $data['invoice']['transaction_detail']['amount'] !!} {!! $data['invoice']['pricepoints']['name'] !!}'
        var slug = '{!! url('/payment/' . $slug_game) !!}'

        function formatTime(seconds) {
            var hours = Math.floor(seconds / 3600);
            var minutes = Math.floor((seconds % 3600) / 60);
            var remainingSeconds = seconds % 60;
            var displayHours = (hours < 10) ? '0' + hours : hours;
            var displayMinutes = (minutes < 10) ? '0' + minutes : minutes;
            var displaySeconds = (remainingSeconds < 10) ? '0' + remainingSeconds : remainingSeconds;

            return displayHours + ':' + displayMinutes + ':' + displaySeconds;
        }


        function getDataByInvoice(invoice) {
            console.log(apiKey)
            // Panggil fetch untuk melakukan GET request ke API
            fetch(`${url}/api/v1/expired?invoice=${invoice}`, {
                    method: 'GET',
                    headers: {
                        'X-Api-Key': apiKey,
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Lakukan apa pun dengan data yang diterima dari API
                    console.log('Data dari API:', data);
                    // Panggil fungsi atau lakukan tindakan lain dengan data tersebut
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                    // Handle kesalahan jika terjadi
                });
        }

        function countdown() {

            clearInterval(interval);
            interval = setInterval(function() {
                initialTime--;



                if (initialTime <= 0) {
                    var alertElement = document.getElementById('id_alert');
                    var iElement = document.getElementById('i_alert');

                    alertElement.style.display = "block";
                    alertElement.classList.remove('alert-warning');
                    alertElement.classList.add('alert-danger');

                    iElement.classList.remove('fa-solid', 'fa-stopwatch');
                    iElement.classList.add('fas', 'fa-exclamation-circle');
                    document.getElementById('pre_title_warning').innerHTML = "Invoice Expired!";
                    document.getElementById('inside_title_warning').innerHTML =
                        "Please Redo Your Transaction";
                    $('#timer_expired').html(`<span class="p-1"></span>`);

                    clearInterval(interval);
                    document.getElementById('btnPay').style.display = "none";
                    document.getElementById('btnPayback').style.display = "block";
                    getDataByInvoice(invoice);

                } else if (trxStats == 1) {
                    document.getElementById('btnPay').style.display = "none";
                    document.getElementById('btnPayback').style.display = "block";
                } else {
                    if (trxStats == 0) {
                        document.getElementById('btnPay').style.display = "block";
                        document.getElementById('btnSuccessPayment').style.display = "block";
                        document.getElementById('payment_date').style.display = "block";
                        document.getElementById('id_alert').style.display = "block";
                        document.getElementById('pre_title_warning').innerHTML = "Waiting For Payment!";
                        document.getElementById('inside_title_warning').innerHTML =
                            "Please Make Your Payment Before";
                    }
                    document.getElementById('btnSuccessPayment').style.display = "none";
                    document.getElementById('payment_date').style.display = "none";
                    $('#timer_expired').html(`<span class="p-1" style="border: 1px solid red; border-radius:8px; font-size: 17px;">${formatTime(
                                            initialTime)}</span>`).css('color', 'red');
                }
            }, 1000);
        }


        $(document).ready(function() {
            countdown();
            addDataToLocalStorage(game, invoice, dateTransaction, status, slug)
        });

        $(document).ready(function() {
            $('.btn-copy-in').click(function() {
                var textToCopy = $('.no-in').text();
                var tempElement = $('<textarea>');
                $('body').append(tempElement);
                tempElement.val(textToCopy).select();
                document.execCommand('copy');
                tempElement.remove();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Invoice No. Copied',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });

        $(document).ready(function() {
            $('#btnPay').click(function() {
                $('#btnPay').addClass('d-none');
                $('#loading').removeClass('d-none');
                $('#text-redirect').removeClass('d-none');
            })
        });


        function formatDate(inputDateTime) {
            const dateObj = new Date(inputDateTime);

            // Set zona waktu ke GMT+7 (420 menit adalah offset untuk GMT+7)
            // dateObj.setMinutes(dateObj.getMinutes() + 420);

            const day = String(dateObj.getDate()).padStart(2, '0');
            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
            const year = String(dateObj.getFullYear());
            const hours = String(dateObj.getHours()).padStart(2, '0');
            const minutes = String(dateObj.getMinutes()).padStart(2, '0');

            return `${day}/${month}/${year} ${hours}:${minutes}`;
        }

        function addDataToLocalStorage(game, invoice, date, status, slug) {
            var existingData = JSON.parse(localStorage.getItem('myArray')) || [];
            var isInvoiceExists = false;

            // Cari data dengan nomor invoice yang sama
            for (var i = 0; i < existingData.length; i++) {
                if (existingData[i].invoice === invoice) {
                    existingData[i].status = status; // Perbarui status jika ditemukan
                    isInvoiceExists = true;
                    break;
                }
            }

            if (!isInvoiceExists) {
                existingData.unshift({
                    game: game,
                    invoice: invoice,
                    date: formatDate(date),
                    status: status,
                    item: item,
                    slug: slug,
                });

                if (existingData.length > 5) {
                    existingData.pop();
                }
            }

            localStorage.setItem('myArray', JSON.stringify(existingData));
        }

        window.onload = function() {

            let dt = JSON.parse(localStorage.getItem('myArray')) || [];
            notif(dt)

        };
</script>

<script>
    $(document).ready(function () {
    const payment = $("#elementAttribute").data("element-input");
    const divParseElement = document.createElement('div');
    divParseElement.style.display = 'none';
    divParseElement.setAttribute('id', 'parseElement');
    document.getElementById('formInvoice').append(divParseElement);

    if (!payment.hasOwnProperty('dataParse')) {
        for (const key in payment) {
        if (Object.hasOwnProperty.call(payment, key)) {
            const element = payment[key];
            if (element.methodAction) {
            $("#formInvoice").attr({ 'method': element[Object.keys(element)] });
            continue;
            }
            if (element.urlAction) {
            $("#formInvoice").attr({ 'action': element[Object.keys(element)] });
            continue;
            }
            createElementInput({
            name: Object.keys(element),
            value: element[Object.keys(element)],
            idForm: divParseElement.getAttribute('id')
            });
        }
        }
    }
    });

    const createElementInput = ({ name, value, idForm }) => {
        const elmentInput = document.createElement('input');
        elmentInput.setAttribute('name', name);
        elmentInput.hidden = true;
        elmentInput.value = value || 'no value';
        document.getElementById(idForm || 'formInvoice').append(elmentInput);
        return;
    }
</script>
@endsection