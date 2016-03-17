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

class Settings extends Simpla
{
	private $vars = array();

	public function __construct()
	{
		parent::__construct();

		// Выбираем из базы настройки
		$this->db->query('SELECT name, value FROM __settings');

		// и записываем их в переменную
		foreach($this->db->results() as $result)
			if(!($this->vars[$result->name] = @unserialize($result->value)))
				$this->vars[$result->name] = $result->value;
	}

	public function __get($name)
	{
		if($res = parent::__get($name))
			return $res;

		if(isset($this->vars[$name]))
			return $this->vars[$name];
		else
			return null;
	}

	public function __set($name, $value)
	{
		$this->vars[$name] = $value;

		if(is_array($value))
			$value = serialize($value);
		else
			$value = (string) $value;

		$this->db->query('SELECT count(*) as count FROM __settings WHERE name=?', $name);
		if($this->db->result('count')>0)
			$this->db->query('UPDATE __settings SET value=? WHERE name=?', $value, $name);
		else
			$this->db->query('INSERT INTO __settings SET value=?, name=?', $value, $name);
	}
}
