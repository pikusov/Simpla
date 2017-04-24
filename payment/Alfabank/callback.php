<?php

/**
 * Simpla CMS
 *
 * @copyright 	2017 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * К этому скрипту обращается Альфа-Банк в процессе оплаты
 *
 */
 
// Работаем в корневой директории
chdir ('../../');
require_once('payment/Alfabank/Alfabank.php');
$alfa = new Alfabank();

$external_order_id = $_GET['orderId'];
$order_id = intval($_GET['o']);

$order = $alfa->orders->get_order(intval($order_id));
if(empty($order))
	errorlink('Оплачиваемый заказ не найден');
 
// Нельзя оплатить уже оплаченный заказ  
if($order->paid)
	errorlink('Этот заказ уже оплачен');

$method = $alfa->payment->get_payment_method(intval($order->payment_method_id));
if(empty($method))
	errorlink("Неизвестный метод оплаты");
 
$settings = unserialize($method->settings);
if(!empty($settings['alfabank_server']))
	$alfa->getaway_url = $settings['alfabank_server'];


$data = array(
	'userName' => $settings['alfabank_login'],
	'password' => $settings['alfabank_password'],
	'orderId' => $external_order_id
);

$response = $alfa->gateway('getOrderStatus.do', $data);

if ($response['ErrorCode'] !== 0)
{
	errorlink($response['ErrorMessage']);
}

if($response['Amount'] != 100*$alfa->money->convert($order->total_price, $method->currency_id, false) || $response['Amount']<=0)
	errorlink("incorrect price\n");

if($response['OrderNumber'] !=  $order->id)
	errorlink("incorrect order number\n");
     
// Установим статус оплачен
$alfa->orders->update_order(intval($order->id), array('paid'=>1));

// Спишем товары  
$alfa->orders->close(intval($order->id));
$alfa->notify->email_order_user(intval($order->id));
$alfa->notify->email_order_admin(intval($order->id));

header("Location: ".$alfa->config->root_url.'/order/'.$order->url);

function errorlink($message)
{
	print "$message<br>";
	print "<a href='".$alfa->config->root_url."/order/".$order->url."'>Вернуться на страницу заказа</a>";
	die();
}