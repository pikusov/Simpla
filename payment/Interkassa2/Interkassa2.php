<?php

require_once('api/Simpla.php');

class Interkassa2 extends Simpla
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
		
		$success_url = $this->config->root_url.'/order/'.$order->url;
		$callback_url = $this->config->root_url.'/payment/Interkassa2/callback.php';

					
		$button = "<form name='payment' method='post' action='https://sci.interkassa.com/' accept-charset='UTF-8'> 
					<input type='hidden' name='ik_co_id' value='".$settings['ik_co_id']."'>
					<input type='hidden' name='ik_pm_no' value='".$order->id."'>
					<input type='hidden' name='ik_cur'   value='".$payment_currency->code."'>
					<input type='hidden' name='ik_am'    value='$price'>
					<input type='hidden' name='ik_desc'  value='$desc'>

					<input type='hidden' name='ik_suc_u'  value='$success_url'>
					<input type='hidden' name='ik_ia_u'  value='$callback_url'>

					<input type='submit' name='process'  value='$button_text' class='checkout_button'>
					</form>";
		return $button;
	}
}