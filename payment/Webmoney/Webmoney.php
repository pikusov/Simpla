<?php

require_once('api/Simpla.php');

class Webmoney extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Перейти к оплате';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_settings = $this->payment->get_payment_settings($payment_method->id);
		
		$amount = $this->money->convert($order->total_price, $payment_method->currency_id, false);
		
		$success_url = $this->config->root_url.'/order/'.$order->url;
		
		$fail_url = $this->config->root_url.'/order/'.$order->url;
		
		
		$button = "<form accept-charset='cp1251' method='POST' action='https://merchant.webmoney.ru/lmi/payment.asp'>
					<input type='hidden' name='LMI_PAYMENT_AMOUNT' value='".$amount."'>
					<input type='hidden' name='LMI_PAYMENT_DESC_BASE64' value='".base64_encode("Оплата заказа №$order->id")."'>
					<input type='hidden' name='LMI_PAYMENT_NO' value='$order->id'>
					<input type='hidden' name='LMI_PAYEE_PURSE' value='".$payment_settings['purse']."'>
					<input type='hidden' name='LMI_SIM_MODE' value='0'>
					<input type='hidden' name='LMI_SUCCESS_URL' value='$success_url'>
					<input type='hidden' name='LMI_FAIL_URL' value='$fail_url'>
					<input class=checkout_button type='submit' value='".$button_text."' />
					</form>";
		return $button;
	}

}