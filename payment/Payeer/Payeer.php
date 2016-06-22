<?php
require_once('api/Simpla.php');

class Payeer extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
		{
			$button_text = 'Оплатить';
		}
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_currency = $this->money->get_currency(intval($payment_method->currency_id));
		$settings = $this->payment->get_payment_settings($payment_method->id);	

		$m_url = $settings['payeer_merchanturl'];
		$m_shop = $settings['payeer_merchantid'];
		$m_orderid = $order->id;
		$m_amount = number_format($order->total_price, 2, '.', '');
		$m_curr = $payment_currency->code == 'RUR' ? 'RUB' : $payment_currency->code;
		$m_desc = base64_encode($order->comment);

		$arHash = array(
			$m_shop,
			$m_orderid,
			$m_amount,
			$m_curr,
			$m_desc,
			$settings['payeer_secret']
		);
		
		$sign = strtoupper(hash('sha256', implode(":", $arHash)));
		
		$button = '
		<form method="GET" action="' . $m_url . '">
			<input type="hidden" name="m_shop" value="' . $m_shop . '">
			<input type="hidden" name="m_orderid" value="' . $m_orderid . '">
			<input type="hidden" name="m_amount" value="' . $m_amount . '">
			<input type="hidden" name="m_curr" value="' . $m_curr . '">
			<input type="hidden" name="m_desc" value="' . $m_desc . '">
			<input type="hidden" name="m_sign" value="' . $sign . '">
			<input type="submit" name="m_process" value="' . $button_text . '" />
		</form>';
		
		return $button;
	}
}
?>