<?php

require_once('api/Simpla.php');

class Paysto extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Перейти к оплате';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_settings = $this->payment->get_payment_settings($payment_method->id);
		
		$amount = $this->money->convert($order->total_price, $payment_method->currency_id, false);
		$amount = number_format($amount, 2, '.', '');
		
		$success_url = $this->config->root_url.'/order/'.$order->url;
		
		$fail_url = $this->config->root_url.'/order/'.$order->url;
		
		
		$button = "<form accept-charset='UTF-8' method='POST' action='https://paysto.com/ru/pay'>
					<input type='hidden' name='PAYSTO_SHOP_ID' value='".$payment_settings['paysto_shop_id']."'>
					<input type='hidden' name='PAYSTO_SUM' value='".$amount."'>
					<input type='hidden' name='PAYSTO_INVOICE_ID' value='$order->id'>
					<input type='hidden' name='PAYSTO_DESC' value='"."Заказ №$order->id"."'>
					<input type='hidden' name='PayerEMail' value='".htmlentities($order->email)."'>
					<input class=checkout_button type='submit' value='".$button_text."' />
					</form>";
		return $button;
	}

}