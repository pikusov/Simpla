<?php

$use_curl = true; // Использовать CURL

$keyword = $_GET['keyword'];
$keyword = str_replace(' ', '+', $keyword);

$start=0;
if(isset($_GET['start']))
	$start = intval($_GET['start']);

$url = 'http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q='.urlencode($keyword).'&start='.$start.'&rsz=8';
if($use_curl && function_exists('curl_init'))
{
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	//curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_REFERER, 'http://google.com');
	curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.9.168 Version/11.51");
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);

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
$data = json_decode($page);
$images = array();
if($data)
	foreach ($data->responseData->results as $result)
		$images[] = urldecode(str_replace('%2520', '%20', $result->url));

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		

print(json_encode($images));
