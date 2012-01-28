<?PHP

require_once('api/Simpla.php');


############################################
# Class goodCategories displays a list of products categories
############################################
class StatsAdmin extends Simpla
{
 
  public function fetch()
  {
 	return $this->design->fetch('stats.tpl');
  }
}
