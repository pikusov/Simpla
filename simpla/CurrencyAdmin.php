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

class CurrencyAdmin extends Simpla
{

	public function fetch()
	{

		// Обработка действий
		if($this->request->method('post'))
		{

			foreach($this->request->post('currency') as $n=>$va)
				foreach($va as $i=>$v)
					{
						if(empty($currencies[$i]))
							$currencies[$i] = new stdClass;
						$currencies[$i]->$n = $v;
					}

			$currencies_ids = array();
			foreach($currencies as $currency)
			{
				if($currency->id)
					$this->money->update_currency($currency->id, $currency);
				else
					$currency->id = $this->money->add_currency($currency);
				$currencies_ids[] = $currency->id;
			}

			// Удалить непереданные валюты
			$query = $this->db->placehold('DELETE FROM __currencies WHERE id NOT IN(?@)', $currencies_ids);
			$this->db->query($query);

			// Пересчитать курсы
			$old_currency = $this->money->get_currency();
			$new_currency = reset($currencies);
			if($old_currency->id != $new_currency->id)
			{
				$coef = $new_currency->rate_from/$new_currency->rate_to;

				if($this->request->post('recalculate') == 1)
				{
					$this->db->query("UPDATE __variants SET price=price*?", $coef);
					$this->db->query("UPDATE __delivery SET price=price*?, free_from=free_from*?", $coef, $coef);
					$this->db->query("UPDATE __orders SET delivery_price=delivery_price*?", $coef);
					$this->db->query("UPDATE __orders SET total_price=total_price*?", $coef);
					$this->db->query("UPDATE __purchases SET price=price*?", $coef);
					$this->db->query("UPDATE __coupons SET value=value*? WHERE type='absolute'", $coef);
					$this->db->query("UPDATE __coupons SET min_order_price=min_order_price*?", $coef);
					$this->db->query("UPDATE __orders SET coupon_discount=coupon_discount*?", $coef);
				}

				$this->db->query("UPDATE __currencies SET rate_from=1.0*rate_from*$new_currency->rate_to/$old_currency->rate_to");
				$this->db->query("UPDATE __currencies SET rate_to=1.0*rate_to*$new_currency->rate_from/$old_currency->rate_from");
				$this->db->query("UPDATE __currencies SET rate_to = rate_from WHERE id=?", $new_currency->id);
				$this->db->query("UPDATE __currencies SET rate_to = 1, rate_from = 1 WHERE (rate_to=0 OR rate_from=0) AND id=?", $new_currency->id);
			}

			// Отсортировать валюты
			asort($currencies_ids);
			$i = 0;
			foreach($currencies_ids as $currency_id)
			{
				$this->money->update_currency($currencies_ids[$i], array('position'=>$currency_id));
				$i++;
			}

			// Действия с выбранными
			$action = $this->request->post('action');
			$id = $this->request->post('action_id');

			if(!empty($action) && !empty($id))
				switch($action)
				{
					case 'disable':
					{
						$this->money->update_currency($id, array('enabled'=>0));
						break;
					}
					case 'enable':
					{
						$this->money->update_currency($id, array('enabled'=>1));
						break;
					}
					case 'show_cents':
					{
						$this->money->update_currency($id, array('cents'=>2));
						break;
					}
					case 'hide_cents':
					{
						$this->money->update_currency($id, array('cents'=>0));
						break;
					}
					case 'delete':
					{
						$this->money->delete_currency($id);
						break;
					}
				}

		}

		// Отображение
		$currencies = $this->money->get_currencies();
		$currency = $this->money->get_currency();
		$this->design->assign('currency', $currency);
		$this->design->assign('currencies', $currencies);

		return $this->design->fetch('currency.tpl');
	}
}
