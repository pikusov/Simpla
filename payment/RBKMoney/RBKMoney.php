<?php

require_once('api/Simpla.php');

class RBKMoney extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Перейти к оплате';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_settings = $this->payment->get_payment_settings($payment_method->id);
		$payment_currency = $this->money->get_currency(intval($payment_method->currency_id));
		
			
		$shop_id = $payment_settings['rbkmoney_id'];
		
		// номер заказа
		// number of order
		$order_id = $order->id;
		
		// описание заказа
		// order description
		$order_description = 'Оплата заказа №'.$order->id;
		
		// сумма заказа
		// sum of order
		$amount = $this->money->convert($order->total_price, $payment_method->currency_id, false);
		
		$currency_code = $payment_currency->code;
		
		// адрес, на который попадет пользователь по окончанию продажи в случае успеха
		$redirect_url_ok = $this->config->root_url.'/order/'.$order->url;
		
		// адрес, на который попадет пользователь по окончанию продажи в случае неудачи
		$redirect_url_failed = $this->config->root_url.'/order/'.$order->url;

		// Email покупателя
		$user_email = $order->email;

		
		$button =	"<form action='https://rbkmoney.ru/acceptpurchase.aspx' method=POST>".
					"<input type=hidden name=eshopId value='$shop_id'>".
					"<input type=hidden name=orderId value='$order_id'>".
					"<input type=hidden name=serviceName value='$order_description'>".
					"<input type=hidden name=recipientAmount value='$amount'>".
					"<input type=hidden name=recipientCurrency value='$currency_code'>".
					"<input type=hidden name=successUrl value='$redirect_url_ok'>".
					"<input type=hidden name=failUrl value='$redirect_url_failed'>".
					"<input type=hidden name=user_email value='$user_email'>".
					"<input type=submit class=payment_button value='$button_text'>".
					"</form>";
		return $button;
	}
}