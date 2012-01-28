<?php

$use_curl = true; // Использовать CURL

$keyword = $_GET['keyword'];
$keyword = str_replace(' ', '+', $keyword);

$start='';
if(isset($_GET['start']))
	$start = intval($_GET['start']);

$url = "http://images.google.com/search?tbm=isch&tbs=isz:lt,islt:qsvga,itp:photo&start=$start&q=$keyword";

if($use_curl)
{
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

	// Для использования прокси используйте строки:
	//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
	//curl_setopt($ch, CURLOPT_PROXY, '88.85.108.16:8080'); 
	//curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'user:password'); 
	
	$page = curl_exec($ch);
	curl_close($ch); 
}
else
{
	$page = file_get_contents($url);
}

preg_match_all('/imgurl=(http:\/\/[^\\\]*(jpg|png|gif|jpeg))/U', $page, $matches, PREG_SET_ORDER);
$images = array();
foreach($matches as $m)
{
	$image = str_replace('%2520', '%20', $m[1]);
		$images[] = urldecode($image);
}

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		

print(json_encode($images));