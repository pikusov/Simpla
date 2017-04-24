<?php

// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();

$data_return = $_POST;

// Сумма, которую заплатил покупатель. Дробная часть отделяется точкой.
$amount = $data_return['orderamount'];

// Внутренний номер покупки продавца
// В этом поле передается id заказа в нашем магазине.
$order_id = intval($data_return['ordernumber']);

// Проверим статус
if($data_return['orderstate'] !== 'Approved')
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
$my_sign = strtoupper(md5(strtoupper(md5($settings['assist_key']).md5($data_return['merchant_id'].$data_return['ordernumber'].$data_return['orderamount'].$data_return['ordercurrency'].$data_return['orderstate']))));
if($data_return['checkvalue'] !== $my_sign)
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
