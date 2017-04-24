<?php

/**
 * Simpla CMS
 *
 * @copyright 	2017 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * Платежный модуль Paysera
 *
 */

require_once('WebToPay.php');
require_once('api/Simpla.php');

class Paysera extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Checkout';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_settings = $this->payment->get_payment_settings($payment_method->id);
		
		$amount = $this->money->convert($order->total_price, $payment_method->currency_id, false);
		
		$success_url = $this->config->root_url.'/order/'.$order->url;		
		$fail_url = $this->config->root_url.'/order/'.$order->url;
		$callback_url = $this->config->root_url.'/payment/Paysera/callback.php?order_id='.$order->id;		

		$currency = $this->money->get_currency(intval($payment_method->currency_id));

		$request = WebToPay::buildRequest(array(
			'projectid'     => $payment_settings['paysera_project_id'],
			'sign_password' => $payment_settings['paysera_password'],
			'test'       => $payment_settings['paysera_test_mode'],
			'orderid'       => $order->id,
			'p_email'       => $order->email,
			'amount'        => round($amount*100),
			'currency'      => $currency->code,
			'paytext'       => 'Payment for order #[order_nr] on [site_name]',
			'accepturl'     => $success_url,
			'cancelurl'     => $fail_url,
			'callbackurl'   => $callback_url
		));
		
		$button = "<form method='POST' action='".WebToPay::PAY_URL."'>
					<input type='hidden' name='data' value='".$request['data']."'>
					<input type='hidden' name='sign' value='".$request['sign']."'>
					<input class=checkout_button type='submit' value='".$button_text."' />
					</form>";
		return $button;
	}

}