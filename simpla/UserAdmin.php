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

class UserAdmin extends Simpla
{
	public function fetch()
	{
		$user = new stdClass;
		if(!empty($_POST['user_info']))
		{
			$user->id = $this->request->post('id', 'integer');
			$user->enabled = $this->request->post('enabled', 'boolean');
			$user->name = $this->request->post('name');
			$user->email = $this->request->post('email');
			$user->group_id = $this->request->post('group_id');

			if(empty($user->name))
			{
				$this->design->assign('message_error', 'empty_name');
			}
			elseif(empty($user->email))
			{
				$this->design->assign('message_error', 'empty_email');
			}
			elseif(($u = $this->users->get_user($user->email)) && $u->id!=$user->id)
			{
				$this->design->assign('message_error', 'login_existed');
			}
			else
			{
				$user->id = $this->users->update_user($user->id, $user);
				$this->design->assign('message_success', 'updated');
				$user = $this->users->get_user(intval($user->id));
			}
		}
		elseif($this->request->post('check'))
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
							$this->orders->update_order($id, array('status'=>3, 'user_id'=>null));
							$this->orders->open($id);
						}
						else
							$this->orders->delete_order($id);
					}
					break;
				}
			}
		}

		$id = $this->request->get('id', 'integer');
		if(!empty($id))
			$user = $this->users->get_user(intval($id));

		if(!empty($user))
		{
			$this->design->assign('user', $user);

			$orders = $this->orders->get_orders(array('user_id'=>$user->id));
			$this->design->assign('orders', $orders);

		}

		$groups = $this->users->get_groups();
		$this->design->assign('groups', $groups);

		return $this->design->fetch('user.tpl');
	}

}

