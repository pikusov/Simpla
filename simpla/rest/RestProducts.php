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

class RestProducts extends Rest
{	
	public function get()
	{
		$items = array();
		$filter = array();

		// id
		$filter['id'] = array();
		foreach(explode(',', $this->request->get('id')) as $id)
			if(($id = intval($id)) > 0)
				$filter['id'][] = $id;

		// Сортировка
		$filter['sort'] = $this->request->get('sort');
		// Категория
		$filter['category_id'] = $this->request->get('category');
		// Бренд
		$filter['brand_id'] = $this->request->get('brand');
		// Страница
		$filter['page'] = $this->request->get('page');
		// Количество элементов на странице
		$filter['limit'] = $this->request->get('limit');
		
		// Какие поля отдавать
		if($fields = $this->request->get('fields'))
			$fields = explode(',', $fields);
		// Выбираем
		foreach($this->products->get_products($filter) as $item)
		{
			$items[$item->id] = new stdClass();
			if($fields)
			{
				foreach($fields as $field)
					if(isset($item->$field))
						$items[$item->id]->$field = $item->$field;
			}
			else
				$items[$item->id] = $item;
		}
		if(empty($items))
			return false;
		
		// Выбранные id
		$items_ids = array_keys($items);

		// Присоединяемые данные
		if($join = $this->request->get('join'))
		{
			$join = explode(',', $join);
			// Изображения
			if(in_array('images', $join))
			{
				foreach($this->products->get_images(array('product_id'=>$items_ids)) as $i)
					if(isset($items[$i->product_id]))
						$items[$i->product_id]->images[] = $i;
			}				
			// Варианты
			if(in_array('variants', $join))
			{
				foreach($this->variants->get_variants(array('product_id'=>$items_ids)) as $v)
					if(isset($items[$v->product_id]))
						$items[$v->product_id]->variants[] = $v;
			}
			// Категории
			$categories_ids = array();	
			if(in_array('categories', $join))
			{
				foreach($this->categories->get_products_categories(array('product_id'=>$items_ids)) as $pc)
				{
					if(isset($items[$pc->product_id]))
					{
						$c = $pc;
						$c = $this->categories->get_category(intval($pc->category_id));
						unset($c->path);
						unset($c->subcategories);
						unset($c->children);
						$items[$pc->product_id]->categories[] = $c;
						$categories_ids[] = $pc->category_id;
					}
				}
			}			
			// Свойства		
			if(in_array('features', $join))
			{
				$features_ids = array();
				foreach($this->features->get_options(array('product_id'=>$items_ids)) as $o)
				{
					if(isset($items[$o->product_id]))
					{
						$options[$o->feature_id] = $o;
						$features_ids[] = $o->feature_id;
					}
				}
				foreach($this->features->get_features(array('id'=>$features_ids)) as $f)
				{
					if(isset($options[$f->id]))
					{
						$f->value = $o->value;
						$items[$o->product_id]->features[] = $f;
					}
				}
			}				
		}
		return array_values($items);
	}
	
	public function post()
	{
		$product = json_decode($this->request->post());
		print_r($product);
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
		else
			return $id;

		header("Content-type: application/json");		
		header("Location: ".$this->config->root_url."/simpla/rest/products/".$id, true, 201);
	}

	public function put()
	{
		$id = intval($this->request->get('id'));
		if(empty($id) || !$this->products->get_product($id))
		{
			header("HTTP/1.0 404 Not Found");
			exit();
		}

		$product = json_decode($this->request->post());
		$variants = $product->variants;
		unset($product->variants);

		$id = $this->products->update_product($id, $product);

		if(!empty($variants))
		{
			$variants_ids = array();
			foreach($variants as $v)
			{
				$v->product_id = $id;

				if($v->stock == '∞' || $v->stock == '')
					$v->stock = null;

				if($v->id)
					$this->variants->update_variant($v->id, $v);
				else
				{
					$v->product_id = $id;
					$v->id = $this->variants->add_variant($v);
				}
				$variants_ids[] = $v->id;

				// Удалить непереданные варианты
				$current_variants = $this->variants->get_variants(array('product_id'=>$id));
				foreach($current_variants as $current_variant)
					if(!in_array($current_variant->id, $variants_ids))
						$this->variants->delete_variant($current_variant->id);
			}			
		}
		if(!$id)
			return false;	
		else
			return $id;

		header("Content-type: application/json");		
		header("Location: ".$this->config->root_url."/simpla/rest/products/".$id, true, 201);
	}
}
