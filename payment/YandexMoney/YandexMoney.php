<?php
/**
	Version: 1.1.0
	License: Любое использование Вами программы означает полное и безоговорочное принятие Вами условий лицензионного договора, размещенного по адресу https://money.yandex.ru/doc.xml?id=527132 (далее – «Лицензионный договор»). Если Вы не принимаете условия Лицензионного договора в полном объёме, Вы не имеете права использовать программу в каких-либо целях.
*/
require_once('api/Simpla.php');

class YandexMoney extends Simpla
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
		
		$success_url = $this->config->root_url.'/order/'.$order->url;		
		$fail_url = $this->config->root_url.'/order/'.$order->url;
		
		if($settings['yandex_testmode'])
			$payment_url = "https://demomoney.yandex.ru/eshop.xml";
		else
			$payment_url = "https://money.yandex.ru/eshop.xml";
		
		if($settings['yandex_paymenttype'])
			$payment_type = '<input type="hidden" name="paymenttype" value="'.$settings['yandex_paymenttype'].'">';

		$button = '<form method="POST" action="'.$payment_url.'">
					<input type="hidden" name="shopid" value="'.$settings['yandex_shopid'].'">
					<input type="hidden" name="sum" value="'.$price.'">
					<input type="hidden" name="scid" value="'.$settings['yandex_scid'].'">
					
					<input type="hidden" name="shopSuccessURL" value="'.$success_url.'">
					<input type="hidden" name="shopFailURL" value="'.$fail_url.'">
					
					<input type="hidden" name="cps_email" value="'.htmlspecialchars($order->email,ENT_QUOTES).'">
					<input type="hidden" name="cps_phone" value="'.htmlspecialchars($order->phone,ENT_QUOTES).'">
					   

					<input type="hidden" name="customerNumber" value="'.$order->id.'">
					'.$payment_type.'
					<input type="hidden" name="cms_name" value="simplacms"/>
					<input type="submit" name="submit-button" value="'.$button_text.'" class="checkout_button">
					</form>';
		return $button;
	}
}