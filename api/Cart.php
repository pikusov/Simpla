<?php

/**
 * Simpla CMS
 *
 * @copyright	2011 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */
 
require_once('Simpla.php');

class Cart extends Simpla
{

	/*
	*
	* Функция возвращает корзину
	*
	*/
	public function get_cart()
	{
		$cart->purchases = array();
		$cart->total_price = 0;
		$cart->total_products = 0;

		// Берем из сессии список variant_id=>amount
		if(!empty($_SESSION['shopping_cart']))
		{
			$session_items = $_SESSION['shopping_cart'];
			
			$variants = $this->variants->get_variants(array('id'=>array_keys($session_items)));
			if(!empty($variants))
			{
 
				foreach($variants as $variant)
				{
					$items[$variant->id]->variant = $variant;
					$items[$variant->id]->amount = $session_items[$variant->id];
					$products_ids[] = $variant->product_id;
				}
	
				$products = array();
				foreach($this->products->get_products(array('id'=>$products_ids)) as $p)
					$products[$p->id]=$p;
				
				$images = $this->products->get_images(array('product_id'=>$products_ids));
				foreach($images as $image)
					$products[$image->product_id]->images[$image->id] = $image;
			
				
				foreach($items as $variant_id=>$item)
				{	
					$purchase = null;
					if(!empty($products[$item->variant->product_id]))
					{
						$purchase->product = $products[$item->variant->product_id];
						
						$purchase->variant = $item->variant;
						
						$purchase->amount = $item->amount;
			
						$cart->purchases[] = $purchase;
						$cart->total_price += $item->variant->price*$item->amount;
						$cart->total_products += $item->amount;
					}
				}
				
				$discount = 0;
				if(isset($_SESSION['user_id']) && $user = $this->users->get_user(intval($_SESSION['user_id'])))
					$discount = $user->discount;
					
				$cart->total_price *= (100-$discount)/100;
			}
		}
	
		return $cart;
	}
	
	/*
	*
	* Добавление варианта товара в корзину
	*
	*/
	public function add_item($variant_id, $amount = 1)
	{ 
		$amount = max(1, $amount);
	
		if(isset($_SESSION['shopping_cart'][$variant_id]))
      		$amount = max(1, $amount+$_SESSION['shopping_cart'][$variant_id]);

		// Выберем товар из базы, заодно убедившись в его существовании
		$variant = $this->variants->get_variant($variant_id);

		// Если товар существует, добавим его в корзину
		if(!empty($variant) && ($variant->stock>0) )
		{
			// Не дадим больше чем на складе
			$amount = min($amount, $variant->stock);
	     
			$_SESSION['shopping_cart'][$variant_id] = intval($amount); 
		}
	}
	
	/*
	*
	* Обновление количества товара
	*
	*/
	public function update_item($variant_id, $amount = 1)
	{
		$amount = max(1, $amount);
		
		// Выберем товар из базы, заодно убедившись в его существовании
		$variant = $this->variants->get_variant($variant_id);

		// Если товар существует, добавим его в корзину
		if(!empty($variant) && $variant->stock>0)
		{
			// Не дадим больше чем на складе
			$amount = min($amount, $variant->stock);
	     
			$_SESSION['shopping_cart'][$variant_id] = intval($amount); 
		}
 
	}
	
	
	/*
	*
	* Удаление товара из корзины
	*
	*/
	public function delete_item($variant_id)
	{
		unset($_SESSION['shopping_cart'][$variant_id]); 
	}
	
	/*
	*
	* Очистка корзины
	*
	*/
	public function empty_cart()
	{
		unset($_SESSION['shopping_cart']);
	}
 
}