<?php

chdir ('../../');
require_once('api/Simpla.php');

$simpla = new Simpla();
$status  = 'failed';
if(isset($_POST['status']))
{
	$status = $_POST['status'];
}
//file_put_contents('answer.txt',serialize($_POST));
// Сумма платежа
// Сумма, которую заплатил покупатель. Дробная часть отделяется точкой.
$amount = $_POST['price'];

$order_id = $_POST['orderId'];

$marchantId = $_POST['merchantId'];

$manderinBankTransactionId = $_POST['transaction'];

$customerEmail = $_POST['customer_email'];
$customerPhone = $_POST['customer_phone'];
$action = $_POST['action'];

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
       
if($status == 'failed')
{
	$simpla->orders->update_order($order_id, array('note'=>$order->note .' '. ' Оплата прошла с ошибкой (status faild)'));
	die("Оплата прошла с ошибкой (status faild)");
}

// Сумма заказа у нас в магазине
$order_amount = $simpla->money->convert($order->total_price, $method->currency_id, false);
       
// Должна быть равна переданной сумме
if($order_amount != $amount || $amount<=0)
{
	$simpla->orders->update_order($order_id, array('note'=>$order->note .' '. "Неверная сумма оплаты MandarinBank"));
	die("Неверная сумма оплаты");
}

if($marchantId != $settings['merchantId'])
{
	$simpla->orders->update_order($order_id, array('note'=>$order->note .' '. "Неверный id мерчанта (возможно попытка подмены)"));
	die("Неверный id мерчанта");
}

if(!check_sign($settings['secret'],$_POST)){
	$simpla->orders->update_order($order_id, array('note'=>$order->note .' '. "Неверный sign"));
	die("Неверный sign");
}


$note = $order->note . ' Статус'. $status .' Email: '. $customerEmail.' Телефон: '.$customerPhone .' Действие:'. $action;
// Установим статус оплачен
$simpla->orders->update_order(intval($order->id), array('paid'=>1,'note'=>$note));

// Спишем товары
$simpla->orders->close(intval($order->id));


$simpla->notify->email_order_user(intval($order->id));
$simpla->notify->email_order_admin(intval($order->id));

function check_sign($secret,$fields)
{
	$signAnswer = $fields['sign'];
	$sign = calc_sign($secret,$fields);
	return $sign == $signAnswer;
}

function calc_sign($secret, $fields)
{
	if(isset($fields['sign'])){
		unset($fields['sign']);
	}
	ksort($fields);
	$secret_t = '';
	foreach($fields as $key => $val)
	{
		$secret_t = $secret_t . '-' . $val;
	}
	$secret_t = substr($secret_t, 1) . '-' . $secret;
	return hash("sha256", $secret_t);
}

die("Yes");