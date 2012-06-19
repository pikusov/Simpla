<?php

/**
 * Simpla CMS
 *
 * @copyright 	2012 Pay2Pay
 * @link 	http://pay2pay.com
 * @author 	Sergey Mihaylovskiy
 *
 * К этому скрипту обращается Pay2Pay в процессе оплаты
 *
 */

function get_tag_val($xml, $name)
{
  preg_match("/<$name>(.*)<\/$name>/i", $xml, $matches);
  return trim($matches[1]); 
}

// Работаем в корневой директории
chdir ('../../');
require_once('api/Simpla.php');
$simpla = new Simpla();


$xml_post = base64_decode(str_replace(' ', '+', $_REQUEST['xml']));
$sign_post = base64_decode(str_replace(' ', '+', $_REQUEST['sign']));

// Выбираем из xml нужные данные
$order_id      = intval(get_tag_val($xml_post, 'order_id'));
$merchant_id   = get_tag_val($xml_post, 'merchant_id'); 
$amount        = get_tag_val($xml_post, 'amount'); 
$currency_code = get_tag_val($xml_post, 'currency'); 
$status        = get_tag_val($xml_post, 'status'); 

$err = '';

////////////////////////////////////////////////
// Выберем заказ из базы
////////////////////////////////////////////////
$order = $simpla->orders->get_order(intval($order_id));
if(!empty($order))
{ 
  ////////////////////////////////////////////////
  // Выбираем из базы соответствующий метод оплаты
  ////////////////////////////////////////////////
  $method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
  if(!empty($method))
  {
  	
    $settings = unserialize($method->settings);
    $payment_currency = $simpla->money->get_currency(intval($method->currency_id));
    
    // Проверяем контрольную подпись
    $mysignature = md5($settings['pay2pay_hidden'].$xml_post.$settings['pay2pay_hidden']);
    if($mysignature == $sign_post)
    {
    
      // Нельзя оплатить уже оплаченный заказ  
      if (!$order->paid)
      {
        if($amount >= round($simpla->money->convert($order->total_price, $method->currency_id, false), 2))
        {
          $currency = $payment_currency->code;
          if ($currency == 'RUR')
            $currency = 'RUB';
          if($currency_code == $currency)
          {
            if($status == 'success')
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
          else
            $err = "Currency check failed";
        }
        else
          $err = "Amount check failed";  
      }
      //else
      //  $err = 'Order is paid';
    }
    else
      $err = "Security check failed";
  }
  else
    $err = "Unknown payment method";
}
else
  $err = "Unknown OrderId";

if ($err != '')
  die("<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>no</status><err_msg>$err</err_msg></response>");
else
  die("<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>yes</status><err_msg></err_msg></response>");