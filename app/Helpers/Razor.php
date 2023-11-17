<?php

namespace App\Helpers;

use Exception;
use App\Helpers\Razor;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class Razor
{
    private $_urlFrontend, $_applicationCode, $_version, $_hashType, $_addZero, $_urlPayment, $_urlReturn, $_methodActionPost;

    public function __construct()
    {
        $this->_methodActionPost = 'POST';
        $this->_version = 'v1';
        $this->_hashType = 'hmac-sha256';
        $this->_applicationCode = env("RAZOR_MERCHANT_CODE");
        $this->_urlPayment = env("RAZOR_URL_DEVELPOMENT");
        $this->_urlReturn = route('home');
        $this->_addZero = "00";
        $this->_urlFrontend = env('FE_URL');
    }

    public static function generateDataParse($dataPayment)
    {

        $_methodActionPost = 'POST';
        $_version = 'v1';
        $_hashType = 'hmac-sha256';
        $_applicationCode = env("RAZOR_MERCHANT_CODE");
        $_urlPayment = env("RAZOR_URL_DEVELPOMENT");
        $_urlReturn = env('FE_URL');
        $_addZero = "00";
        $_urlFrontend = env('FE_URL');

        $urlAction = $_urlFrontend . 'payment-vendor/' . strtolower($dataPayment['code_payment']);
        $referenceId = $dataPayment['invoice'];
        $amount = $dataPayment['total_price'];
        $customerId = $dataPayment['user'];
        $currencyCode = $dataPayment['country'];
        $description = $dataPayment['amount'] . ' ' . $dataPayment['name'];
        $dataAttribute = [
            ['methodAction' => $_methodActionPost],
            ['urlAction' => $urlAction],
            ['referenceId' => $referenceId],
            ['amount' => $amount],
            ['currencyCode' => $currencyCode],
            ['description' => $description],
            ['customerId' => $customerId]
        ];

        return $dataAttribute;
    }

    public static function urlRedirect(array $dataParse)
    {

        $_methodActionPost = 'POST';
        $_version = 'v1';
        $_hashType = 'hmac-sha256';
        $_applicationCode = env("RAZOR_MERCHANT_CODE");
        $_urlPayment = env("RAZOR_URL_DEVELPOMENT");
        $_urlReturn = env('FE_URL');
        $_addZero = "00";
        $_urlFrontend = env('FE_URL');

        try {
            $plainText = $dataParse['amount'] . $_addZero
                . $_applicationCode
                . $dataParse['currencyCode']
                . $dataParse['customerId']
                . $dataParse['description']
                . $_hashType
                . $dataParse['referenceId']
                . $_urlReturn . 'payment/confirmation?invoice=' . $dataParse['referenceId']
                . $_version;

            // dd($dataParse);
            $response = Razor::_doRequestToApi($dataParse, $plainText);
            $dataResponse = json_decode($response->getBody()->getContents(), true);



            if (!Razor::checkSignature($dataResponse)) {
                throw new Exception('Invalid Signature', 403);
            }

            if ($dataResponse['paymentUrl']) {
                $api_Key  = env('API_KEY');
                $base_url = env('BASE_URL_API');

                Http::withHeaders([
                    'X-Api-Key' => $api_Key,
                ])->post($base_url . '/api/v1/save-reference?reference=' . $dataResponse['paymentId'] . '&order_id=' . $dataResponse['referenceId']);


                return $dataResponse['paymentUrl'];
            }
        } catch (RequestException $error) {
            $responseError = json_decode($error->getResponse()->getBody()->getContents(), true);
            echo 'Error message ' . $responseError['message'];
        }
    }

    public static function generateSignature(string $plainText = null)
    {
        $signature = hash_hmac('sha256', $plainText, env("RAZOR_SECRET_KEY"));
        return $signature;
    }

    public static function checkSignature($dataResponse)
    {
        $plainText = $dataResponse['amount']
            . $dataResponse['applicationCode']
            . $dataResponse['currencyCode']
            . $dataResponse['hashType']
            . $dataResponse['paymentId']
            . $dataResponse['paymentUrl']
            . $dataResponse['referenceId']
            . $dataResponse['version'];
        $signatureMerchat = Razor::generateSignature($plainText);

        if ($dataResponse['signature'] == $signatureMerchat) return true;

        return false;
    }


    private static function _doRequestToApi(array $dataParse, string $plainText)
    {
        $_methodActionPost = 'POST';
        $_version = 'v1';
        $_hashType = 'hmac-sha256';
        $_applicationCode = env("RAZOR_MERCHANT_CODE");
        $_urlPayment = env("RAZOR_URL_DEVELPOMENT");
        $_urlReturn = env('FE_URL');
        $_addZero = "00";
        $_urlFrontend = env('FE_URL');


        $client = new Client();
        $response = $client->request($_methodActionPost, $_urlPayment, [
            'headers' => ['Content-type' => 'application/x-www-form-urlencoded'],
            'form_params' => [
                "applicationCode" => $_applicationCode,
                "referenceId" => $dataParse['referenceId'],
                "version" => $_version,
                "amount" => $dataParse['amount'] . $_addZero,
                "currencyCode" => $dataParse['currencyCode'],
                "returnUrl" => $_urlReturn . 'payment/confirmation?invoice=' . $dataParse['referenceId'],
                "description" => $dataParse['description'],
                "customerId" => $dataParse['customerId'],
                "hashType" => $_hashType,
                "signature" => Razor::generateSignature($plainText),
            ]
        ]);

        return $response;
    }
}
