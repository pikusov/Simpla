<?PHP

require_once('View.php');

class RegisterView extends View
{
	function fetch()
	{
		$default_status = 1; // Активен ли пользователь сразу после регистрации (0 или 1)
		
		if($this->request->method('post') && $this->request->post('register'))
		{
			$name			= $this->request->post('name');
			$email			= $this->request->post('email');
			$password		= $this->request->post('password');
			
			$this->design->assign('name', $name);
			$this->design->assign('email', $email);
			
			$this->db->query('SELECT count(*) as count FROM __users WHERE email=?', $email);
			$user_exists = $this->db->result('count');

			if($user_exists)
				$this->design->assign('error', 'user_exists');
			elseif(empty($name))
				$this->design->assign('error', 'empty_name');
			elseif(empty($email))
				$this->design->assign('error', 'empty_email');
			elseif(empty($password))
				$this->design->assign('error', 'empty_password');		
			elseif($user_id = $this->users->add_user(array('name'=>$name, 'email'=>$email, 'password'=>$password, 'enabled'=>$default_status)))
			{
				$_SESSION['user_id'] = $user_id;
				header('Location: '.$this->config->root_url);
			}
			else
				$this->design->assign('error', 'unknown error');
	
		}
		return $this->design->fetch('register.tpl');
	}	
}
