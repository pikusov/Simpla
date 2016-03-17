<?php

/**
 * Simpla CMS
 *
 * @copyright	2016 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */

require_once('api/Simpla.php');

class StatsAdmin extends Simpla
{

	public function fetch()
	{
		return $this->design->fetch('stats.tpl');
	}
}
