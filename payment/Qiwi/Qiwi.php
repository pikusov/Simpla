<?php

require_once('api/Simpla.php');

class Qiwi extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Оплатить';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_settings = $this->payment->get_payment_settings($payment_method->id);
		
		$price = $this->money->convert($order->total_price, $payment_method->currency_id, false);
		
		$success_url = $this->config->root_url.'/order/'.$order->url;
		
		$fail_url = $this->config->root_url.'/order/'.$order->url;
				
		// регистрационная информация (логин, пароль #1)
		// registration info (login, password #1)
		$login = $payment_settings['qiwi_login'];
		
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
		
		$message = "Введите логин Qiwi-кошелька или номер телефона (10 последних цифр):";
		$phone = preg_replace('/[^\d]/', '', $order->phone);
		$phone = substr($phone, -min(10, strlen($phone)), 10);
		
		$button =	"<form accept-charset='UTF-8' action='http://w.qiwi.ru/setInetBill_utf.do' method=POST>".
					"<input type=hidden name=from value='$login'>".
					"<input type=hidden name=summ value='$price'>".
					"<input type=hidden name=txn_id value='$inv_id'>".
					"<input type=hidden name=check_agt value='false'>".
					"<input type=hidden name=lifetime value='540'>".
					"<input type=hidden name=com value='$inv_desc'>".
					"<label>$message</label><input type=text name=to value='".$phone."'>".
					"<input type=submit class=checkout_button value='$button_text'>".
					"</form>";
		return $button;
	}

}