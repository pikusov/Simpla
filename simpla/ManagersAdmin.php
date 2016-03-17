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

class ManagersAdmin extends Simpla
{
	public function fetch()
	{

		if($this->request->method('post'))
		{
			// Действия с выбранными
			$logins = $this->request->post('check');
			if(is_array($logins))
			switch($this->request->post('action'))
			{
				case 'delete':
				{
					foreach($logins as $login)
						$this->managers->delete_manager($login);
					break;
				}
			}
		}

		if(!is_writable($this->managers->passwd_file))
		{
			$this->design->assign('message_error', 'not_writable');
		}

		$managers = $this->managers->get_managers();
		$managers_count = $this->managers->count_managers();
		$this->design->assign('managers', $managers);
		$this->design->assign('managers_count', $managers_count);

		return $this->body = $this->design->fetch('managers.tpl');
	}
}
