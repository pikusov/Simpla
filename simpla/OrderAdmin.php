<?PHP

require_once('api/Simpla.php');

############################################
# Class Product - edit the static section
############################################
class OrderAdmin extends Simpla
{
	public function fetch()
	{
		if($this->request->method('post'))
		{
			$order->id = $this->request->post('id', 'integer');
			$order->name = $this->request->post('name');
			$order->email = $this->request->post('email');
			$order->phone = $this->request->post('phone');
			$order->address = $this->request->post('address');
			$order->comment = $this->request->post('comment');
			$order->note = $this->request->post('note');
			$order->discount = $this->request->post('discount', 'floatr');
			$order->coupon_discount = $this->request->post('coupon_discount', 'floatr');
			$order->delivery_id = $this->request->post('delivery_id', 'integer');
			$order->delivery_price = $this->request->post('delivery_price', 'float');
			$order->payment_method_id = $this->request->post('payment_method_id', 'integer');
			$order->paid = $this->request->post('paid', 'integer');
			$order->user_id = $this->request->post('user_id', 'integer');
			$order->separate_delivery = $this->request->post('separate_delivery', 'integer');


			if(empty($order->id))
			{
  				$order->id = $this->orders->add_order($order);
				$this->design->assign('message_success', 'added');
  			}
    		else
    		{
    			$this->orders->update_order($order->id, $order);
				$this->design->assign('message_success', 'updated');
    		}	
			
			if($order->id)
			{
				// Покупки
				$purchases = array();
				if($this->request->post('purchases'))
				{
					foreach($this->request->post('purchases') as $n=>$va) foreach($va as $i=>$v)
						$purchases[$i]->$n = $v;
				}		
				$posted_purchases_ids = array();
				foreach($purchases as $purchase)
				{
					$variant = $this->variants->get_variant($purchase->variant_id);

					if(!empty($purchase->id))
						if(!empty($variant))
							$this->orders->update_purchase($purchase->id, array('variant_id'=>$purchase->variant_id, 'variant_name'=>$variant->name, 'price'=>$purchase->price, 'amount'=>$purchase->amount));
						else
							$this->orders->update_purchase($purchase->id, array('price'=>$purchase->price, 'amount'=>$purchase->amount));
					else
						$purchase->id = $this->orders->add_purchase(array('order_id'=>$order->id, 'variant_id'=>$purchase->variant_id, 'variant_name'=>$variant->name, 'price'=>$purchase->price, 'amount'=>$purchase->amount));
						
					$posted_purchases_ids[] = $purchase->id;			
				}
				
				// Удалить непереданные товары
				foreach($this->orders->get_purchases(array('order_id'=>$order->id)) as $p)
					if(!in_array($p->id, $posted_purchases_ids))
						$this->orders->delete_purchase($p->id);
					
				// Принять?
				if($this->request->post('status_new'))
					$new_status = 0;
				elseif($this->request->post('status_accept'))
					$new_status = 1;
				elseif($this->request->post('status_done'))
					$new_status = 2;
				elseif($this->request->post('status_deleted'))
					$new_status = 3;
				else
					$new_status = $this->request->post('status', 'string');
	
				if($new_status == 0)					
				{
					if(!$this->orders->open(intval($order->id)))
						$this->design->assign('message_error', 'error_open');
					else
						$this->orders->update_order($order->id, array('status'=>0));
				}
				elseif($new_status == 1)					
				{
					if(!$this->orders->close(intval($order->id)))
						$this->design->assign('message_error', 'error_closing');
					else
						$this->orders->update_order($order->id, array('status'=>1));
				}
				elseif($new_status == 2)					
				{
					if(!$this->orders->close(intval($order->id)))
						$this->design->assign('message_error', 'error_closing');
					else
						$this->orders->update_order($order->id, array('status'=>2));
				}
				elseif($new_status == 3)					
				{
					if(!$this->orders->open(intval($order->id)))
						$this->design->assign('message_error', 'error_open');
					else
						$this->orders->update_order($order->id, array('status'=>3));
					header('Location: '.$this->request->get('return'));
				}
				$order = $this->orders->get_order($order->id);
	
				// Отправляем письмо пользователю
				if($this->request->post('notify_user'))
					$this->notify->email_order_user($order->id);
			}

		}
		else
		{
			$order->id = $this->request->get('id', 'integer');
			$order = $this->orders->get_order(intval($order->id));
		}


		$subtotal = 0;
		$purchases_count = 0;
		if($order && $purchases = $this->orders->get_purchases(array('order_id'=>$order->id)))
		{
			// Покупки
			$products_ids = array();
			$variants_ids = array();
			foreach($purchases as $purchase)
			{
				$products_ids[] = $purchase->product_id;
				$variants_ids[] = $purchase->variant_id;
			}
			
			$products = array();
			foreach($this->products->get_products(array('id'=>$products_ids)) as $p)
				$products[$p->id] = $p;
	
			$images = $this->products->get_images(array('product_id'=>$products_ids));		
			foreach($images as $image)
				$products[$image->product_id]->images[] = $image;
			
			$variants = array();
			foreach($this->variants->get_variants(array('product_id'=>$products_ids)) as $v)
				$variants[$v->id] = $v;
			
			foreach($variants as $variant)
				if(!empty($products[$variant->product_id]))
					$products[$variant->product_id]->variants[] = $variant;
				
	
			foreach($purchases as &$purchase)
			{
				if(!empty($products[$purchase->product_id]))
					$purchase->product = $products[$purchase->product_id];
				if(!empty($variants[$purchase->variant_id]))
					$purchase->variant = $variants[$purchase->variant_id];
				$subtotal += $purchase->price*$purchase->amount;
				$purchases_count += $purchase->amount;				
			}			
			
		}
		else
		{
			$purchases = array();
		}

		$this->design->assign('purchases', $purchases);
		$this->design->assign('purchases_count', $purchases_count);
		$this->design->assign('subtotal', $subtotal);
		$this->design->assign('order', $order);

		if($order)
		{
			// Способ доставки
			$delivery = $this->delivery->get_delivery($order->delivery_id);
			$this->design->assign('delivery', $delivery);
	
			// Способ оплаты
			$payment_method = $this->payment->get_payment_method($order->payment_method_id);
			
			if(!empty($payment_method))
			{
				$this->design->assign('payment_method', $payment_method);
		
				// Валюта оплаты
				$payment_currency = $this->money->get_currency(intval($payment_method->currency_id));
				$this->design->assign('payment_currency', $payment_currency);
			}
			// Пользователь
			if($order->user_id)
				$this->design->assign('user', $this->users->get_user(intval($order->user_id)));
	
			// Соседние заказы
			$this->design->assign('next_order', $this->orders->get_next_order($order->id, $this->request->get('status', 'string')));
			$this->design->assign('prev_order', $this->orders->get_prev_order($order->id, $this->request->get('status', 'string')));
		}

		// Все способы доставки
		$deliveries = $this->delivery->get_deliveries();
		$this->design->assign('deliveries', $deliveries);

		// Все способы оплаты
		$payment_methods = $this->payment->get_payment_methods();
		$this->design->assign('payment_methods', $payment_methods);
		

 	  	return $this->design->fetch('order.tpl');
	}
}