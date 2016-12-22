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

class BrandsAdmin extends Simpla
{
	public function fetch()
	{

		// Обработка действий
		if($this->request->method('post'))
		{

			// Действия с выбранными
			$ids = $this->request->post('check');

			if(is_array($ids))
				switch($this->request->post('action'))
				{
					case 'delete':
					{
						foreach($ids as $id)
							$this->brands->delete_brand($id);
					break;
					}
				}
		}

		$brands = $this->brands->get_brands();

		$this->design->assign('brands', $brands);
		
		return $this->body = $this->design->fetch('brands.tpl');
	}
}
