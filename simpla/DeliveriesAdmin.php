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

class DeliveriesAdmin extends Simpla
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
					case 'disable':
					{
						$this->delivery->update_delivery($ids, array('enabled'=>0));
						break;
					}
					case 'enable':
					{
						$this->delivery->update_delivery($ids, array('enabled'=>1));
						break;
					}
					case 'delete':
					{
						foreach($ids as $id)
							$this->delivery->delete_delivery($id);
						break;
					}
				}

			// Сортировка
			$positions = $this->request->post('positions');
			$ids = array_keys($positions);
			sort($positions);
			foreach($positions as $i=>$position)
				$this->delivery->update_delivery($ids[$i], array('position'=>$position));

		}

		// Отображение
		$deliveries = $this->delivery->get_deliveries();
		$this->design->assign('deliveries', $deliveries);

		return $this->design->fetch('deliveries.tpl');
	}
}
