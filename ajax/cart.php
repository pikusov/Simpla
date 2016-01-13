<?php
	session_start();
	require_once('../api/Simpla.php');
	$simpla = new Simpla();
	$simpla->cart->add_item($simpla->request->get('variant', 'integer'), $simpla->request->get('amount', 'integer'));
	$cart = $simpla->cart->get_cart();
	$simpla->design->assign('cart', $cart);
	
	$currencies = $simpla->money->get_currencies(array('enabled'=>1));
	if(isset($_SESSION['currency_id']))
		$currency = $simpla->money->get_currency($_SESSION['currency_id']);
	else
		$currency = reset($currencies);

	$simpla->design->assign('currency',	$currency);
	
	$result = $simpla->design->fetch('cart_informer.tpl');

	header("Content-type: application/json; charset=UTF-8");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("X-Robots-Tag: noindex");
	header("Pragma: no-cache");
	header("Expires: -1");
	print json_encode($result);
	exit;
