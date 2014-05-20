<?php
	require_once('../../api/Simpla.php');
	$simpla = new Simpla();
	$limit = 100;
	
	if(!$simpla->managers->access('orders'))
		return false;
	
	$keyword = $simpla->request->get('query', 'string');

	$keywords = explode(' ', $keyword);
	$keyword_sql = '';
	foreach($keywords as $keyword)
	{
				$kw = $simpla->db->escape(trim($keyword));
				$keyword_sql .= $simpla->db->placehold("AND (p.name LIKE '%$kw%' OR p.meta_keywords LIKE '%$kw%' OR p.id in (SELECT product_id FROM __variants WHERE sku LIKE '%$kw%'))");
	}
	
	
	$simpla->db->query('SELECT p.id, p.name, i.filename as image FROM __products p
	                    LEFT JOIN __images i ON i.product_id=p.id AND i.position=(SELECT MIN(position) FROM __images WHERE product_id=p.id LIMIT 1)
	                    WHERE 1 '.$keyword_sql.' ORDER BY p.name LIMIT ?', $limit);
	foreach($simpla->db->results() as $product)
		$products[$product->id] = $product;
	
	$variants = array();
	if(!empty($products))
	{
		$simpla->db->query('SELECT v.id, v.name, v.price, IFNULL(v.stock, ?) as stock, (v.stock IS NULL) as infinity, v.product_id FROM __variants v WHERE v.product_id in(?@) AND (v.stock IS NULL OR v.stock>0) AND v.price>0 ORDER BY v.position', $simpla->settings->max_order_amount, array_keys($products));
		$variants = $simpla->db->results();
	}
	
	foreach($variants as $variant)
		if(isset($products[$variant->product_id]))
			$products[$variant->product_id]->variants[] = $variant;
	
	$suggestions = array();
	foreach($products as $product)
	{
		if(!empty($product->variants))
		{
			$suggestion = new stdClass;
			if(!empty($product->image))
				$product->image = $simpla->design->resize_modifier($product->image, 35, 35);
			$suggestion->value = $product->name;		
			$suggestion->data = $product;		
			$suggestions[] = $suggestion;
		}
	}

	$res = new stdClass;
	$res->query = $keyword;
	$res->suggestions = $suggestions;
	header("Content-type: application/json; charset=UTF-8");
	header("Cache-Control: must-revalidate");
	header("Pragma: no-cache");
	header("Expires: -1");		
	print json_encode($res);
