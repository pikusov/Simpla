<?php

// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();

////////////////////////////////////////////////
// Проверка статуса
////////////////////////////////////////////////
if($_POST['transaction_status'] !== 'PURCHASE')
	die('bad status');

////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $simpla->orders->get_order(intval($_POST['cf']));
if(empty($order))
	die('Оплачиваемый заказ не найден');
 
////////////////////////////////////////////////
// Выбираем из базы соответствующий метод оплаты
////////////////////////////////////////////////
$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
if(empty($method))
	die("Неизвестный метод оплаты");
	
$settings = unserialize($method->settings);
$payment_currency = $simpla->money->get_currency(intval($method->currency_id));

////////////////////////////////////////////////
// Проверка id магазина
////////////////////////////////////////////////
if($settings['interkassa_shop_id'] !== $_POST['ik_shop_id'])
	die('bad shop id');

// Проверяем контрольную подпись
$merchant_id = $_POST['merchant_id'];
$payment_id = $_POST['payment_id'];
$status = $_POST['status'];
$cf = $_POST['cf'];
$cf2 = $_POST['cf2'];
$cf3 = $_POST['cf3'];
$sign = $_POST['sign'];

$secret_key = $settings['acquiropay_sw'];

$sign_str = $merchant_id.$payment_id.$status.$cf.$cf2.$cf3.$secret_key;

if(strtoupper($sign) !== strtoupper(md5($sign_str)))
	die('bad sign');

// Нельзя оплатить уже оплаченный заказ  
if($order->paid)
	die('Этот заказ уже оплачен');

if($_POST['amount'] != round($simpla->money->convert($order->total_price, $method->currency_id, false), 2) || $_POST['amount']<=0)
	die("incorrect price");

// Установим статус оплачен
$simpla->orders->update_order(intval($order->id), array('paid'=>1));

// Отправим уведомление на email
$simpla->notify->email_order_user(intval($order->id));
$simpla->notify->email_order_admin(intval($order->id));

// Спишем товары  
$simpla->orders->close(intval($order->id));

exit();
