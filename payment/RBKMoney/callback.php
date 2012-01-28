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

// Сумма платежа
// Сумма, которую заплатил покупатель. Дробная часть отделяется точкой.
$amount = $_POST['recipientAmount'];

//Номер сайта продавца (eshopId);
$shop_id = $_POST['eshopId'];
//Номер счета продавца (orderId); 
$order_id = $_POST['orderId'];
//Описание покупки (serviceName); 
$order_description = $_POST['serviceName'];
//Номер счета в системе RBK Money (eshopAccount); 
$eshopAccount = $_POST['eshopAccount'];
//Валюта платежа (recipientCurrency); 
$currency = $_POST['recipientCurrency'];
//Статус платежа (paymentStatus); 
$status = $_POST['paymentStatus'];
if($status != 5)
	exit();
//Имя покупателя (userName); 
$username = $_POST['userName'];
//Email покупателя (userEmail); 
$email = $_POST['userEmail'];

$paymentData = $_POST['paymentData'];
$crc = $_POST['hash'];


////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $simpla->orders->get_order(intval($order_id));
if(empty($order))
	die('Оплачиваемый заказ не найден');
	
////////////////////////////////////////////////
// Выбираем из базы соответствующий метод оплаты
////////////////////////////////////////////////
$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
if(empty($method))
	die("Неизвестный метод оплаты");
 
$settings = unserialize($method->settings);

$secret_key = $settings['rbkmoney_secret_key'];
// Проверяем контрольную подпись
$my_crc = md5("$shop_id::$order_id::$order_description::$eshopAccount::$amount::$currency::$status::$username::$email::$paymentData::$secret_key");  

if(strtoupper($my_crc) != strtoupper($crc))
	die ("bad sign\n");     
 
// Нельзя оплатить уже оплаченный заказ  
if($order->paid)
	die('Этот заказ уже оплачен');

// Сумма заказа у нас в магазине
// Должна быть равна переданной сумме
if($amount != $simpla->money->convert($order->total_price, $method->currency_id, false) || $amount<=0)
	die("incorrect price\n");

	
// Проверка наличия товара для RBK не актуальна, так как платёж проходит независимо от нашего ответа
/*
$purchases = $simpla->orders->get_purchases($order->id);
foreach($purchases as $purchase)
{
	$variant = $simpla->variants->get_variant(intval($purchase->variant_id));
	if(empty($variant) || (!$variant->infinity && $variant->stock < $purchase->amount))
	{
		die("Нехватка товара $purchase->product_name $purchase->variant_name");
	}
}
*/
       
// Установим статус оплачен
$simpla->orders->update_order(intval($order->id), array('paid'=>1));

// Спишем товары  
$simpla->orders->close(intval($order->id));
$simpla->notify->email_order_user(intval($order->id));
$simpla->notify->email_order_admin(intval($order->id));

die("OK".$order_id."\n");
