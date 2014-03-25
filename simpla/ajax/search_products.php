<?php
	chdir('../..');
	require_once('api/Simpla.php');
	$simpla = new Simpla();
	$limit = 100;
	
	$keyword = $simpla->request->get('query', 'string');
	
	$simpla->db->query('SELECT p.id, p.name, i.filename as image FROM __products p
	                    LEFT JOIN __images i ON i.product_id=p.id AND i.position=(SELECT MIN(position) FROM __images WHERE product_id=p.id LIMIT 1)
	                    WHERE p.name LIKE "%'.$simpla->db->escape($keyword).'%" ORDER BY p.name LIMIT ?', $limit);
	$products = $simpla->db->results();

	$suggestions = array();
	foreach($products as $product)
	{
		if(!empty($product->image))
			$product->image = $simpla->design->resize_modifier($product->image, 35, 35);
		
		$suggestion = new stdClass();
		$suggestion->value = $product->name;
		$suggestion->data = $product;
		$suggestions[] = $suggestion;
	}
	
	$res = new stdClass;
	$res->query = $keyword;
	$res->suggestions = $suggestions;
	header("Content-type: application/json; charset=UTF-8");
	header("Cache-Control: must-revalidate");
	header("Pragma: no-cache");
	header("Expires: -1");		
	print json_encode($res);
