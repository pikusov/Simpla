<?php

/**
 * Класс-обертка для конфигурационного файла с настройками магазина
 * В отличие от класса Settings, Config оперирует низкоуровневыми настройками, например найстройками базы данных.
 *
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 */
 
require_once('Simpla.php');

class Config
{
	public $version = '2.1.4';
	
	// Файл для хранения настроек
	public $config_file = 'config/config.php';

	private $vars = array();
	
	// В конструкторе записываем настройки файла в переменные этого класса
	// для удобного доступа к ним. Например: $simpla->config->db_user
	public function __construct()
	{		
		// Временная зона
		date_default_timezone_set('CET');

		// Читаем настройки из дефолтного файла
		$ini = parse_ini_file($this->config_file);
		// Записываем настройку как переменную класса
		foreach($ini as $var=>$value)
			$this->vars[$var] = $value;
		
		// Вычисляем DOCUMENT_ROOT вручную, так как иногда в нем находится что-то левое
		$localpath=getenv("SCRIPT_NAME");
		$absolutepath=getenv("SCRIPT_FILENAME");
		$_SERVER['DOCUMENT_ROOT']=substr($absolutepath,0,strpos($absolutepath,$localpath));

		// Адрес сайта - тоже одна из настроек, но вычисляем его автоматически, а не берем из файла
		$script_dir1 = realpath(dirname(dirname(__FILE__)));
		$script_dir2 = realpath($_SERVER['DOCUMENT_ROOT']);
		$subdir = trim(substr($script_dir1, strlen($script_dir2)), "/\\");

		$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'? 'https' : 'http';
		$this->vars['root_url'] = $protocol.'://'.rtrim($_SERVER['HTTP_HOST']);
		if(!empty($subdir))
			$this->vars['root_url'] .= '/'.$subdir;

		// Подпапка в которую установлена симпла относительно корня веб-сервера
		$this->vars['subfolder'] = $subdir.'/';

		// Определяем корневую директорию сайта
		$this->vars['root_dir'] =  dirname(dirname(__FILE__)).'/';

		// Максимальный размер загружаемых файлов
		$max_upload = (int)(ini_get('upload_max_filesize'));
		$max_post = (int)(ini_get('post_max_size'));
		$memory_limit = (int)(ini_get('memory_limit'));
		$this->vars['max_upload_filesize'] = min($max_upload, $max_post, $memory_limit)*1024*1024;
		
		// Соль (разная для каждой копии сайта, изменяющаяся при изменении config-файла)
		$s = stat($this->config_file);
		$this->vars['salt'] = md5(md5_file($this->config_file).$s['dev'].$s['ino'].$s['uid'].$s['mtime']);
	}

	// Магическим методов возвращаем нужную переменную
	public function __get($name)
	{
		if(isset($this->vars[$name]))
			return $this->vars[$name];
		else
			return null;
	}
	
	// Магическим методов задаём нужную переменную
	public function __set($name, $value)
	{
		# Запишем конфиги
		if(isset($this->vars[$name]))
		{
			$conf = file_get_contents($this->config_file);
			$conf = preg_replace("/".$name."\s*=.*\n/i", $name.' = '.$value."\r\n", $conf);
			$cf = fopen($this->config_file, 'w');
			fwrite($cf, $conf);
			fclose($cf);
			$this->vars[$name] = $value;
		}
	}

	public function token($text)
	{
		return md5($text.$this->salt);
	}	
	
	public function check_token($text, $token)
	{
		if(!empty($token) && $token === $this->token($text))
			return true;
		return false;
	}	
	
	public function get_admin_login()
	{
		$current_login = false;
		$passwd = file_get_contents($this->root_dir.'simpla/.passwd');
		if(preg_match('/([^:^\r^\n]+):.+/', $passwd, $matches))
		{
			$current_login = $matches[1];
		}
		return($current_login);
	}	

	public function set_admin_password($login, $new_pass)
	{
		$passwd_file = $this->root_dir.'simpla/.passwd';				
		$new_cpass = $this->crypt_apr1_md5($new_pass);
		
		if(!$passfile = fopen($passwd_file, 'w'))
			return false;
		
		fwrite($passfile, "$login:$new_cpass");
		fclose($passfile);
	}
	
	private function crypt_apr1_md5($plainpasswd) {
		$salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
		$len = strlen($plainpasswd);
		$text = $plainpasswd.'$apr1$'.$salt;
		$bin = pack("H32", md5($plainpasswd.$salt.$plainpasswd));
		for($i = $len; $i > 0; $i -= 16) { $text .= substr($bin, 0, min(16, $i)); }
		for($i = $len; $i > 0; $i >>= 1) { $text .= ($i & 1) ? chr(0) : $plainpasswd{0}; }
		$bin = pack("H32", md5($text));
		for($i = 0; $i < 1000; $i++) {
			$new = ($i & 1) ? $plainpasswd : $bin;
			if ($i % 3) $new .= $salt;
			if ($i % 7) $new .= $plainpasswd;
			$new .= ($i & 1) ? $bin : $plainpasswd;
			$bin = pack("H32", md5($new));
		}
		for ($i = 0; $i < 5; $i++) {
			$k = $i + 6;
			$j = $i + 12;
			if ($j == 16) $j = 5;
			$tmp = $bin[$i].$bin[$k].$bin[$j].$tmp;
		}
		$tmp = chr(0).chr(0).$bin[11].$tmp;
		$tmp = strtr(strrev(substr(base64_encode($tmp), 2)),
		"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
		"./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
		return "$"."apr1"."$".$salt."$".$tmp;
	}
		
}
