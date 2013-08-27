<?PHP

/**
 * Simpla CMS
 *
 * @copyright 	2009 Denis Pikusov
 * @link 		http://simp.la
 * @author 		Denis Pikusov
 *
 * Корзина покупок
 * Этот класс использует шаблон cart.tpl
 *
 */
 
require_once('View.php');

class CartView extends View
{
  //////////////////////////////////////////
  // Изменения товаров в корзине
  //////////////////////////////////////////
  public function __construct()
  {
	parent::__construct();

    // Если передан id варианта, добавим его в корзину
    if($variant_id = $this->request->get('variant', 'integer'))
    {
		$this->cart->add_item($variant_id, $this->request->get('amount', 'integer'));
	    header('location: '.$this->config->root_url.'/cart/');
		
    }

    // Удаление товара из корзины
    if($delete_variant_id = intval($this->request->get('delete_variant')))
    {
      $this->cart->delete_item($delete_variant_id);
      if(!isset($_POST['submit_order']) || $_POST['submit_order']!=1)
			header('location: '.$this->config->root_url.'/cart/');
	}
	
    // Если нажали оформить заказ
    if(isset($_POST['checkout']))
    {
    
    	$order->delivery_id = $this->request->post('delivery_id', 'integer');
    	$order->name        = $this->request->post('name');
    	$order->email       = $this->request->post('email');
    	$order->address     = $this->request->post('address');
    	$order->phone       = $this->request->post('phone');
    	$order->comment     = $this->request->post('comment');
    	$order->ip	    = $_SERVER['REMOTE_ADDR'];
    	
		$this->design->assign('delivery_id', $order->delivery_id);
		$this->design->assign('name', $order->name);
		$this->design->assign('email', $order->email);
		$this->design->assign('phone', $order->phone);
		$this->design->assign('address', $order->address);

    	$captcha_code =  $this->request->post('captcha_code', 'string');

		// Скидка
		$cart = $this->cart->get_cart();
		$order->discount = $cart->discount;
		
		if($cart->coupon)
		{
			$order->coupon_discount = $cart->coupon_discount;
			$order->coupon_code = $cart->coupon->code;
		}
		//
    	
    	if(!empty($this->user->id))
	    	$order->user_id = $this->user->id;
    	
    	if(empty($order->name))
    	{
    		$this->design->assign('error', 'empty_name');
    	}
    	elseif(empty($order->email))
    	{
    		$this->design->assign('error', 'empty_email');
    	}
    	elseif($_SESSION['captcha_code'] != $captcha_code || empty($captcha_code))
    	{
    		$this->design->assign('error', 'captcha');
    	}
    	else
    	{
	    	// Добавляем заказ в базу
	    	$order_id = $this->orders->add_order($order);
	    	$_SESSION['order_id'] = $order_id;
	    	
	    	// Если использовали купон, увеличим количество его использований
	    	if($cart->coupon)
	    		$this->coupons->update_coupon($cart->coupon->id, array('usages'=>$cart->coupon->usages+1));
	    	
	    	// Добавляем товары к заказу
	    	foreach($this->request->post('amounts') as $variant_id=>$amount)
	    	{
	    		$this->orders->add_purchase(array('order_id'=>$order_id, 'variant_id'=>intval($variant_id), 'amount'=>intval($amount)));
	    	}
	    	$order = $this->orders->get_order($order_id);
	    	
	    	// Стоимость доставки
			$delivery = $this->delivery->get_delivery($order->delivery_id);
	    	if(!empty($delivery) && $delivery->free_from > $order->total_price)
	    	{
	    		$this->orders->update_order($order->id, array('delivery_price'=>$delivery->price, 'separate_delivery'=>$delivery->separate_payment));
	    	}
			
			// Отправляем письмо пользователю
			$this->notify->email_order_user($order->id);
	    	
			// Отправляем письмо администратору
			$this->notify->email_order_admin($order->id);
	    	
	    	// Очищаем корзину (сессию)
			$this->cart->empty_cart();
						
			// Перенаправляем на страницу заказа
			header('Location: '.$this->config->root_url.'/order/'.$order->url);
		}
    }   
    else
    {

	    // Если нам запостили amounts, обновляем их
	    if($amounts = $this->request->post('amounts'))
	    {
			foreach($amounts as $variant_id=>$amount)
			{
				$this->cart->update_item($variant_id, $amount);         
			}

	    	$coupon_code = trim($this->request->post('coupon_code', 'string'));
	    	if(empty($coupon_code))
	    	{
	    		$this->cart->apply_coupon('');
				header('location: '.$this->config->root_url.'/cart/');	    		
	    	}
	    	else
	    	{
				$coupon = $this->coupons->get_coupon((string)$coupon_code);

				if(empty($coupon) || !$coupon->valid)
				{
		    		$this->cart->apply_coupon($coupon_code);
					$this->design->assign('coupon_error', 'invalid');
				}
				else
				{
					$this->cart->apply_coupon($coupon_code);
					header('location: '.$this->config->root_url.'/cart/');
				}
	    	}
		}
	    
	}
              
  }

  
	//////////////////////////////////////////
	// Основная функция
	//////////////////////////////////////////
	function fetch()
	{  
		// Способы доставки
		$deliveries = $this->delivery->get_deliveries(array('enabled'=>1));
		$this->design->assign('deliveries', $deliveries);
		
		// Данные пользователя
		if($this->user)
		{
			$last_order = reset($this->orders->get_orders(array('user_id'=>$this->user->id, 'limit'=>1)));
			if($last_order)
			{
				$this->design->assign('name', $last_order->name);
				$this->design->assign('email', $last_order->email);
				$this->design->assign('phone', $last_order->phone);
				$this->design->assign('address', $last_order->address);
			}
			else
			{
				$this->design->assign('name', $this->user->name);
				$this->design->assign('email', $this->user->email);			
			}
		}
		
		// Если существуют валидные купоны, нужно вывести инпут для купона
		if($this->coupons->count_coupons(array('valid'=>1))>0)
			$this->design->assign('coupon_request', true);
		
		/*
		// Связанные товары
		$related_ids = array();
		$cart = $this->cart->get_cart();
		$purchases_ids = array();
		foreach($cart->purchases as $purchase)
		{
			$purchases_ids[] = $purchase->product->id;
		}
		foreach($cart->purchases as $purchase)
		{
			$related = $this->products->get_related_products($purchase->product->id);
			foreach($related as $r)
				if(!in_array($r->related_id, $related_ids) && !in_array($r->related_id, $purchases_ids))
					$related_ids[] = $r->related_id;
		}
		if(!empty($related_ids))
		{
			foreach($this->products->get_products(array('id'=>$related_ids, 'in_stock'=>1, 'visible'=>1)) as $p)
				$related_products[$p->id] = $p;
			
			$related_products_images = $this->products->get_images(array('product_id'=>array_keys($related_products)));
			foreach($related_products_images as $related_product_image)
				if(isset($related_products[$related_product_image->product_id]))
					$related_products[$related_product_image->product_id]->images[] = $related_product_image;
			$related_products_variants = $this->variants->get_variants(array('product_id'=>array_keys($related_products), 'in_stock'=>1));
			foreach($related_products_variants as $related_product_variant)
			{
				if(isset($related_products[$related_product_variant->product_id]))
				{
					$related_products[$related_product_variant->product_id]->variants[] = $related_product_variant;
				}
			}
			foreach($related_products as $id=>$r)
			{
				if(is_object($r))
				{
					$r->image = &$r->images[0];
					$r->variant = &$r->variants[0];
				}
				else
				{
					unset($related_products[$id]);
				}
			}
			$this->design->assign('related_products', $related_products);
		}
		*/
		
		// Выводим корзину
		return $this->design->fetch('cart.tpl');
	}
	
}
