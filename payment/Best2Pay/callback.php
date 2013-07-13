<?php

/**
 * Simpla CMS
 *
 * @copyright 	2013 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * К этому скрипту обращается best2pay в процессе оплаты
 *
 */

// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();

$xml = file_get_contents('php://input');
$xml = simplexml_load_string($xml);
$response = json_decode(json_encode($xml));


if($response->type != 'PURCHASE' || $response->state != 'APPROVED')
	exit();
	
// Сумма, которую заплатил покупатель
$amount = $response->amount/100;

// Внутренний номер покупки продавца
// В этом поле передается id заказа в нашем магазине.
$order_id = $response->reference;

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
 
// Проверяем контрольную подпись
$settings = unserialize($method->settings);
$signature = $response->signature;
unset($response->signature);
$str = implode('', (array)$response).$settings['password'];
print $my_signature = base64_encode(md5($str));
if($my_signature !== $signature)
	die("bad sign\n");


$mrh_pass2 = $settings['password2'];

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


die("ok");
