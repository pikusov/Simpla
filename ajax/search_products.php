<?php
	require_once('../api/Simpla.php');

	class SearchProductsAjax extends Simpla
	{
		private $limit = 30;
		public function fetch()
		{
			$result = new stdClass;
			$result->suggestions = array();
			$result->query = $this->request->get('query', 'string');
			
			if(!empty($result->query))
			{
				$kw = $this->db->escape($result->query);

				$this->db->query("SELECT p.id, p.name, i.filename as image FROM __products p
									LEFT JOIN __images i ON i.product_id=p.id AND i.position=(SELECT MIN(position) FROM __images WHERE product_id=p.id LIMIT 1)
									WHERE (p.name LIKE '%$kw%' OR p.meta_keywords LIKE '%$kw%' OR p.id in (SELECT product_id FROM __variants WHERE sku LIKE '%$kw%'))
									AND visible=1
									GROUP BY p.id
									ORDER BY p.name
									LIMIT ?", $this->limit);
				$products = $this->db->results();

				$suggestions = array();

				foreach($products as $product)
				{
					$suggestion = new stdClass();

					if(!empty($product->image))
						$product->image = $this->design->resize_modifier($product->image, 35, 35);

					$suggestion->value = $product->name;
					$suggestion->data = $product;
					$result->suggestions[] = $suggestion;
				}
			}


			return $result;
		}
	}

	$cart_ajax = new SearchProductsAjax();
	$result = $cart_ajax->fetch();

	header("Content-type: application/json; charset=UTF-8");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("X-Robots-Tag: noindex, noarchive, nosnippet");
	header("Pragma: no-cache");
	header("Expires: -1");
	print json_encode($result);
	exit;
