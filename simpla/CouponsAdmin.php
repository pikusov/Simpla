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

class CouponsAdmin extends Simpla
{
	public function fetch()
	{
		// Обработка действий
		if($this->request->method('post'))
		{
			// Действия с выбранными
			$ids = $this->request->post('check');
			if(is_array($ids) && count($ids)>0)
			switch($this->request->post('action'))
			{
				case 'delete':
				{
					foreach($ids as $id)
						$this->coupons->delete_coupon($id);
					break;
				}
			}
		}

		$filter = array();
		$filter['page'] = max(1, $this->request->get('page', 'integer'));
		$filter['limit'] = 20;
		
		// Поиск
		$keyword = $this->request->get('keyword', 'string');
		if(!empty($keyword))
		{
			$filter['keyword'] = $keyword;
			$this->design->assign('keyword', $keyword);
		}		
		
		$coupons_count = $this->coupons->count_coupons($filter);
		
		$pages_count = ceil($coupons_count/$filter['limit']);
		$filter['page'] = min($filter['page'], $pages_count);
		$this->design->assign('coupons_count', $coupons_count);
		$this->design->assign('pages_count', $pages_count);
		$this->design->assign('current_page', $filter['page']);


		$coupons = $this->coupons->get_coupons($filter);
				
		$this->design->assign('coupons', $coupons);

		return $this->design->fetch('coupons.tpl');
	}
}
