<?php

require_once('api/Simpla.php');

class Rficb extends Simpla
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
		$desc = 'Оплата заказа №'.$order->id;
		
		$key = $settings['rficb_payment_key'];
					
		$button = "<form name='payment' action='https://partner.rficb.ru/a1lite/input/' method='post' 
					enctype='application/x-www-form-urlencoded' accept-charset='UTF-8'>
					<input type='hidden' name='key' value='$key'>
					<input type='hidden' name='cost' value='$price'>
					<input type='hidden' name='order_id' value='$order->id'>
					<input type='hidden' name='name' value='$desc'>
					<input type='submit' name='process' value='$button_text' class='checkout_button'>
					</form>";
		return $button;
	}
}