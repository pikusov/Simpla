<?PHP
require_once('api/Simpla.php');

class OrdersLabelAdmin extends Simpla
{	
	public function fetch()
	{	
		$label = new stdClass;
		$label->color = 'ffffff';
		if($this->request->method('POST'))
		{
			$label->id = $this->request->post('id', 'integer');
			$label->name = $this->request->post('name');
			$label->color = $this->request->post('color');
			if(empty($label->name))
            {
                $this->design->assign('message_error', 'empty_name');
            }
            elseif(empty($label->id))
			{
				$label->id = $this->orders->add_label($label);
				$label = $this->orders->get_label($label->id);
  				$this->design->assign('message_success', 'added');
			}
			else
			{
				$this->orders->update_label($label->id, $label);
				$label = $this->orders->get_label($label->id);
				$this->design->assign('message_success', 'updated');
			}
		}
		else
		{
			$id = $this->request->get('id', 'integer');
			if(!empty($id))
				$label = $this->orders->get_label(intval($id));			
		}	

		$this->design->assign('label', $label);
		
 	  	return $this->design->fetch('orders_label.tpl');
	}
	
}

