'use strict';
// const baseUrl = window.location.origin;
// const apiToken = import.meta.env.VITE_API_KEY;
// const dataGame = document.getElementsByClassName('games-info__body')[0].dataset.game;
// const { id_game } = JSON.parse(dataGame);
// console.log(JSON.parse(dataGame));

const convertCurrencyByCountry = (code, price) => {
  switch (code) {
    case 'ID':
      return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR"
      }).format(price).replace('Rp', 'IDR ').replace(',00', '');
    case 'SG':
      return new Intl.NumberFormat("sg-SG", {
        style: "currency",
        currency: "SG"
      }).format(number);
    case 'TH':
      return new Intl.NumberFormat("th-TH", {
        style: "currency",
        currency: "THB"
      }).format(number).replace('฿', '฿ ');
    default:
      break;
  }
}

$("#btnClearId").hide();

$("#btnCheckId").click(async function (event) {
  if (!$("#idPlayer").val()) {
    $(".input-feedback.input-id-player").addClass('invalid');
    $(".input-feedback.input-id-player").text('ID Player is required');
    return;
  }

  getDataUser(baseUrl);
  $(this).hide();
  $("#btnClearId").show();
});

$("#btnClearId").click(function () {
  $(this).hide();
  $("#btnCheckId").show();
  $("#idPlayer").prop('disabled', false);
  $("#idPlayer").val('');
  $(".input-feedback.input-id-player").removeClass('valid invalid');
  $(".input-feedback.input-id-player").text('');
  $("#formCheckout").children('.info-user').remove();
});


const getDataUser = async (baseUrl = null) => {
  try {
    const urlPlayer = new URL(`${baseUrl}/api/v1/player`);
    urlPlayer.searchParams.set('player_id', $("#idPlayer").val());

    await fetch(urlPlayer, {
      credentials: "include",
      headers: {
        'X-Api-Key': apiToken
      }
    })
      .then((response) => {
        if (!response.ok) return Promise.reject(response);
        return response.json();
      })
      .then((data) => {
        console.log(data);
      })
      .catch((errorResponse) => {
        $(this).hide();
        errorResponse.json().then((error) => {
          console.error(error);
        });
      });
    return;
  } catch (error) {
    console.log(error);
  }
}

const getCountryByIp = async () => {
  const urlApiIpCountry = 'http://ip-api.com/json';
  let countryCode;
  try {
    await fetch(urlApiIpCountry).then((response) => {
      if (!response.ok) return Promise.reject(response);

      return response.json();
    })
      .then((data) => {
        countryCode = data.countryCode;
      })
      .catch((errorResponse) => {
        errorResponse.json().then((error) => {
          console.error(error);
        });
      });
    return countryCode;
  } catch (error) {
    console.log(error);
  }
}

const getCountries = async () => {
  const url = new URL(`${baseUrl}/api/v1/country`);
  let listCountry;

  await fetch(url, {
    credentials: "include",
    headers: {
      'X-Api-Key': apiToken
    }
  }).then((response) => {
    if (!response.ok) return Promise.reject(response);

    return response.json();
  })
    .then((data) => {
      listCountry = data.data;
    })
    .catch((errorResponse) => {
      errorResponse.json().then((error) => {
        console.error(error);
      });
    });

  return listCountry;
}

const getPricePoint = async ({ country_id = null }, idGame = null) => {
  let listPricePoint;
  const urlPayment = new URL(`${baseUrl}/api/v1/pricepoint`);
  urlPayment.searchParams.set('country_id', country_id);
  urlPayment.searchParams.set('game_id', idGame);
  await fetch(urlPayment, {
    credentials: "include",
    headers: {
      'X-Api-Key': apiToken
    }
  }).then((response) => {
    if (!response.ok) return Promise.reject(response);
    return response.json();
  })
    .then((data) => {
      listPricePoint = data.data;
    })
    .catch((errorResponse) => {
      errorResponse.json().then((error) => {
        console.error(error);
      });
    });
  return listPricePoint;
}

async function getDataPayment() {
  const codeCountry = await getCountryByIp();
  const listCountry = await getCountries();
  const country = listCountry.find(country => country.country_code == codeCountry);
  const pricePoint = await getPricePoint(country, id_game);
  let payments;

  $('#countrySelect').find('option[value="' + country.country_id + '"]').attr('selected', 'selected');

  if ($('#countrySelect').find(":selected").val()) {
    const urlPayment = new URL(`${baseUrl}/api/v1/payment`);
    urlPayment.searchParams.set('country', country.country_id);
    urlPayment.searchParams.set('game_id', id_game);

    await fetch(urlPayment, {
      credentials: "include",
      headers: {
        'X-Api-Key': apiToken
      }
    }).then((response) => {
      if (!response.ok) return Promise.reject(response);

      return response.json();
    })
      .then((data) => {
        payments = data.data;
      })
      .catch((errorResponse) => {
        errorResponse.json().then((error) => {
          console.error(error);
        });
      });

  }
  // console.log(payments);
  return { payments, pricePoint, currency: listCountry[0].code_currency, countryCode: listCountry[0].country_code };
}

async function generatePayment() {
  // Mengambil data pembayaran melalui fungsi getDataPayment()
  const { payments, pricePoint, countryCode } = await getDataPayment();

  // Melakukan mapping terhadap array payments
  payments.map(payment => {
    const listChannel = payment.payment;
    const { category } = payment;
    const nameIdElement = payment.category.replace(/[^a-zA-Z]/g, '').toLowerCase();
    renderCategoryPayment(category, nameIdElement, listChannel);
  });

  // Mengosongkan konten dari elemen dengan kelas "item-price__wrapper"
  $(".item-price__wrapper").text('');

  // Melakukan mapping terhadap array pricePoint
  pricePoint.map(({ price, amount, name_currency, img }) => {
    // Membuat elemen HTML menggunakan template literal
    const html = `
    <div class="col-2 box-item-old m-3 text-center">
      <div class="col">
        <img src="/image/items/${img}" alt="item-game">
      </div>
      <div class="box-item__amountOld">${amount} ${name_currency}</div>
      <div class="box-item__priceOld">${convertCurrencyByCountry(countryCode, price)}</div>
    </div>
    `;
    $(".item-price__wrapperOld").append(html);
  });
  activatePaymentClass();
}
// generatePayment();

function activatePaymentClass() {
  const paymentItems = document.querySelectorAll('.box-item');

  paymentItems.forEach(item => {
    item.addEventListener('click', () => {
      paymentItems.forEach(item => {
        item.classList.remove('active');
      });
      item.classList.add('active');
      const amount = item.querySelector('.box-item__amount').textContent;
      const price = item.querySelector('.box-item__price').textContent;
      console.log(`Amount: ${amount}, Price: ${price}`);
    });
  });
}

function renderCategoryPayment(nameCategory, nameIdElement, listChannel) {
  $("#accordionPaymentItemsStayOpen").prepend(`
    <div class="accordion-item">
      <h2 class="accordion-header" id="payment${nameIdElement}StayOpen-headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#payment${nameIdElement}StayOpen-collapseOne" aria-expanded="true" aria-controls="payment${nameIdElement}StayOpen-collapseOne">
      ${nameCategory}
      </button>
      </h2>
      <div id="payment${nameIdElement}StayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="payment${nameIdElement}StayOpen-headingOne">
        <div class="accordion-body text-start">
        <div class="row row-cols-4 g-3"></div>
        </div>
      </div>
    </div>
  `
  );

  if (listChannel.length) {
    listChannel.map(({ payment_name, category, logo }) => {
      if (category == nameCategory) $(`#payment${nameIdElement}StayOpen-collapseOne .accordion-body .row`).append(`
        <div class="col">
          <div class="channel-payment border rounded p-1 d-flex justify-content-center align-items-center ">
            <img class="img-fluid" src="/image/${logo}" alt="${payment_name}">
          </div>
        </div>
      `)
    });
  }

  $(".channel-payment").click(function () {

    $(".channel-payment").removeClass("active");
    $(this).addClass("active");
  })
}






