<?php
	require_once('../api/Simpla.php');
	$simpla = new Simpla();
	$limit = 30;
	
	$keyword = $simpla->request->get('query', 'string');
	$kw = $simpla->db->escape($keyword);
	$kw = preg_replace('/\s{2,}/', ' ', trim($kw));
	$kw_array = explode(' ', $kw);
	$kw_filter = '';
	foreach ($kw_array as $kw1) {
		$kw_filter .= $simpla->db->placehold("AND (p.name LIKE '%$kw1%' OR p.meta_keywords LIKE '%$kw1%' OR p.id in (SELECT product_id FROM __variants WHERE sku LIKE '%$kw1%')) ");
	}

	$simpla->db->query("SELECT p.id, p.name, i.filename as image FROM __products p
						LEFT JOIN __images i ON i.product_id=p.id AND i.position=(SELECT MIN(position) FROM __images WHERE product_id=p.id LIMIT 1)
						WHERE 1
						$kw_filter
						AND visible=1 
						GROUP BY p.id
						ORDER BY p.name 
						LIMIT ?", $limit);
	$products = $simpla->db->results();

	$suggestions = array();
	
	foreach($products as $product)
	{
		$suggestion = new stdClass();
		if(!empty($product->image))
			$product->image = $simpla->design->resize_modifier($product->image, 35, 35);
			
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
