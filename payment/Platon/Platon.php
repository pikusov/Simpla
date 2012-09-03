<?php

require_once('api/Simpla.php');

class Platon extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Перейти к оплате';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_currency = $this->money->get_currency(intval($payment_method->currency_id));
		$settings = $this->payment->get_payment_settings($payment_method->id);
		
		$price = round($this->money->convert($order->total_price, $payment_method->currency_id, false), 2);
		
		
		// описание заказа
		// order description
		$desc = 'Оплата заказа №'.$order->id;
		
		$return_url = $this->config->root_url.'/payment/Platon/callback.php';
		$callback_url = $this->config->root_url.'/payment/Platon/callback.php';		
		

		
		$merc_sign = $settings['liqpay_sign'];
		$sign = md5(strtoupper(strrev($_SERVER["REMOTE_ADDR"]).strrev($settings['platon_key']).strrev($desc).strrev($return_url).strrev($settings['platon_password'])));
					
		$button =	'<form action="https://secure.platononline.com/pcc.php?a=auth" method="POST"/>'.
					'<input type="hidden" name="key" value="'.$settings['platon_key'].'" />'.
					'<input type="hidden" name="order" value="'.$order->id.'" />'.
					'<input type="hidden" name="data" value="'.$desc.'" />'.
					'<input type="hidden" name="url" value="'.$return_url.'" />'.
					'<input type="hidden" name="sign" value="'.$sign.'" />'.
					'<input type=submit class=checkout_button value="'.$button_text.'">'.
					'</form>';
		return $button;
	}
}