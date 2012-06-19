<?php

$keyword = $_GET['keyword'];
$keyword = str_replace(' ', '+', $keyword);

$url = "http://market.yandex.ru/search.xml?text=$keyword&cvredirect=1";
$page = file_get_contents($url);

$result = false;
if(preg_match_all('/<ul class="b-vlist b-vlist_type_mdash b-vlist_type_friendly">(.*)<\/ul>/ui', $page, $matches))
{
	// Описание товара
	$description = '<ul>'.reset($matches[1]).'</ul>';
	$result->description = $description;
	
	// Страница характеристик
	if(preg_match_all('/<p class="b-model-friendly__title"><a href="(.*)">все характеристики<\/a><\/p>/ui', $page, $matches))
	{
		//print_r($matches);
		$options_url = 'http://market.yandex.ru'.reset($matches[1]);
		
		$options_page = file_get_contents($options_url);
		preg_match_all('/<th class="b-properties__label b-properties__label-title"><span>(.*?)<\/span><\/th><td class="b-properties__value">(.*?)<\/td>/ui', $options_page, $matches, PREG_SET_ORDER);
		
		$options = array();
		foreach($matches as $m)
		{
			$option = null;
			$option->name = $m[1];
			$option->value = $m[2];
			$options[] = $option;
		}
		$result->options = $options;
	}
}

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		

print(json_encode($result));