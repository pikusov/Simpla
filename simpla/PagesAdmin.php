<?PHP 

require_once('api/Simpla.php');

########################################
class PagesAdmin extends Simpla
{

  public function fetch()
  {
  
    // Меню
    $menus = $this->pages->get_menus();
 	$this->design->assign('menus', $menus);
 	
    // Текущее меню
  	$menu_id = $this->request->get('menu_id', 'integer'); 
  	if(!$menu_id || !$menu = $this->pages->get_menu($menu_id))
  	{
  		$menu = reset($menus);
  	}
 	$this->design->assign('menu', $menu);


   	// Обработка действий
  	if($this->request->method('post'))
  	{
		// Сортировка
		$positions = $this->request->post('positions'); 		
 		$ids = array_keys($positions);
		sort($positions);
		foreach($positions as $i=>$position)
			$this->pages->update_page($ids[$i], array('position'=>$position)); 

		
		// Действия с выбранными
		$ids = $this->request->post('check');
		if(is_array($ids))
		switch($this->request->post('action'))
		{
		    case 'disable':
		    {
				$this->pages->update_page($ids, array('visible'=>0));	      
				break;
		    }
		    case 'enable':
		    {
				$this->pages->update_page($ids, array('visible'=>1));	      
		        break;
		    }
		    case 'delete':
		    {
			    foreach($ids as $id)
					$this->pages->delete_page($id);    
		        break;
		    }
		    case 'rmove':
		    {
		    
		    	// целевая страница является текущей
		    	$target_page = $this->request->post('target_page', 'integer');
		    	
		    	$filter['page'] = $target_page;

			    // До какого товара перемещать
			    $limit = $filter['limit']*($target_page-1);
			    if($target_page > $this->request->get('page', 'integer'))
			    	$limit += count($ids)-1;
			    else
			    	$ids = array_reverse($ids, true);

				$category_id_filter = '';
				if(isset($filter['category_id']))
					$category_id_filter = $this->db->placehold('AND pc.category_id in(?@)', (array)$filter['category_id']);

				$brand_id_filter = '';
				if(isset($filter['brand_id']))
					$brand_id_filter = $this->db->placehold('AND p.brand_id in(?@)', (array)$filter['brand_id']);
			    
			    $query = $this->db->placehold("SELECT distinct p.position AS target FROM __products p LEFT JOIN __products_categories AS pc ON pc.product_id = p.id WHERE 1 $category_id_filter $brand_id_filter ORDER BY p.position LIMIT ? ,1", $limit);	
			   	$this->db->query($query);
			   	$target_position = $this->db->result('target');     
			   		 
		    	foreach($ids as $id)
		    	{		    	
			    	$query = $this->db->placehold("SELECT position FROM __products WHERE id=? LIMIT 1", $id);	
			    	$this->db->query($query);	      
			    	$initial_position = $this->db->result('position');

			    	if($target_position > $initial_position)
			    		$query = $this->db->placehold("	UPDATE __products p set p.position= p.position-1 WHERE p.position>? AND p.position<=?", $initial_position, $target_position);	
			    	else
			    		$query = $this->db->placehold("	UPDATE __products p set p.position= p.position+1 WHERE p.position<? AND p.position>=?", $initial_position, $target_position);	
			    		
		    		$this->db->query($query);	      			    	
		    		$query = $this->db->placehold("UPDATE __products SET __products.position = ? WHERE __products.id = ?", $target_position, $id);	
		    		$this->db->query($query);	
		    		     

			    }
		        break;
			}
		}		
		
 	}

  

	// Отображение
  	$pages = $this->pages->get_pages(array('menu_id'=>$menu->id));

 	$this->design->assign('pages', $pages);
	return $this->design->fetch('pages.tpl');
  }
}


?>