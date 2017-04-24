<?php

require_once('api/Simpla.php');
if (!class_exists('Security')) {
    include(dirname(__FILE__) . '/security.class.php');
    }

function to_float($sum) {
    $sum2 = round(floatval($sum), 2);
    $sum = sprintf("%01.2f", $sum2);
    if (substr($sum, -1) == "0") {
        $sum = sprintf("%01.1f", $sum2);
    }
    return $sum;
}

class NetPay extends Simpla {
    /*
     * 
     * Формирует форму для фронтэнда, добавляя туда необходимые $_POST
     * 
     */

    public function checkout_form($order_id, $button_text = null) {
        if (empty($button_text))
            $button_text = 'Перейти к оплате';

        $order = $this->orders->get_order(intval($order_id));
        $payment_method = $this->payment->get_payment_method($order->payment_method_id);
        $payment_settings = $this->payment->get_payment_settings($payment_method->id);
        $price = to_float($this->money->convert($order->total_price, $payment_method->currency_id, false));
        $currency = $this->money->get_currency($payment_method->currency_id);
        $success_url = $this->config->root_url . '/order/' . $order->url;
        $fail_url = $this->config->root_url . '/order/' . $order->url;
                
        if ($payment_settings['api_key'] == ''){
			$url_net2pay_pay = 'https://demo.net2pay.ru/billingService/paypage/';
                        $Api_key='js4cucpn4kkc6jl1p95np054g2';
                        $AuthSign='1';
                        $submitval='Оплатить онлайн';
		}
		else{
			$url_net2pay_pay = 'https://my.net2pay.ru/billingService/paypage/';
                        $Api_key=$payment_settings['api_key'];
                        $AuthSign=$payment_settings['auth_sign'];
                        $submitval='Оплатить онлайн';
		}              
                
        $md5_Api_key = base64_encode(md5($Api_key, true));
	$dateClass = new DateTime();
	$dateClass->modify('+999 day');
	$order_date = $dateClass->format('Y-m-dVH:i:s');
	$cryptoKey = substr(base64_encode(md5($md5_Api_key.$order_date, true)),0,16);
	
	$params = array();
	$params['description'] = 'ORDER '.$order->id;
	$params['amount'] = $price;
	$params['currency'] = 'RUB';
	$params['orderID'] = $order->id;
	$params['cardHolderCity'] = "";
	$params['cardHolderCountry'] = "";
	$params['cardHolderPostal'] = "";
	$params['cardHolderRegion'] = "";
	$params['successUrl'] = $success_url;
	$params['failUrl'] = $fail_url;
	
	$params_crypted = array();
	foreach ($params as $key=>$param){
		$cripter = Security::encrypt($key.'='.$param, $cryptoKey);
		$params_crypted[] = $cripter;
	}
	
	$params_crypted_str = implode('&', $params_crypted);

        $button = '<form action="'.$url_net2pay_pay.'" method="get" target="_blank">
                 
                <input type="hidden" name="data" value="'.urlencode($params_crypted_str).'">
                <input type="hidden" name="auth" value="'.$AuthSign.'">
                <input type="hidden" name="expire" value="'.urlencode($order_date).'">

                <input type="submit" name="Submit" class="netpaybutton buttonred"	value="'.$submitval.'"> 
        </form>';
        if ($payment_settings['mailforsend']!='') {
                    $netpay_url = 'http://'.$_SERVER['HTTP_HOST'].'/netpay/index.html';
                    $link = $netpay_url."?data=".urlencode($params_crypted_str)."&auth=".$AuthSign."&expire=".urlencode($order_date);
                    $link = str_replace("%", "%25", $link);
                    if (mail ($payment_settings['mailforsend'], 'Ссылка для оплаты заказа #'.$order->id, $link, "From: ".$payment_settings['mailforsend']."  \nContent-Type: text/html; charset=\"windows-1251\"\n")) $button=$payment_settings['textinsteadbutton'];
                    else $button=$payment_settings['sendmailerror'];
            
        }        
        return $button;
    }

}
