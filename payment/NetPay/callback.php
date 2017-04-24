<?php

// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();
$status = 0;
$error = '';

$query = $simpla->db->placehold("SELECT * FROM __payment_methods WHERE module=? LIMIT 1", 'NetPay');
$simpla->db->query($query);
$payment_method = $simpla->db->result();
$pyment_settins = unserialize($payment_method->settings);
$api_key = $pyment_settins['api_key'];    


$data = $_GET['data'];
$auth = $_GET['auth'];
$md5_Api_key = base64_encode(md5($api_key, true));
$order_date = $_GET['expire'];

function decrypt($sStr, $sKey)
{
    $decrypted = mcrypt_decrypt(
        MCRYPT_RIJNDAEL_128, $sKey, base64_decode($sStr), MCRYPT_MODE_ECB
    );
    $dec_s = strlen($decrypted);
    $padding = ord($decrypted[$dec_s - 1]);
    $decrypted = substr($decrypted, 0, -$padding);
    return $decrypted;
}

$md5_Api_key = base64_encode(md5($api_key, true));

$cryptoKey = substr(base64_encode(md5($md5_Api_key.$order_date, true)),0,16);

$arr = explode('&', $data);
$i = '0';

foreach ($arr as $par) {
    $newarr[$i] = explode('=', decrypt($par, $cryptoKey));
    $i++;
}

if ($newarr[0][0] == 'orderID') {
    $status = '1';
    $error = '';
} else {
    $data = urldecode($data);    
    $order_date = urldecode($order_date);
    $cryptoKey = substr(base64_encode(md5($md5_Api_key . $order_date, true)), 0, 16);
    $arr = explode('&', $data);
    $i = '0';
    foreach ($arr as $par) {
        $newarr[$i] = explode('=', decrypt($par, $cryptoKey));
        $i++;
    }
    if ($newarr[0][0] == 'orderID') {
        $status = '1';
        $error = '';
    } else {
        $status = '0';
        $error = 'error parsing data';
    }
}

//Меняем статус заказа на оплачен
if (($newarr[2][1] == 'APPROVED') &
    (($newarr[3][1] == 'Sale') || ($newarr[3][1] == 'Sale_Qiwi') || ($newarr[3][1] == 'Sale_YaMoney') || ($newarr[3][1] == 'Sale_WebMoney'))){

    // Выберем заказ из базы
    $order = $simpla->orders->get_order(intval($newarr[0][1]));
    if(empty($order))
            $error = 'Оплачиваемый заказ не найден';

    // Установим статус оплачен
    $simpla->orders->update_order(intval($order->id), array('paid'=>1));

    // Отправим уведомление на email
    $simpla->notify->email_order_user(intval($order->id));
    $simpla->notify->email_order_admin(intval($order->id));

    // Спишем товары  
    $simpla->orders->close(intval($order->id));

    $status = '1';
    
}

echo '<notification>
<orderId>' . $order->id . '</orderId>
<transactionType>' . $newarr[3][1] . '</transactionType>
<status>' . $status . '</status>
<error>' . $error . '</error>
</notification>';