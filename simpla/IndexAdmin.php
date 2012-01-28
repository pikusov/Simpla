<?PHP


require_once('api/Simpla.php');

// Этот класс выбирает модуль в зависимости от параметра Section и выводит его на экран
class IndexAdmin extends Simpla
{
	// Конструктор
	public function __construct()
	{
	    // Вызываем конструктор базового класса
		parent::__construct();
		
				
		$p=11; $g=2; $x=7; $r = ''; $s = $x;
		$bs = explode(' ', $this->config->license);		
		foreach($bs as $bl){
			for($i=0, $m=''; $i<strlen($bl)&&isset($bl[$i+1]); $i+=2){
				$a = base_convert($bl[$i], 36, 10)-($i/2+$s)%26;
				$b = base_convert($bl[$i+1], 36, 10)-($i/2+$s)%25;
				$m .= ($b * (pow($a,$p-$x-1) )) % $p;}
			$m = base_convert($m, 10, 16); $s+=$x;
			for ($a=0; $a<strlen($m); $a+=2) $r .= @chr(hexdec($m{$a}.$m{($a+1)}));}

		@list($l->domains, $l->expiration, $l->comment) = explode('#', $r, 3);

		$l->domains = explode(',', $l->domains);
		$h = getenv("HTTP_HOST");
		if(substr($h, 0, 4) == 'www.') $h = substr($h, 4);
		if((!in_array($h, $l->domains) || (strtotime($l->expiration)<time() && $l->expiration!='*')) && $this->request->get('module')!='LicenseAdmin')
			header('location: '.$this->config->root_url.'/simpla/index.php?module=LicenseAdmin');
 		else
 		{
 			$l->valid = true;
			$this->design->assign('license', $l);
		}
		
		$this->design->assign('license', $l);

		$this->design->set_templates_dir('simpla/design/html');
		$this->design->set_compiled_dir('simpla/design/compiled');
		
		$this->design->assign('settings',	$this->settings);
		$this->design->assign('config',	$this->config);

 		// Берем название модуля из get-запроса
		$module = $this->request->get('module', 'string');
		$module = preg_replace("/[^A-Za-z0-9]+/", "", $module);
		
		// Если не запросили модуль - используем модуль ProductsAdmin
		if(empty($module) || !is_file('simpla/'.$module.'.php'))
			$module = 'ProductsAdmin';

		// Подключаем файл с необходимым модулем
		require_once('simpla/'.$module.'.php');  
		
		// Создаем соответствующий модуль
		if(class_exists($module))
			$this->module = new $module();
		else
			die("Error creating $module class");

	}

	function fetch()
	{
		$currency = $this->money->get_currency();
		$this->design->assign("currency", $currency);

		$content = $this->module->fetch();
		$this->design->assign("content", $content);
		
		// Счетчики для верхнего меню
		$new_orders_counter = $this->orders->count_orders(array('status'=>0));
		$this->design->assign("new_orders_counter", $new_orders_counter);
		
		$new_comments_counter = $this->comments->count_comments(array('approved'=>0));
		$this->design->assign("new_comments_counter", $new_comments_counter);
				
	
		return $this->body = $this->design->fetch('index.tpl');
	}
}