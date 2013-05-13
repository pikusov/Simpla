<?php

require_once('api/Simpla.php');

class OKPay extends Simpla
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
		$currency = $this->money->get_currency(intval($payment_method->currency_id));
		
		// описание заказа
		// order description
		$desc = 'Оплата заказа №'.$order->id;
		

		$return_url = $this->config->root_url.'/payment/OKPay/callback.php';
		
		$button =	'<form action="https://www.okpay.com/process.html" method="POST"/>'.
					'<input type="hidden" name="ok_receiver" value="'.$settings['okpay_reciever'].'" />'.
					'<input type="hidden" name="ok_invoice" value="'.$order->id.'" />'.
					'<input type="hidden" name="ok_item_1_name" value="'.$desc.'" />'.
					'<input type="hidden" name="ok_item_1_price" value="'.$price.'" />'.
					'<input type="hidden" name="ok_currency" value="'.$currency->code.'" />'.
					'<input type="hidden" name="ok_return_success" value="'.$return_url.'" />'.
					'<input type="hidden" name="ok_return_fail" value="'.$return_url.'" />'.
					'<input type=image src="https://www.okpay.com/img/buttons/x03.gif" alt="'.$button_text.'">'.
					'</form>';
				
		return $button;
	}
}