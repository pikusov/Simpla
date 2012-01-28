<?php

session_start();

chdir('../..');
require_once('api/Simpla.php');

$simpla = new Simpla();

// Проверка сессии для защиты от xss
if(!$simpla->request->check_session())
{
	trigger_error('Session expired', E_USER_WARNING);
	exit();
}
$content = $simpla->request->post('content');
$template = $simpla->request->post('template');
$theme = $simpla->request->post('theme', 'string');

if(pathinfo($template, PATHINFO_EXTENSION) != 'tpl')
	exit();

$file = $simpla->config->root_dir.'design/'.$theme.'/html/'.$template;
if(is_file($file) && is_writable($file) && !is_file($simpla->config->root_dir.'design/'.$theme.'/locked'))
	file_put_contents($file, $content);

$result= true;
header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		
$json = json_encode($result);
print $json;