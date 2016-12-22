<?php

/**
 * Simpla CMS
 *
 * @copyright	2016 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */

/**
 * Основной класс Simpla для доступа к API Simpla
 */
class Simpla
{
	// Свойства - Классы API
	private $classes = array(
		'config'     => 'Config',
		'request'    => 'Request',
		'db'         => 'Database',
		'settings'   => 'Settings',
		'design'     => 'Design',
		'products'   => 'Products',
		'variants'   => 'Variants',
		'categories' => 'Categories',
		'brands'     => 'Brands',
		'features'   => 'Features',
		'money'      => 'Money',
		'pages'      => 'Pages',
		'blog'       => 'Blog',
		'cart'       => 'Cart',
		'image'      => 'Image',
		'delivery'   => 'Delivery',
		'payment'    => 'Payment',
		'orders'     => 'Orders',
		'users'      => 'Users',
		'coupons'    => 'Coupons',
		'comments'   => 'Comments',
		'feedbacks'  => 'Feedbacks',
		'notify'     => 'Notify',
		'managers'   => 'Managers'
	);

	// Созданные объекты
	private static $objects = array();

	/**
	 * Конструктор оставим пустым, но определим его на случай обращения parent::__construct() в классах API
	 */
	public function __construct()
	{
		//error_reporting(E_ALL & !E_STRICT);
	}

	/**
	 * Магический метод, создает нужный объект API
	 */
	public function __get($name)
	{
		// Если такой объект уже существует, возвращаем его
		if(isset(self::$objects[$name]))
		{
			return(self::$objects[$name]);
		}

		// Если запрошенного API не существует - ошибка
		if(!array_key_exists($name, $this->classes))
		{
			return null;
		}

		// Определяем имя нужного класса
		$class = $this->classes[$name];

		// Подключаем его
		include_once(dirname(__FILE__).'/'.$class.'.php');

		// Сохраняем для будущих обращений к нему
		self::$objects[$name] = new $class();

		// Возвращаем созданный объект
		return self::$objects[$name];
	}

	/*
		Вспомогательные методы
	*/

	public function convert_str_encoding($str, $to_encoding, $from_encoding, $alt = false)
	{

		if (function_exists('iconv'))
		{
			$str = @iconv($from_encoding, $to_encoding, $str);
		}
		elseif (function_exists('mb_convert_encoding'))
		{
			$str = @mb_convert_encoding($str, $to_encoding, $from_encoding);
		}
		else
		{
			// TODO add сonverting Windows-1251 to UTF-8 and the reverse when no iconv and mb_convert_encoding
			return $alt ? $alt : $str;
		}

		return $str;
	}
}
