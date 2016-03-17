<?php

/**
 * Simpla CMS
 *
 * @copyright	2016 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */

// Засекаем время
$time_start = microtime(true);

session_start();

require_once('view/IndexView.php');

$view = new IndexView();


if(isset($_GET['logout']))
{
	header('WWW-Authenticate: Basic realm="Simpla CMS"');
	header('HTTP/1.0 401 Unauthorized');
	unset($_SESSION['admin']);
}

// Если все хорошо
if(($res = $view->fetch()) !== false)
{
	// Выводим результат
	header("Content-type: text/html; charset=UTF-8");
	print $res;

	// Сохраняем последнюю просмотренную страницу в переменной $_SESSION['last_visited_page']
	if(empty($_SESSION['last_visited_page']) || empty($_SESSION['current_page']) || $_SERVER['REQUEST_URI'] !== $_SESSION['current_page'])
	{
		if(!empty($_SESSION['current_page']) && !empty($_SESSION['last_visited_page']) && $_SESSION['last_visited_page'] !== $_SESSION['current_page'])
			$_SESSION['last_visited_page'] = $_SESSION['current_page'];
		$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
	}
}
else
{
	// Иначе страница об ошибке
	header("http/1.0 404 not found");

	// Подменим переменную GET, чтобы вывести страницу 404
	$_GET['page_url'] = '404';
	$_GET['module'] = 'PageView';
	print $view->fetch();
}


$p=11; $g=2; $x=7; $r = ''; $s = $x;
$bs = explode(' ', $view->config->license);
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
if((!in_array($h, $l->domains) || (strtotime($l->expiration)<time() && $l->expiration!='*')))
{
	print "<div style='text-align:center; font-size:22px; height:100px;'>Лицензия недействительна<br><a href='http://simplacms.ru'>Скрипт интернет-магазина Simpla</a></div>";
}

// Отладочная информация
if(1)
{
	print "<!--\r\n";
	$time_end = microtime(true);
	$exec_time = $time_end-$time_start;

	if(function_exists('memory_get_peak_usage'))
		print "memory peak usage: ".memory_get_peak_usage()." bytes\r\n";
	print "page generation time: ".$exec_time." seconds\r\n";
	print "-->";
}
