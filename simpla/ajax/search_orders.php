<?php
	chdir('../..');
	require_once('api/Simpla.php');
	$simpla = new Simpla();
	$limit = 100;
	
	$keyword = $simpla->request->get('keyword', 'string');
	if($simpla->request->get('limit', 'integer'))
		$limit = $simpla->request->get('limit', 'integer');
	
	$orders = array_values($simpla->orders->get_orders(array('keyword'=>$keyword, 'limit'=>$limit)));
	

	header("Content-type: application/json; charset=UTF-8");
	header("Cache-Control: must-revalidate");
	header("Pragma: no-cache");
	header("Expires: -1");		
	print json_encode($orders);
