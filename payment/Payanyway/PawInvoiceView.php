<?PHP

require_once('view/View.php');

class PawInvoiceView extends View
{
	public function __construct()
	{
		parent::__construct();
	}

	//////////////////////////////////////////
	// Основная функция
	//////////////////////////////////////////
	public function fetch()
	{
		// Содержимое корзины
		$this->design->assign('cart',		$this->cart->get_cart());
	
        // Категории товаров
		$this->design->assign('categories', $this->categories->get_categories_tree());
		
		// Страницы
		$pages = $this->pages->get_pages(array('visible'=>1));		
		$this->design->assign('pages', $pages);
		
		// Создаем основной блок страницы
		$content = $this->design->fetch('payment/Payanyway/payanyway_invoice.tpl');
				
		// Передаем основной блок в шаблон
		$this->design->assign('content', $content);		
		
		// Создаем текущую обертку сайта (обычно index.tpl)
		$wrapper = $this->design->smarty->getTemplateVars('wrapper');
		if(empty($wrapper))
			$wrapper = 'index.tpl';
			
		$this->body = $this->design->fetch($wrapper);
		return $this->body;
	}
	
}