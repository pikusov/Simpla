<?php

/**
 * Simpla CMS
 *
 * @copyright	2016 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */

define( 'PCLZIP_TEMPORARY_DIR', 'simpla/files/backup/' );

require_once('api/Simpla.php');
require_once('simpla/pclzip/pclzip.lib.php');

class BackupAdmin extends Simpla
{

	public function fetch()
	{
	
		$dir = 'simpla/files/backup/';
		// Обработка действий
		if($this->request->method('post'))
		{
			switch($this->request->post('action'))
			{
				case 'create':
				{
					$filename = $dir.'simpla_'.date("Y_m_d_G_i_s").'.zip';
					##Дамп базы	
					$this->db->dump($dir.'simpla.sql');
					chmod($dir.'simpla.sql', 0777);
					
					### Архивируем
					$zip = new PclZip($filename);
					$v_list = $zip->create(array('files', $dir.'simpla.sql'), PCLZIP_OPT_REMOVE_PATH, $dir, PCLZIP_CB_PRE_ADD, "myCallBack");
					if ($v_list == 0)
					{
						trigger_error('Не могу заархивировать '.$zip->errorInfo(true));
					}
					$this->design->assign('message_success', 'created');

					break;
				}
				case 'restore':
				{
					$name = $this->request->post('name');

					$archive = $dir.$name;
					$zip = new PclZip($archive);

					$this->clean_dir('files');

					if (!$zip->extract(PCLZIP_OPT_PATH, '', PCLZIP_OPT_BY_PREG, "/^files\//", PCLZIP_CB_POST_EXTRACT, 'myPostExtractCallBack'))
					{
						trigger_error('Не могу разархивировать '.$zip->errorInfo(true));
					}
					elseif (!$zip->extract(PCLZIP_OPT_PATH, $dir, PCLZIP_OPT_BY_NAME, 'simpla.sql'))
					{
						trigger_error('Не могу разархивировать '.$zip->errorInfo(true));
					}
					elseif (!is_readable($dir.'simpla.sql'))
					{
						trigger_error('Не могу прочитать файл /temp/simpla.sql');
					}
					else
					{
						$this->db->restore($dir.'simpla.sql');
						unlink($dir.'simpla.sql');
						$this->design->assign('message_success', 'restored');
					}
					break;
				}
				case 'delete':
				{
					$names = $this->request->post('check');
					foreach($names as $name)
						unlink($dir.$name);
					break;
				}
			}
		}

		$backup_files = glob($dir."*.zip");
		$backups = array();
		if(is_array($backup_files))
		{
			foreach($backup_files as $backup_file)
			{	
				$backup = new stdClass;
				$backup->name = basename($backup_file);
				$backup->size = filesize($backup_file);
				$backups[] = $backup;
			}
		}
		$backups = array_reverse($backups);
		
		$this->design->assign('backup_files_dir', $dir);
		if(!is_writable($dir))
			$this->design->assign('message_error', 'no_permission');
		
		$this->design->assign('backups', $backups);

		return $this->design->fetch('backup.tpl');
	}
	
	private function clean_dir($path)
	{
		$path= rtrim($path, '/').'/';
		$handle = opendir($path);
		for (;false !== ($file = readdir($handle));)
			if($file != "." and $file != ".." )
			{
				$fullpath= $path.$file;
				if( is_dir($fullpath) )
				{
					$this->clean_dir($fullpath);
					rmdir($fullpath);
				}
				else
					unlink($fullpath);
			}
		closedir($handle);
	}
	
}


function myPostExtractCallBack($p_event, &$p_header)
{
	// проверяем успешность распаковки
	if ($p_header['status'] == 'ok')
	{
		// Меняем права доступа
		@chmod($p_header['filename'], 0777);
	}
	return 1;
}

function myCallBack($p_event, &$p_header)
{
	$fname = $p_header['stored_filename'];
	if(preg_match('/^files\/products\/.+/i', $fname))
		return 0;
	return 1;
}


