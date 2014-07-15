<?php

require_once('api/Simpla.php');

class InvoiceBox extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Оплатить';
		
		$order 			= $this->orders->get_order((int)$order_id);
		$payment_method 	= $this->payment->get_payment_method($order->payment_method_id);
		$payment_currency 	= $this->money->get_currency(intval($payment_method->currency_id));
		$payment_settings 	= $this->payment->get_payment_settings($payment_method->id);

		// регистрационная информация (идентификаторы)
		// invoicebox_participant_id
		// invoicebox_participant_ident
		// invoicebox_participant_apikey
		$participant_id 	= $payment_settings['invoicebox_participant_id'];
		$participant_ident 	= $payment_settings['invoicebox_participant_ident'];
		$participant_apikey 	= $payment_settings['invoicebox_participant_apikey'];
		$timelimit		= $payment_settings['invoicebox_timelimit'];
		if ( $timelimit )
		{
			$timelimit = time() + 86400 * $timelimit;
		}; //
		if ( !$timelimit || $timelimit < time() )
		{
			$timelimit = time() + 86400 * 7;
		}; //
		$timelimit		= date( "Y-m-d", $timelimit ) . "T" . date( "H:i:s", $timelimit );

		$itransfer_order_amount	= $this->money->convert($order->total_price, $payment_method->currency_id, false);
		$itransfer_order_amount	= number_format( $itransfer_order_amount, 2, '.', '');

		$itransfer_url_success	= $this->config->root_url.'/order/'.$order->url;
		$itransfer_url_fail	= $this->config->root_url.'/order/'.$order->url;
				
		$itransfer_order_quantity	= 1;
		$participant_order_id	= $order->id;
		$participant_description= 'Оплата заказа №' . $participant_order_id;
		$itransfer_language	= $payment_settings['language'];

		$personName		= $order->name;
		$personEmail		= $order->email;
		$personPhone		= $order->phone;

		$participant_sign 	= md5(
				$participant_id .
				$participant_order_id .
				$itransfer_order_amount .
				$itransfer_order_quantity .
				$timelimit . 
				$personName .
				$personEmail .
				$personPhone .
				$participant_apikey
		); //
		$shp_item 		= $payment_method->id;
	
		$button =	"<form action='https://go.invoicebox.ru/module_inbox_auto.u' method='post'>".
					"<input type='hidden' name='itransfer_participant_id' 		value='" . $participant_id . "'/>".
					"<input type='hidden' name='itransfer_participant_ident' 	value='" . $participant_ident . "'/>".
					"<input type='hidden' name='itransfer_participant_sign' 	value='" . $participant_sign . "'/>".

					"<input type='hidden' name='itransfer_order_id' 		value='" . $participant_order_id . "'/>".
					"<input type='hidden' name='itransfer_order_amount' 		value='" . $itransfer_order_amount . "'/>".
					"<input type='hidden' name='itransfer_order_quantity' 		value='" . $itransfer_order_quantity . "'/>".
					"<input type='hidden' name='itransfer_order_description'	value='" . $participant_description . "'/>".

					"<input type='hidden' name='itransfer_person_name'		value='" . $personName . "'/>".
					"<input type='hidden' name='itransfer_person_email'		value='" . $personEmail . "'/>".
					"<input type='hidden' name='itransfer_person_phone'		value='" . $personPhone . "'/>".

					"<input type='hidden' name='itransfer_order_currency_ident'	value='RUR'/>".
					"<input type='hidden' name='itransfer_scheme_id'		value='DEFAULT'/>".
					"<input type='hidden' name='itransfer_language_ident'		value='" . $itransfer_language . "'/>".
					"<input type='hidden' name='itransfer_encoding'			value='utf-8'/>".

					"<input type='hidden' name='itransfer_url_return'		value='" . $itransfer_url_success . "'/>".
					"<input type='hidden' name='itransfer_url_cancel'		value='" . $itransfer_url_fail . "'/>".

					"<input type='submit' class='checkout_button' 			value='$button_text' />".
					"</form>";
		return $button;
	}

}