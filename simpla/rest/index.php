<?php

$time_start = microtime(true);

$resources = array(
	'products' => 'RestProducts',
	'orders'   => 'RestOrders',
	'blog'     => 'RestBlog'
);

// Работаем в корне сайта
chdir('../../');

// Ресурс с которым будем работать
$resource = $_GET['resource'];

// Если существует соответсвующий класс
if(isset($resources[$resource]))
{
	$class_name = $resources[$resource];
	require_once('simpla/rest/'.$class_name.'.php');
	$rest = new $class_name();

	// Действие с ресурсом
	if($rest->request->method('GET'))
		$result = $rest->get();
	if($rest->request->method('POST'))
		$result = $rest->post();
	if($rest->request->method('PUT'))
		$result = $rest->put();
	if($rest->request->method('DELETE'))
		$result = $rest->delete();
	
	// Отдаём результат
	print json_encode($result);
}
else
{
	// Еслиь не существует соответсвующий класс
	header("HTTP/1.0 404 Not Found");
	exit();
}


// Отладка		
$time_end = microtime(true);
$exec_time = round(($time_end-$time_start)*1000, 0);
//print "[$exec_time ms]";
