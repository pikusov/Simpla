<?PHP 

require_once('api/Simpla.php');

########################################
class CommentsAdmin extends Simpla
{


  function fetch()
  {
  
 	$filter = array();
  	$filter['page'] = max(1, $this->request->get('page', 'integer'));
  		
  	$filter['limit'] = 40;
 
    // Тип
    $type = $this->request->get('type', 'string');
    if($type)
    {
    	$filter['type'] = $type;
 		$this->design->assign('type', $type);
 	}

    // Поиск
  	$keyword = $this->request->get('keyword', 'string');
  	if(!empty($keyword))
  	{
	  	$filter['keyword'] = $keyword;
 		$this->design->assign('keyword', $keyword);
	}

  
  	// Обработка действий 	
  	if($this->request->method('post'))
  	{
		
		// Действия с выбранными
		$ids = $this->request->post('check');
		if(!empty($ids) && is_array($ids))
		switch($this->request->post('action'))
		{
		    case 'approve':
		    {
				foreach($ids as $id)
					$this->comments->update_comment($id, array('approved'=>1));    
		        break;
		    }
		    case 'delete':
		    {
				foreach($ids as $id)
					$this->comments->delete_comment($id);    
		        break;
		    }
		}		
		
 	}

  

	// Отображение
  	$comments_count = $this->comments->count_comments($filter);
	// Показать все страницы сразу
	if($this->request->get('page') == 'all')
		$filter['limit'] = $comments_count;	
  	$comments = $this->comments->get_comments($filter);
  	
  	// Выбирает объекты, которые прокомментированы:
  	$products_ids = array();
  	$posts_ids = array();
  	foreach($comments as $comment)
  	{
  		if($comment->type == 'product')
  			$products_ids[] = $comment->object_id;
  		if($comment->type == 'blog')
  			$posts_ids[] = $comment->object_id;
  	}
	$products = array();
	foreach($this->products->get_products(array('id'=>$products_ids)) as $p)
		$products[$p->id] = $p;

  	$posts = array();
  	foreach($this->blog->get_posts(array('id'=>$posts_ids)) as $p)
  		$posts[$p->id] = $p;
  		
  	foreach($comments as &$comment)
  	{
  		if($comment->type == 'product' && isset($products[$comment->object_id]))
  			$comment->product = $products[$comment->object_id];
  		if($comment->type == 'blog' && isset($posts[$comment->object_id]))
  			$comment->post = $posts[$comment->object_id];
  	}
  	
  	
 	$this->design->assign('pages_count', ceil($comments_count/$filter['limit']));
 	$this->design->assign('current_page', $filter['page']);

 	$this->design->assign('comments', $comments);
 	$this->design->assign('comments_count', $comments_count);

	return $this->design->fetch('comments.tpl');
  }
}


?>
