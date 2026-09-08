<?php

$use_curl = true; // Использовать CURL

$keyword = $_GET['keyword'];
$keyword = str_replace(' ', '+', $keyword);

$start=0;
if(isset($_GET['start']))
        $start = intval($_GET['start']);

$url = 'http://www.google.com/search?q=' . urlencode($keyword) . '&start=' . $start . '&asearch=ichunk';
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
preg_match_all('/imgurl=([.\s\S]*)imgrefurl=/U', $page, $data);
$images = array();
if(isset($data[1]))
        foreach ($data[1] as $result)
	        $images[] = urldecode(html_entity_decode(str_replace(array('%2520', '\\', 'u0026amp;'), array('%20', '', '')
		        , $result)));

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");

print(json_encode($images));
