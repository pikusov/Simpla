<?php
	chdir('../..');
	require_once('api/Simpla.php');
	$simpla = new Simpla();
	$limit = 100;

	
	$keyword = $simpla->request->get('query', 'string');
	$feature_id = $simpla->request->get('feature_id', 'string');
	
	$query = $simpla->db->placehold('SELECT DISTINCT po.value FROM __options po
										WHERE value LIKE "'.mysql_real_escape_string($keyword).'%" AND feature_id=? ORDER BY po.value LIMIT ?', $feature_id, $limit);

	$simpla->db->query($query);
		
	$options = $simpla->db->results('value');

	$res->query = $keyword;
	$res->suggestions = $options;
	header("Content-type: application/json; charset=UTF-8");
	header("Cache-Control: must-revalidate");
	header("Pragma: no-cache");
	header("Expires: -1");		
	print json_encode($res);
