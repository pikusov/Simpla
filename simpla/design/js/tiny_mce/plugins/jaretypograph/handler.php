<?php

// При ошибке мы не должны отправлять в редактор сообщение
error_reporting(0);

// Подключаем типограф Муравьева
require_once 'Jare/Typograph.php';

// Принимаем текст (html)
$text = $_POST['text'];

// Если нужно, убираем лишние кавычки
if(get_magic_quotes_gpc())
{
	$text = stripslashes($text);
}

$start_space = $end_space = '';
if($text[0]==' ')
	$start_space = ' ';
if($text[strlen($text)-1]==' ')
	$end_space = ' ';

// Типографируем
$typograph = new Jare_Typograph($text);
$typograph->getTof('etc')->disableBaseParam('paragraphs');
$typograph->getTof('space')->disableBaseParam('many_spaces_to_one');
$text = $typograph->parse($typograph->getBaseTofsNames());

// Отдаем текст
print $start_space.$text.$end_space;

?>