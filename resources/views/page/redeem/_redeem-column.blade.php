{{-- style --}}

@section('css-utilities')
<style>
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

    .dashed-line-gray {
        margin: 3% 0 3%;
        border-top: 2px dashed grey;
        width: 100%;
    }

    .link-href {
        color: #6242FC;
        text-decoration: underline;
    }

    #submitButton.active {
        background: #5138CB;
        color: white;
    }

    #submitButton.inactive {
        background: #A9A9A9;
    }

    .swal2-confirm {
        background-color: #5138CB;
        order: 0;
    }

    .swal2-cancel {
        background-color: #d33;
        order: 1;
    }

    /* Mengatur tata letak tombol */
    .swal2-actions {
        display: flex;
        flex-direction: row-reverse;
    }

    .icon-exit {
        height: 30px;
        width: auto;
        background-color: transparent;
    }
</style>
@endsection


{{-- redeem column --}}
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
                        <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                            <i class="fa-solid fa-circle-question fa-lg"></i>
                        </button>
                    </div>
                    <div class="card-body" style="background-color: #ECEFF6">
                        <div class="row row-cols-lg">
                            <div class="card-text">
                                <small>Player ID <span class="text-danger">*</span></small>
                            </div>
                            <div class="input-form__country input-group mt-1">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control auto-uppercase" name="player_id"
                                    id="player_id" placeholder="KS1000000001" required>
                                <div id="loading-check" class="btn text-white rounded px-4 d-none"
                                    style="background: #5138CB">
                                    <i class="fas fa-1x fa-sync-alt fa-spin"></i>
                                </div>
                                <button class="btn text-white" type="button" id="confirmButton"
                                    style="background: #5138CB" onclick="checkPlayer()">Check</button>
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
                                <input type="text" class="form-control" name="val_nickname" id="val_nickname"
                                    disabled>
                                <input type="text" class="form-control" name="val_uid_player" id="val_uid_player"
                                    disabled hidden>
                                <i class="fas fa-check-circle check-circle"></i>
                            </div>
                        </div>
                        <div class="input-country d-flex justify-content-end text-danger"
                            style="font-size: .8rem; margin-top: 5px;">
                            *required field
                        </div>
                    </div>
                </div>
            </div>
        </li>

        {{-- processing --}}
        <div class="overlay text-center mt-4 d-none">
            <i class="fas fa-3x fa-sync-alt fa-spin" style="color: #125096"></i>
            <p>Processing...</p>
        </div>
        <li class="d-flex section-2 p-0 mb-4 d-none">
            <div class="left-side">
                <div class="left-number left-number-2">2</div>
            </div>
            <div class="right-side">
                <div class="card">
                    <div class="card-header fs-5 text-white" style="background-color: #8495BD">
                        Enter Your Code
                    </div>
                    <div class="card-body" style="background-color: #ECEFF6" id="detailsRedeem">
                        <form action="{{ route('redeem.games.redeemed') }}" method="post" id="redeemForm">
                            @csrf
                            <div class="row">
                                <small class="text-muted">Got your Redemption Code? Don't wait
                                    any longer – Redeem it Now!</small>

                                <input type="hidden" name="player_id" class="val_player_id">
                                <input type="hidden" name="uid" class="val_uid">
                                <input type="hidden" name="game_id" class="val_game_id">

                                <div class="card-text mt-2">
                                    <small>Redemption Code <span class="text-danger">*</span></small>
                                </div>
                                <div class="input-group my-1">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-ticket"></i>
                                    </span>
                                    <input type="text" name="val_redeem_code" id="val_redeem_code"
                                        class="form-control auto-uppercase" placeholder="Enter Code Here"
                                        aria-label="val_redeem_code" pattern="[A-Za-z0-9]+" required>
                                </div>
                                <div class="col-12">
                                    <div class="form-check mt-1">
                                        <span><small> &nbsp;</small></span>
                                        <span>
                                            <div class="input-country d-flex text-danger justify-content-end"
                                                style="font-size: .8rem; margin-top: -25px;">
                                                *required field
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="g-recaptcha d-flex justify-content-center mt-2"
                                    data-callback="reCaptchaCallback"
                                    data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                            </div>
                            <div class="dashed-line-gray"></div>
                            <div class="row">
                                <h6 class="card-title mb-2"><strong>Terms &amp; Conditions:</strong></h6>
                                <div class="col">
                                    <p class="p-font-small">By clicking “Redeem”,<br>(i) &nbsp;I acknowledge that I
                                        have
                                        read and agree to
                                        ESI Gameshop <a class="link-href" href="https://policy.mncgames.com/"
                                            target="_blank">Terms &amp;
                                            Conditions</a> and <a class="link-href"
                                            href="https://policy.mncgames.com/" target="_blank">Privacy Policy</a>
                                        <br>(ii) I understand and agree that all sales are final and non-refundable
                                    </p>
                                </div>
                            </div>
                            <div class="row rounded">
                                <div class="col col-12 d-flex justify-content-center my-auto">
                                    <div class="d-grid gap-2 col-6">
                                        <div id="loading" class="btn text-white rounded py-3 mb-2 d-none"
                                            style="background: #5138CB;">
                                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                        </div>
                                        <button type="submit" class="btn text-white rounded py-3 mb-2 inactive"
                                            onclick="loader()" id="submitButton" disabled>
                                            <i class="fa-solid fa-repeat"></i>&nbsp;&nbsp;Redeem
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>

<!-- Modal Detail-->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"
        style="background: grey;
    position: absolute;
  float: left;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);">
        <img src="{{ $dataGame['tooltips'] }}" alt="">
    </div>
</div>

{{-- modal sponsor --}}
<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button> --}}

<!-- Modal -->
<div class="modal fade" id="ModalPopUp" tabindex="-1" aria-labelledby="ModalPopUpLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: #fff; border:3px solid #9C143E; border-radius: 20px;">
            <div class="modal-header border-0">
                <h5 class="modal-title text-center w-100" style="margin-left: 25px;">Rewards
                </h5>
                <a type="button" data-bs-dismiss="modal" aria-label="Close">
                    <img class="icon-exit" src="{{ url('/image/icon_exit.png') }}" alt="icon-exit">
                </a>
            </div>
            <div class="modal-body">
                <iframe style="width: 100%; height: 900px;" class="new_frame" id="new_frame"></iframe>
            </div>
        </div>
    </div>
</div>

@section('js-utilities')
    <!-- Script -->

    <script>
        $(document).ready(function() {
            const prefix_web = getSlugFromUrl();
            const url_web = prefix_web === 'kiko-survivor' ? 'https://www-dev.mncgames.com/kikosurvivor/r/' : '';
        });
    </script>

    <script>
        document.getElementById('redeemForm').addEventListener('submit', function(event) {
            event.preventDefault();
            $(".left-number-2").css("background-color", "#007536");


            const value_player_id = $("#player_id").val();
            const value_nickname = $("#val_nickname").val();
            const value_code = $("#val_redeem_code").val();
            const http_code = 200;
            const now = new Date();
            const day = now.getDate();
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            const month = monthNames[now.getMonth()];
            const year = now.getFullYear();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const formattedDate = `${day} ${month} ${year}, ${hours}:${minutes}`;

            fetch(this.getAttribute('action'), {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Request failed');
                    }
                })
                .then(data => {
                    if (data.message == '200') { // success redeem
                        var gurl = data.game_id === '3' ? 'https://www-dev.mncgames.com/kikosurvivor/r/' : ''
                        var urelst = gurl + data.url;
                        $("#new_frame").attr("src", urelst);
                        const globalData = JSON.stringify({
                            value_player_id,
                            value_code,
                            http_code,
                            formattedDate
                        });
                        redeemLocalStorage(globalData);
                        $('#ModalPopUp').modal('show');
                        $('#ModalPopUp').on('hidden.bs.modal', function() {
                            location.reload();
                        });
                    } else if (data.message == '401') { // player blocked
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            html: '<p style="font-size: 14px;">Sorry, your Player ID has been blocked!</p>',
                            showConfirmButton: false,
                            timer: 1900
                        });
                    } else if (data.message == '424') { // already claim
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            html: '<p style="font-size: 14px;">Sorry, your Player ID already claimed!</p>',
                            showConfirmButton: false,
                            timer: 1900
                        });
                    } else if (data.message == '412') { // out of stock
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            html: '<p style="font-size: 14px;">Sorry, but the stock for redeeming this code has been run out!</p>',
                            showConfirmButton: false,
                            timer: 1900
                        });
                    } else if (data.message == '498') { // code expired
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            html: '<p style="font-size: 14px;">Sorry, this redemption code has already expired!</p>',
                            showConfirmButton: false,
                            timer: 1900
                        });
                    } else if (data.message == '425') { // redeem only in period
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            html: '<p style="font-size: 14px;">Sorry, This redemption can only be claimed during specific periods!</p>',
                            showConfirmButton: false,
                            timer: 1900
                        });
                    } else { // code not found
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            html: '<p style="font-size: 14px;">Sorry, The redemption code was not found!</p>',
                            showConfirmButton: false,
                            timer: 1900
                        });
                    }
                })
                .catch(data => {
                    console.log('error' + data);
                })
        });
    </script>

    <script>
        function redeemLocalStorage(data) {
            // Mendapatkan data dari localStorage (jika ada)
            const existingDataJSON = localStorage.getItem('data_redeem');
            let existingData = [];

            if (existingDataJSON) {
                existingData = JSON.parse(existingDataJSON);
            }

            existingData.push(data);

            // Menghapus data terlama jika sudah lebih dari 5 data
            if (existingData.length > 5) {
                existingData.shift(); // Menghapus data terlama (indeks pertama)
            }

            // Menyimpan data terbaru ke localStorage
            localStorage.setItem('data_redeem', JSON.stringify(existingData));
        }
    </script>

    <script>
        const inputs = document.querySelectorAll('input'); // untuk set button redeem active dan disabled
        const submitButton = document.getElementById('submitButton');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const allInputsFilled = Array.from(inputs).every(input => input.value.trim() !== '');
                submitButton.disabled = !allInputsFilled;

                if (allInputsFilled) {
                    submitButton.classList.remove('inactive');
                    submitButton.classList.add('active');
                } else {
                    submitButton.classList.remove('active');
                    submitButton.classList.add('inactive');
                }
            });
        });

        const inputElements = document.querySelectorAll('.auto-uppercase'); // untuk set uppercase tiap inputan
        inputElements.forEach(inputElement => {
            inputElement.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });

        function reCaptchaCallback() { // untuk captcha
            $('#btn-modal-item').removeAttr('disabled');
        }

        function numberWithCommas(number) { // fungsi untuk memberikan koma per currency
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function showOverlay() { // fungsi untuk open loading
            $(".overlay").removeClass("d-none");
            $(".section-2").addClass("d-none");
        }

        function closeOverlay() { // fungsi untuk close loading
            $(".overlay").addClass("d-none");
            $(".section-2").removeClass("d-none");
        }

        function checkPlayer() { // fungsi checking player
            const players_id = document.querySelector('input[name="player_id"]');
            const val_pid = players_id.value;
            var url = window.location.href;
            var segments = url.split('/');
            var gameId = segments[4];
            var urls = window.location.origin + '/payment/' + gameId + '/check/' + val_pid;
            var parameter = {
                game_id: gameId,
                player_id: val_pid,
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
                        window.scrollTo({
                            top: document.body.scrollHeight,
                            behavior: 'smooth'
                        });
                        $(".form-load-nickname").removeClass("d-none");
                        $("#val_nickname").val(response.nickname);
                        $("#val_uid_player").val(response.uid);
                        const val_uid = $("#val_uid_player").val();
                        handleFormInput(val_pid, val_uid);
                        $(".section-2").removeClass("d-none");
                        $(".left-number-1").css("background-color", "#007536");

                    }
                },
                error: function(xhr, status, error) {
                    // console.log('Error sending PPID to the route:', error);
                }
            });
        }

        function handleFormInput(playerValue, uidValue) { // form handle input buat redeem
            $(".val_player_id").val(playerValue);
            $(".val_uid").val(uidValue);
            $(".val_game_id").val(getSlugFromUrl());
        }

        function getSlugFromUrl() { // form handle slug
            const url = window.location.href;
            const parts = url.split('/');
            const slug = parts.pop();

            return slug;
        }

        function loader() { // loader button
            $('#loading').removeClass('d-none');
            $('#submitButton').addClass('d-none');
            setTimeout(() => {
                $('#submitButton').removeClass('d-none');
                $('#loading').addClass('d-none');
            }, 10000);

        }
    </script>
@endsection
