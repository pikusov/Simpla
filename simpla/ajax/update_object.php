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
        $result = $simpla->products->update_product($id, $values);
        break;
    case 'category':
        $result = $simpla->categories->update_category($id, $values);
        break;
    case 'brands':
        $result = $simpla->brands->update_brand($id, $values);
        break;
    case 'feature':
        $result = $simpla->features->update_feature($id, $values);
        break;
    case 'page':
        $result = $simpla->pages->update_page($id, $values);
        break;
    case 'blog':
        $result = $simpla->blog->update_post($id, $values);
        break;
    case 'delivery':
        $result = $simpla->delivery->update_delivery($id, $values);
        break;
    case 'payment':
        $result = $simpla->payment->update_payment_method($id, $values);
        break;
    case 'currency':
        $result = $simpla->money->update_currency($id, $values);
        break;
    case 'comment':
        $result = $simpla->comments->update_comment($id, $values);
        break;
    case 'user':
        $result = $simpla->users->update_user($id, $values);
        break;
}

header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		
$json = json_encode($result);
print $json;