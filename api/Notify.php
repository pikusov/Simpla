<?php

/**
 * Simpla CMS
 *
 * @copyright	2011 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */
 
class Notify extends Simpla
{
    function email($to, $subject, $message, $from = '', $reply_to = '')
    {
    	$headers = "MIME-Version: 1.0\n" ;
    	$headers .= "Content-type: text/html; charset=utf-8; \r\n"; 
    	$headers .= "From: $from\r\n";
    	if(!empty($reply_to))
	    	$headers .= "reply-to: $reply_to\r\n";
    	
    	$subject = "=?utf-8?B?".base64_encode($subject)."?=";

    	@mail($to, $subject, $message, $headers);
    }

	public function email_order_user($order_id)
	{
			if(!($order = $this->orders->get_order(intval($order_id))) || empty($order->email))
				return false;
			
			$purchases = $this->orders->get_purchases(array('order_id'=>$order->id));
			$this->design->assign('purchases', $purchases);			

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
			foreach($this->variants->get_variants(array('id'=>$variants_ids)) as $v)
			{
				$variants[$v->id] = $v;
				$products[$v->product_id]->variants[] = $v;
			}
				
			foreach($purchases as &$purchase)
			{
				if(!empty($products[$purchase->product_id]))
					$purchase->product = $products[$purchase->product_id];
				if(!empty($variants[$purchase->variant_id]))
					$purchase->variant = $variants[$purchase->variant_id];
			}
			
			// Способ доставки
			$delivery = $this->delivery->get_delivery($order->delivery_id);
			$this->design->assign('delivery', $delivery);

			$this->design->assign('order', $order);
			$this->design->assign('purchases', $purchases);

			// Отправляем письмо
			// Если в шаблон не передавалась валюта, передадим
			if ($this->design->smarty->getTemplateVars('currency') === null) 
			{
				$this->design->assign('currency', reset($this->money->get_currencies(array('enabled'=>1))));
			}
			$email_template = $this->design->fetch($this->config->root_dir.'design/'.$this->settings->theme.'/html/email_order.tpl');
			$subject = $this->design->get_var('subject');
			$this->email($order->email, $subject, $email_template, $this->settings->notify_from_email);
	
	}


	public function email_order_admin($order_id)
	{
			if(!($order = $this->orders->get_order(intval($order_id))))
				return false;
			
			$purchases = $this->orders->get_purchases(array('order_id'=>$order->id));
			$this->design->assign('purchases', $purchases);			

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
			foreach($this->variants->get_variants(array('id'=>$variants_ids)) as $v)
			{
				$variants[$v->id] = $v;
				$products[$v->product_id]->variants[] = $v;
			}
	
			foreach($purchases as &$purchase)
			{
				if(!empty($products[$purchase->product_id]))
					$purchase->product = $products[$purchase->product_id];
				if(!empty($variants[$purchase->variant_id]))
					$purchase->variant = $variants[$purchase->variant_id];
			}
			
			// Способ доставки
			$delivery = $this->delivery->get_delivery($order->delivery_id);
			$this->design->assign('delivery', $delivery);

			// Пользователь
			$user = $this->users->get_user(intval($order->user_id));
			$this->design->assign('user', $user);

			$this->design->assign('order', $order);
			$this->design->assign('purchases', $purchases);

			// В основной валюте
			$this->design->assign('main_currency', $this->money->get_currency());

			// Отправляем письмо
			$email_template = $this->design->fetch($this->config->root_dir.'simpla/design/html/email_order_admin.tpl');
			$subject = $this->design->get_var('subject');
			$this->email($this->settings->order_email, $subject, $email_template, $this->settings->notify_from_email);
	
	}

	

	public function email_comment_admin($comment_id)
	{ 
			if(!($comment = $this->comments->get_comment(intval($comment_id))))
				return false;

			$this->design->assign('comment', $comment);

			// Отправляем письмо
			$email_template = $this->design->fetch($this->config->root_dir.'simpla/design/html/email_comment_admin.tpl');
			$subject = $this->design->get_var('subject');
			$this->email($this->settings->comment_email, $subject, $email_template, $this->settings->notify_from_email);
	}

	public function email_password_remind($user_id, $code)
	{
			if(!($user = $this->users->get_user(intval($user_id))))
				return false;
			
			$this->design->assign('user', $user);
			$this->design->assign('code', $code);

			// Отправляем письмо
			$email_template = $this->design->fetch($this->config->root_dir.'design/'.$this->settings->theme.'/html/email_password_remind.tpl');
			$subject = $this->design->get_var('subject');
			$this->email($user->email, $subject, $email_template, $this->settings->notify_from_email);
			
			$this->design->smarty->clearAssign('user');
			$this->design->smarty->clearAssign('code');
	}

	public function email_feedback_admin($feedback_id)
	{ 
			if(!($feedback = $this->feedbacks->get_feedback(intval($feedback_id))))
				return false;

			$this->design->assign('feedback', $feedback);

			// Отправляем письмо
			$email_template = $this->design->fetch($this->config->root_dir.'simpla/design/html/email_feedback_admin.tpl');
			$subject = $this->design->get_var('subject');
			$this->email($this->settings->comment_email, $subject, $email_template, "$feedback->name <$feedback->email>", "$feedback->name <$feedback->email>");
	}


}