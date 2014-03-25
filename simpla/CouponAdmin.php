<?PHP

require_once('api/Simpla.php');

class CouponAdmin extends Simpla
{
	public function fetch()
	{
		$coupon = new stdClass;
		if($this->request->method('post'))
		{
			$coupon->id = $this->request->post('id', 'integer');
			$coupon->code = $this->request->post('code', 'string');
			if($this->request->post('expires'))
				$coupon->expire = date('Y-m-d', strtotime($this->request->post('expire')));
			else
				$coupon->expire = null;
			$coupon->value = $this->request->post('value', 'float');			
			$coupon->type = $this->request->post('type', 'string');
			$coupon->min_order_price = $this->request->post('min_order_price', 'float');
			$coupon->single = $this->request->post('single', 'float');

 			// Не допустить одинаковые URL разделов.
			if(($a = $this->coupons->get_coupon((string)$coupon->code)) && $a->id!=$coupon->id)
			{			
				$this->design->assign('message_error', 'code_exists');
			}
			else
			{
				if(empty($coupon->id))
				{ 
	  				$coupon->id = $this->coupons->add_coupon($coupon);
	  				$coupon = $this->coupons->get_coupon($coupon->id);
					$this->design->assign('message_success', 'added');
	  			}
  	    		else
  	    		{
  	    			$this->coupons->update_coupon($coupon->id, $coupon);
  	    			$coupon = $this->coupons->get_coupon($coupon->id);
					$this->design->assign('message_success', 'updated');
  	    		}	

   	    		
			}
		}
		else
		{
			$coupon->id = $this->request->get('id', 'integer');
			$coupon = $this->coupons->get_coupon($coupon->id);
		}

//		if(empty($coupon->id))
//			$coupon->expire = date($this->settings->date_format, time());
 		
		$this->design->assign('coupon', $coupon);
 	  	return $this->design->fetch('coupon.tpl');
	}
}