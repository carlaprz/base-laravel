<?php

namespace App\Services;
use App\Libraries\ApiRedsys;

/*Configurar en ENV:
TPV_FUC
TPV_TERMINAL
TPV_MONEDA
TPV_TYPE_TRANSACTION
 
*/
class TpvService {
    private $inTestMode = true;

    private static $environmentsUrls = [
        'test'       => 'https://sis-t.redsys.es:25443/sis/realizarPago',
        'production' => 'https://sis.redsys.es/sis/realizarPago',
    ];

    private function getTpvlUrl()
    {
        return $this->inTestMode ? self::$environmentsUrls['test'] : self::$environmentsUrls['production'];
    }

    public function prepareForm(ApiRedsys $redsys){
        //Recogemos el valor total y el identificador del pedido
        $order_id       = Session::get('order.order_id'); //para guardar el identificador de pago, ya que no es este, si no uno que se genera
        $order_total    = number_format(Session::get('order.total_pvp'), 2, '.', '') * 100;

        //Introducimos los valores de la transacción
        $fuc        = urlencode(env('TPV_FUC'));        //FUC: Código identificador de banco
        $terminal   = urlencode(env('TPV_TERMINAL'));   //Terminal: Por defecto 1, va ligada a la clave SHA256.
        $moneda     = urlencode(env('TPV_MONEDA'));     //Código de moneda: El código de € es 978
        $trans      = urlencode(env('TPV_TYPE_TRANSACTION')); //En la mayoría de TPVs es 0
        $order      = date('ymdHis');
        $amount     = $order_total; // <-- Lo guardamos en BBDD como identificador de pago, relacionaremos la respuesta del TPV mediante este campo

        // Se rellenan los campos necesarios para la petición
        $redsys->setParameter("DS_MERCHANT_AMOUNT",$amount);
        $redsys->setParameter("DS_MERCHANT_ORDER", strval($order));
        $redsys->setParameter("DS_MERCHANT_MERCHANTCODE",$fuc);
        $redsys->setParameter("DS_MERCHANT_CURRENCY",$moneda);
        $redsys->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$trans);
        $redsys->setParameter("DS_MERCHANT_TERMINAL",$terminal);
        $redsys->setParameter("DS_MERCHANT_MERCHANTURL", urlencode(route('payments.tpv')));
        $redsys->setParameter("DS_MERCHANT_URLOK", urlencode(route('payments.tpv_ok')));
        $redsys->setParameter("DS_MERCHANT_URLKO", urlencode(route('payments.tpv_ko')));

        // Datos de configuración
        $sig_ver    = "HMAC_SHA256_V1";
        $key_sha256 = urlencode(env('TPV_SHA256')); //FUC: 327287918 -> Terminal 1

        // Se generan los parámetros de la petición
        $request    = "";
        $params     = $redsys->createMerchantParameters();
        $signature  = $redsys->createMerchantSignature($key_sha256);

        // Preparamos los datos para pasarselos a la vista
        $data['DS_SIGNATUREVERSION']    = $sig_ver;
        $data['DS_MERCHANTPARAMETERS']  = $params;
        $data['DS_SIGNATURE']           = $signature;
        $data['ACTION']                 = $this->getTpvlUrl();

        return $data;
    }

    public function makeForm(){

        $data = prepareForm();

        $action             = $data['ACTION'];
        $signatureVersion   = $data['DS_SIGNATUREVERSION'];
        $parameters         = $data['DS_MERCHANTPARAMETERS'];
        $signature          = $data['DS_SIGNATURE'];

        $html = "<form action='$action' method='post' target='_self'>
                <input type='hidden' name='Ds_SignatureVersion' value='$signatureVersion'>
                <input type='hidden' name='Ds_MerchantParameters' value='$parameters'>
                <input type='hidden' name='Ds_Signature' value='$signature'>
                <input type='submit' value='Pagar con tarjeta' />
            </form>";

        return $html;
    }


    public function decryptResponse(ApiRedsys $redsys, $response){

        $data = [];

        if (!empty($response)) {

            //Recogemos las variables de respuesta
            $params             = $response['Ds_MerchantParameters'];
            $firma_recibida     = $response['Ds_Signature'];

            //Desciframos la información recibida
            $key_sha256         = urlencode(env('TPV_SHA256'));
            $datos              = $redsys->decodeMerchantParameters($params);
            $firma_calculada    = $redsys->createMerchantSignatureNotif($key_sha256,$params);

            $data['response']   = $redsys->getParameter("Ds_Response");
            $data['order']      = $redsys->getParameter("Ds_Order");
            $data['auth_code']  = $redsys->getParameter("Ds_AuthorisationCode");

            //Validamos las dos firmas, si coinciden hacemos las tareas en el servidor
            $firma_recibida === $firma_calculada ? $validation = true : $validation = false;

            $data['validation'] = $validation;
        }

        return $data;
    }
}