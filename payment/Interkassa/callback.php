<?php

/**
 * Simpla CMS
 *
 * @copyright 	2012 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * К этому скрипту обращается Interkassa в процессе оплаты
 *
 */

// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();

////////////////////////////////////////////////
// Проверка статуса
////////////////////////////////////////////////
if($_POST['ik_payment_state'] !== 'success')
	die('bad status');

////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $simpla->orders->get_order(intval($_POST['ik_payment_id']));
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
$ik_shop_id = $_POST['ik_shop_id'];
$ik_payment_amount = $_POST['ik_payment_amount'];
$ik_payment_id = $_POST['ik_payment_id'];
$ik_payment_desc = $_POST['ik_payment_desc'];
$ik_paysystem_alias = $_POST['ik_paysystem_alias'];
$ik_baggage_fields = $_POST['ik_baggage_fields'];
$ik_payment_state = $_POST['ik_payment_state'];
$ik_trans_id = $_POST['ik_trans_id'];
$ik_currency_exch = $_POST['ik_currency_exch'];
$ik_fees_payer = $_POST['ik_fees_payer'];
$ik_sign_hash = $_POST['ik_sign_hash'];;

$secret_key = $settings['interkassa_secret_key'];
$ik_sign_hash_str = $ik_shop_id.':'.$ik_payment_amount.':'.$ik_payment_id.':'.$ik_paysystem_alias.':'.$ik_baggage_fields.':'.$ik_payment_state.':'.$ik_trans_id.':'.$ik_currency_exch.':'.$ik_fees_payer.':'.$secret_key;

if(strtoupper($ik_sign_hash) !== strtoupper(md5($ik_sign_hash_str)))
	die('bad sign');

// Нельзя оплатить уже оплаченный заказ  
if($order->paid)
	die('Этот заказ уже оплачен');

if($_POST['ik_payment_amount'] != round($simpla->money->convert($order->total_price, $method->currency_id, false), 2) || $_POST['ik_payment_amount']<=0)
	die("incorrect price");

// Установим статус оплачен
$simpla->orders->update_order(intval($order->id), array('paid'=>1));

// Отправим уведомление на email
$simpla->notify->email_order_user(intval($order->id));
$simpla->notify->email_order_admin(intval($order->id));

// Спишем товары  
$simpla->orders->close(intval($order->id));

exit();
