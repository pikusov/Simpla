<?php

/**
 * Simpla CMS
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * Paypal checkout button
 *
 */
 
require_once('api/Simpla.php');

class Paypal extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		
		if(empty($button_text))
			$button_text = 'Checkout with Paypal';
		
		$order = $this->orders->get_order((int)$order_id);
		$purchases = $this->orders->get_purchases(array('order_id'=>intval($order->id)));

		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$currency = $this->money->get_currency(intval($payment_method->currency_id));
		$payment_settings = $this->payment->get_payment_settings($payment_method->id);
			
		if($payment_settings['mode'] == 'sandbox') $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		else $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
			
		$ipn_url = $this->config->root_url.'/payment/Paypal/callback.php';
		$success_url = $this->config->root_url.'/order/'.$order->url;
		$fail_url = $this->config->root_url.'/order/'.$order->url;

		$button =	"<form method='post' action= '".$paypal_url."'>
					<input type='hidden' name='charset' value='utf-8'>
					<input type='hidden' name='currency_code' value='".$currency->code."'>
					<input type='hidden' name='invoice' value='".$order->id."'>
					<input type='hidden' name='business' value='".$payment_settings['business']."'>
					<input type='hidden' name='cmd' value='_cart'>
					<input type='hidden' name='upload' value='1'>
					<input type='hidden' name='rm' value='2'>
					<input type='hidden' name='notify_url' value='$ipn_url'>
					<input type='hidden' name='return' value='$success_url'>
					<input type='hidden' name='cancel_return' value='$fail_url'>
					";
					
		if($order->discount)
			$button .= "<input type='hidden' name='discount_rate_cart' value='".$order->discount."'>";
					
		$i = 1;
		foreach($purchases as $purchase)
		{			
			$price = $this->money->convert($purchase->price, $payment_method->currency_id, false);
			$price = number_format($price, 2, '.', '');
			$button .=	"<input type='hidden' name='item_name_".$i."' value='".$purchase->product_name.' '.$purchase->variant_name."'>
						<input type='hidden' name='amount_".$i."' value='".$price."'>
						<input type='hidden' name='quantity_".$i."' value='".$purchase->amount."'>";
			$i++;
		}
			
		$delivery_price = 0;
		if($order->delivery_id && !$order->separate_delivery && $order->delivery_price>0)
		{
			$delivery_price = $this->money->convert($order->delivery_price, $payment_method->currency_id, false);
			$delivery_price = number_format($delivery_price, 2, '.', '');
			$button .=	"<input type='hidden' name='shipping_1' value='".$delivery_price."'>";
		}

		$button .=	"<input type='image' src='https://www.paypalobjects.com/en_US/i/btn/btn_xpressCheckout.gif' value='".$button_text."'>
					</form>";
		return $button;
	}

}