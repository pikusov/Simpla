<?php

/**
 * Simpla CMS
 *
 * @copyright	2016 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */

require_once('Simpla.php');

class Delivery extends Simpla
{

	public function get_delivery($id)
	{
		$query = $this->db->placehold("SELECT d.id, d.name, d.description, d.free_from, d.price, d.enabled, d.position, d.separate_payment
										FROM __delivery d
										WHERE d.id=?
										LIMIT 1", intval($id));

		$this->db->query($query);
		return $this->db->result();
	}

	public function get_deliveries($filter = array())
	{
		// По умолчанию
		$enabled_filter = '';

		if(!empty($filter['enabled']))
			$enabled_filter = $this->db->placehold('AND d.enabled=?', intval($filter['enabled']));

		$query = $this->db->placehold("SELECT d.id, d.name, d.description, d.free_from, d.price, d.enabled, d.position, d.separate_payment
										FROM __delivery d
										WHERE 1
											$enabled_filter
										ORDER BY d.position");

		$this->db->query($query);

		return $this->db->results();
	}

	public function update_delivery($id, $delivery)
	{
		$query = $this->db->placehold("UPDATE __delivery SET ?% WHERE id in(?@)", $delivery, (array)$id);
		$this->db->query($query);
		return $id;
	}

	public function add_delivery($delivery)
	{
		$query = $this->db->placehold('INSERT INTO __delivery SET ?%', $delivery);

		if(!$this->db->query($query))
			return false;

		$id = $this->db->insert_id();
		$this->db->query("UPDATE __delivery SET position=id WHERE id=?", intval($id));
		return $id;
	}

	public function delete_delivery($id)
	{
		// Удаляем связь доставки с методоми оплаты
		$query = $this->db->placehold("SELECT payment_method_id FROM __delivery_payment WHERE delivery_id=?", intval($id));
		$this->db->query($query);

		if(!empty($id))
		{
			$query = $this->db->placehold("DELETE FROM __delivery WHERE id=? LIMIT 1", intval($id));
			$this->db->query($query);
		}
	}


	public function get_delivery_payments($id)
	{
		$query = $this->db->placehold("SELECT payment_method_id FROM __delivery_payment WHERE delivery_id=?", intval($id));
		$this->db->query($query);
		return $this->db->results('payment_method_id');
	}

	public function update_delivery_payments($id, $payment_methods_ids)
	{
		$query = $this->db->placehold("DELETE FROM __delivery_payment WHERE delivery_id=?", intval($id));
		$this->db->query($query);
		if(is_array($payment_methods_ids))
		foreach($payment_methods_ids as $p_id)
			$this->db->query("INSERT INTO __delivery_payment SET delivery_id=?, payment_method_id=?", $id, $p_id);
	}

}
