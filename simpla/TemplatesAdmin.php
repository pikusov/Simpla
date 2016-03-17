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

class TemplatesAdmin extends Simpla
{
	public function fetch()
	{
		$templates_dir = 'design/'.$this->settings->theme.'/html/';
		$templates = array();

		// Порядок файлов в меню
		$sort = array('index.tpl', 'page.tpl', 'products.tpl', 'main.tpl', 'product.tpl', 'blog.tpl', 'post.tpl', 'cart.tpl', 'cart_informer.tpl', 'order.tpl', 'login.tpl', 'register.tpl', 'user.tpl', 'feedback.tpl', 'password_remind.tpl', 'email_order.tpl', 'email_password_remind.tpl', 'pagination.tpl');

		// Чтаем все tpl-файлы
		if($handle = opendir($templates_dir)) {
			$i = count($sort);
			while(false !== ($file = readdir($handle)))
			{
				if(is_file($templates_dir.$file) && $file[0] != '.'  && pathinfo($file, PATHINFO_EXTENSION) == 'tpl')
				{
					if(($key = array_search($file, $sort)) !== false)
						$templates[$key] = $file;
					else
						$templates[$i++] = $file;
				}
			}
			closedir($handle);
			ksort($templates);
		}

		// Текущий шаблон
		$template_file = $this->request->get('file');

		if(!empty($template_file) && pathinfo($template_file, PATHINFO_EXTENSION) != 'tpl')
			exit();


		// Если не указан - вспоминаем его из сессии
		if(empty($template_file) && isset($_SESSION['last_edited_template']))
			$template_file = $_SESSION['last_edited_template'];
		// Иначе берем первый файл из списка
		elseif(empty($template_file))
			$template_file = reset($templates);

		// Передаем имя шаблона в дизайн
		$this->design->assign('template_file', $template_file);

		// Если можем прочитать файл - передаем содержимое в дизайн
		if(is_readable($templates_dir.$template_file))
		{
			$template_content = file_get_contents($templates_dir.$template_file);
			$this->design->assign('template_content', $template_content);
		}

		// Если нет прав на запись - передаем в дизайн предупреждение
		if(!empty($template_file) && !is_writable($templates_dir.$template_file) && !is_file($templates_dir.'../locked'))
		{
			$this->design->assign('message_error', 'permissions');
		}
		elseif(is_file($templates_dir.'../locked'))
		{
			$this->design->assign('message_error', 'theme_locked');
		}
		else
		{
			// Запоминаем в сессии имя редактируемого шаблона
			$_SESSION['last_edited_template'] = $template_file;
		}

		$this->design->assign('theme', $this->settings->theme);
		$this->design->assign('templates', $templates);

		return $this->design->fetch('templates.tpl');
	}

}

