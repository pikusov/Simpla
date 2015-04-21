<?php

/**
 * Simpla CMS
 *
 * @copyright	2015 Denis Pikusov
 * @link		http://simplacms.ru
 * @author		Denis Pikusov
 *
 */
 

// Для использования прокси используйте строки:
define("USE_PROXY",		0);		// 1 = использовать прокси 
define("PROXY",			'xxx.xxx.xxx.xxx:80');		 
define("PROXY_USER",	'login:password');

// Настройка региона в маркете
define("REGION",		'213'); // 213 - москва, список регионов: http://search.yaca.yandex.ru/geo.c2n
define("DOMAIN",		'market.yandex.ru'); // для украины нужно market.yandex.ua
 
session_start();

// Временный файл для хранения cookies
// Так как временный файл существует до окончания выполнения скрипта,
// сохраняем его содержимое в сессию
$cookies_filename = tempnam(sys_get_temp_dir(), 'yandex_market_cookies');
if(!empty($_SESSION['yandex_market_cookies']))
	file_put_contents($cookies_filename, $_SESSION['yandex_market_cookies']);

// Для изменения региона нужно обратиться сюда
$url = 'http://tune.yandex.ru/region/?retpath=http%3A%2F%2Fmarket.yandex.ru';
get_page($url);

// Ключевое слово для поиска
$keyword = '';
if(!empty($_GET['keyword']))
	$keyword = $_GET['keyword'];

// Если нам запостили капчу, отправим ее на проверку
if(!empty($_GET['captcha']))
{
	$page = get_page("http://".DOMAIN."/checkcaptcha?key=".urlencode($_SESSION['captcha_key'])."&retpath=".urlencode(html_entity_decode($_SESSION['captcha_retpath']))."&rep=".urlencode($_GET['captcha']));
}

// Адрес страницы с результатами поиска
$url = "http://".DOMAIN."/search.xml?text=".urlencode($keyword)."&cvredirect=1";
// Выбираем результаты поиска
$page = get_page($url);
//print $page;

if(preg_match('/src="(http:.*captchaimg[^"]*)" alt=""\/>/ui', $page, $match))
{
	$captcha_image = $match[1];
	
	if(preg_match('/<input class="form__key" type="hidden" name="key" value="(.*)"\/><input class="form__retpath"/ui', $page, $match))
	{
		$_SESSION['captcha_key'] = $match[1];
	}
	
	if(preg_match('/<input class="form__retpath" type="hidden" name="retpath" value="(.*)"\/><div class="form__trigger"/ui', $page, $match))
	{
		$_SESSION['captcha_retpath'] = $match[1];
	}
	
}


$result = new stdClass();
if(!empty($captcha_image))
{
	$result->captcha = base64_encode(get_page($captcha_image));
	//print "<form><img src='data:image/jpeg;base64," . base64_encode(get_page($captcha_image)) . "' /><input type=text name=captcha><input type=text name=keyword value='$keyword'><input type=text name=captcha_key value='$captcha_key'><input type=text name=captcha_retpath value='$captcha_retpath'><input type=submit></form>";
}
$result->product = parse_product($page);

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		

print(json_encode($result));


// Функция забирает содержимое страницы по указанному URL
function get_page($url, $level=0)
{
	// Имя временного файла, в котором хранятся куки для CURL
	global $cookies_filename;
	
	// Максимальный уровень рекурсии
	$max_level = 20;
	if($level >= $max_level)
		return false;

	// Должен быть установлен curl
	if(!function_exists('curl_init'))
	{
		trigger_error("curl does not exists");
		return false;
	}

	// Инициализируем curl
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36");
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);	
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies_filename);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies_filename);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
		'Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3',
		'Connection: keep-alive'
	));	

	// Нужно установить регион
	$cookies_content = file_get_contents($cookies_filename);
	$new_cookies_content = preg_replace('/(yandex_gid).*/', "$1\t".REGION, $cookies_content);
	if($new_cookies_content == $cookies_content)
		$new_cookies_content .= "\n.yandex.ua\tTRUE\t/\tFALSE\t1\tyandex_gid\t".REGION."\n.yandex.ru\tTRUE\t/\tFALSE\t0\tyandex_gid\t".REGION;
	file_put_contents($cookies_filename, $new_cookies_content);	
	
	// Яндекс любит рефереров и реже банит, если реферер правдоподобный
	// Указываем реферером адрес, запрошенный в прошлый раз
	if(!empty($_SESSION['yandex_market_last_visited_url']))
		curl_setopt($ch, CURLOPT_REFERER, $_SESSION['yandex_market_last_visited_url']);


	// Настройки прокси:
	if(USE_PROXY)
	{
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
		curl_setopt($ch, CURLOPT_PROXY, PROXY); 
		curl_setopt($ch, CURLOPT_PROXYUSERPWD, PROXY_USER); 
	}

	// Выполняем запрос по адресу
	$data = curl_exec($ch);
	/*
	if(!$data)
	{
		trigger_error(curl_error($ch));
		return false;
	}
	*/

	// Проверяем код ответа для проверки, нет ли редиректа
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	// Больше нам curl не нужен
	curl_close($ch);
	
	// Записываем в сессию куки, которые отложил curl во временный файл
	$_SESSION['yandex_market_cookies'] = file_get_contents($cookies_filename);
	
	// Отделяем тело страницы от заголовка
	$dataArray = explode("\r\n\r\n", $data, 2);
	
	// Делим ответ на заголовок и тело
	if(count($dataArray)!=2)
		return false;	
			
	list($header, $body) = $dataArray;

	// В случае редиректа рекурсивно следуем за яндексом
	if($httpCode == 301 || $httpCode == 302)
	{
		$matches = array();
		preg_match('/Location:([^\n]*)/', $header, $matches);
		if(isset($matches[1]))
		{			
			// Рекурсивно запрашиваем страницу по адресу редиректа
			$body = get_page(trim($matches[1]), $level+1);
		}
	}
	// В случае 404 пробуем еще несколько раз - яндекс часто глючит и отдает 404
	if($httpCode == 404)
	{
		$body = get_page($url, $level+1);
	}
	
	// Сохраняем последний посещенный URL для реферера
	$_SESSION['yandex_market_last_visited_url'] = $url;
	
	// Отдаем тело страницы
	return $body;
}

// Функция отдает результат парсинга страницы
function parse_product($page)
{
	// Если это страница товара, ишем описание
	if(preg_match_all('/<ul class="product-card__spec-list">(.*)<\/ul>/uis', $page, $matches))
	{
		// Описание товара
		$description = '<ul>'.reset($matches[1]).'</ul>';
		$result = new stdClass;
		$result->description = $description;
		
		// Страница характеристик
		if(preg_match_all('/<li class="product-tabs__item" data-name="spec"><a href="(.*?)">/ui', $page, $matches))
		{
			$options_url = 'http://'.DOMAIN.reset($matches[1]);
			
			$options_page = get_page($options_url);
			preg_match_all('/<dl class="product-spec-item"><dt class="product-spec-item__name"><span class="product-spec-item__name-inner">(.*?)<.*?<span class="product-spec-item__value-inner">(.*?)\p{Z}?<\/span><\/dd><\/dl>/uis', $options_page, $matches, PREG_SET_ORDER);
			$options = array();
			foreach($matches as $m)
			{
				$option = new stdClass;
				$option->name = str_replace("\n", "", $m[1]);
				$option->value = str_replace("\n", "", $m[2]);
				$options[] = $option;
			}
			$result->options = $options;
		}
		else
			return false;
	}
	// Иногда яндекс отдает не страницу конкретного товара, а список товаров
	// В этом случае переходим на страницу первого товара в списке
	elseif(preg_match_all('/<a class="snippet-card__image link" href="(.*?)"><img/ui', $page, $matches))
	{                  
		$product_url = 'http://'.DOMAIN.reset($matches[1]);		
		$page = get_page($product_url);
		return parse_product($page);
	}	
	else
		return false;

	return $result;
}