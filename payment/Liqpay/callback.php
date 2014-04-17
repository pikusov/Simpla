<?php

/**
 * Simpla CMS
 *
 * @copyright 	2014 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * К этому скрипту обращается Liqpay в процессе оплаты
 *
 */

// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();

// Выбираем из xml нужные данные
$public_key		 	= $simpla->request->post('public_key');
$amount				= $simpla->request->post('amount');
$currency			= $simpla->request->post('currency');
$description		= $simpla->request->post('description');
$liqpay_order_id	= $simpla->request->post('order_id');
$order_id			= intval(substr($liqpay_order_id, 0, strpos($liqpay_order_id, '-')));
$type				= $simpla->request->post('type');
$signature			= $simpla->request->post('signature');
$status				= $simpla->request->post('status');
$transaction_id		= $simpla->request->post('transaction_id');
$sender_phone		= $simpla->request->post('sender_phone');

if($status !== 'success')
	die("bad status");

if($type !== 'buy')
	die("bad type");

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
$payment_currency = $simpla->money->get_currency(intval($method->currency_id));

// Валюта должна совпадать
if($currency !== $payment_currency->code)
	die("bad currency");

// Проверяем контрольную подпись
$mysignature = base64_encode(sha1($settings['liqpay_private_key'].$amount.$currency.$public_key.$liqpay_order_id.$type.$description.$status.$transaction_id.$sender_phone, 1));
if($mysignature !== $signature)
	die("bad sign".$signature);

// Нельзя оплатить уже оплаченный заказ  
if($order->paid)
	die('order already paid');

if($amount != round($simpla->money->convert($order->total_price, $method->currency_id, false), 2) || $amount<=0)
	die("incorrect price");
	       
// Установим статус оплачен
$simpla->orders->update_order(intval($order->id), array('paid'=>1));

// Отправим уведомление на email
$simpla->notify->email_order_user(intval($order->id));
$simpla->notify->email_order_admin(intval($order->id));

// Спишем товары  
$simpla->orders->close(intval($order->id));

// Перенаправим пользователя на страницу заказа
// header('Location: '.$simpla->config->root_url.'/order/'.$order->url);

exit();