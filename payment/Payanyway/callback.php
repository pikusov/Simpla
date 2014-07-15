<?php

// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();

require_once('view/PawInvoiceView.php');
$pawView = new PawInvoiceView();

if (isset($_REQUEST['invoice']))
{
	$order = $simpla->orders->get_order(intval($_REQUEST['MNT_TRANSACTION_ID']));
	$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
	$settings = unserialize($method->settings);
	
	require_once (dirname(__FILE__).'/MonetaAPI/MonetaWebService.php');
	switch ($settings['payment_url'])
	{
		case 'www.payanyway.ru':
			$service = new MonetaWebService("https://www.moneta.ru/services.wsdl", $settings['payanyway_login'], $settings['payanyway_password']);
			break;
		case 'demo.moneta.ru':
			$service = new MonetaWebService("https://demo.moneta.ru/services.wsdl", $settings['payanyway_login'], $settings['payanyway_password']);
			break;
	}

	$invoice = array();
	try
	{
		// запрос стоимости и комиссии
		$transactionRequestType = new MonetaForecastTransactionRequest();
		$transactionRequestType->payer = $_REQUEST['paymentSystem_accountId'];
		$transactionRequestType->payee = $_REQUEST['MNT_ID'];
		$transactionRequestType->amount = $_REQUEST['MNT_AMOUNT'];
		$transactionRequestType->clientTransaction = $_REQUEST['MNT_TRANSACTION_ID'];
		$forecast = $service->ForecastTransaction($transactionRequestType);

		// получить данные счета
		$request = new MonetaInvoiceRequest();
		$request->payer = $_REQUEST['paymentSystem_accountId'];
		$request->payee = $_REQUEST['MNT_ID'];
		$request->amount = $_REQUEST['MNT_AMOUNT'];
		$request->clientTransaction = $_REQUEST['MNT_TRANSACTION_ID'];

		if ($_REQUEST['payment_system'] == 'post')
		{
			$operationInfo = new MonetaOperationInfo();
			$a = new MonetaKeyValueAttribute();
			$a->key = 'mailofrussiaindex';
			$a->value = $_REQUEST['additionalParameters_mailofrussiaSenderIndex'];
			$operationInfo->addAttribute($a);
			$a1 = new MonetaKeyValueAttribute();
			$a1->key = 'mailofrussiaregion';
			$a1->value = $_REQUEST['additionalParameters_mailofrussiaSenderRegion'];
			$operationInfo->addAttribute($a1);
			$a2 = new MonetaKeyValueAttribute();
			$a2->key = 'mailofrussiaaddress';
			$a2->value = $_REQUEST['additionalParameters_mailofrussiaSenderAddress'];
			$operationInfo->addAttribute($a2);
			$a3 = new MonetaKeyValueAttribute();
			$a3->key = 'mailofrussianame';
			$a3->value = $_REQUEST['additionalParameters_mailofrussiaSenderName'];
			$operationInfo->addAttribute($a3);
			$request->operationInfo = $operationInfo;
		}
		elseif ($_REQUEST['payment_system'] == 'euroset')
		{
			$operationInfo = new MonetaOperationInfo();
			$a1 = new MonetaKeyValueAttribute();
			$a1->key = 'rapidamphone';
			$a1->value = $_REQUEST['additionalParameters_rapidaPhone'];
			$operationInfo->addAttribute($a1);
			$request->operationInfo = $operationInfo;
		}
		$response = $service->Invoice($request);

		if ($_REQUEST['payment_system'] == 'euroset')
		{
			$response1 = $service->GetOperationDetailsById($response->transaction);
			foreach ($response1->operation->attribute as $attr)
			{
				if ($attr->key == 'rapidatid')
				{
					$transaction_id = $attr->value;
				}
			}
		}
		else
		{
			$transaction_id = $response->transaction;//(!empty($response->transaction))?$response->transaction:$response->clientTransaction;
		}
		
		$invoice['status'] = $response->status;
		$invoice['transaction'] = str_pad($transaction_id, 9, "0", STR_PAD_LEFT);
		$invoice['system'] = $_REQUEST['payment_system'];
		$invoice['amount'] = $_REQUEST['MNT_AMOUNT']." ".$_REQUEST['MNT_CURRENCY_CODE'];
		$invoice['payerAmount'] = number_format($forecast->payerAmount, 2, '.', '')." ".$forecast->payerCurrency;
		$invoice['payerFee'] = number_format($forecast->payerFee, 2, '.', '');
		$invoice['unitid'] = $_REQUEST['paymentSystem_unitId'];
	}
	catch (Exception $e)
	{
		$invoice['status'] = 'FAILED';
		$invoice['error_message'] = $e->getMessage();
		$invoice['transaction'] = $_REQUEST['MNT_TRANSACTION_ID'];
	}

	$pawView->design->assign('invoice', $invoice);
	
	print $pawView->fetch();
}
else
{
	if(isset($_REQUEST['MNT_ID']) && isset($_REQUEST['MNT_TRANSACTION_ID']) && isset($_REQUEST['MNT_OPERATION_ID'])
	   && isset($_REQUEST['MNT_AMOUNT']) && isset($_REQUEST['MNT_CURRENCY_CODE']) && isset($_REQUEST['MNT_TEST_MODE'])
	   && isset($_REQUEST['MNT_SIGNATURE']))
	{
		$order = $simpla->orders->get_order(intval($_REQUEST['MNT_TRANSACTION_ID']));
		if(empty($order))
			die('FAIL');

		$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
		if(empty($method))
			die("FAIL");

		$settings = unserialize($method->settings);

		$mnt_sugnature = md5("{$_REQUEST['MNT_ID']}{$_REQUEST['MNT_TRANSACTION_ID']}{$_REQUEST['MNT_OPERATION_ID']}{$_REQUEST['MNT_AMOUNT']}{$_REQUEST['MNT_CURRENCY_CODE']}{$_REQUEST['MNT_TEST_MODE']}".$settings['MNT_DATAINTEGRITY_CODE']);

		if ($_REQUEST['MNT_SIGNATURE'] == $mnt_sugnature)
		{
			// Установим статус оплачен
			$simpla->orders->update_order(intval($order->id), array('paid'=>1));

			// Спишем товары
			$simpla->orders->close(intval($order->id));
			$simpla->notify->email_order_user(intval($order->id));
			$simpla->notify->email_order_admin(intval($order->id));

			die('SUCCESS');
		} 
		else
		{
			die('FAIL');
		}
	} 
	else
	{
		die('FAIL');
	}
}