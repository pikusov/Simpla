<?php

require_once('api/Simpla.php');

class Assist extends Simpla
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
				
		$return_url = $this->config->root_url.'/order/'.$order->url;
		
		$hashcode = strtoupper(md5(strtoupper(md5( $settings['assist_key'] ).md5( $settings['assist_merchant_id'] . $order->id .  $order->total_price . str_replace("RUR", "RUB", $payment_currency->code)))));


		$fio_arr = explode(" ", $order->name);
		$firstname = $fio_arr[0];
		$lastname = $fio_arr[1];

		if (trim($firstname) == "") {
			$firstname = "---";
		}
		if (trim($lastname) == "") {
			$lastname = "---";
		}

		
		$button =	'<form action="'.$settings['assist_url'].'" method="POST"/>'.
					'<input type="hidden" name="Merchant_ID" value="'.$settings['assist_merchant_id'].'" />'.
					'<input type="hidden" name="OrderNumber" value="'.$order->id.'" />'.
					'<input type="hidden" name="OrderAmount" value="'.$order->total_price.'" />'.
					'<input type="hidden" name="url" value="'.$return_url.'" />'.
					'<input type="hidden" name="CheckValue" value="'.$hashcode.'" />'.
					'<input type="hidden" name="OrderCurrency" value="'.str_replace("RUR", "RUB", $payment_currency->code).'" />'.
					'<input type="hidden" name="LastName" value="'.$lastname.'" />'.
					'<input type="hidden" name="FirstName" value="'.$firstname.'" />'.
					'<input type="hidden" name="Language" value="RU" />'.
					'<input type="hidden" name="URL_RETURN_OK" value="'.$return_url.'" />'.
					'<input type="hidden" name="URL_RETURN_NO" value="'.$return_url.'" />'.
					'<input type="hidden" name="Email" value="'.$order->email.'" />'.
					'<input type="hidden" name="MobilePhone" value="'.$order->phone.'" />'.
					'<input type="hidden" name="OrderComment" value="'.$order->comment.'" />'.
					'<input type=submit class=checkout_button value="'.$button_text.'">'.
					'</form>';
		return $button;
	}
}