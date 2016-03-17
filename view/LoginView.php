<?php

/**
 * Simpla CMS
 *
 * @copyright	2016 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */

require_once('View.php');

class LoginView extends View
{
	public function fetch()
	{
		// Выход
		if($this->request->get('action') == 'logout')
		{
			unset($_SESSION['user_id']);
			header('Location: '.$this->config->root_url);
			exit();
		}
		// Вспомнить пароль
		elseif($this->request->get('action') == 'password_remind')
		{
			// Если запостили email
			if($this->request->method('post') && $this->request->post('email'))
			{
				$email = $this->request->post('email');
				$this->design->assign('email', $email);

				// Выбираем пользователя из базы
				$user = $this->users->get_user($email);
				if(!empty($user))
				{
					// Генерируем секретный код и сохраняем в сессии
					$code = md5(uniqid($this->config->salt, true));
					$_SESSION['password_remind_code'] = $code;
					$_SESSION['password_remind_user_id'] = $user->id;

					// Отправляем письмо пользователю для восстановления пароля
					$this->notify->email_password_remind($user->id, $code);
					$this->design->assign('email_sent', true);
				}
				else
				{
					$this->design->assign('error', 'user_not_found');
				}
			}
			// Если к нам перешли по ссылке для восстановления пароля
			elseif($this->request->get('code'))
			{
				// Проверяем существование сессии
				if(!isset($_SESSION['password_remind_code']) || !isset($_SESSION['password_remind_user_id']))
				return false;

				// Проверяем совпадение кода в сессии и в ссылке
				if($this->request->get('code') != $_SESSION['password_remind_code'])
					return false;

				// Выбераем пользователя из базы
				$user = $this->users->get_user(intval($_SESSION['password_remind_user_id']));
				if(empty($user))
					return false;

				// Залогиниваемся под пользователем и переходим в кабинет для изменения пароля
				$_SESSION['user_id'] = $user->id;
				header('Location: '.$this->config->root_url.'/user');
			}
			return $this->design->fetch('password_remind.tpl');
		}
		// Вход
		elseif($this->request->method('post') && $this->request->post('login'))
		{
			$email			= $this->request->post('email');
			$password		= $this->request->post('password');

			$this->design->assign('email', $email);

			if($user_id = $this->users->check_password($email, $password))
			{
				$user = $this->users->get_user($email);
				if($user->enabled)
				{
					$_SESSION['user_id'] = $user_id;
					$this->users->update_user($user_id, array('last_ip'=>$_SERVER['REMOTE_ADDR']));

					// Перенаправляем пользователя на прошлую страницу, если она известна
					if(!empty($_SESSION['last_visited_page']))
						header('Location: '.$_SESSION['last_visited_page']);
					else
						header('Location: '.$this->config->root_url);
				}
				else
				{
					$this->design->assign('error', 'user_disabled');
				}
			}
			else
			{
				$this->design->assign('error', 'login_incorrect');
			}
		}
		return $this->design->fetch('login.tpl');
	}
}
