<?php

/**
 * Simpla CMS
 *
 * @copyright 	2017 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * Платежный модуль для Промсвязьбанка
 *
 */

require_once('api/Simpla.php');

class PSBank extends Simpla
{	
	private $test_gate = 'https://test.3ds.payment.ru/cgi-bin/cgi_link';
	private $real_gate = 'https://3ds.payment.ru/cgi-bin/cgi_link';
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Оплатить';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$settings = $this->payment->get_payment_settings($payment_method->id);
		$amount = $this->money->convert($order->total_price, $payment_method->currency_id, false);
		$currency = $this->money->get_currency(intval($payment_method->currency_id));		
		$return_url = $this->config->root_url.'/order/'.$order->url;
		$desc = 'Оплата заказа №'.$order->id;
		
		// Московское время - 3 часа.
		// Зачем это банку? Неизвестно, но без этого не работает
		$date = new DateTime('now', new DateTimeZone('Europe/Moscow'));
		$date->modify('-3Hours');
		$timestamp = $date->format('YmdHis');		
		
		$data = array(
			'AMOUNT' => $amount,
			'CURRENCY' => $currency->code,
			// Номер заказа почему-то должен состоять минимум из 6 цифр
			'ORDER' => 1000000 + $order->id,
			'MERCH_NAME' => $this->settings->site_name,
			'MERCHANT' => $settings['psbank_merchant'],
			'TERMINAL' => $settings['psbank_terminal'],
			'EMAIL' => $order->email,
			'TRTYPE' => '1',
			'TIMESTAMP' => $timestamp,
			// Случайное число неизвестного назначения
			'NONCE' => rand(10000000000000000, 99999999999999999999),
			'BACKREF' => $return_url
		);
		
		// Формируем строку, которую далее будем шифровать
		$mac = '';
		foreach($data as $k=>$v)
		{
			$mac .= strlen($v).$v;
		}	
		$sign = hash_hmac('sha1', $mac ,pack('H*', $settings['psbank_key']));

		// Форма для отправки банку
		if($settings['psbank_test_mode'] == 1)
			$gate = $this->test_gate;
		else
			$gate = $this->real_gate;
		$button = "";
		$button .= "<form method='POST' action='".$gate."'>";	
		foreach($data as $k=>$v)
		{
			$button .= "<input type='hidden' name='".$k."' value='".$v."'>";
		}					
		$button .= "<input type='hidden' name='P_SIGN' value='".$sign."'>
					<input type='hidden' name='DESC' value='".$desc."'>
					<input class=checkout_button type='submit' value='".$button_text."' />
					</form>";
		return $button;
	}

}