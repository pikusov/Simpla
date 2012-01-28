<?php

/**
 * Simpla CMS
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 * IPN Script for Paypal
 *
 */

// Working in root dir
chdir ('../../');

// Including simpla API
require_once('api/Simpla.php');
$simpla = new Simpla();


// Get the order
$order = $simpla->orders->get_order(intval($simpla->request->post('invoice')));
if(empty($order))
	die('Order not found');
 
// Get payment method from this order
$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));
if(empty($method))
	die("Unknown payment method");

// Payment method settings
$settings = unserialize($method->settings);
if($settings['mode'] == 'sandbox') $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
else $paypal_url = "https://www.paypal.com/cgi-bin/webscr";


// Verify transaction
$postdata = ""; 
foreach ($_POST as $key=>$value) $postdata.=$key."=".urlencode($value)."&"; 
$postdata .= "cmd=_notify-validate";  
$curl = curl_init($paypal_url); 
curl_setopt ($curl, CURLOPT_HEADER, 0);  
curl_setopt ($curl, CURLOPT_POST, 1); 
curl_setopt ($curl, CURLOPT_POSTFIELDS, $postdata); 
curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);  
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 1); 
$response = curl_exec($curl); 
curl_close ($curl); 
if ($response != "VERIFIED")
	die("Could not verify transaction");
	
// Check payment status
if($_POST["payment_status"] != "Completed" )
	die('Incorrect status '.$_POST["payment_status"].$_POST["pending_reason"]);

// Verify merchant email
if ($simpla->request->post('receiver_email') != $settings['business']) 
	die("Incorrect merchant email"); 

// Verify transaction type
if ($simpla->request->post('txn_type') != 'cart') 
	die("Incorrect txn_type"); 

// Is order already paid
if($order->paid)
	die('Duplicate payment');


////////////////////////////////////
// Verify total payment amount
////////////////////////////////////
$total_price = 0;

// Get order purchases
$purchases = $simpla->orders->get_purchases(array('order_id'=>intval($order->id)));
foreach($purchases as $purchase)
{			
	$price = $simpla->money->convert($purchase->price, $method->currency_id, false);
	$price = round($price, 2);
	$total_price += $price*$purchase->amount;
}
// Substract the discount
if($order->discount)
{
	$total_price *= (100-$order->discount)/100;
	$total_price = round($total_price, 2);
}
// Adding delivery price
if($order->delivery_id && !$order->separate_delivery && $order->delivery_price>0)
{
	$delivery_price = $simpla->money->convert($order->delivery_price, $payment_method->currency_id, false);
	$delivery_price =round($delivery_price, 2);
	$total_price += $delivery_price;
}
if($total_price != $simpla->request->post('mc_gross'))
	die("Incorrect total price (".$total_price."!=".$simpla->request->post('mc_gross').")");
       
// Set order status paid
$simpla->orders->update_order(intval($order->id), array('paid'=>1));

// Write off products
$simpla->orders->close(intval($order->id));
$simpla->notify->email_order_user(intval($order->id));
$simpla->notify->email_order_admin(intval($order->id));


function logg($str)
{
	file_put_contents('payment/Paypal/log.txt', file_get_contents('payment/Paypal/log.txt')."\r\n".date("m.d.Y H:i:s").' '.$str);
}
