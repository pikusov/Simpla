<?php

/**
 * Simpla CMS
 *
 * @copyright	2012 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */
 
require_once('Rest.php');

class RestBlog extends Rest
{	
	public function __construct()
	{		
		parent::__construct();
		if(!$this->managers->access('categories'))
		{
			header('HTTP/1.1 401 Unauthorized');
			exit();
		}
	}

	public function fetch()
	{
		if($this->request->method('GET'))
			$result = $this->get();
		if($this->request->method('POST'))
			$result = $this->post();
		if($this->request->method('PUT'))
			$result = $this->put();
		if($this->request->method('DELETE'))
			$result = $this->delete();
			
		return $this->indent(json_encode($result));
	}

	public function get()
	{
		$fields = explode(',', $this->request->get('fields'));
		
		$ids = array();
		foreach(explode(',', $this->request->get('id')) as $id)
			if(($id = intval($id))>0)
				$ids[] = $id;
		
		$filter = array();
		if(!empty($ids))
			$filter['id'] = $ids;

		$filter['sort'] = $this->request->get('sort');
		$filter['category_id'] = $this->request->get('category_id');
		$filter['page'] = $this->request->get('page');
		$filter['limit'] = $this->request->get('limit');
		
		$products = array();
		foreach($this->blog->get_posts($filter) as $p)
		{
			$products[$p->id] = null;
			if($this->request->get('fields'))
			foreach($fields as $field)
			{
				if(isset($p->$field))
				$products[$p->id]->$field = $p->$field;
			}
			else
				$products[$p->id] = $p;
		}
		
		$products_ids = array_keys($products);

		if($join = $this->request->get('join'))
		{
			$join = explode(',', $join);
			if(in_array('images', $join))
			{
				foreach($this->products->get_images(array('product_id'=>$products_ids)) as $i)
					if(isset($products[$i->product_id]))
					{
						$products[$i->product_id]->images[$i->id] = $i;
					}
			}				
			if(in_array('variants', $join))
			{
				foreach($this->variants->get_variants(array('product_id'=>$products_ids)) as $v)
					if(isset($products[$v->product_id]))
						$products[$v->product_id]->variants[$v->id] = $v;
			}				
			if(in_array('categories', $join))
			{
				foreach($this->categories->get_products_categories(array('product_id'=>$products_ids)) as $pc)
				{
					if(isset($products[$pc->product_id]))
					{
						$products[$pc->product_id]["categories"][$pc->category_id] = $pc;
						$products[$pc->product_id]["categories"][$pc->category_id]->category = $this->categories->get_category(intval($pc->category_id));
					}
				}
			}				
		}
		return $products;
	}
	
	public function post_product()
	{
	
		if($this->request->method('POST'))
		{
			$product = json_decode($this->request->post());
			$variants = $product->variants;
			unset($product->variants);
	
			$id = $this->products->add_product($product);
	
			if(!empty($variants))
			{
				foreach($variants as $v)
				{
					$v->product_id = $id;
					$varinat_id = $this->variants->add_variant($v);
				}
			}
			if(!$id)
				return false;	
		}
		
		header("Content-type: application/json");		
		header("Location: ".$this->config->root_url."/simpla/rest/products/".$id, true, 201);
	}

	// Создать товар
	public function put_product()
	{		
 
	}

}

