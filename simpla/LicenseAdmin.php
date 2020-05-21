<?PHP
require_once('api/Simpla.php');

class LicenseAdmin extends Simpla
{	
	public function fetch()
	{

		if($this->request->method('POST'))
		{
			$license = $this->request->post('license');
			$this->config->license = trim($license);
		}

		$p=11; $g=2; $x=7; $r = ''; $s = $x;
		$bs = explode(' ', $this->config->license);		
		foreach($bs as $bl){
			for($i=0, $m=''; $i<strlen($bl)&&isset($bl[$i+1]); $i+=2){
				$a = base_convert($bl[$i], 36, 10)-($i/2+$s)%26;
				$b = base_convert($bl[$i+1], 36, 10)-($i/2+$s)%25;
				$m .= ($b * (pow($a,$p-$x-1) )) % $p;}
			$m = base_convert($m, 10, 16); $s+=$x;
			for ($a=0; $a<strlen($m); $a+=2) $r .= @chr(hexdec($m{$a}.$m{($a+1)}));}

		@list($l->domains, $l->expiration, $l->comment) = explode('#', $r, 3);

		$l->domains = explode(',', $l->domains);

		$h = getenv("HTTP_HOST");
		if(substr($h, 0, 4) == 'www.') $h = substr($h, 4);
		$l->valid = true;
		if(!in_array($h, $l->domains))
			$l->valid = false;
		if(strtotime($l->expiration)<time() && $l->expiration!='*')
			$l->valid = false;
			
		
		$this->design->assign('license', $l);
		
		if (! $l->valid) {
			if ($result = file_get_contents("http://license.simplacommerce.com/index.php?host=".$_SERVER['HTTP_HOST']))
			{
				$tl = result;
				$this->design->assign('testlicense', $tl);
			}
		}
		
 	  	return $this->design->fetch('license.tpl');
	}
	
}

