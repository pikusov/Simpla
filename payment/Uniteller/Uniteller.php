<?php

/**
 * Simpla CMS
 * 
 * @link		http://rlab.pro
 * @author		OsBen
 * @mail		php@rlab.pro
 *
 * Оплата через Интернет-эквайринг через Uniteller
 *
 */
 
require_once('api/Simpla.php');

class Uniteller extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Перейти к оплате';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_currency = $this->money->get_currency(intval($payment_method->currency_id));
		$settings = $this->payment->get_payment_settings($payment_method->id);
		
	
			
		$uniteller_shop_id	=	$settings['uniteller_shop_id'];
		$uniteller_password = 	$settings['uniteller_password'];  
		$Customer_IDP		= '';	
		$IData				= '';
		$PT_Code			= '';
		$EMoneyType			= '';
		$MeanType			= '';
		$Lifetime			= 300;
		$Subtotal_P			= round($this->money->convert($order->total_price, $payment_method->currency_id, false), 2);
		$return_url 		= $this->config->root_url.'/order/'.$order->url;
		$Signature = strtoupper(
				md5(
					md5($uniteller_shop_id) . "&" .
					md5($order->id) . "&" . 
					md5($Subtotal_P) . "&" . 
					md5($MeanType) . "&" . 
					md5($EMoneyType) . "&" . 
					md5($Lifetime) . "&" . 
					md5($Customer_IDP) . "&" . 
					md5($Card_IDP) . "&" . 
					md5($IData) . "&" . 
					md5($PT_Code) . "&" . 
					md5($uniteller_password)
				)
			);





	if($settings['uniteller_test_action'])
		$action = 'https://test.wpay.uniteller.ru/pay/';	
	else
		$action = 'https://wpay.uniteller.ru/pay/';
		
	$button =	'<form action="'.$action.'" method="POST">'. 
					'<input type="hidden" name="Shop_IDP" value="'.$uniteller_shop_id.'">'. 
					'<input type="hidden" name="Order_IDP" value="'.$order->id.'">'. 
					'<input type="hidden" name="Subtotal_P" value="'.$Subtotal_P.'">'. 
					'<input type="hidden" name="Lifetime" value="'.$Lifetime.'">'. 
					'<input type="hidden" name="Signature" value="'.$Signature.'">'. 
					'<input type=submit class=checkout_button value="'.$button_text.'">'.
					'<input type="hidden" name="URL_RETURN_OK" value="'.$return_url.'">'.
					'<input type="hidden" name="URL_RETURN_NO" value="'.$return_url.'">'.
				'</form>';
			
		return $button;
	}
}
