<?php

/**
 * Simpla CMS
 *
 * @copyright 	2017 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * Платежный шлюз для Альфа-Банка
 *
 */

require_once('api/Simpla.php');

class Alfabank extends Simpla
{	
	public $getaway_url = 'https://test.paymentgate.ru/testpayment/rest/';
	
	public function checkout_form($order_id, $button_text = null)
	{
		if($this->request->method('post') && $this->request->post('go'))
		{
			$this->redirect($order_id);
		}
		else
		{
			$button =	"<form method=POST>".
						"<input name=go type=submit class=checkout_button
						 value='Перейти к оплате &#8594;'>".
						"</form>";
			return $button;
		}
	}
	
	public function redirect($order_id)
	{
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_settings = $this->payment->get_payment_settings($payment_method->id);	
		if(!empty($payment_settings['alfabank_server']))
			$this->getaway_url = $payment_settings['alfabank_server'];
		$price = $this->money->convert($order->total_price, $payment_method->currency_id, false);
		$return_url = $this->config->root_url.'/payment/Alfabank/callback.php?o='.$order->id;		

		$data = array(
			'userName' => $payment_settings['alfabank_login'],
			'password' => $payment_settings['alfabank_password'],
			'orderNumber' => $order->id, 
			'amount' => $price*100,
			'returnUrl' => $return_url
		);
		
		$response = $this->gateway('register.do', $data);	
		if ($response['errorCode'] != 0)
		{
			print($response['errorMessage']);
		}
		else
		{
			print "REDIRECT";
			header('Location: '.$response['formUrl']);
			exit;
		}
					
		return $button;
	}
	

	public function gateway($method, $data)
	{
		$curl = curl_init(); // Инициализируем запрос
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->getaway_url.$method,
			CURLOPT_RETURNTRANSFER => true, // Возвращать ответ
			CURLOPT_POST => true, // Метод POST
			CURLOPT_POSTFIELDS => http_build_query($data) // Данные в запросе
		));

		$response = curl_exec($curl); // Выполненяем запрос
		$response = json_decode($response, true); // Декодируем из JSON в массив
		$err = curl_error($curl);
		if($err)
		{
			print $err;
		}
		curl_close($curl); // Закрываем соединение
		return $response; // Возвращаем ответ
	}

}