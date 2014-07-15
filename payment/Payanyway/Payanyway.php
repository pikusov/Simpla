<?php

require_once('api/Simpla.php');

class Payanyway extends Simpla
{	
	public function checkout_form($order_id, $button_text = null)
	{
		if(empty($button_text))
			$button_text = 'Перейти к оплате';
		
		$order = $this->orders->get_order((int)$order_id);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_settings = $this->payment->get_payment_settings($payment_method->id);
		$payment_currency = $this->money->get_currency(intval($payment_method->currency_id));
		
		$price = number_format($this->money->convert($order->total_price, $payment_method->currency_id, false), 2, '.', '');
		
		$success_url = $this->config->root_url.'/order/'.$order->url;
		$fail_url = $this->config->root_url.'/order/'.$order->url;
				
		// метод оплаты - текущий
		$payment_system = explode('_', $payment_settings['payment_system']);

		// формирование подписи
		$currency_code = ($payment_currency->code == 'RUR')?'RUB':$payment_currency->code;
		$signature  = md5($payment_settings['MNT_ID'].$order->id.$price.$currency_code.$payment_settings['MNT_TEST_MODE'].$payment_settings['MNT_DATAINTEGRITY_CODE']);

		if ($payment_system[1]){
			$url = "https://".$payment_settings['payment_url']."/assistant.htm";
		} else {
			$url = $this->config->root_url.'/payment/Payanyway/callback.php?invoice=true';
		}
			
		$button =	"<form class='form' action='".$url."' method=POST>".
					"<input type=hidden name=payment_system value='".$payment_system[0]."'>".
					"<input type=hidden name=MNT_ID value='".$payment_settings['MNT_ID']."'>".
					"<input type=hidden name=MNT_TRANSACTION_ID value='".$order->id."'>".
					"<input type=hidden name=MNT_AMOUNT value='$price'>".
					"<input type=hidden name=MNT_CURRENCY_CODE value='".$currency_code."'>".
					"<input type=hidden name=MNT_SIGNATURE value='".$signature."'>".
					"<input type=hidden name=MNT_SUCCESS_URL value='".$success_url."'>".
					"<input type=hidden name=MNT_FAIL_URL value='".$fail_url."'>"
				;
		if ($payment_system[0] !== "payanyway") {
			$button .= "<input type=hidden name=followup value='true'>";
			$button .= "<input type=hidden name=javascriptEnabled value='true'>";
		}
		if (!empty($payment_system[2])) {
			$button .= "<input type=hidden name=paymentSystem.unitId value='".$payment_system[2]."'>";
		}
		if (isset($payment_system[4])) {
			/* for old version */
			if (!empty($payment_system[4]))
				$button .= "<input type=hidden name=paymentSystem.accountId value='".$payment_system[4]."'>";
		} else {
			/* new version */
			if (!empty($payment_system[3])) {
				$button .= "<input type=hidden name=paymentSystem.accountId value='".$payment_system[3]."'>";
			}
		}
		switch ($payment_system[0])
		{
			case 'post':
				$button .= "<label>Индекс отправителя</label>";
				$button .= "<input type=text name='additionalParameters.mailofrussiaSenderIndex' value=''>";
				$button .= "<label>Регион (или город федерального значения) отправителя</label>";
				$button .= "<input type=text name='additionalParameters.mailofrussiaSenderRegion' value=''>";
				$button .= "<label>Адрес отправителя</label>";
				$button .= "<input type=text name='additionalParameters.mailofrussiaSenderAddress' value=''>";
				$button .= "<label>Имя отправителя</label>";
				$button .= "<input type=text name='additionalParameters.mailofrussiaSenderName' value=''>";
				break;
			case 'webmoney':
				$button .= "<label>Источник оплаты</label>";
				$button .= "<select name='paymentSystem.accountId'>";
				$button .= "<option value='2'>WMR</option>";
				$button .= "<option value='3'>WMZ</option>";
				$button .= "<option value='4'>WME</option>";
				$button .= "</select>";
				break;
			case 'moneymail':
				$button .= "<label>E-mail в MoneyMail</label>";
				$button .= "<input type='text' name='additionalParameters.buyerEmail' data-format='email' data-notice='Введите email' value=''>";
				break;
			case 'euroset':
				$button .= "<label>Номер телефона</label>";
				$button .= "<input type='text' name='additionalParameters.rapidaPhone' data-format='(\+)(7)(\d){10,20}' data-notice='Введите номер телефона в формате +71234567890' value=''>";
				break;
			case 'dengimail':
				$button .= "<label>E-mail в системе Деньги@Mail.Ru</label>";
				$button .= "<input type='text' name='additionalParameters.dmrBuyerEmail' data-format='email' data-notice='Введите email' value=''>";
				break;
			case 'alfaclick':
				$button .= "<label>Логин в интернет-банке</label>";
				$button .= "<input type='text' name='additionalParameters.alfaIdClient' value=''>";
				$button .= "<label>Назначение платежа</label>";
				$button .= "<input type='text' name='additionalParameters.alfaPaymentPurpose' value='PayAnyWay invoice'>";
				break;
			case 'mts':
				$button .= "<label>Номер телефона</label>";
				$button .= "<input type='text' name='additionalParameters.smsmsPhone' data-format='(7)(\d){10}' data-notice='Введите номер телефона в формате: 71234567890' value=''>";
				break;
			case 'qiwi':
				$button .= "<label>Номер телефона</label>";
				$button .= "<input type='text' name='additionalParameters.qiwiUser' value='' data-format='(\d){10}' data-notice='Номер телефона вводится без \"8\"'>";
				$button .= "<label>Комментарий</label>";
				$button .= "<input type='text' name='additionalParameters.qiwiComment' value=''>";
				break;
		}
				
		$button .=  "<input type=submit class=checkout_button value='Перейти к оплате &#8594;'>".
					"</form>";
		return $button;
	}

}