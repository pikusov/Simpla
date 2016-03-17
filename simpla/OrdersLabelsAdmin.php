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

class OrdersLabelsAdmin extends Simpla
{

	public function fetch()
	{
		// Обработка действий
		if($this->request->method('post'))
		{
			// Сортировка
			$positions = $this->request->post('positions');
			$ids = array_keys($positions);
			sort($positions);
			foreach($positions as $i=>$position)
				$this->orders->update_label($ids[$i], array('position'=>$position));


			// Действия с выбранными
			$ids = $this->request->post('check');
			if(is_array($ids))
				switch($this->request->post('action'))
				{
					case 'delete':
					{
						foreach($ids as $id)
							$this->orders->delete_label($id);
						break;
					}
				}
		}

		// Отображение
		$labels = $this->orders->get_labels();

		$this->design->assign('labels', $labels);
		return $this->design->fetch('orders_labels.tpl');
	}
}
