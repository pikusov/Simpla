<?php

/**
 * Simpla CMS
 *
 * @copyright	2011 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */

require_once('Simpla.php');

class Orders extends Simpla
{

	public function get_order($id)
	{
		if(is_int($id))
			$where = $this->db->placehold(' WHERE id=? ', intval($id));
		else
			$where = $this->db->placehold(' WHERE url=? ', $id);
		
		$query = $this->db->placehold("SELECT * FROM __orders $where LIMIT 1");

		if($this->db->query($query))
			return $this->db->result();
		else
			return false; 
	}
	
	function get_orders($filter = array())
	{
		// По умолчанию
		$limit = 100;
		$page = 1;
		$keyword_filter = '';	
		$status_filter = '';
		$user_filter = '';	
		$modified_from_filter = '';	
		$id_filter = '';
		
		if(isset($filter['limit']))
			$limit = max(1, intval($filter['limit']));

		if(isset($filter['page']))
			$page = max(1, intval($filter['page']));

		$sql_limit = $this->db->placehold(' LIMIT ?, ? ', ($page-1)*$limit, $limit);
		
			
		if(isset($filter['status']))
			$status_filter = $this->db->placehold('AND o.status = ?', intval($filter['status']));
		
		if(isset($filter['id']))
			$id_filter = $this->db->placehold('AND o.id in(?@)', (array)$filter['id']);
		
		if(isset($filter['user_id']))
			$user_filter = $this->db->placehold('AND o.user_id = ?', intval($filter['user_id']));
		
		if(isset($filter['modified_from']))
			$modified_from_filter = $this->db->placehold('AND o.modified > ?', $filter['modified_from']);
		
		if(!empty($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND o.name LIKE "%'.mysql_real_escape_string(trim($keyword)).'%" ');
		}
		
		// Выбираем заказы
		$query = $this->db->placehold("SELECT id, delivery_id, delivery_price, separate_delivery, payment_method_id, paid, payment_date, closed, discount, date,
									user_id, name, address, phone, email, comment, status, url, total_price, note
									FROM __orders AS o 
									WHERE 1
									$id_filter $status_filter $user_filter $keyword_filter $modified_from_filter ORDER BY status, id DESC $sql_limit", "%Y-%m-%d");
		$this->db->query($query);
		$orders = array();
		foreach($this->db->results() as $order)
			$orders[$order->id] = $order;
		return $orders;
	}

	function count_orders($filter = array())
	{
		$keyword_filter = '';	
		$status_filter = '';
		$user_filter = '';	
		
		if(isset($filter['status']))
			$status_filter = $this->db->placehold('AND o.status = ?', intval($filter['status']));
		
		if(isset($filter['user_id']))
			$user_filter = $this->db->placehold('AND o.user_id = ?', intval($filter['user_id']));
		
		if(!empty($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND o.name LIKE "%'.mysql_real_escape_string(trim($keyword)).'%" ');
		}
		
		// Выбираем заказы
		$query = $this->db->placehold("SELECT COUNT(DISTINCT id) as count
									FROM __orders AS o 
									WHERE 1
									$status_filter $user_filter $keyword_filter");
		$this->db->query($query);
		return $this->db->result('count');
	}

	public function update_order($id, $order)
	{
		$query = $this->db->placehold("UPDATE __orders SET ?%, modified=now() WHERE id=? LIMIT 1", $order, intval($id));
		$this->db->query($query);
		$this->update_total_price(intval($id));
		return $id;
	}

	public function delete_order($id)
	{
		if(!empty($id))
		{
			$query = $this->db->placehold("DELETE FROM __purchases WHERE order_id=? LIMIT 1", $id);
			$this->db->query($query);
			
			$query = $this->db->placehold("DELETE FROM __orders WHERE id=? LIMIT 1", $id);
			$this->db->query($query);
		}
	}
	
	public function add_order($order)
	{
		$order = (object)$order;
		$order->url = md5(uniqid($this->config->salt, true));
		$set_curr_date = '';
		if(empty($order->date))
			$set_curr_date = ', date=now()';
		$query = $this->db->placehold("INSERT INTO __orders SET ?%$set_curr_date", $order);
		$this->db->query($query);
		$id = $this->db->insert_id();		
		return $id;
	}


	public function get_purchase($id)
	{
		$query = $this->db->placehold("SELECT * FROM __purchases WHERE id=? LIMIT 1", $id);
		$this->db->query($query);
		return $this->db->result();
	}

	public function get_purchases($filter = array())
	{
		$order_id_filter = '';
		if(!empty($filter['order_id']))
			$order_id_filter = $this->db->placehold('AND order_id in(?@)', (array)$filter['order_id']);

		$query = $this->db->placehold("SELECT * FROM __purchases WHERE 1 $order_id_filter ORDER BY id");
		$this->db->query($query);
		return $this->db->results();
	}
	
	public function update_purchase($id, $purchase)
	{	
		$purchase = (object)$purchase;
		$old_purchase = $this->get_purchase($id);
		if(!$old_purchase)
			return false;
			
		$order = $this->get_order(intval($old_purchase->order_id));
		if(!$order)
			return false;
			
		// Если заказ закрыт, нужно обновить склад при изменении покупки
		if($order->closed && !empty($purchase->amount))
		{
			if($old_purchase->variant_id != $purchase->variant_id)
			{
				if(!empty($old_purchase->variant_id))
				{
					$query = $this->db->placehold("UPDATE __variants SET stock=stock+? WHERE id=? AND stock IS NOT NULL LIMIT 1", $old_purchase->amount, $old_purchase->variant_id);
					$this->db->query($query);
				}
				if(!empty($purchase->variant_id))
				{
					$query = $this->db->placehold("UPDATE __variants SET stock=stock-? WHERE id=? AND stock IS NOT NULL LIMIT 1", $purchase->amount, $purchase->variant_id);
					$this->db->query($query);
				}
			}
			elseif(!empty($purchase->variant_id))
			{
				$query = $this->db->placehold("UPDATE __variants SET stock=stock+(?) WHERE id=? AND stock IS NOT NULL LIMIT 1", $old_purchase->amount - $purchase->amount, $purchase->variant_id);
				$this->db->query($query);
			}
		}
		
		$query = $this->db->placehold("UPDATE __purchases SET ?% WHERE id=? LIMIT 1", $purchase, intval($id));
		$this->db->query($query);
		$this->update_total_price($order->id);		
		return $id;
	}
	
	public function add_purchase($purchase)
	{
		$purchase = (object)$purchase;
		if(!empty($purchase->variant_id))
		{
			$variant = $this->variants->get_variant($purchase->variant_id);
			if(empty($variant))
				return false;
			$product = $this->products->get_product(intval($variant->product_id));
			if(empty($product))
				return false;
		}			

		$order = $this->get_order(intval($purchase->order_id));
		if(empty($order))
			return false;				
	
		
		if(!isset($purchase->product_id) && isset($variant))
			$purchase->product_id = $variant->product_id;
				
		if(!isset($purchase->product_name)  && !empty($product))
			$purchase->product_name = $product->name;
			
		if(!isset($purchase->sku) && !empty($variant))
			$purchase->sku = $variant->sku;
			
		if(!isset($purchase->variant_name) && !empty($variant))
			$purchase->variant_name = $variant->name;
			
		if(!isset($purchase->price) && !empty($variant))
			$purchase->price = $variant->price;
			
		if(!isset($purchase->amount))
			$purchase->amount = 1;

		// Если заказ закрыт, нужно обновить склад при добавлении покупки
		if($order->closed && !empty($purchase->amount) && !empty($variant->id))
		{
			$stock_diff = $purchase->amount;
			$query = $this->db->placehold("UPDATE __variants SET stock=stock-? WHERE id=? AND stock IS NOT NULL LIMIT 1", $stock_diff, $variant->id);
			$this->db->query($query);
		}

		$query = $this->db->placehold("INSERT INTO __purchases SET ?%", $purchase);
		$this->db->query($query);
		$purchase_id = $this->db->insert_id();
		
		$this->update_total_price($order->id);		
		return $purchase_id;
	}

	public function delete_purchase($id)
	{
		$purchase = $this->get_purchase($id);
		if(!$purchase)
			return false;
			
		$order = $this->get_order(intval($purchase->order_id));
		if(!$order)
			return false;

		// Если заказ закрыт, нужно обновить склад при изменении покупки
		if($order->closed && !empty($purchase->amount))
		{
			$stock_diff = $purchase->amount;
			$query = $this->db->placehold("UPDATE __variants SET stock=stock+? WHERE id=? AND stock IS NOT NULL LIMIT 1", $stock_diff, $purchase->variant_id);
			$this->db->query($query);
		}
		
		$query = $this->db->placehold("DELETE FROM __purchases WHERE id=? LIMIT 1", intval($id));
		$this->db->query($query);
		$this->update_total_price($order->id);				
		return true;
	}

	
	public function close($order_id)
	{
		$order = $this->get_order(intval($order_id));
		if(empty($order))
			return false;
		
		if(!$order->closed)
		{
			$purchases = $this->get_purchases(array('order_id'=>$order->id));
			foreach($purchases as $purchase)
			{
				$variant = $this->variants->get_variant($purchase->variant_id);
				if(empty($variant) || ($variant->stock<$purchase->amount))
					return false;
			}
			foreach($purchases as $purchase)
			{	
				if(!$variant->infinity)
				{
					$new_stock = $variant->stock-$purchase->amount;
					$this->variants->update_variant($variant->id, array('stock'=>$new_stock));
				}
			}				
			$query = $this->db->placehold("UPDATE __orders SET closed=1, modified=NOW() WHERE id=? LIMIT 1", $order->id);
			$this->db->query($query);
		}
		return $order->id;
	}
	
	public function open($order_id)
	{
		$order = $this->get_order(intval($order_id));
		if(empty($order))
			return false;
		
		if($order->closed)
		{
			$purchases = $this->get_purchases(array('order_id'=>$order->id));
			foreach($purchases as $purchase)
			{
				$variant = $this->variants->get_variant($purchase->variant_id);
				
				if($variant && !$variant->infinity)
				{
					$new_stock = $variant->stock+$purchase->amount;
					$this->variants->update_variant($variant->id, array('stock'=>$new_stock));
				}
			}				
			$query = $this->db->placehold("UPDATE __orders SET closed=0, modified=NOW() WHERE id=? LIMIT 1", $order->id);
			$this->db->query($query);
		}
		return $order->id;
	}
	
	public function pay($order_id)
	{
		$order = $this->get_order(intval($order_id));
		if(empty($order))
			return false;
		
		if(!$this->close($order->id))
		{
			return false;
		}
		$query = $this->db->placehold("UPDATE __orders SET payment_status=1, payment_date=NOW(), modified=NOW() WHERE id=? LIMIT 1", $order->id);
		$this->db->query($query);
		return $order->id;
	}
	
	private function update_total_price($order_id)
	{
		$order = $this->get_order(intval($order_id));
		if(empty($order))
			return false;
		
		$query = $this->db->placehold("UPDATE __orders o SET o.total_price=IFNULL((SELECT SUM(p.price*p.amount)*(100-o.discount)/100 FROM __purchases p WHERE p.order_id=o.id), 0)+o.delivery_price*(1-o.separate_delivery), modified=NOW() WHERE o.id=? LIMIT 1", $order->id);
		$this->db->query($query);
		return $order->id;
	}
	

	public function get_next_order($id, $status = null)
	{
		$f = '';
		if($status!==null)
			$f = $this->db->placehold('AND status=?', $status);
		$this->db->query("SELECT MIN(id) as id FROM __orders WHERE id>? $f LIMIT 1", $id);
		$next_id = $this->db->result('id');
		if($next_id)
			return $this->get_order(intval($next_id));
		else
			return false; 
	}
	
	public function get_prev_order($id, $status = null)
	{
		$f = '';
		if($status !== null)
			$f = $this->db->placehold('AND status=?', $status);
		$this->db->query("SELECT MAX(id) as id FROM __orders WHERE id<? $f LIMIT 1", $id);
		$prev_id = $this->db->result('id');
		if($prev_id)
			return $this->get_order(intval($prev_id));
		else
			return false; 
	}
}
