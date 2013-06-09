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


class Money extends Simpla
{
	private $currencies = array();
	private $currency;

	public function __construct()
	{
		parent::__construct();
		
		if(isset($this->settings->price_decimals_point))
			$this->decimals_point = $this->settings->price_decimals_point;
		
		if(isset($this->settings->price_thousands_separator))
			$this->thousands_separator = $this->settings->price_thousands_separator;
 
		$this->design->smarty->registerPlugin('modifier', 'convert', array($this, 'convert'));

		$this->init_currencies();
	}
	
	private function init_currencies()
	{
		$this->currencies = array();
		// Выбираем из базы валюты
		$query = "SELECT id, name, sign, code, rate_from, rate_to, cents, position, enabled FROM __currencies ORDER BY position";
		$this->db->query($query);
		
		$results = $this->db->results();
		
		foreach($results as $c)
		{
			$this->currencies[$c->id] = $c;
		}
		
		$this->currency = reset($this->currencies);

	}

	
	public function get_currencies($filter = array())
	{
		$currencies = array();
		foreach($this->currencies as $id=>$currency)
			if((isset($filter['enabled']) && $filter['enabled'] == 1 && $currency->enabled) || empty($filter['enabled']))
				$currencies[$id] = $currency;
			
		return $currencies;
	}
	
	public function get_currency($id = null)
	{
		if(!empty($id) && is_integer($id) && isset($this->currencies[$id]))
			return $this->currencies[$id];
			
		if(!empty($id) && is_string($id))
		{
			foreach($this->currencies as $currency)
			{
				if($currency->code == $id)
					return $currency;
			}
		}

		return $this->currency;
	}
	
	
	public function add_currency($currency)
	{	
		$query = $this->db->placehold('INSERT INTO __currencies
		SET ?%',
		$currency);

		if(!$this->db->query($query))
			return false;

		$id = $this->db->insert_id();
		$this->db->query("UPDATE __currencies SET position=id WHERE id=?", $id);
		$this->init_currencies();
			
		return $id;
	}
	
	public function update_currency($id, $currency)
	{	
		$query = $this->db->placehold('UPDATE __currencies
						SET ?%
						WHERE id in (?@)',
					$currency, (array)$id);
		if(!$this->db->query($query))
			return false;
		
		$this->init_currencies();
		return $id;
	}
	
	public function delete_currency($id)
	{
		if(!empty($id))
		{
			$query = $this->db->placehold("DELETE FROM __currencies WHERE id=? LIMIT 1", intval($id));
			$this->db->query($query);
		}
		$this->init_currencies();		
	}	
	
	
	public function convert($price, $currency_id = null, $format = true)
	{
		if(isset($currency_id))
		{
			if(is_numeric($currency_id))
				$currency = $this->get_currency((integer)$currency_id);
			else
				$currency = $this->get_currency((string)$currency_id);
		}
		elseif(isset($_SESSION['currency_id']))
			$currency = $this->get_currency($_SESSION['currency_id']);
		else
			$currency = current($this->get_currencies(array('enabled'=>1)));
								
		$result = $price;
		
		if(!empty($currency))
		{		
			// Умножим на курс валюты
			$result = $result*$currency->rate_from/$currency->rate_to;
		}
		
		// Точность отображения, знаков после запятой
		$precision = isset($currency) && isset($currency->cents) && $currency->cents
			? intval($currency->cents)
			: strlen(substr(strrchr($result, '.'), 1));
		
		
		// Форматирование цены
		return $format
			? number_format($result, $precision, $this->settings->decimals_point, $this->settings->thousands_separator)
			: strval(round($result, $precision));
			
	}

	
}
