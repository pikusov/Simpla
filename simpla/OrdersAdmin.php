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
	  	$orders = $this->orders->get_orders($filter);
	  	
	 	$this->design->assign('pages_count', ceil($orders_count/$filter['limit']));
	 	$this->design->assign('current_page', $filter['page']);
	  	
	 	$this->design->assign('orders_count', $orders_count);
	
	 	$this->design->assign('orders', $orders);
		return $this->design->fetch('orders.tpl');
	}
}
