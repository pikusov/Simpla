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

class RestOrders extends Rest
{
	public function __construct()
	{		
		parent::__construct();
		if(!$this->managers->access('orders'))
		{
			header('HTTP/1.1 401 Unauthorized');
			exit();
		}
	}
	
	public function get()
	{
		$items = array();
		$filter = array();

		// id
		$filter['id'] = $this->request->get('id');
		// Сортировка
		$filter['status'] = $this->request->get('status');
		// Страница
		$filter['modified_since'] = $this->request->get('modified_since');
		// Страница
		$filter['page'] = $this->request->get('page');
		// Количество элементов на странице
		$filter['limit'] = $this->request->get('limit');
		
		// Какие поля отдавать
		if($fields = $this->request->get('fields'))
			$fields = explode(',', $fields);
			
		// Выбираем
		foreach($this->orders->get_orders($filter) as $item)
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
			if(in_array('purchases', $join))
			{
				foreach($this->orders->get_purchases(array('order_id'=>$items_ids)) as $i)
					if(isset($items[$i->order_id]))
						$items[$i->order_id]->purchases[] = $i;
			}				
		}
		return array_values($items);
	}
}