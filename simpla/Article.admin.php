<?PHP

require_once('Widget.admin.php');
require_once('../placeholder.php');


############################################
# Class EditServiceSection - edit the static section
############################################
class Article extends Widget
{
  var $item;
  function Article(&$parent)
  {
    Widget::Widget($parent);
    $this->add_param('page');
    $this->prepare();
  }

  function prepare()
  {
  	$item_id = intval($this->param('item_id'));
  	if(
  	   isset($_POST['header']) &&
  	   isset($_POST['meta_title']) &&
  	   isset($_POST['meta_keywords']) &&
  	   isset($_POST['meta_description']) &&
  	   isset($_POST['annotation']) &&
  	   isset($_POST['body']))
  	{
		
		$this->check_token();
		
  		$this->item->header = $_POST['header'];
  		$this->item->meta_title = $_POST['meta_title'];
  		$this->item->meta_keywords = $_POST['meta_keywords'];
  		$this->item->meta_description = $_POST['meta_description'];
  		$this->item->url = $_POST['url'];
  		$this->item->annotation = $_POST['annotation'];
  		$this->item->body = $_POST['body'];

  		if(isset($_POST['enabled']) && $_POST['enabled']==1)
  		  $this->item->enabled = 1;
  		else
  		  $this->item->enabled = 0; 
  		  
        ## Не допустить одинаковые URL новостей.
    	$query = sql_placeholder('select count(*) as count from articles where url=? and article_id!=?',
                $this->item->url,
                $item_id);
        $this->db->query($query);
        $res = $this->db->result();

  		if(empty($this->item->header))
  		  $this->error_msg = $this->lang->ENTER_TITLE;
  		elseif($res->count>0)
  		  $this->error_msg = 'Статья с таким URL уже существует. Выберите другой URL.';
        else
  		{
  			if(empty($item_id))
            {
  				$query = sql_placeholder('INSERT INTO articles(article_id, header, url, meta_title, meta_keywords, meta_description, annotation, body, enabled, created, modified) VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?, now(), now())',
                	                  $this->item->header,
                	                  $this->item->url,
  			                          $this->item->meta_title,
  			                          $this->item->meta_keywords,
  			                          $this->item->meta_description,
  			                          $this->item->annotation,
  			                          $this->item->body,
  			                          $this->item->enabled);
                $this->db->query($query);
	  			$inserted_id = $this->db->insert_id();

  				$query = sql_placeholder('UPDATE articles SET order_num=article_id WHERE article_id=?',
  			                          $inserted_id);
  				$this->db->query($query);

            }
  			else
            {
  				$query = sql_placeholder('UPDATE articles SET header=?, url=?, meta_title=?, meta_keywords=?, meta_description=?, annotation=?, body=?, enabled=?, modified=now() WHERE article_id=?',
                                      $this->item->header,
                                      $this->item->url,
                                      $this->item->meta_title,
  			                          $this->item->meta_keywords,
  			                          $this->item->meta_description,
  			                          $this->item->annotation,
  			                          $this->item->body,
  			                          $this->item->enabled,
  			                          $item_id);
                $this->db->query($query);
            }

            $this->db->query("UPDATE articles SET url=article_id WHERE url=''");

 			$get = $this->form_get(array('section'=>'Articles'));
        if(isset($_GET['from']))
          header("Location: ".$_GET['from']);
        else
 		  header("Location: index.php$get");
  		}
  	}

  	elseif (!empty($item_id))
  	{
  	  $query = sql_placeholder('SELECT * FROM articles WHERE article_id=?', $item_id);
  	  $this->db->query($query);
  	  $this->item = $this->db->result();
  	}
  }

  function fetch()
  {
  	  if(empty($this->item->article_id))
  	    $this->title = $this->lang->NEW_ARTICLE;
  	  else
  	    $this->title = $this->lang->EDIT_ARTICLE;

 	  $this->smarty->assign('Item', $this->item);
 	  $this->smarty->assign('Error', $this->error_msg);
      $this->smarty->assign('Lang', $this->lang);
 	  $this->body = $this->smarty->fetch('article.tpl');
  }
}