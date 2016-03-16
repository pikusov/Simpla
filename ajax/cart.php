<?php
	session_start();
	require_once('../api/Simpla.php');
	
	class CartAjax extends Simpla
	{
		public function fetch()
		{
			$this->cart->add_item($this->request->get('variant', 'integer'), $this->request->get('amount', 'integer'));
			$cart = $this->cart->get_cart();
			$this->design->assign('cart', $cart);

			$currencies = $this->money->get_currencies(array('enabled'=>1));
			if(isset($_SESSION['currency_id']))
				$currency = $this->money->get_currency($_SESSION['currency_id']);
			else
				$currency = reset($currencies);

			$this->design->assign('currency',	$currency);

			return $this->design->fetch('cart_informer.tpl');
		}
	}

	$cart_ajax = new CartAjax();
	$result = $cart_ajax->fetch();

	header("Content-type: application/json; charset=UTF-8");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("X-Robots-Tag: noindex");
	header("Pragma: no-cache");
	header("Expires: -1");
	print json_encode($result);
	exit;
