<?php

header("Content-type: text/html; charset=UTF-8");	
chdir ('../../');
require_once('api/Simpla.php');

$simpla = new Simpla();


function hmac($key, $data) {
		// Вычисление подписи методом HMAC
		$b = 64; // byte length for md5
		
		if ( strlen($key) > $b ) {
			$key = pack("H*",md5($key));
		}
		
		$key = str_pad($key, $b, chr(0x00));
		$k_ipad = $key ^ str_pad(null, $b, chr(0x36));
		$k_opad = $key ^ str_pad(null, $b, chr(0x5c));
		
		return md5($k_opad . pack("H*",md5($k_ipad . $data)));
}


$order_id = $_REQUEST['ext_transact'];
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

//Проверяем магазин
if($settings['num_shop']!=$_REQUEST['num_shop'])
	die('Ошибка проверки данных');
//Проверяем номер счета
if($settings['keyt_shop']!=$_REQUEST['keyt_shop'])
	die('Номер счета не совпадает');
   
// Нельзя оплатить уже оплаченный заказ  
if($order->paid){
	if($_REQUEST['check']=="1"){
		die('Этот заказ уже оплачен');
	}else{
		$url = $simpla->config->root_url.'/order/'.$order->url;
		header('location:'.$url);
		exit;
	}
}


////////////////////////////////////
// Проверка контрольной подписи
////////////////////////////////////

if($_REQUEST['check']=="1"){
	$param =  $_REQUEST['ext_transact'].$_REQUEST['num_shop'].$_REQUEST['keyt_shop'].$_REQUEST['identified'].$_REQUEST['sum'].$_REQUEST['comment'];
	$sign = hmac($settings['skeys'], $param);
}else{
	$param = $_REQUEST['transact'].$_REQUEST['status'].$_REQUEST['result'].$_REQUEST['ext_transact'].$_REQUEST['num_shop'].$_REQUEST['keyt_shop'].'1'.$_REQUEST['sum'].$_REQUEST['comment'];
	$sign = hmac($settings['skeys'],$param);
}

if ($sign != $_REQUEST['sign']){
	if($_REQUEST['check']=="1"){
		die("Контрольная подпись не верна");
	}else{
		$url = $simpla->config->root_url.'/order/'.$order->url;
		header('location:'.$url);
		exit;
	}
}

////////////////////////////////////
// Проверка суммы платежа
////////////////////////////////////
       
// Сумма заказа у нас в магазине
$order_amount = $simpla->money->convert($order->total_price, $method->currency_id, false);
       
// Должна быть равна переданной сумме
if(floatval($order_amount) !== floatval($_REQUEST['sum'])){
	if($_REQUEST['check']=="1"){
		die("Неверная сумма оплаты");
	}else{
		$url = $simpla->config->root_url.'/order/'.$order->url;
		header('location:'.$url);
		exit;
	}
}
	

////////////////////////////////////
// Проверка наличия товара
////////////////////////////////////
$purchases = $simpla->orders->get_purchases(array('order_id'=>intval($order->id)));
foreach($purchases as $purchase){
	$variant = $simpla->variants->get_variant(intval($purchase->variant_id));
	if(empty($variant) || (!$variant->infinity && $variant->stock < $purchase->amount)){
		if($_REQUEST['check']=="1"){
			die("Нехватка товара $purchase->product_name $purchase->variant_name");
		}else{
			$url = $simpla->config->root_url.'/order/'.$order->url;
			header('location:'.$url);
			exit;
		}
	}
}

if($_REQUEST['check']=="1"){
	die('ok');
}else{
	if($_REQUEST['result']=="0"){
		$simpla->orders->update_order(intval($order->id), array('paid'=>1));
		$simpla->orders->close(intval($order->id));
		$simpla->notify->email_order_user(intval($order->id));
		$simpla->notify->email_order_admin(intval($order->id));
		$datetime = new DateTime();
		$performedDatetime = $datetime->format('c');
	}
	$url = $simpla->config->root_url.'/order/'.$order->url;
	header('location:'.$url);
}

