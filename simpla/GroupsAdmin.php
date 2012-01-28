<?PHP

require_once('api/Simpla.php');

############################################
# Class Properties displays a list of product parameters
############################################
class GroupsAdmin extends Simpla
{
	function fetch()
	{	
		if($this->request->method('post'))
		{
			// Действия с выбранными
			$ids = $this->request->post('check');
			if(is_array($ids))
			switch($this->request->post('action'))
			{
			    case 'delete':
			    {
			    	foreach($ids as $id)
						$this->users->delete_group($id);    
			        break;
			    }
			}		
		}  

		$groups = $this->users->get_groups();

		$this->design->assign('groups', $groups);		
		return $this->body = $this->design->fetch('groups.tpl');
	}
}
