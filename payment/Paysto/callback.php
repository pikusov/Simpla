<?php

/**
 * Simpla CMS
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * К этому скрипту обращается webmoney в процессе оплаты
 *
 */
 
// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');

$simpla = new Simpla();

// Это предварительный запрос?
if(isset($_POST['PAYSTO_REQUEST_MODE']) && $_POST['PAYSTO_REQUEST_MODE']=='CHECK')
{
	$pre_request = 1;
}
elseif(isset($_POST['PAYSTO_REQUEST_MODE']) && $_POST['PAYSTO_REQUEST_MODE']=='RES_PAID')
{
	$pre_request = 0;
}
else
{
	exit();
}

// Кошелек продавца
// Кошелек продавца, на который покупатель совершил платеж. Формат - буква и 12 цифр.
$merchant_purse = $_POST['LMI_PAYEE_PURSE'];
       
// Внутренний номер покупки продавца
// В этом поле передается id заказа в нашем магазине.
$order_id = $_POST['PAYSTO_INVOICE_ID'];

// Контрольная подпись
$hash = $_POST['PAYSTO_MD5'];

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
       
////////////////////////////////////
// Проверка контрольной подписи
////////////////////////////////////
$params = $_POST;
unset($params['PAYSTO_MD5']);
uksort($params, 'strcasecmp');	
$temp = array();
foreach($params as $param=>$val)
	$temp[] = "$param=$val";
$temp[] = $settings['paysto_secret_key'];
$my_hash = strtoupper(md5(implode('&', $temp)));

if($my_hash !== $hash)
{
	die("Контрольная подпись не верна");
}

////////////////////////////////////
// Проверка суммы платежа
////////////////////////////////////

// Сумма заказа у нас в магазине
$order_amount = $simpla->money->convert($order->total_price, $method->currency_id, false);

// Должна быть равна переданной сумме
if(floatval($order_amount) !== floatval($_POST['PAYSTO_SUM']) || $order_amount<=0)
	die("Неверная сумма оплаты");

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
       
// Запишем
if(!$pre_request)
{
	// Установим статус оплачен
	$simpla->orders->update_order(intval($order->id), array('paid'=>1));

	// Спишем товары  
	$simpla->orders->close(intval($order->id));
}

if(!$pre_request)
{
	$simpla->notify->email_order_user(intval($order->id));
	$simpla->notify->email_order_admin(intval($order->id));
}

die($order->id);
