<?php
    require '../../../vendor/mercadopago/autoload.php';

    $URL_RETORNO = $_POST['CALLBACK_URL'];
    $TOKEN_MP    = $_POST['TOKEN'];
    $REFERENCIA  = $_POST['ORDER_ID'];
    $VALOR       = $_POST['TXN_AMOUNT'];
    $NOME        = $_POST['NOME'];
    $BASE        = $_POST['BASE'];

    $URL = $BASE."/addfunds";

    $amount = floatval(str_replace(',','.',$VALOR));
    
        MercadoPago\SDK::setAccessToken($TOKEN_MP);
        $preference = new MercadoPago\Preference();
        $item = new MercadoPago\Item();
        $item->title = 'Saldo MP - '.$NOME;
        $item->quantity = 1;
        $item->unit_price = $amount;
        $preference->items = array($item);
        $preference->external_reference = $REFERENCIA;
        $preference->back_urls = array("success" => $URL, "failure" => $URL, "pending" => $URL);
        $preference->notification_url   = $URL_RETORNO;
        $preference->auto_return = "approved";
        $preference->save();     
        header("Location: ".$preference->init_point);        
?>