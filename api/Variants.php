<?php

/**
 * Работа с вариантами товаров
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 */

require_once('Simpla.php');

class Variants extends Simpla
{
	/**
	* Функция возвращает варианты товара
	* @param	$filter
	* @retval	array
	*/
	public function get_variants($filter = array())
	{		
		$product_id_filter = '';
		$variant_id_filter = '';
		$instock_filter = '';
		
		if(!empty($filter['product_id']))
			$product_id_filter = $this->db->placehold('AND v.product_id in(?@)', (array)$filter['product_id']);
		
		if(!empty($filter['id']))
			$variant_id_filter = $this->db->placehold('AND v.id in(?@)', (array)$filter['id']);

		if(!empty($filter['in_stock']) && $filter['in_stock'])
			$variant_id_filter = $this->db->placehold('AND (v.stock>0 OR v.stock IS NULL)');

		if(!$product_id_filter && !$variant_id_filter)
			return array();
		
		$query = $this->db->placehold("SELECT v.id, v.product_id , v.price, NULLIF(v.compare_price, 0) as compare_price, v.sku, IFNULL(v.stock, ?) as stock, (v.stock IS NULL) as infinity, v.name, v.attachment, v.position
					FROM __variants AS v
					WHERE 
					1
					$product_id_filter          
					$variant_id_filter   
					ORDER BY v.position       
					", $this->settings->max_order_amount);
		
		$this->db->query($query);	
		return $this->db->results();
	}
	
	
	public function get_variant($id)
	{	
		if(empty($id))
			return false;
			
		$query = $this->db->placehold("SELECT v.id, v.product_id , v.price, NULLIF(v.compare_price, 0) as compare_price, v.sku, IFNULL(v.stock, ?) as stock, (v.stock IS NULL) as infinity, v.name, v.attachment
					FROM __variants v WHERE id=?
					LIMIT 1", $this->settings->max_order_amount, $id);
		
		$this->db->query($query);	
		$variant = $this->db->result();
		return $variant;
	}
	
	public function update_variant($id, $variant)
	{
		$query = $this->db->placehold("UPDATE __variants SET ?% WHERE id=? LIMIT 1", $variant, intval($id));
		$this->db->query($query);
		return $id;
	}
	
	public function add_variant($variant)
	{
		$query = $this->db->placehold("INSERT INTO __variants SET ?%", $variant);
		$this->db->query($query);
		return $this->db->insert_id();
	}

	public function delete_variant($id)
	{
		if(!empty($id))
		{
			$this->delete_attachment($id);
			$query = $this->db->placehold("DELETE FROM __variants WHERE id = ? LIMIT 1", intval($id));
			$this->db->query($query);
			$this->db->query('UPDATE __purchases SET variant_id=NULL WHERE variant_id=?', intval($id));
		}
	}
	
	public function delete_attachment($id)
	{
		$query = $this->db->placehold("SELECT attachment FROM __variants WHERE id=?", $id);
		$this->db->query($query);
		$filename = $this->db->result('attachment');
		$query = $this->db->placehold("SELECT 1 FROM __variants WHERE attachment=? AND id!=?", $filename, $id);
		$this->db->query($query);
		$exists = $this->db->num_rows();
		if(!empty($filename) && $exists == 0)
			@unlink($this->config->root_dir.'/'.$this->config->downloads_dir.$filename);
		$this->update_variant($id, array('attachment'=>null));
	}
	
}