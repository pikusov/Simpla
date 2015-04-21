<?php

require_once('api/Simpla.php');

class DeltaKey extends Simpla
{
	public function hmac($key, $data) {
		// Вычисление подписи методом HMAC
		$b = 64; // byte length for md5
		
		if ( strlen($key) > $b ) {
			$key = pack("H*",md5($key));
		}
		
		$key = str_pad($key, $b, chr(0x00));
		$k_ipad = $key ^ str_pad(null, $b, chr(0x36));
		$k_opad = $key ^ str_pad(null, $b, chr(0x5c));
		
		return md5($k_opad . pack("H*",md5($k_ipad . $data)));
	}

	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Перейти к оплате';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_currency = $this->money->get_currency(intval($payment_method->currency_id));
		$settings = $this->payment->get_payment_settings($payment_method->id);
		
		$price = round($this->money->convert($order->total_price, $payment_method->currency_id, false), 2);
			
		$url = $this->config->root_url.'/order/'.$order->url;
		
		$payment_url = "https://merchant.deltakey.net/index.py";
		$skeys = $settings['skeys'];
		
		$param = $order->id. $settings['num_shop'].$settings['keyt_shop'].'1'.$price.'Order '.$order->id;
		$sign = $this->hmac($skeys, $param);
		
		$button = '<form method="POST" action="'.$payment_url.'">
					<input type=hidden name="keyt_shop" value="'.$settings['keyt_shop'].'">
					<input type=hidden name="sum" value="'.$price.'">
					<input type=hidden name="num_shop" value="'.$settings['num_shop'].'">
					<input type=hidden name="ext_transact" value="'.$order->id.'">
					<input type=hidden name="comment" value="Order '.$order->id.'">
					<input type=hidden name="identified" value="1">
					<input type=hidden name="sign" value="'.$sign.'">
					<input type="submit" name="submit-button" value="'.$button_text.'" class="checkout_button">
					</form>';
		return $button;
	}
}