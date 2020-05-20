<?php
session_start();
?>

<html>
<head>
	<title>Восстановления пароля администратора</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
	<meta http-equiv="Content-Language" content="ru" />
</head>
<style>
  h1{font-size:26px; font-weight:normal}
  p{font-size:19px;}
  input{font-size:18px;}
  p.error{color:red;}
  div.maindiv{width: 600px; height: 300px; position: relative; left: 50%; top: 100px; margin-left: -300px; }
</style>
<body>
<div style='width:100%; height:100%;'> 
  <div class="maindiv">

<?php
require_once('api/Simpla.php');
$simpla = new Simpla();

// Если пришли по ссылке из письма
if($c = $simpla->request->get('code'))
{
	// Код не совпадает - прекращаем работу
	if(empty($_SESSION['admin_password_recovery_code']) || empty($c) || $_SESSION['admin_password_recovery_code'] !== $c)
	{
		header('Location:password.php');
		exit();
	}
	
	// IP не совпадает - прекращаем работу
	if(empty($_SESSION['admin_password_recovery_ip'])|| empty($_SERVER['REMOTE_ADDR']) || $_SESSION['admin_password_recovery_ip'] !== $_SERVER['REMOTE_ADDR'])
	{
		header('Location:password.php');
		exit();
	}
	
	// Если запостили пароль
	if($new_password = $simpla->request->post('new_password'))
	{
		// Файл с паролями
		$passwd_file = $simpla->config->root_dir.'simpla/.passwd';
		
		// Удаляем из сесси код, чтобы больше никто не воспользовался ссылкой
		unset($_SESSION['admin_password_recovery_code']);
		unset($_SESSION['admin_password_recovery_ip']);

		// Если в файлы запрещена запись - предупреждаем об этом
		if(!is_writable($passwd_file))
		{
			print "
				<h1>Восстановление пароля администратора</h1>
				<p class='error'>
				Файл /simpla/.passwd недоступен для записи.
				</p>
				<p>Вам нужно зайти по FTP и изменить права доступа к этому файлу, после чего повторить процедуру восстановления пароля.</p>
			";
		}
		else
		{
			// Новый логин и пароль
			$new_login = $simpla->request->post('new_login');
			$new_password = $simpla->request->post('new_password');
			if(!$simpla->managers->update_manager($new_login, array('password'=>$new_password)))
				$simpla->managers->add_manager(array('login'=>$new_login, 'password'=>$new_password));
			
			print "
				<h1>Восстановление пароля администратора</h1>
				<p>
				Новый пароль установлен
				</p>
				<p>
				<a href='".$simpla->root_url."/simpla/index.php?module=ManagersAdmin'>Перейти в панель управления</a>
				</p>
			";
		}
	}
	else
	{
	// Форма указалия нового логина и пароля
	print "
		<h1>Восстановление пароля администратора</h1>
		<p>
		<form method=post>
			Новый логин:<br><input type='text' name='new_login'><br><br>
			Новый пароль:<br><input type='password' name='new_password'><br><br>
			<input type='submit' value='Сохранить логин и пароль'>
		</form>
		</p>
		";
	}
}
else
{
	print "
		<h1>Восстановление пароля администратора</h1>
		<p>
		Введите email администратора
		<form method='post' action='".$simpla->root_url."/password.php'>
			<input type='text' name='email'>
			<input type='submit' value='Восстановить пароль'>
		</form>
		</p>
	";

	$admin_email = $simpla->settings->admin_email;
	
	if(isset($_POST['email']))
	{
		if($_POST['email'] === $admin_email)
		{
			$code = $simpla->config->token(mt_rand(1, mt_getrandmax()).mt_rand(1, mt_getrandmax()).mt_rand(1, mt_getrandmax()));
			$_SESSION['admin_password_recovery_code'] = $code;
			$_SESSION['admin_password_recovery_ip'] = $_SERVER['REMOTE_ADDR'];
			
			$message = 'Вы или кто-то другой запросил ссылку на восстановление пароля администратора.<br>';
			$message .= 'Для смены пароля перейдите по ссылке '.$simpla->config->root_url.'/password.php?code='.$code.'<br>';
			$message .= 'Если письмо пришло вам по ошибке, проигнорируйте его.';
			
			$simpla->notify->email($admin_email, 'Восстановление пароля администратора '.$simpla->settings->site_name, $message, $simpla->settings->notify_from_email);
		}
		print "Вам отправлена ссылка для восстановления пароля. Если письмо вам не пришло, значит вы неверно указали email или что-то не так с хостингом";
	}

}
?>

  </div>
</div>
</body>
</html>
