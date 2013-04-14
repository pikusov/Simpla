<?PHP
require_once('api/Simpla.php');

class ManagerAdmin extends Simpla
{	
	public function fetch()
	{
		if($this->request->method('post'))
		{
			$manager = new stdClass();
			$manager->old_login = $this->request->post('old_login');
			$manager->login = $this->request->post('login');
			
			if(!is_writable($this->managers->passwd_file))
			{
				$this->design->assign('message_error', 'not_writable');			
			}
			elseif(empty($manager->login))
			{
				$this->design->assign('message_error', 'empty_login');			
			}
			elseif($this->managers->get_manager($manager->login) && $manager->login!=$manager->old_login)
			{
	  			$manager->login = $manager->old_login;
	  			$manager->permissions = (array)$this->request->post('permissions');
	  			$this->design->assign('message_error', 'login_exists');
			}
			else
			{			
				if($this->request->post('password') != "")
					$manager->password = $this->request->post('password');
				
				// Обновляем права только другим менеджерам
				$current_manager = $this->managers->get_manager();
				if($manager->old_login != $current_manager->login)
					$manager->permissions = (array)$this->request->post('permissions');
		
				if(empty($manager->old_login))
				{
					$manager->login = $this->managers->add_manager($manager);
	  				$this->design->assign('message_success', 'added');
	  			}
		    	else
		    	{
		    		$manager->login = $this->managers->update_manager($manager->old_login, $manager);
	  				$this->design->assign('message_success', 'updated');
	  			}
		    	$manager = $this->managers->get_manager($manager->login);
	    	}
		}
		else
		{
			$login = $this->request->get('login');
			if(!empty($login))
				$manager = $this->managers->get_manager($login);			
		}	

		if(!empty($manager))
		{
			$this->design->assign('m', $manager);			
		}
		
 	  	return $this->design->fetch('manager.tpl');
	}
	
}

