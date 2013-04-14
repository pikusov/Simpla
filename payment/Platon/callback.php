<?php

/**
 * Simpla CMS
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * К этому скрипту обращается Platon в процессе оплаты
 *
 */

// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();

// Сумма, которую заплатил покупатель. Дробная часть отделяется точкой.
$amount = $_POST['amount'];

// Внутренний номер покупки продавца
// В этом поле передается id заказа в нашем магазине.
$order_id = intval($_POST['order']);

// Контрольная подпись
$sign = $_POST['sign'];

// Проверим статус
if($_POST['status'] !== 'SALE')
	die('Incorrect Status');

////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $simpla->orders->get_order(intval($order_id));
if(empty($order))
	die('Оплачиваемый заказ не найден');
 
// Нельзя оплатить уже оплаченный заказ  
if($order->paid)
	die('Этот заказ уже оплачен');


////////////////////////////////////////////////
// Выбираем из базы соответствующий метод оплаты
////////////////////////////////////////////////
$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
if(empty($method))
	die("Неизвестный метод оплаты");
 
$settings = unserialize($method->settings);

// Проверяем контрольную подпись
$my_sign = md5(strtoupper(strrev($_POST['email']).$settings['platon_password'].$order->id.strrev(substr($_POST['card'],0,6).substr($_POST['card'],-4))));
if($sign !== $my_sign)
	die("bad sign\n");

if($amount != $simpla->money->convert($order->total_price, $method->currency_id, false) || $amount<=0)
	die("incorrect price\n");
	
////////////////////////////////////
// Проверка наличия товара
////////////////////////////////////
$purchases = $simpla->orders->get_purchases(array('order_id'=>intval($order->id)));
foreach($purchases as $purchase)
{
	$variant = $simpla->variants->get_variant(intval($purchase->variant_id));
	if(empty($variant) || (!$variant->infinity && $variant->stock < $purchase->amount))
	{
		die("Нехватка товара $purchase->product_name $purchase->variant_name");
	}
}
       
// Установим статус оплачен
$simpla->orders->update_order(intval($order->id), array('paid'=>1));

// Спишем товары  
$simpla->orders->close(intval($order->id));
$simpla->notify->email_order_user(intval($order->id));
$simpla->notify->email_order_admin(intval($order->id));

die("OK".$order_id."\n");
