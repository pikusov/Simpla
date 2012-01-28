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
    	
		// Скидка
		$order->discount = empty($this->user->discount)?0:$this->user->discount;
    	
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
    	else
    	{
	    	// Добавляем заказ в базу
	    	$order_id = $this->orders->add_order($order);
	    	$_SESSION['order_id'] = $order_id;
	    	
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
    // Если нам запостили amounts, обновляем их
    elseif($amounts = $this->request->post('amounts'))
    {
		foreach($amounts as $variant_id=>$amount)
		{
			$this->cart->update_item($variant_id, $amount);         
		}
		header('location: '.$this->config->root_url.'/cart/');
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
		
		// Выводим корзину
		return $this->design->fetch('cart.tpl');
	}
	
}