<?PHP
require_once('api/Simpla.php');

class PageAdmin extends Simpla
{	
	public function fetch()
	{	
		if($this->request->method('POST'))
		{
			$page->id = $this->request->post('id', 'integer');
			$page->name = $this->request->post('name');
			$page->header = $this->request->post('header');
			$page->url = $this->request->post('url');
			$page->meta_title = $this->request->post('meta_title');
			$page->meta_keywords = $this->request->post('meta_keywords');
			$page->meta_description = $this->request->post('meta_description');
			$page->body = $this->request->post('body');
			$page->menu_id = $this->request->post('menu_id', 'integer');
			$page->visible = $this->request->post('visible', 'boolean');
	
			## Не допустить одинаковые URL разделов.
			if(($p = $this->pages->get_page($page->url)) && $p->id!=$page->id)
			{			
				$this->design->assign('message_error', 'url_exists');
			}
			else
			{
				if(empty($page->id))
				{
	  				$page->id = $this->pages->add_page($page);
	  				$page = $this->pages->get_page($page->id);
	  				$this->design->assign('message_success', 'added');
  	    		}
  	    		else
  	    		{
  	    			$this->pages->update_page($page->id, $page);
	  				$page = $this->pages->get_page($page->id);
	  				$this->design->assign('message_success', 'updated');
   	    		}
			}
		}
		else
		{
			$id = $this->request->get('id', 'integer');
			if(!empty($id))
				$page = $this->pages->get_page(intval($id));			
			else
			{
				$page->menu_id = $this->request->get('menu_id');
				$page->visible = 1;
			}
		}	

		$this->design->assign('page', $page);
		
 	  	$menus = $this->pages->get_menus();
		$this->design->assign('menus', $menus);
		
	    // Текущее меню
	    if(isset($page->menu_id))
	  		$menu_id = $page->menu_id; 
	  	if(empty($menu_id) || !$menu = $this->pages->get_menu($menu_id))
	  	{
	  		$menu = reset($menus);
	  	}
	 	$this->design->assign('menu', $menu);


 	  	return $this->design->fetch('page.tpl');
	}
	
}

