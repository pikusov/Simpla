<?php

require_once('api/Simpla.php');

class Receipt extends Simpla
{

	public function checkout_form($order_id)
	{
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_settings = $this->payment->get_payment_settings($payment_method->id);
		
		$amount = $this->money->convert($order->total_price, $payment_method->currency_id, false);
		//	подготовить данные
		$recipient = $payment_settings['recipient'];
		$inn = $payment_settings['inn'];
		$account = $payment_settings['account'];
		$bank = $payment_settings['bank'];
		$bik = $payment_settings['bik'];
		$correspondent_account = $payment_settings['correspondent_account'];		
		
		$button = "<FORM class='form' ACTION='".$this->config->root_url."/payment/Receipt/callback.php' METHOD='POST'>
					<INPUT TYPE='HIDDEN' NAME='recipient' VALUE='".$payment_settings['recipient']."'>
					<INPUT TYPE='HIDDEN' NAME='inn' VALUE='".$payment_settings['inn']."'>
					<INPUT TYPE='HIDDEN' NAME='account' VALUE='".$payment_settings['account']."'>
					<INPUT TYPE='HIDDEN' NAME='bank' VALUE='".$payment_settings['bank']."'>
					<INPUT TYPE='HIDDEN' NAME='bik' VALUE='".$payment_settings['bik']."'>
					<INPUT TYPE='HIDDEN' NAME='correspondent_account' VALUE='".$payment_settings['correspondent_account']."'>
					<INPUT TYPE='HIDDEN' NAME='banknote' VALUE='".$payment_settings['banknote']."'>
					<INPUT TYPE='HIDDEN' NAME='pence' VALUE='".$payment_settings['pense']."'>
					<INPUT TYPE='HIDDEN' NAME='order_id' VALUE='$order->id'>
					<INPUT TYPE='HIDDEN' NAME='amount' VALUE='".$amount."'>
					<label>Имя плательщика: </label><INPUT TYPE='text' NAME='name' VALUE=''>
					<label>Адрес плательщика: </label><INPUT TYPE='text' NAME='address' VALUE=''>
					<INPUT class=checkout_button TYPE='submit' VALUE='Сформировать квитанцию  &#8594;'>
					</FORM>";
		
		return $button;
	}
}
