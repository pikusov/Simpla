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

$id = intval($simpla->request->post('id'));
$object = $simpla->request->post('object');
$values = $simpla->request->post('values');

switch ($object)
{
    case 'product':
    	if($simpla->managers->access('products'))
        $result = $simpla->products->update_product($id, $values);
        break;
    case 'category':
    	if($simpla->managers->access('categories'))
        $result = $simpla->categories->update_category($id, $values);
        break;
    case 'brands':
    	if($simpla->managers->access('brands'))
        $result = $simpla->brands->update_brand($id, $values);
        break;
    case 'feature':
    	if($simpla->managers->access('features'))
        $result = $simpla->features->update_feature($id, $values);
        break;
    case 'page':
    	if($simpla->managers->access('pages'))
        $result = $simpla->pages->update_page($id, $values);
        break;
    case 'blog':
    	if($simpla->managers->access('blog'))
        $result = $simpla->blog->update_post($id, $values);
        break;
    case 'delivery':
    	if($simpla->managers->access('delivery'))
        $result = $simpla->delivery->update_delivery($id, $values);
        break;
    case 'payment':
    	if($simpla->managers->access('payment'))
        $result = $simpla->payment->update_payment_method($id, $values);
        break;
    case 'currency':
    	if($simpla->managers->access('currency'))
        $result = $simpla->money->update_currency($id, $values);
        break;
    case 'comment':
    	if($simpla->managers->access('comments'))
        $result = $simpla->comments->update_comment($id, $values);
        break;
    case 'user':
    	if($simpla->managers->access('users'))
        $result = $simpla->users->update_user($id, $values);
        break;
    case 'label':
    	if($simpla->managers->access('labels'))
        $result = $simpla->orders->update_label($id, $values);
        break;
}

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		
$json = json_encode($result);
print $json;