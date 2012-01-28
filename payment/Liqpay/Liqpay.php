<?php

require_once('api/Simpla.php');

class Liqpay extends Simpla
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
		$desc = 'Оплата заказа №'.$order->id;
		
		// Способы оплаты
		$payway = array();
		if($settings['pay_way_card'])
			$payway[] = 'card';
		if($settings['pay_way_liqpay'])
			$payway[] = 'liqpay';
		if($settings['pay_way_delayed'])
			$payway[] = 'delayed';
		$payway = implode(',', $payway);
		
		$result_url = $this->config->root_url.'/order/';
		$server_url = $this->config->root_url.'/payment/Liqpay/callback.php';		
		
		$xml = '<request>      
				<version>1.2</version>
				<merchant_id>'.$settings['liqpay_id'].'</merchant_id>
				<result_url>'.$result_url.'</result_url>
				<server_url>'.$server_url.'</server_url>
				<order_id>'.$order->id.'</order_id>
				<amount>'.$price.'</amount>
				<currency>'.$payment_currency->code.'</currency>
				<description>'.$desc.'</description>
				<pay_way>'.$payway.'</pay_way>
 				</request>';
		$xml_encoded = base64_encode($xml);
		
		$merc_sign = $settings['liqpay_sign'];
		$sign = base64_encode(sha1($merc_sign.$xml.$merc_sign, 1));
					
		$button =	'<form action="https://www.liqpay.com/?do=clickNbuy" method="POST" />'.
					'<input type="hidden" name="operation_xml" value="'.$xml_encoded.'" />'.
					'<input type="hidden" name="signature" value="'.$sign.'" />'.
					'<input type=submit class=checkout_button value="'.$button_text.'">'.
					'</form>';
		return $button;
	}
}