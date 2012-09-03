<?PHP
require_once('api/Simpla.php');

class ExportUsersAdmin extends Simpla
{	
	private $export_files_dir = 'simpla/files/export_users/';

	public function fetch()
	{
		$this->design->assign('export_files_dir', $this->export_files_dir);
		$this->design->assign('sort', $this->request->get('sort'));
		$this->design->assign('keyword', $this->request->get('keyword'));
		$this->design->assign('group_id', $this->request->get('group_id'));
		$this->design->assign('export_files_dir', $this->export_files_dir);
		if(!is_writable($this->export_files_dir))
			$this->design->assign('message_error', 'no_permission');
  	  	return $this->design->fetch('export_users.tpl');
	}
	
}

