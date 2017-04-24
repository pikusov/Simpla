<?php

/**
 * Simpla CMS
 * 
 * @link		http://rlab.pro
 * @author		OsBen
 * @mail		php@rlab.pro
 *
 * Оплата через Интернет-эквайринг через Uniteller
 *
 */
 
// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();

mail('pikusov@gmail.com', 'uniteller', print_r($_POST, true));

$order_id = $simpla->request->post('Order_ID', 'integer');

$order = $simpla->orders->get_order(intval($order_id));
if(empty($order) && !empty($order_id))
	die('Оплачиваемый заказ не найден');


$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
$settings = unserialize($method->settings);
if($_POST["Signature"] = strtoupper(md5($order_id . $_POST["Status"] . $settings['uniteller_password'])))
{
	if( strtolower($_POST["Status"]) == 'authorized')
	{
		// Установим статус оплачен
		$simpla->orders->update_order(intval($order->id), array('paid'=>1));

		// Отправим уведомление на email
		$simpla->notify->email_order_user(intval($order->id));
		$simpla->notify->email_order_admin(intval($order->id));

		// Спишем товары  
		$simpla->orders->close(intval($order->id));

	}
}