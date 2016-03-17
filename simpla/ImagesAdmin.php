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

class ImagesAdmin extends Simpla
{
	public function fetch()
	{
		$images_dir = 'design/'.$this->settings->theme.'/images/';
		$allowed_extentions = array('png', 'gif', 'jpg', 'jpeg', 'ico');
		$images = array();

		// Сохраняем
		if($this->request->method('post') && !is_file($images_dir.'../locked'))
		{
			$old_names = $this->request->post('old_name');
			$new_names = $this->request->post('new_name');
			if(is_array($old_names))
				foreach($old_names as $i=>$old_name)
					{
						$new_name = $new_names[$i];
						$new_name = trim(pathinfo($new_name, PATHINFO_FILENAME).'.'.pathinfo($old_name, PATHINFO_EXTENSION), '.');

						if(is_writable($images_dir) && is_file($images_dir.$old_name) && !is_file($images_dir.$new_name))
							rename($images_dir.$old_name, $images_dir.$new_name);
						elseif(is_file($images_dir.$new_name) && $new_name!=$old_name)
							$message_error = 'name_exists';
					}

			$delete_image = trim($this->request->post('delete_image'), '.');

			if(!empty($delete_image))
			{
				@unlink($images_dir.$delete_image);
			}

			// Загрузка изображений
			if($images = $this->request->files('upload_images'))
			{
				for($i=0; $i<count($images['name']); $i++)
				{
					$name = trim($images['name'][$i], '.');
					if(in_array(strtolower(pathinfo($name, PATHINFO_EXTENSION)), $allowed_extentions))
						move_uploaded_file($images['tmp_name'][$i], $images_dir.$name);
				}
			}


			if(!isset($message_error))
			{
				header("Location: ".$_SERVER['REQUEST_URI']);
				exit();
			}
			else
				$this->design->assign('message_error', $message_error);

		}



		// Чтаем все файлы
		if($handle = opendir($images_dir)) {
			while(false !== ($file = readdir($handle)))
			{
				if(is_file($images_dir.$file) && $file[0] != '.' && in_array(pathinfo($file, PATHINFO_EXTENSION), $allowed_extentions))
				{
					$image = new stdClass;
					$image->name = $file;
					$image->size = filesize($images_dir.$file);
					list($image->width, $image->height) = @getimagesize($images_dir.$file);
					$images[$file] = $image;
				}
			}
			closedir($handle);
			ksort($images);
		}

		// Если нет прав на запись - передаем в дизайн предупреждение
		if(!is_writable($images_dir))
		{
			$this->design->assign('message_error', 'permissions');
		}
		elseif(is_file($images_dir.'../locked'))
		{
			$this->design->assign('message_error', 'theme_locked');
		}

		$this->design->assign('theme', $this->settings->theme);
		$this->design->assign('images', $images);
		$this->design->assign('images_dir', $images_dir);

		return $this->design->fetch('images.tpl');
	}

}

