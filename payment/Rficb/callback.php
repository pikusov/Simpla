<?php

/**
 * Simpla CMS
 *
 * @copyright 	2014 Romanof
 * @link 		http://simplacms.ru
 * @author 		Romanof
 *
 * К этому скрипту обращается Rficb в процессе оплаты
 *
 */

// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();

////////////////////////////////////////////////
// Проверка статуса
////////////////////////////////////////////////
//if($_POST['payment_state'] !== 'success')
//	die('bad status');

////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $simpla->orders->get_order(intval($_POST['order_id']));
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

// Проверяем контрольную подпись
$in_data = array(  'tid'    =>  $_POST['tid'],
                   'name'           =>  $_POST['name'], 
                   'comment'        =>  $_POST['comment'],
                   'partner_id'     =>  $_POST['partner_id'],
                   'service_id'     =>  $_POST['service_id'],
                   'order_id'       =>  $_POST['order_id'],
                   'type'           =>  $_POST['type'],
                   'partner_income' =>  $_POST['partner_income'],
                   'system_income'  =>  $_POST['system_income'],
                   'test'           =>  $_POST['test']
                );
       $transaction_sign = md5(implode('', array_values($in_data)) . $settings['rficb_secret_key']);
       
if ($transaction_sign !== $_POST['check'] || empty($settings['rficb_secret_key']))
	die('bad sign');

// Нельзя оплатить уже оплаченный заказ  
if($order->paid)
	die('Этот заказ уже оплачен');

if($_POST['system_income'] != round($simpla->money->convert($order->total_price, $method->currency_id, false), 2) || $_POST['system_income']<=0)
	die("incorrect price");

// Установим статус оплачен
$simpla->orders->update_order(intval($order->id), array('paid'=>1));
echo 'OK';
// Отправим уведомление на email
$simpla->notify->email_order_user(intval($order->id));
$simpla->notify->email_order_admin(intval($order->id));

// Спишем товары  
$simpla->orders->close(intval($order->id));

exit();
