<?php

require_once('api/Simpla.php');

class ChronoPay extends Simpla
{
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Перейти к оплате';

		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$settings = $this->payment->get_payment_settings($payment_method->id);

		$price = number_format($this->money->convert($order->total_price, $payment_method->currency_id, false), 2, '.', '');

		$success_url = $this->config->root_url.'/order/'.$order->url;
		$fail_url = $this->config->root_url.'/order/'.$order->url;
		$cb_url = $this->config->root_url.'/payment/ChronoPay/callback.php';
		$product_id = $settings['chronopay_product_id'];

		$sign = md5(
			$product_id.'-'.$price.'-'.$order->id.'-'.$settings['chronopay_sharedSec']
		);

		$payment_url = "https://payments.chronopay.com";

		$button = '<form method="POST" action="'.$payment_url.'">
					<input type="hidden" name="product_id" value="'.$product_id.'">
					<input type="hidden" name="cb_url" value="'.$cb_url.'">
					<input type="hidden" name="success_url" value="'.$success_url.'">
					<input type="hidden" name="decline_url" value="'.$fail_url.'">
					<input type="hidden" name="sign" value="'.$sign.'">

					<input type="hidden" name="product_price" value="'.$price.'">
					<input type="hidden" name="order_id" value="'.$order->id.'">

					<input type="hidden" name="cms_name" value="simplacms"/>
					<input type="submit" name="submit-button" value="'.$button_text.'" class="checkout_button">
					</form>';
		return $button;
	}
}