<?PHP
require_once('api/Simpla.php');

class ThemeAdmin extends Simpla
{
	private $themes_dir = 'design/';
	private $compiled_dir = 'compiled/';

	public function fetch()
	{
		if($this->request->method('post'))
		{
			$this->dir_delete($this->compiled_dir, false);
			$old_names = $this->request->post('old_name');
			$new_names = $this->request->post('new_name');
			if(is_array($old_names))
				foreach($old_names as $i=>$old_name)
					{
						$new_name = $new_names[$i];

						if(is_writable($this->themes_dir) && is_dir($this->themes_dir.$old_name) && !is_file($this->themes_dir.$new_name)&& !is_dir($this->themes_dir.$new_name))
						{
							rename($this->themes_dir.$old_name, $this->themes_dir.$new_name);
							if($this->settings->theme == $old_name)
								$this->settings->theme = $new_name;
						}
						elseif(is_file($this->themes_dir.$new_name) && $new_name!=$old_name)
							$message_error = 'name_exists';
					}

			$action = $this->request->post('action');
			$action_theme  = $this->request->post('theme');
			
			switch($this->request->post('action'))
			{
			    case 'set_main_theme':
			    {
					$this->settings->theme = $action_theme;	      
					break;
			    }
			    case 'clone_theme':
			    {	
			    	$new_name = $this->settings->theme;
			    	while(is_dir($this->themes_dir.$new_name) || is_file($this->themes_dir.$new_name))
			    	{
						if(preg_match('/(.+)_([0-9]+)$/', $new_name, $parts))
							$new_name = $parts[1].'_'.($parts[2]+1);
						else
							$new_name = $new_name.'_1';
					}
			    	$this->dir_copy($this->themes_dir.$this->settings->theme, $this->themes_dir.$new_name);	
			    	@unlink($this->themes_dir.$new_name.'/locked'); 
			    	$this->settings->theme = $new_name;
					break;
			    }
			    case 'delete_theme':
			    {
					$this->dir_delete($this->themes_dir.$action_theme);
					if($action_theme == $this->settings->theme)
					{
						$t = reset($this->get_themes());
						$this->settings->theme = $t->name;
					}
			        break;
			    }
			}
		}
	
		$themes = $this->get_themes();
		
		// Если нет прав на запись - передаем в дизайн предупреждение
		if(!is_writable($this->themes_dir))
		{
			$this->design->assign('message_error', 'permissions');
		}
		
		$current_theme->name = $this->settings->theme;
		$current_theme->locked = is_file($this->themes_dir.$current_theme->name.'/locked');
		$this->design->assign('theme', $current_theme);
		$this->design->assign('themes', $themes);
		$this->design->assign('themes_dir', $this->themes_dir);
  	  	return $this->design->fetch('theme.tpl');
	}

	private function dir_copy($src, $dst)
	{
		if(is_dir($src))
		{
			mkdir($dst, 0777);
			$files = scandir($src);
			foreach ($files as $file)
				if ($file != "." && $file != "..") $this->dir_copy("$src/$file", "$dst/$file"); 
		}
		elseif(file_exists($src))
			copy($src, $dst);
		@chmod($dts, 0777);
	}
	
	
	private function dir_delete($path, $delete_self = true)
	{
		if(!$dh = @opendir($path)) 
	 		return; 
		while (false !== ($obj = readdir($dh))) 
	    { 
			if($obj == '.' || $obj == '..') 
	            continue; 
	
	        if (!@unlink($path . '/' . $obj)) 
				$this->dir_delete($path.'/'.$obj, true); 
		} 
		closedir($dh);
		if($delete_self)
			@rmdir($path); 
		return; 
	} 
	
	private function get_themes()
	{
		if($handle = opendir($this->themes_dir)) {
			while(false !== ($file = readdir($handle)))
			{ 
				if(is_dir($this->themes_dir.'/'.$file) && $file[0] != '.')
				{
					unset($theme);
					$theme->name = $file;
					$theme->locked = is_file($this->themes_dir.$file.'/locked');
					$themes[] = $theme; 
        		} 
		    }
			closedir($handle); 
			sort($themes);
		}
		return $themes;
	}
}
