<?PHP

chdir('..');

// Засекаем время
$time_start = microtime(true);

@ini_set('session.gc_maxlifetime', 86400); // 86400 = 24 часа
@ini_set('session.cookie_lifetime', 0); // 0 - пока браузер не закрыт
session_start();
$_SESSION['id'] = session_id();

require_once('simpla/IndexAdmin.php');

// Кеширование в админке нам не нужно
Header("Cache-Control: no-cache, must-revalidate");
Header("Pragma: no-cache");


// Установим переменную сессии, чтоб фронтенд нас узнал как админа
$_SESSION['admin'] = 'admin';

/*
if ($_SESSION["logout"]) {
	
	if($_SESSION["PHP_AUTH_USER"] == $_SERVER['PHP_AUTH_USER'] && $_SESSION["PHP_AUTH_PW"] == $_SERVER['PHP_AUTH_PW'])
 		$_SESSION["logout"] = false;
 	else
 	{
		header('HTTP/1.0 401 Unauthorised');
		header('WWW-Authenticate: Invalid'); // Change MyRealm to be the same as AuthName in .htaccess
		exit();
	}
}

// Если попросили разлогинится - убиваем сессию и переходим на сайт
if(isset($_GET['action']) && $_GET['action']=='logout')
{
	$_SESSION["logout"] = true;
	$_SESSION["PHP_AUTH_USER"] = $_SERVER['PHP_AUTH_USER'];
	$_SESSION["PHP_AUTH_PW"] = $_SERVER['PHP_AUTH_PW'];
    session_unregister('admin');
	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'? 'https' : 'http';
	$url = $protocol.'://x:x@'.rtrim($_SERVER['HTTP_HOST']).'/simpla';
	Header('Location: '.$url);
    exit();
}
*/

$backend = new IndexAdmin();
//$backend->design->set_templates_dir('admin/design/html');
//$backend->design->set_compiled_dir('admin/design/compiled');

// Проверка сессии для защиты от xss
if(!$backend->request->check_session())
{
	unset($_POST);
	trigger_error('Session expired', E_USER_WARNING);
}


print $backend->fetch();


// Отладочная информация
if($backend->config->debug)
{
	print "<!--\r\n";
	$i = 0;
	$sql_time = 0;
	foreach($page->db->queries as $q)
	{
		$i++;
		print "$i.\t$q->exec_time sec\r\n$q->sql\r\n\r\n";
		$sql_time += $q->exec_time;
	}
  
	$time_end = microtime(true);
	$exec_time = $time_end-$time_start;
  
  	if(function_exists('memory_get_peak_usage'))
		print "memory peak usage: ".memory_get_peak_usage()." bytes\r\n";  
	print "page generation time: ".$exec_time." seconds\r\n";  
	print "sql queries time: ".$sql_time." seconds\r\n";  
	print "php run time: ".($exec_time-$sql_time)." seconds\r\n";  
	print "-->";
}
