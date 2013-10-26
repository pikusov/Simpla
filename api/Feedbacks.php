<?php

/**
 * Simpla CMS
 *
 * @copyright	2011 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */

require_once('Simpla.php');

class Feedbacks extends Simpla
{

	public function get_feedback($id)
	{
		$query = $this->db->placehold("SELECT f.id, f.name, f.email, f.ip, f.message, f.date FROM __feedbacks f WHERE id=? LIMIT 1", intval($id));

		if($this->db->query($query))
			return $this->db->result();
		else
			return false; 
	}
	
	public function get_feedbacks($filter = array(), $new_on_top = false)
	{	
		// По умолчанию
		$limit = 0;
		$page = 1;
		$keyword_filter = '';

		if(isset($filter['limit']))
			$limit = max(1, intval($filter['limit']));

		if(isset($filter['page']))
			$page = max(1, intval($filter['page']));

		$sql_limit = $this->db->placehold(' LIMIT ?, ? ', ($page-1)*$limit, $limit);

		if(!empty($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND f.name LIKE "%'.mysql_real_escape_string(trim($keyword)).'%" OR f.message LIKE "%'.mysql_real_escape_string(trim($keyword)).'%" OR f.email LIKE "%'.mysql_real_escape_string(trim($keyword)).'%" ');
		}
			
		if($new_on_top)
			$sort='DESC';
		else
			$sort='ASC';

		$query = $this->db->placehold("SELECT f.id, f.name, f.email, f.ip, f.message, f.date
										FROM __feedbacks f WHERE 1 $keyword_filter ORDER BY f.id $sort $sql_limit");
	
		$this->db->query($query);
		return $this->db->results();
	}
	
	public function count_feedbacks($filter = array())
	{	
		$keyword_filter = '';

		if(!empty($filter['keyword']))
		{
			$keywords = explode(' ', $filter['keyword']);
			foreach($keywords as $keyword)
				$keyword_filter .= $this->db->placehold('AND f.name LIKE "%'.mysql_real_escape_string(trim($keyword)).'%" OR f.message LIKE "%'.mysql_real_escape_string(trim($keyword)).'%" OR f.email LIKE "%'.mysql_real_escape_string(trim($keyword)).'%" ');
		}

		$query = $this->db->placehold("SELECT count(distinct f.id) as count
										FROM __feedbacks f WHERE 1 $keyword_filter");
	
		$this->db->query($query);	
		return $this->db->result('count');

	}
	
	
	public function add_feedback($feedback)
	{	
		$query = $this->db->placehold('INSERT INTO __feedbacks
		SET ?%,
		date = NOW()',
		$feedback);
		
		if(!$this->db->query($query))
			return false;

		$id = $this->db->insert_id();
		return $id;
	}
	
	
	public function update_feedback($id, $feedback)
	{
		$date_query = '';
		if(isset($feedback->date))
		{
			$date = $feedback->date;
			unset($feedback->date);
			$date_query = $this->db->placehold(', date=STR_TO_DATE(?, ?)', $date, $this->settings->date_format);
		}
		$query = $this->db->placehold("UPDATE __feedbacks SET ?% $date_query WHERE id in(?@) LIMIT 1", $feedback, (array)$id);
		$this->db->query($query);
		return $id;
	}


	public function delete_feedback($id)
	{
		if(!empty($id))
		{
			$query = $this->db->placehold("DELETE FROM __feedbacks WHERE id=? LIMIT 1", intval($id));
			$this->db->query($query);
		}
	}	
}
