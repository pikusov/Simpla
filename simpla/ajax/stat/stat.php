<?php

require_once('../../../api/Simpla.php');

class StatAjax extends Simpla
{	
	public function fetch()
	{
		$query = $this->db->placehold('SELECT SUM( o.total_price ) AS total_price, DAY(date) AS day, MONTH(date) as month, YEAR(date) as year FROM __orders o WHERE o.closed GROUP BY YEAR(o.date), MONTH(o.date)');
		$this->db->query($query);
		$data = $this->db->results();

		$results = array();
 		foreach($data as $d)
 		{
 			$result['day'] = $d->day;
 			$result['month'] = $d->month;
 			$result['year'] = $d->year;
 			$result['y'] = $d->total_price;
 			$results[] = $result;
		}
		return $results;
	}
	
}

$stat_ajax = new StatAjax();
header("Content-type: application/json; charset=utf-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		
$json = json_encode($stat_ajax->fetch());
print $json;