<?php

namespace App\Services;
use App\Models\OrdersPayments;
class PaypalService
{
    private $inTestMode;

    public function __construct( OrdersPayments $ordersPaymentsRepository )
    {
        $this->ordersPayments = $ordersPaymentsRepository;
    }

    private static $environmentsUrls = [
        'test' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
        'production' => 'https://www.paypal.com/cgi-bin/webscr',
    ];
    private static $checkoutUrls = [
        'test' => 'https://api-3t.sandbox.paypal.com/nvp',
        'production' => 'https://api-3t.paypal.com/nvp',
    ];

    private function getApiUrl()
    {
        $this->inTestMode = false;
        if (urlencode(env('PAYPAL_TEST')) == "1") $this->inTestMode = true;

        return $this->inTestMode ? self::$checkoutUrls['test'] : self::$checkoutUrls['production'];
    }

    private function getPaypalUrl()
    {
        $this->inTestMode = false;
        if (urlencode(env('PAYPAL_TEST')) == "1") $this->inTestMode = true;

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
                . '&RETURNURL=' . urlencode(route('payments.paypal_ok'))
                . '&CANCELURL=' . urlencode(route('payments.paypal_ko'))
                . '&PAYMENTREQUEST_0_NOTIFYURL=' . urlencode(route('payment.paypal'));

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

    public function validateIpn($data)
    {
        $this->guardReponseIsValid($data);

        $payPalUrl = $this->getPaypalUrl();
        $payPalRequestBody = $this->generatePayPalVerifyBodyFromRequest($data);
        $response = $this->doPost($payPalUrl, $payPalRequestBody, true);

        $paymentStatus = $data['payment_status'];
        $adId = $data['custom'];
        $txn_id = $data['txn_id'];

        if ($this->payPalResponseIsValid($response)) {

            /*if ($paymentStatus != 'Completed' || !$adId) {
                throw new Exception('Payment status unfinished');
            }*/
            // @todo, update add to paid using the $adId         
            return ['id' => $adId, 'status' => $paymentStatus, 'txn_id' => $txn_id];
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

    public function makeSimpleForm($data){

        //Creamos el registro del pago en BBDD
        $orderPayment = [
            'order_id'          => $data['order_id'],
            'payment_id'        => "2",
            'operation_code'    => date('ymdHis')
        ];

        $orderPayments = $this->ordersPayments;
        $orderPayments->create($orderPayment);

        $html = "<form name='paypal_form' action='".$this->getPaypalUrl()."' method='POST' id='paypal_form'>
        <input type='hidden' name='cmd' value='_xclick'>
        <input type='hidden' name='bn'          value='".env('PAYPAL_BUSINESS_NAME')."' />
        <input type='hidden' name='business' value='".env('PAYPAL_USER')."'>
        <input type='hidden' name='image_url'   value='".env('PAYPAL_LOGO')."'/>
        <input type='hidden' name='item_name' value='Pedido ".$data['ref']."'>
        <input type='hidden' name='custom' value='".$orderPayment['operation_code']."'>
        <input type='hidden' name='currency_code' value='EUR'>
        <input type='hidden' name='amount' value='".$data['total']."'>
        <input type='hidden' name='return'               value='".route('payments.paypal.ok')."' />
        <input type='hidden' name='cancel_return'        value='".route('payments.paypal.ko')."' />
        <input type='hidden' name='notify_url'           value='".route('payments.paypal.response')."'>
        </form>
        <script>document.paypal_form.submit()</script>";
        return $html;
    }

    public function makeForm($config, $order, $cart){

        /*
        $config = [
            "name" => "Emporda Estil",
            "logo" => "http://www.empordaestil.com/front/img/logo2.png"
        ];

        $order = [
            "ref"       => "referencia pedido",
            "name"      => "Nombre del usuario",
            "surnames"  => "Apellidos usuario",
            "address"   => "Dirección del usuario",
            "city"      => "Ciudad del usuario",
            "cp"        => "codigo postal",
            "shippings" => "0",
            "discount"  => "descuento aplicado en euros",
        ];

        $cart = [
            [
                "name"  => "Producto 1",
                'ref'   => "ref111",
                'pvp'   => "12.50",
                'qty'   => "1"
            ],
            [
                "name"  => "Producto 2",
                'ref'   => "ref222",
                'pvp'   => "12.52",
                'qty'   => "2"
            ]
        ];
        */

        $html = "<form name='paypal_form' action='".$this->getPaypalUrl()."' method='POST' id='paypal_form'>
        <input type='hidden' name='business'    value='info-facilitator@atmospheresp.com' />
        <input type='hidden' name='cmd'         value='_cart' />
        <input type='hidden' name='upload'      value='1'>
        <input type='hidden' name='bn'          value='".$config['name']."' />
        <input type='hidden' name='image_url'   value='".$config['logo']."'/>";

        $i = 1;
        foreach ($cart as $item) {
            $html = $html."
            <input type='hidden' name='item_name_".$i."'    value='".$item['name']."' />
            <input type='hidden' name='item_number_".$i."'  value='".$item['ref']."' />
            <input type='hidden' name='amount_".$i."'       value='".$item['pvp']."' />
            <input type='hidden' name='quantity_".$i."'     value='".$item['qty']."' />";
            $i++;
        }

        $html = $html."
        <input type='hidden' name='page_style'           value='primary' />
        <input type='hidden' name='return'               value='".urlencode(route('payments.paypal.ok'))."' />
        <input type='hidden' name='cancel_return'        value='".urlencode(route('payments.paypal.ko'))."' />
        <input type='hidden' name='notify_url'           value='".urlencode(route('payments.paypal.response'))."'>
        <input type='hidden' name='currency_code'        value='EUR' />
        <input type='hidden' name='cn'                   value='PP-BuyNowBF' />
        <input type='hidden' name='custom'               value='".$order['ref']."' />
        <input type='hidden' name='first_name'           value='".$order['name']."' />
        <input type='hidden' name='last_name'            value='".$order['surnames']."' />
        <input type='hidden' name='address1'             value='".$order['address']."' />
        <input type='hidden' name='city'                 value='".$order['city']."' />
        <input type='hidden' name='zip'                  value='".$order['cp']."' />
        <input type='hidden' name='lc'                   value='es' />
        <input type='hidden' name='country'              value='ES' />
        <input type='hidden' name='rm'                   value='2'>
        <input type='hidden' name='shipping'             value='".$order['shippings']."'>
        <input type='hidden' name='cbt'                  value='Clique aquí para finalizar su compra'>
        <input type='hidden' name='discount_amount_cart' value='".$order['discount']."' />
        </form>
        <script>document.paypal_form.submit()</script>
        ";

        return $html;
    }

}
