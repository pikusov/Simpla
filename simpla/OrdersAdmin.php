<?PHP 

require_once('api/Simpla.php');

########################################
class OrdersAdmin extends Simpla
{
	public function fetch()
	{
	 	$filter = array();
	  	$filter['page'] = max(1, $this->request->get('page', 'integer'));
	  		
	  	$filter['limit'] = 40;
	  	
	    // Поиск
	  	$keyword = $this->request->get('keyword', 'string');
	  	if(!empty($keyword))
	  	{
		  	$filter['keyword'] = $keyword;
	 		$this->design->assign('keyword', $keyword);
		}

		// Фильтр по метке
	  	$label = $this->orders->get_label($this->request->get('label'));	  	
	  	if(!empty($label))
	  	{
		  	$filter['label'] = $label->id;
		 	$this->design->assign('label', $label);
		}


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
					{
						$o = $this->orders->get_order(intval($id));
						if($o->status<3)
						{
							$this->orders->update_order($id, array('status'=>3));
							$this->orders->open($id);							
						}
						else
							$this->orders->delete_order($id);
					}
					break;
				}
				case 'set_status_0':
				{
					foreach($ids as $id)
					{
						if($this->orders->open(intval($id)))
							$this->orders->update_order($id, array('status'=>0));	
					}
					break;
				}
				case 'set_status_1':
				{
					foreach($ids as $id)
					{
						if(!$this->orders->close(intval($id)))
							$this->design->assign('message_error', 'error_closing');
						else
							$this->orders->update_order($id, array('status'=>1));	
					}
					break;
				}
				case 'set_status_2':
				{
					foreach($ids as $id)
					{
						if(!$this->orders->close(intval($id)))
							$this->design->assign('message_error', 'error_closing');
						else
							$this->orders->update_order($id, array('status'=>2));	
					}
					break;
				}
				case(preg_match('/^set_label_([0-9]+)/', $this->request->post('action'), $a) ? true : false):
				{
					$l_id = intval($a[1]);
					if($l_id>0)
					foreach($ids as $id)
					{
						$this->orders->add_order_labels($id, $l_id);
					}
					break;
				}
				case(preg_match('/^unset_label_([0-9]+)/', $this->request->post('action'), $a) ? true : false):
				{
					$l_id = intval($a[1]);
					if($l_id>0)
					foreach($ids as $id)
					{
						$this->orders->delete_order_labels($id, $l_id);
					}
					break;
				}
			}
		}		

		if(empty($keyword))
		{
			$status = $this->request->get('status', 'integer');
			$filter['status'] = $status;
		 	$this->design->assign('status', $status);
		}
				  	
	  	$orders_count = $this->orders->count_orders($filter);
		// Показать все страницы сразу
		if($this->request->get('page') == 'all')
			$filter['limit'] = $orders_count;	

		// Отображение
		$orders = array();
		foreach($this->orders->get_orders($filter) as $o)
			$orders[$o->id] = $o;
	 	
		// Метки заказов
		$orders_labels = array();
	  	foreach($this->orders->get_order_labels(array_keys($orders)) as $ol)
	  		$orders[$ol->order_id]->labels[] = $ol;
	  	
	 	$this->design->assign('pages_count', ceil($orders_count/$filter['limit']));
	 	$this->design->assign('current_page', $filter['page']);
	  	
	 	$this->design->assign('orders_count', $orders_count);
	
	 	$this->design->assign('orders', $orders);
	
		// Метки заказов
	  	$labels = $this->orders->get_labels();
	 	$this->design->assign('labels', $labels);
	  	
		return $this->design->fetch('orders.tpl');
	}
}
