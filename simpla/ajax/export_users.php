<?php

require_once('../../api/Simpla.php');

class ExportAjax extends Simpla
{	
	private $columns_names = array(
			'name'=>             'Èìÿ',
			'email'=>            'Email',
			'group_name'=>            'Ãðóïïà',
			'discount'=>         'Ñêèäêà',
			'enabled'=>          'Àêòèâåí',
			'created'=>          'Äàòà',
			'last_ip'=>          'Ïîñëåäíèé IP'
			);
			
	private $column_delimiter = ';';
	private $users_count = 10;
	private $export_files_dir = '../files/export_users/';
	private $filename = 'users.csv';

	public function fetch()
	{
		if(!$this->managers->access('users'))
			return false;
	
		// Ýêñåëü êóøàåò òîëüêî 1251
		setlocale(LC_ALL, 'ru_RU.1251');
		$this->db->query('SET NAMES cp1251');
	
		// Ñòðàíèöà, êîòîðóþ ýêñïîðòèðóåì
		$page = $this->request->get('page');
		if(empty($page) || $page==1)
		{
			$page = 1;
			// Åñëè íà÷àëè ñíà÷àëà - óäàëèì ñòàðûé ôàéë ýêñïîðòà
			if(is_writable($this->export_files_dir.$this->filename))
				unlink($this->export_files_dir.$this->filename);
		}
		
		// Îòêðûâàåì ôàéë ýêñïîðòà íà äîáàâëåíèå
		$f = fopen($this->export_files_dir.$this->filename, 'ab');
				
		// Åñëè íà÷àëè ñíà÷àëà - äîáàâèì â ïåðâóþ ñòðîêó íàçâàíèÿ êîëîíîê
		if($page == 1)
		{
			fputcsv($f, $this->columns_names, $this->column_delimiter);
		}
		
		$filter = array();
		$filter['page'] = $page;
		$filter['limit'] = $this->users_count;
		if($this->request->get('group_id'))
			$filter['group_id'] = intval($this->request->get('group_id'));
		$filter['sort'] = $this->request->get('sort');
		$filter['keyword'] = $this->request->get('keyword');
		
		// Âûáèðàåì ïîëüçîâàòåëåé
		$users = array();
 		foreach($this->users->get_users($filter) as $u)
 		{
 			$str = array();
 			foreach($this->columns_names as $n=>$c)
 				$str[] = $u->$n;
 				
 			fputcsv($f, $str, $this->column_delimiter);
 		}
 		
		$total_users = $this->users->count_users($filter);
		
		if($this->users_count*$page < $total_users)
			return array('end'=>false, 'page'=>$page, 'totalpages'=>$total_users/$this->users_count);
		else
			return array('end'=>true, 'page'=>$page, 'totalpages'=>$total_users/$this->users_count);		

		fclose($f);

	}
	
}

$export_ajax = new ExportAjax();
$json = json_encode($export_ajax->fetch());
header("Content-type: application/json; charset=utf-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		
print $json;
