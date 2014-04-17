<?php

require_once('api/Simpla.php');

class Liqpay extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Перейти к оплате';
		
		$order = $this->orders->get_order((int)$order_id);
		$liqpay_order_id = $order->id."-".rand(100000, 999999);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_currency = $this->money->get_currency(intval($payment_method->currency_id));
		$settings = $this->payment->get_payment_settings($payment_method->id);
		
		$price = round($this->money->convert($order->total_price, $payment_method->currency_id, false), 2);	

		// описание заказа
		// order description
		$desc = 'Оплата заказа №'.$order->id;

		$result_url = $this->config->root_url.'/order/'.$order->url;
		$server_url = $this->config->root_url.'/payment/Liqpay/callback.php';		
		
		
		$private_key = $settings['liqpay_private_key'];
		$public_key = $settings['liqpay_public_key'];
		$sign = base64_encode(sha1($private_key.$price.$payment_currency->code.$public_key.$liqpay_order_id.'buy'.$desc.$result_url.$server_url, 1));
					
		$button =	'<form method="POST" action="https://www.liqpay.com/api/pay">
						<input type="hidden" name="public_key" value="'.$public_key.'" />
						<input type="hidden" name="amount" value="'.$price.'" />
						<input type="hidden" name="currency" value="'.$payment_currency->code.'" />
						<input type="hidden" name="description" value="'.$desc.'" />
						<input type="hidden" name="order_id" value="'.$liqpay_order_id.'" />
						<input type="hidden" name="result_url" value="'.$result_url.'" />
						<input type="hidden" name="server_url" value="'.$server_url.'" />  
						<input type="hidden" name="type" value="buy" />
						<input type="hidden" name="signature" value="'.$sign.'" />
						<input type=submit class=checkout_button value="'.$button_text.'">
					</form>';
		return $button;
	}
}