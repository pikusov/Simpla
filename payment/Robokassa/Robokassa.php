<?php

require_once('api/Simpla.php');

class Robokassa extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Перейти к оплате';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_settings = $this->payment->get_payment_settings($payment_method->id);
		
		$price = $this->money->convert($order->total_price, $payment_method->currency_id, false);
		
		$success_url = $this->config->root_url.'/order/'.$order->url;
		
		$fail_url = $this->config->root_url.'/order/'.$order->url;
				
		// регистрационная информация (логин, пароль #1)
		// registration info (login, password #1)
		$mrh_login = $payment_settings['login'];
		$mrh_pass1 = $payment_settings['password1'];
		
		// номер заказа
		// number of order
		$inv_id = $order->id;
		
		// описание заказа
		// order description
		$inv_desc = 'Оплата заказа №'.$inv_id;
				
		// метод оплаты - текущий
		$shp_item = $payment_method->id;
		
		// предлагаемая валюта платежа
		// default payment e-currency
		$in_curr = "PCR";
		
		// язык
		// language
		$culture = $payment_settings['language'];
		
		// формирование подписи
		// generate signature
		$crc  = md5("$mrh_login:$price:$inv_id:$mrh_pass1");
		
		$button =	"<form accept-charset='cp1251' action='https://merchant.roboxchange.com/Index.aspx' method=POST>".
					"<input type=hidden name=MrchLogin value='$mrh_login'>".
					"<input type=hidden name=OutSum value='$price'>".
					"<input type=hidden name=InvId value='$inv_id'>".
					"<input type=hidden name=Desc value='$inv_desc'>".
					"<input type=hidden name=SignatureValue value='$crc'>".
					"<input type=hidden name=IncCurrLabel value='$in_curr'>".
					"<input type=hidden name=Culture value='$culture'>".
					"<input type=submit class=checkout_button value='Перейти к оплате &#8594;'>".
					"</form>";
		return $button;
	}

}