<?php

/**
 * Основной класс для доступа ко всем возможностям Simplacms
 *
 * @copyright 	2011 Denis Pikusov
 * @link 		http://simplacms.ru
 * @author 		Denis Pikusov
 *
 */

require_once('api/Config.php');
require_once('api/Request.php');
require_once('api/Database.php');
require_once('api/Settings.php');
require_once('api/Design.php');
require_once('api/Money.php');
require_once('api/Pages.php');
require_once('api/Blog.php');
require_once('api/Catalog.php');
require_once('api/Features.php');
require_once('api/Cart.php');
require_once('api/Image.php');
require_once('api/Delivery.php');
require_once('api/Payment.php');
require_once('api/Orders.php');
require_once('api/Users.php');

class Simpla
{
	public $config;		/**< Экземпляр класса Conifg */
	public $request;	/**< Экземпляр класса Request */
	public $db;			/**< Экземпляр класса Database  */
	public $settings;	/**< Экземпляр класса Settings  */
	public $design;		/**< Экземпляр класса Design  */
	public $user;		/**< Экземпляр класса User  */
	public $money;		/**< Экземпляр класса Currencies  */
	public $pages;		/**< Экземпляр класса ArticlesModel  */
	public $blog;		/**< Экземпляр класса ArticlesModel  */
	public $catalog;	/**< Экземпляр класса Catalog  */
	public $features;	/**< Экземпляр класса Features  */
	public $cart;		/**< Экземпляр класса Cart  */
	public $image;		/**< Экземпляр класса Cart  */
	public $delivery;	/**< Экземпляр класса Cart  */
	public $payment;	/**< Экземпляр класса Cart  */
	public $orders;		/**< Экземпляр класса Cart  */
	public $users;		/**< Экземпляр класса Cart  */
	
	private static $simpla_instance;

	/**
	 * В конструкторе создаем нужные объекты.
	 * При повторном вызове конструктора устанавливаем ссылки на уже существующие экземпляры.
	 * Немного напоминает синглтон - члены класса Simpla всегда ссылаются на одни и те же объекты.
	 */
	 
	public function __construct()
	{
		if(self::$simpla_instance)
		{
			$this->config		= &self::$simpla_instance->config;
			$this->request		= &self::$simpla_instance->request;
			$this->db			= &self::$simpla_instance->db;
			$this->settings		= &self::$simpla_instance->settings;
			$this->design		= &self::$simpla_instance->design;
			$this->image		= &self::$simpla_instance->image;
			$this->money		= &self::$simpla_instance->money;
			$this->pages		= &self::$simpla_instance->pages;
			$this->blog			= &self::$simpla_instance->blog;
			$this->catalog		= &self::$simpla_instance->catalog;
			$this->features		= &self::$simpla_instance->features;
			$this->cart			= &self::$simpla_instance->cart;
			$this->delivery		= &self::$simpla_instance->delivery;
			$this->payment		= &self::$simpla_instance->payment;
			$this->orders		= &self::$simpla_instance->orders;
			$this->users		= &self::$simpla_instance->users;
		}
		else
		{
			self::$simpla_instance = $this;

			$this->config		= new Config();
			$this->request		= new Request();
			$this->db			= new Database();
			$this->settings		= new Settings();
			$this->design		= new Design();
			$this->image		= new Image();
			$this->money		= new Money();
			$this->pages		= new Pages();
			$this->blog			= new Blog();
			$this->catalog		= new Catalog();	
			$this->features		= new Features();						
			$this->cart			= new Cart();
			$this->delivery		= new Delivery();
			$this->payment		= new Payment();
			$this->orders		= new Orders();
			$this->users		= new Users();
		}
	}
}