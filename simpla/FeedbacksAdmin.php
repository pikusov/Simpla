<?PHP 

require_once('api/Simpla.php');

########################################
class FeedbacksAdmin extends Simpla
{


  function fetch()
  {
  
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
		if(!empty($ids))
		switch($this->request->post('action'))
		{
		    case 'delete':
		    {
				foreach($ids as $id)
					$this->feedbacks->delete_feedback($id);    
		        break;
		    }
		}		
		
 	}

  	// Отображение
	$filter = array();
	$filter['page'] = max(1, $this->request->get('page', 'integer')); 		
	$filter['limit'] = 20;

	// Поиск
	$keyword = $this->request->get('keyword', 'string');
	if(!empty($keyword))
	{
		$filter['keyword'] = $keyword;
		$this->design->assign('keyword', $keyword);
	}		

  	$feedbacks = $this->feedbacks->get_feedbacks($filter, true);
  	$feedbacks_count = $this->feedbacks->count_feedbacks($filter);
  	
 	$this->design->assign('pages_count', ceil($feedbacks_count/$filter['limit']));
 	$this->design->assign('current_page', $filter['page']);

 	$this->design->assign('feedbacks', $feedbacks);
 	$this->design->assign('feedbacks_count', $feedbacks_count);

	return $this->design->fetch('feedbacks.tpl');
  }
}


?>