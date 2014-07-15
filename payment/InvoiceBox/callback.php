<?php

// Participant Default HTTP method

// Работаем в корневой директории
chdir ('../../');

// Подключаем симплу
require_once('api/Simpla.php');
$simpla = new Simpla();

$participantId		= isset( $_REQUEST["participantId"] ) ? intval( $_REQUEST["participantId"] ) : false;
$participantOrderId	= isset( $_REQUEST["participantOrderId"] ) ? trim( $_REQUEST["participantOrderId"] ) : false;
$ucode			= isset( $_REQUEST["ucode"] ) ? trim( $_REQUEST["ucode"] ) : false;
$timetype		= isset( $_REQUEST["timetype"] ) ? trim( $_REQUEST["timetype"] ) : false;
$time			= isset( $_REQUEST["time"] ) ? trim( $_REQUEST["time"] ) : false;
$amount			= isset( $_REQUEST["amount"] ) ? trim( $_REQUEST["amount"] ) : false;
$agentName		= isset( $_REQUEST["agentName"] ) ? trim( $_REQUEST["agentName"] ) : false;
$agentPointName		= isset( $_REQUEST["agentPointName"] ) ? trim( $_REQUEST["agentPointName"] ) : false;
$testMode		= isset( $_REQUEST["testMode"] ) ? intval( $_REQUEST["testMode"] ) : false;
$sign			= isset( $_REQUEST["sign"] ) ? trim( $_REQUEST["sign"] ) : false;

// -------------------------------------------------------------------------------------------------------------------

if ( !$participantOrderId )
{
	die( "Идентификатор заказа не передан" );
}; //


// Выбираем оплачиваемый заказ
$order = $simpla->orders->get_order(intval($participantOrderId));
if ( empty( $order ) )
{
	die( "Указанный заказ не обнаружен в системе" );
}; //

// Выбираем из базы соответствующий метод оплаты
$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
if(empty($method))
{
	die( "Ошибка получения информации о способе оплаты по заказу" );
}; //


// Настройки способа оплаты	
$payment_settings 	= @unserialize($method->settings);
$participant_id 	= $payment_settings['invoicebox_participant_id'];
$participant_ident 	= $payment_settings['invoicebox_participant_ident'];
$participant_apikey 	= $payment_settings['invoicebox_participant_apikey'];

if ( $participant_id != $participantId )
{
	die( "Идентификатор поставщика в настройках не соответствует переданному" );
}; //

$crc	= md5(
		$participantId .
		$participantOrderId .
		$ucode .
		$timetype .
		$time .
		$amount .
		$agentName .
		$agentPointName .
		$participant_apikey
); //
if ( $crc != $sign )
{
	die( "Подпись запроса неверна" );
}; //


// Нельзя оплатить уже оплаченный заказ 
if($order->paid)
{
	die( "OK" ); // Уж оплачен?
}; //


// Проверка наличия товара
$purchases = $simpla->orders->get_purchases(array('order_id'=>intval($order->id)));
foreach($purchases as $purchase)
{
	$variant = $simpla->variants->get_variant(intval($purchase->variant_id));
	if(empty($variant) || (!$variant->infinity && $variant->stock < $purchase->amount))
	{
		die( "Один или несколько товаров в заказе отсутствует" ); // Зачем это знать платежной системе?
	}; //if
}; //foreach

	
// Установим статус оплачен
$simpla->orders->update_order(intval($order->id), array('paid'=>1));
	
// Спишем товары  
$simpla->orders->close(intval($order->id));
$simpla->notify->email_order_user(intval($order->id));
$simpla->notify->email_order_admin(intval($order->id));

die( "OK" );


