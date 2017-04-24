<?php
if ($_SERVER['REMOTE_ADDR'] !== '185.30.16.166') {
	header('HTTP/1.0 401 Unauthorized');
	echo "Error 401";
	return;
}

chdir ('../../');
require_once('api/Simpla.php');

$simpla = new Simpla();

$order = $simpla->orders->get_order(intval($_POST['order_id']));
$method = $simpla->payment->get_payment_method(intval($order->payment_method_id));

$settings = unserialize($method->settings);

$sign = md5(
	trim($settings['chronopay_sharedSec']).
	$_POST['customer_id'].
	$_POST['transaction_id'].
	$_POST['transaction_type'].
	$_POST['total']
);

if($sign == $_POST['sign']) {
	$simpla->orders->update_order(intval($order->id), array('paid'=>1));

	$simpla->orders->close(intval($order->id));
	$simpla->notify->email_order_user(intval($order->id));
	$simpla->notify->email_order_admin(intval($order->id));
}