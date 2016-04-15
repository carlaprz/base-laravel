<?php

namespace App\Services;

use App\Libraries\ApiRedsys;
use App\Models\OrdersPayments;

/* Configurar en ENV:
  TPV_FUC
  TPV_TERMINAL
  TPV_MONEDA
  TPV_TYPE_TRANSACTION
  TPV_TEST
 */

class TpvService
{

    private $inTestMode;

    public function __construct( ApiRedsys $redsys, OrdersPayments $ordersPaymentsRepository )
    {
        $this->redsys = $redsys;
        $this->ordersPayments = $ordersPaymentsRepository;

        $this->inTestMode = false;
        if (urlencode(env('TPV_TEST')) == "1")
            $this->inTestMode = true;
    }

    private static $environmentsUrls = [
        'test' => 'https://sis-t.redsys.es:25443/sis/realizarPago',
        'production' => 'https://sis.redsys.es/sis/realizarPago',
    ];

    private function getTpvlUrl()
    {
        return $this->inTestMode ? self::$environmentsUrls['test'] : self::$environmentsUrls['production'];
    }

    private function prepareForm( $order_data )
    {
        //Recogemos el valor total y el identificador del pedido
        $order_id = $order_data['order_id']; //para guardar el identificador de pago, ya que no es este, si no uno que se genera
        $order_total = number_format($order_data['order_total'], 2, '.', '') * 100;

        //Introducimos los valores de la transacción
        $fuc = urlencode(env('TPV_FUC'));        //FUC: Código identificador de banco
        $terminal = urlencode(env('TPV_TERMINAL'));   //Terminal: Por defecto 1, va ligada a la clave SHA256.
        $moneda = urlencode(env('TPV_MONEDA'));     //Código de moneda: El código de € es 978
        $trans = urlencode(env('TPV_TYPE_TRANSACTION')); //En la mayoría de TPVs es 0
        $paymentId = date('ymdHis'); //<-- Lo guardamos en BBDD como identificador de pago, relacionaremos la respuesta del TPV mediante este campo
        $amount = $order_total;

        //Creamos el registro del pago en BBDD
        $orderPayment = [
            'order_id' => $order_id,
            'payment_id' => "1",
            'operation_code' => $paymentId
        ];

        $orderPayments = $this->ordersPayments;
        $orderPayments->create($orderPayment);

        // Se rellenan los campos necesarios para la petición
        $this->redsys->setParameter("DS_MERCHANT_AMOUNT", $amount);
        $this->redsys->setParameter("DS_MERCHANT_ORDER", strval($paymentId));
        $this->redsys->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
        $this->redsys->setParameter("DS_MERCHANT_CURRENCY", $moneda);
        $this->redsys->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
        $this->redsys->setParameter("DS_MERCHANT_TERMINAL", $terminal);
        $this->redsys->setParameter("DS_MERCHANT_MERCHANTURL", urlencode(route('payments.tpv.response')));
        $this->redsys->setParameter("DS_MERCHANT_URLOK", urlencode(route('payments.tpv.ok')));
        $this->redsys->setParameter("DS_MERCHANT_URLKO", urlencode(route('payments.tpv.ko')));

        // Datos de configuración
        $sig_ver = "HMAC_SHA256_V1";
        $key_sha256 = urlencode(env('TPV_SHA256'));

        // Se generan los parámetros de la petición
        $params = $this->redsys->createMerchantParameters();
        $signature = $this->redsys->createMerchantSignature($key_sha256);

        // Preparamos los datos para pasarselos a la vista
        $data['DS_SIGNATUREVERSION'] = $sig_ver;
        $data['DS_MERCHANTPARAMETERS'] = $params;
        $data['DS_SIGNATURE'] = $signature;
        $data['ACTION'] = $this->getTpvlUrl();

        return $data;
    }

    public function makeForm( $order_data )
    {
        $data = $this->prepareForm($order_data);

        $action = $data['ACTION'];
        $signatureVersion = $data['DS_SIGNATUREVERSION'];
        $parameters = $data['DS_MERCHANTPARAMETERS'];
        $signature = $data['DS_SIGNATURE'];

        $html = "<form id='tpvform' action='$action' method='post' target='_self'>
                <input type='hidden' name='Ds_SignatureVersion' value='$signatureVersion'>
                <input type='hidden' name='Ds_MerchantParameters' value='$parameters'>
                <input type='hidden' name='Ds_Signature' value='$signature'>
            </form>";

        return $html;
    }

    public function decryptResponse( $response )
    {

        $data = [];

        if (!empty($response)) {

            //Recogemos las variables de respuesta
            $params = $response['Ds_MerchantParameters'];
            $firma_recibida = $response['Ds_Signature'];

            //Desciframos la información recibida
            $key_sha256 = urlencode(env('TPV_SHA256'));
            $datos = $this->redsys->decodeMerchantParameters($params);
            $firma_calculada = $this->redsys->createMerchantSignatureNotif($key_sha256, $params);

            $data['order'] = $this->redsys->getParameter("Ds_Order");
            $data['response'] = $this->redsys->getParameter("Ds_Response");
            $data['auth_code'] = $this->redsys->getParameter("Ds_AuthorisationCode");

            //Validamos las dos firmas, si coinciden hacemos las tareas en el servidor
            $firma_recibida === $firma_calculada ? $validation = true : $validation = false;

            $data['validation'] = $validation;
        }

        return $data;
    }

}
