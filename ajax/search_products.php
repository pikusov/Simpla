<?php
	chdir('..');
	require_once('api/Simpla.php');
	$simpla = new Simpla();
	$limit = 30;
	
	$keyword = $simpla->request->get('query', 'string');
	
	$simpla->db->query('SELECT p.id, p.name, i.filename as image FROM __products p
	                    LEFT JOIN __images i ON i.product_id=p.id AND i.position=(SELECT MIN(position) FROM __images WHERE product_id=p.id LIMIT 1)
	                    WHERE p.name LIKE "%'.mysql_real_escape_string($keyword).'%" AND visible=1 ORDER BY p.name LIMIT ?', $limit);
	$products = $simpla->db->results();

	foreach($products as $product)
	{
		if(!empty($product->image))
			{
				$product->image = $simpla->design->resize_modifier($product->image, 35, 35);
				$products_names[] = $product->name;
			}
		else
			$products_names[] = $product->name;	
				
		$products_data[] = $product;
	}

	$res->query = $keyword;
	$res->suggestions = $products_names;
	$res->data = $products_data;
	header("Content-type: application/json; charset=UTF-8");
	header("Cache-Control: must-revalidate");
	header("Pragma: no-cache");
	header("Expires: -1");		
	print json_encode($res);
