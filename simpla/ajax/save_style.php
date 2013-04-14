<?php

session_start();

chdir('../..');
require_once('api/Simpla.php');

$simpla = new Simpla();

if(!$simpla->managers->access('design'))
	return false;

// Проверка сессии для защиты от xss
if(!$simpla->request->check_session())
{
	trigger_error('Session expired', E_USER_WARNING);
	exit();
}
$content = $simpla->request->post('content');
$style = $simpla->request->post('style');
$theme = $simpla->request->post('theme', 'string');

if(pathinfo($style, PATHINFO_EXTENSION) != 'css')
	exit();

$file = $simpla->config->root_dir.'design/'.$theme.'/css/'.$style;
if(is_file($file) && is_writable($file) && !is_file($simpla->config->root_dir.'design/'.$theme.'/locked'))
	file_put_contents($file, $content);

$result= true;
header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		
$json = json_encode($result);
print $json;