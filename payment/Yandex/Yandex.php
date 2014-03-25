<?php

require_once('api/Simpla.php');

class Yandex extends Simpla
{

	// Комиссия Яндекса, %
	private $fee = 0.5;

	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Перейти к оплате';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_currency = $this->money->get_currency(intval($payment_method->currency_id));
		$settings = $this->payment->get_payment_settings($payment_method->id);
		
		$price = round($this->money->convert($order->total_price, $payment_method->currency_id, false), 2);
		
		// Учесть комиссию Яндекса
		$price = $price+max(0.01, $price*$this->fee/100);

		// описание заказа
		$desc = 'Оплата заказа №'.$order->id.' на сайте '.$this->settings->site_name;
							
		$button = '<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
					<input name="receiver" type="hidden" value="'.$settings['yandex_id'].'">
					<input name="short-dest" type="hidden" value="'.$desc.'">
					<input type="hidden" name="comment" value="'.$desc.'"/>
					<input name="quickpay-form" type="hidden" value="shop">
					<input data-type="number" type="hidden" name="sum" value="'.$price.'">
					<input name="label" type="hidden" value="'.$order->id.'">   
					<input type="submit" name="submit-button" value="'.$button_text.'"  class="checkout_button">
					</form>';
		return $button;
	}
}