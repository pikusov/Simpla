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

// Этот класс выбирает модуль в зависимости от параметра Section и выводит его на экран
class IndexAdmin extends Simpla
{
	// Соответсвие модулей и названий соответствующих прав
	private $modules_permissions = array(
		'ProductsAdmin'       => 'products',
		'ProductAdmin'        => 'products',
		'CategoriesAdmin'     => 'categories',
		'CategoryAdmin'       => 'categories',
		'BrandsAdmin'         => 'brands',
		'BrandAdmin'          => 'brands',
		'FeaturesAdmin'       => 'features',
		'FeatureAdmin'        => 'features',
		'OrdersAdmin'         => 'orders',
		'OrderAdmin'          => 'orders',
		'OrdersLabelsAdmin'   => 'labels',
		'OrdersLabelAdmin'    => 'labels',
		'UsersAdmin'          => 'users',
		'UserAdmin'           => 'users',
		'ExportUsersAdmin'    => 'users',
		'GroupsAdmin'         => 'groups',
		'GroupAdmin'          => 'groups',
		'CouponsAdmin'        => 'coupons',
		'CouponAdmin'         => 'coupons',
		'PagesAdmin'          => 'pages',
		'PageAdmin'           => 'pages',
		'BlogAdmin'           => 'blog',
		'PostAdmin'           => 'blog',
		'CommentsAdmin'       => 'comments',
		'FeedbacksAdmin'      => 'feedbacks',
		'ImportAdmin'         => 'import',
		'ExportAdmin'         => 'export',
		'BackupAdmin'         => 'backup',
		'StatsAdmin'          => 'stats',
		'ThemeAdmin'          => 'design',
		'StylesAdmin'         => 'design',
		'TemplatesAdmin'      => 'design',
		'ImagesAdmin'         => 'design',
		'SettingsAdmin'       => 'settings',
		'CurrencyAdmin'       => 'currency',
		'DeliveriesAdmin'     => 'delivery',
		'DeliveryAdmin'       => 'delivery',
		'PaymentMethodAdmin'  => 'payment',
		'PaymentMethodsAdmin' => 'payment',
		'ManagersAdmin'       => 'managers',
		'ManagerAdmin'        => 'managers',
		'LicenseAdmin'        => 'license'
	);

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

		if(!is_dir($this->config->root_dir.'/compiled'))
			mkdir($this->config->root_dir.'simpla/design/compiled', 0777);

		$this->design->set_compiled_dir('simpla/design/compiled');

		$this->design->assign('settings',	$this->settings);
		$this->design->assign('config',	$this->config);

		// Администратор
		$this->manager = $this->managers->get_manager();
		$this->design->assign('manager', $this->manager);

		// Берем название модуля из get-запроса
		$module = $this->request->get('module', 'string');
		$module = preg_replace("/[^A-Za-z0-9]+/", "", $module);

		// Если не запросили модуль - используем модуль первый из разрешенных
		if(empty($module) || !is_file('simpla/'.$module.'.php'))
		{
			foreach($this->modules_permissions as $m=>$p)
			{
				if($this->managers->access($p))
				{
					$module = $m;
					break;
				}
			}
		}
		if(empty($module))
			$module = 'ProductsAdmin';

		// Подключаем файл с необходимым модулем
		require_once('simpla/'.$module.'.php');

		// Создаем соответствующий модуль
		if(class_exists($module))
			$this->module = new $module();
		else
			die("Error creating $module class");

	}

	public function fetch()
	{
		$currency = $this->money->get_currency();
		$this->design->assign("currency", $currency);

		// Проверка прав доступа к модулю
		if(isset($this->modules_permissions[get_class($this->module)])
		&& $this->managers->access($this->modules_permissions[get_class($this->module)]))
		{
			$content = $this->module->fetch();
			$this->design->assign("content", $content);
		}
		else
		{
			$this->design->assign("content", "Permission denied");
		}

		// Счетчики для верхнего меню
		$new_orders_counter = $this->orders->count_orders(array('status'=>0));
		$this->design->assign("new_orders_counter", $new_orders_counter);

		$new_comments_counter = $this->comments->count_comments(array('approved'=>0));
		$this->design->assign("new_comments_counter", $new_comments_counter);

		// Создаем текущую обертку сайта (обычно index.tpl)
		$wrapper = $this->design->smarty->getTemplateVars('wrapper');
		if(is_null($wrapper))
			$wrapper = 'index.tpl';

		if(!empty($wrapper))
			return $this->body = $this->design->fetch($wrapper);
		else
			return $this->body = $content;
	}
}
