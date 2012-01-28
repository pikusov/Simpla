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

class Payment extends Simpla
{
	public function get_payment_methods($filter = array())
	{	
		$delivery_filter = '';
		if(!empty($filter['delivery_id']))
			$delivery_filter = $this->db->placehold('AND id in (SELECT payment_method_id FROM __delivery_payment dp WHERE dp.delivery_id=?)', intval($filter['delivery_id']));
		
		$enabled_filter = '';
 		if(!empty($filter['enabled']))
			$enabled_filter = $this->db->placehold('AND enabled=?', intval($filter['enabled']));

		$query = "SELECT *
					FROM __payment_methods WHERE 1 $delivery_filter $enabled_filter ORDER BY position";
	
		$this->db->query($query);
		return $this->db->results();
	}
	
	function get_payment_method($id)
	{
		$query = $this->db->placehold("SELECT * FROM __payment_methods WHERE id=? LIMIT 1", intval($id));
		$this->db->query($query);
		$payment_method = $this->db->result();
  		return $payment_method;
	}
	
	function get_payment_settings($method_id)
	{
		$query = $this->db->placehold("SELECT settings FROM __payment_methods WHERE id=? LIMIT 1", intval($method_id));
		$this->db->query($query);
		$settings = $this->db->result('settings');
 
		$settings = unserialize($settings);
		return $settings;
	}
	
	function get_payment_modules()
	{
		$modules_dir = $this->config->root_dir.'payment/';
		
		$modules = array();
		$handler = opendir($modules_dir);		
		while ($dir = readdir($handler))
		{
			$dir = preg_replace("/[^A-Za-z0-9]+/", "", $dir);
			if (!empty($dir) && $dir != "." && $dir != ".." && is_dir($modules_dir.$dir))
			{
				
				if(is_readable($modules_dir.$dir.'/settings.xml') && $xml = simplexml_load_file($modules_dir.$dir.'/settings.xml'))
				{
					$module = null;
					
					$module->name = (string)$xml->name;
					$module->settings = array();
	
					foreach($xml->settings as $setting)
					{
						$module->settings[(string)$setting->variable]->name = (string)$setting->name;
						$module->settings[(string)$setting->variable]->variable = (string)$setting->variable;
					 	$module->settings[(string)$setting->variable]->variable_options = array();
					 	foreach($setting->options as $option)
					 	{
					 		$module->settings[(string)$setting->variable]->options[(string)$option->value]->name = (string)$option->name;
					 		$module->settings[(string)$setting->variable]->options[(string)$option->value]->value = (string)$option->value;
					 	}
					}
					$modules[$dir] = $module;
				}

			}
		}
    	closedir($handler);
    	return $modules;

	}
	
	public function get_payment_deliveries($id)
	{
		$query = $this->db->placehold("SELECT delivery_id FROM __delivery_payment WHERE payment_method_id=?", intval($id));
		$this->db->query($query);
		return $this->db->results('delivery_id');
	}		
	
	public function update_payment_method($id, $payment_method)
	{
		$query = $this->db->placehold("UPDATE __payment_methods SET ?% WHERE id in(?@)", $payment_method, (array)$id);
		$this->db->query($query);
		return $id;
	}
	
	public function update_payment_settings($method_id, $settings)
	{
		if(!is_string($settings))
		{
			$settings = serialize($settings);
		}
		$query = $this->db->placehold("UPDATE __payment_methods SET settings=? WHERE id in(?@) LIMIT 1", $settings, (array)$method_id);
		$this->db->query($query);
		return $method_id;
	}
	
	public function update_payment_deliveries($id, $deliveries_ids)
	{
		$query = $this->db->placehold("DELETE FROM __delivery_payment WHERE payment_method_id=?", intval($id));
		$this->db->query($query);
		if(is_array($deliveries_ids))
		foreach($deliveries_ids as $d_id)
			$this->db->query("INSERT INTO __delivery_payment SET payment_method_id=?, delivery_id=?", $id, $d_id);
	}		
	
	public function add_payment_method($payment_method)
	{	
		$query = $this->db->placehold('INSERT INTO __payment_methods
		SET ?%',
		$payment_method);

		if(!$this->db->query($query))
			return false;

		$id = $this->db->insert_id();
		$this->db->query("UPDATE __payment_methods SET position=id WHERE id=?", $id);	
		return $id;
	}

	public function delete_payment_method($id)
	{
		if(!empty($id))
		{
			$query = $this->db->placehold("DELETE FROM __payment_methods WHERE id=? LIMIT 1", intval($id));
			$this->db->query($query);
		}
	}	

	
}
