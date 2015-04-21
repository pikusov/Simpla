<?php

/**
 * Simpla CMS
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * К этому скрипту обращается RBKMoney в процессе оплаты
 *
 */
 
 
// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();
/*--------------------------------------------------------------------------------*/
function from_request($name)
{
	return isset($_REQUEST[$name]) ? htmlspecialchars(stripslashes($_REQUEST[$name])) : null;
}
/*---Данные из POST----------------------------------------------------------------*/
$eshopId = from_request('eshopId');
$orderId = from_request('orderId');
$serviceName = from_request('serviceName');
$eshopAccount = from_request('eshopAccount');
$recipientAmount = from_request('recipientAmount');
$recipientCurrency = from_request('recipientCurrency');
$paymentStatus = from_request('paymentStatus');
$userName = from_request('userName');
$userEmail = from_request('userEmail');
$paymentData = from_request('paymentData');
$hash = from_request('hash');



////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $simpla->orders->get_order(intval($orderId));
if(empty($order))
	die('Оплачиваемый заказ не найден');
	
////////////////////////////////////////////////
// Выбираем из базы соответствующий метод оплаты
////////////////////////////////////////////////
$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
if(empty($method))
	die("Неизвестный метод оплаты");
 
$settings = unserialize($method->settings);

$secret_key = $settings['im_secret_key'];
// Проверяем контрольную подпись
/*----------------------------------------------------------*/
$control_hash_str = implode('::', array(
				$eshopId,
				$orderId,
				$serviceName, $eshopAccount, $recipientAmount, $recipientCurrency,
				$paymentStatus, $userName, $userEmail, $paymentData,
				$secret_key ,
			));
			//print_r($control_hash_str);die;
$control_hash = md5($control_hash_str);
$control_hash_utf8 = md5(iconv('windows-1251', 'utf-8', $control_hash_str));

if (($hash != $control_hash && $hash != $control_hash_utf8) || !$hash)
	die ("error\n");     
else{
/*----------------------------------------------*/
	//Статус платежа (paymentStatus); 
	$status = $paymentStatus;
	if($status == 3)
		die("OK");
	if($status == 5)
	{
		// Нельзя оплатить уже оплаченный заказ  
		if($order->paid)
			die('Этот заказ уже оплачен');

		// Сумма заказа у нас в магазине
		// Должна быть равна переданной сумме
		if($recipientAmount != $simpla->money->convert($order->total_price, $method->currency_id, false) || $recipientAmount<=0)
			die("incorrect price\n");

			   
		// Установим статус оплачен
		$simpla->orders->update_order(intval($order->id), array('paid'=>1));

		// Спишем товары  
		$simpla->orders->close(intval($order->id));
		$simpla->notify->email_order_user(intval($order->id));
		$simpla->notify->email_order_admin(intval($order->id));
	}
/*---------------------------------------------*/
}	
 die('error');