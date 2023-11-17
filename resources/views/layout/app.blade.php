

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="esipayment">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ESI GAMESHOP</title>

    <style>
        .footer {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f0f0f0;
            padding: 10px;
            text-align: center;
        }

        .cookie-popup {
            /* display: none; */
            background-color: white;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .cookie-popup p {
            margin: 0;
        }

        .cookie-popup button {
            margin-top: 10px;
        }

        .link-href {
            color: #6242FC;
            text-decoration: underline;
        }
    </style>

    {{-- bootstrap 5.2.3 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    {{-- fontawesome 6.4.0 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- sweetalert 10.10.1 --}}
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    {{-- Additional Google reCaptcha --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link rel="stylesheet" href="{{ url('assets/style/style.css') }}" />


    @yield('css-utilities')


</head>



<body>
    @include('template.loader-page')
    @include('template.header')
    <main class="container position-relative px-5">
        @yield('content')


        <div class="footer" id="cookiePopup">
            <div class="cookie-popup">
                <p>This website uses cookies to ensure you get the best experience. By continuing to use our website.
                    you agree to our <a href="#" class="link-href">Privacy Policy</a></p>
                <button id="withoutCookies" class="btn btn-outline-primary">Continue Without Cookies</button>
                <button id="acceptCookies" class="btn btn-primary">Accept Cookies</button>
            </div>
        </div>


    </main>
    @include('template.footer')
  
    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
  ></script>
    {{-- jQuery 3.6.0 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- sweetalert 10.10.1 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

    {{-- html2pdf --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function notif(data) {
            var url = '{!! env('FE_URL') !!}'
            let result = '';
            let notifDiv = document.querySelector('ul#notif');
            let status = '';

            let notifToogle = document.getElementById('notif-toogle');
            let navHistory = document.getElementById('hide-history');

            if (data.length > 0) {
                navHistory.classList.remove('d-none')
                notifToogle.classList.add('dropdown-toggle');
                notifDiv.classList.remove('d-none')
            } else {
                if (navHistory) {
                    navHistory.classList.add('d-none') 
                }
                notifToogle.classList.remove('dropdown-toggle')
                notifDiv.classList.add('d-none')
            }

            data.forEach(el => {

                if (el.status == '0') {
                    status =
                        '<i class="fa-solid fa-circle-exclamation fa-2xl m-auto" style="color: #FE8A06"></i>'
                } else if (el.status == '1') {
                    status = '<i class="fa-solid fa-circle-check fa-2xl m-auto" style="color: #007536"></i>'
                } else {
                    status = '<i class="fa-solid fa-circle-xmark fa-2xl m-auto" style="color: #FF2600"></i>'
                }

                let notif = `
                <a href="${url}payment/confirmation?invoice=${el.invoice}" class="dropdown-item border border-1">    
                    <div class="row">
                        <div class="col-2 d-flex">
                            ${status}
                        </div>
                        <div class="col-8 d-grid">
                            <p class="my-auto fw-bold">${el.item}</p>
                            <p class="my-auto fw-bold"><small>${el.invoice}</small></p>
                            <p class="my-auto ms-auto"><small>${el.date}</small></p>
                        </div>
                        <div class="col-2 d-flex">
                            <img src="{{ url('assets/website/images/logo/fol.png') }}" class="img-fluid m-auto"
                                alt="icon-game">
                        </div>
                    </div>
                </a>
                `;

                result += notif;
            });

            notifDiv.innerHTML = result;
        }



        function clearData() {
            localStorage.clear();
            window.location.reload();
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cookiePopup = document.getElementById("cookiePopup");
            const acceptCookiesButton = document.getElementById("acceptCookies");

            // Check if cookies have been accepted before
            const cookiesAccepted = localStorage.getItem("cookiesAccepted");

            if (!cookiesAccepted) {
                setTimeout(() => {
                    cookiePopup.style.display = "block";
                }, 1500);
            }

            acceptCookiesButton.addEventListener("click", function() {
                localStorage.setItem("cookiesAccepted", "true");
                cookiePopup.style.display = "none";
            });
        });
    </script>
     @yield('js-utilities') 
</body>

</html>
