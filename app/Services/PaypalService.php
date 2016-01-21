<?php

namespace Potoroze\Services;

class PaypalService
{

    private static $environmentsUrls = [
        'test' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
        'production' => 'https://www.paypal.com/cgi-bin/webscr',
    ];
    private static $checkoutUrls = [
        'test' => 'https://api-3t.sandbox.paypal.com/nvp',
        'production' => 'https://api-3t.paypal.com/nvp',
    ];
    private $inTestMode = true;

    private function getApiUrl()
    {
        return $this->inTestMode ? self::$checkoutUrls['test'] : self::$checkoutUrls['production'];
    }

    private function getPaypalUrl()
    {
        return $this->inTestMode ? self::$environmentsUrls['test'] : self::$environmentsUrls['production'];
    }

    public function makeExpressCheckout( $desc, $operation_code )
    {

        $url = $this->getApiUrl();

        $nvp = 'USER=' . urlencode(env('PAYPAL_USER'))
                . '&PWD=' . urlencode(env('PAYPAL_PWD'))
                . '&SIGNATURE=' . urlencode(env('PAYPAL_SIGNATURE'))
                . '&METHOD=SetExpressCheckout'
                . '&VERSION=93'
                . '&PAYMENTREQUEST_0_PAYMENTACTION=Sale'
                . '&PAYMENTREQUEST_0_AMT=' . urlencode('2.50')
                . '&PAYMENTREQUEST_0_CUSTOM=' . urlencode($operation_code)
                . '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode('EUR')
                . '&NOSHIPPING=1'
                . '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode('2.50')
                . '&L_PAYMENTREQUEST_0_AMT0=' . urlencode('2.50')
                . '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($desc)
                . '&L_PAYMENTREQUEST_0_QTY0=1'
                . '&PAYMENTREQUEST_0_DESC=' . urlencode($desc)
                . '&RETURNURL=' . urlencode(route('my_account.ads.payment_ok'))
                . '&CANCELURL=' . urlencode(route('my_account.ads.payment_ko'))
                . '&PAYMENTREQUEST_0_NOTIFYURL=' . urlencode(route('payment.ads.paypal'));

        $resArray = $this->doPost($url, $nvp);

        if (empty($resArray['ACK']) || !in_array($resArray['ACK'], ['Success', 'SuccessWithWarning'])) {
            return false;
        }

        //var_dump($resArray);

        $urlApi = $this->getPaypalUrl();
        return $urlApi . '?cmd=_express-checkout&token=' . $resArray['TOKEN'];

        //echo ' Url checkout ' . $urlApi . '?cmd=_express-checkout&token=' . $resArray['TOKEN'];
        //die();
    }

    public function getExpressCheckoutDetails( $token )
    {
        $url = $this->getApiUrl();
        $nvp = 'USER=' . urlencode(env('PAYPAL_USER'))
                . '&PWD=' . urlencode(env('PAYPAL_PWD'))
                . '&SIGNATURE=' . urlencode(env('PAYPAL_SIGNATURE'))
                . '&METHOD=GetExpressCheckoutDetails'
                . '&VERSION=93'
                . '&TOKEN=' . $token;

        return $this->doPost($url, $nvp);
    }

    public function confirmExpressCheckout( $token, $payerId, $paymentAction, $amount, $currency )
    {
        $url = $this->getApiUrl();
        $nvp = 'USER=' . urlencode(env('PAYPAL_USER'))
                . '&PWD=' . urlencode(env('PAYPAL_PWD'))
                . '&SIGNATURE=' . urlencode(env('PAYPAL_SIGNATURE'))
                . '&METHOD=DoExpressCheckoutPayment'
                . '&VERSION=93'
                . '&TOKEN=' . $token
                . '&PAYERID=' . $payerId
                . '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode($paymentAction)
                . '&PAYMENTREQUEST_0_AMT=' . urlencode($amount)
                . '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($currency)
                . '&PAYMENTREQUEST_0_TAXAMT=0';

        return $this->doPost($url, $nvp);
    }

    public function validateIpn( $data )
    {
        $this->guardReponseIsValid($data);

        $payPalUrl = $this->getPaypalUrl();
        $payPalRequestBody = $this->generatePayPalVerifyBodyFromRequest($data);
        $response = $this->doPost($payPalUrl, $payPalRequestBody, true);

        $paymentStatus = $data['payment_status'];
        $adId = $data['custom'];

        if ($this->payPalResponseIsValid($response)) {

            if ($paymentStatus != 'Completed' || !$adId) {
                throw new Exception('Payment status unfinished');
            }
            // @todo, update add to paid using the $adId         
            return ['id' => $adId, 'status' => $paymentStatus];
        }
        throw new Exception('Invalid paypal response');
    }

    private function doPost( $url, $nvp, $returnStr = false )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvp);

        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        curl_close($ch);

        $resArray = [];
        parse_str(urldecode($response), $resArray);
        if ($returnStr) {
            return $response;
        }
        return $resArray;
    }

    private function guardReponseIsValid( $data )
    {
        if (empty($data['custom'])) {
            throw new Exception('Invalid paypal request');
        }
    }

    private function payPalResponseIsValid( $response )
    {
        return strcmp($response, 'VERIFIED') == 0;
    }

    private function generatePayPalVerifyBodyFromRequest( $request )
    {
        $generatedRequest = 'cmd=_notify-validate';

        foreach ($request as $key => $value) {
            $generatedRequest .= sprintf('&%s=%s', $key, urlencode(stripslashes($value)));
        }

        return $generatedRequest;
    }

}
