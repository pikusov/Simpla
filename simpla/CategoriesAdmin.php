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

class CategoriesAdmin extends Simpla
{
	public function fetch()
	{
		if($this->request->method('post'))
		{
			// Действия с выбранными
			$ids = $this->request->post('check');
			if(is_array($ids))
				switch($this->request->post('action'))
				{
					case 'disable':
					{
						foreach($ids as $id)
							$this->categories->update_category($id, array('visible'=>0));
						break;
					}
					case 'enable':
					{
						foreach($ids as $id)
							$this->categories->update_category($id, array('visible'=>1));
						break;
					}
					case 'delete':
					{
						$this->categories->delete_category($ids);
						break;
					}
			}
		
			// Сортировка
			$positions = $this->request->post('positions');
			$ids = array_keys($positions);
			sort($positions);
			foreach($positions as $i=>$position)
				$this->categories->update_category($ids[$i], array('position'=>$position));

		}

		$categories = $this->categories->get_categories_tree();

		$this->design->assign('categories', $categories);
		
		return $this->design->fetch('categories.tpl');
	}
}
