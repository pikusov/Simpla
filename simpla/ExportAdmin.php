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

class ExportAdmin extends Simpla
{
	private $export_files_dir = 'simpla/files/export/';

	public function fetch()
	{
		$this->design->assign('export_files_dir', $this->export_files_dir);
		if(!is_writable($this->export_files_dir))
			$this->design->assign('message_error', 'no_permission');

		if (!function_exists('iconv') && !function_exists('mb_convert_encoding'))
			$this->design->assign('message_error', 'iconv_or_mb_convert_encoding');

		return $this->design->fetch('export.tpl');
	}
	
}
