<?php

// Папка для хранения временных файлов синхронизации
$dir = 'simpla/cml/temp/';

// Обновлять все данные при каждой синхронизации
$full_update = true;

// Название параметра товара, используемого как бренд
$brand_option_name = 'Производитель';

$start_time = microtime(true);
$max_exec_time = min(30, @ini_get("max_execution_time"));
if(empty($max_exec_time))
	$max_exec_time = 30;

session_start();
chdir('../..');
include('api/Simpla.php');
$simpla = new Simpla();

if($simpla->request->get('type') == 'sale' && $simpla->request->get('mode') == 'checkauth')
{
	print "success\n";
	print session_name()."\n";
	print session_id();
}

if($simpla->request->get('type') == 'sale' && $simpla->request->get('mode') == 'init')
{
	$tmp_files = glob($dir.'*.*');
	if(is_array($tmp_files))
	foreach($tmp_files as $v)
	{
    	//unlink($v);
    }
	print "zip=no\n";
	print "file_limit=1000000\n";
}

if($simpla->request->get('type') == 'sale' && $simpla->request->get('mode') == 'file')
{
	$filename = $simpla->request->get('filename');
	
	
	$f = fopen($dir.$filename, 'ab');
	fwrite($f, file_get_contents('php://input'));
	fclose($f);

	$xml = simplexml_load_file($dir.$filename);	

	foreach($xml->Документ as $xml_order)
	{
		$order = new stdClass;

		$order->id = $xml_order->Номер;
		$existed_order = $simpla->orders->get_order(intval($order->id));
		
		$order->date = $xml_order->Дата.' '.$xml_order->Время;
		$order->name = $xml_order->Контрагенты->Контрагент->Наименование;

		if(isset($xml_order->ЗначенияРеквизитов->ЗначениеРеквизита))
		foreach($xml_order->ЗначенияРеквизитов->ЗначениеРеквизита as $r)
		{
			switch ($r->Наименование) {
		    case 'Проведен':
		    	$proveden = ($r->Значение == 'true');
		        break;
		    case 'ПометкаУдаления':
		    	$udalen = ($r->Значение == 'true');
		        break;
			}
		}
		
		if($udalen)
			$order->status = 3;
		elseif($proveden)
			$order->status = 1;
		elseif(!$proveden)
			$order->status = 0;
		
		if($existed_order)
		{
			$simpla->orders->update_order($order->id, $order);
		}
		else
		{
			$order->id = $simpla->orders->add_order($order);
		}
		
		$purchases_ids = array();
		// Товары
		foreach($xml_order->Товары->Товар as $xml_product)
		{
			$purchase = null;
			//  Id товара и варианта (если есть) по 1С
			$product_1c_id = $variant_1c_id = '';
			@list($product_1c_id, $variant_1c_id) = explode('#', $xml_product->Ид);
			if(empty($product_1c_id))
				$product_1c_id = '';
			if(empty($variant_1c_id))
				$variant_1c_id = '';
				
			// Ищем товар
			$simpla->db->query('SELECT id FROM __products WHERE external_id=?', $product_1c_id);
			$product_id = $simpla->db->result('id');
			$simpla->db->query('SELECT id FROM __variants WHERE external_id=? AND product_id=?', $variant_1c_id, $product_id);
			$variant_id = $simpla->db->result('id');
				
			$purchase = new stdClass;		
			$purchase->order_id = $order->id;
			$purchase->product_id = $product_id;
			$purchase->variant_id = $variant_id;
			
			$purchase->sku = $xml_product->Артикул;			
			$purchase->product_name = $xml_product->Наименование;
			$purchase->amount = $xml_product->Количество;
			$purchase->price = floatval($xml_product->ЦенаЗаЕдиницу);
			
			if(isset($xml_product->Скидки->Скидка))
			{
				$discount = $xml_product->Скидки->Скидка->Процент;
				$purchase->price = $purchase->price*(100-$discount)/100;
			}
			
			$simpla->db->query('SELECT id FROM __purchases WHERE order_id=? AND product_id=? AND variant_id=?', $order->id, $product_id, $variant_id);
			$purchase_id = $simpla->db->result('id');
			if(!empty($purchase_id))
				$purchase_id = $simpla->orders->update_purchase($purchase_id, $purchase);
			else
				$purchase_id = $simpla->orders->add_purchase($purchase);
			$purchases_ids[] = $purchase_id;
		}
		// Удалим покупки, которых нет в файле
		foreach($simpla->orders->get_purchases(array('order_id'=>intval($order->id))) as $purchase)
		{
			if(!in_array($purchase->id, $purchases_ids))
				$simpla->orders->delete_purchase($purchase->id);
		}
		
		$simpla->db->query('UPDATE __orders SET discount=0, total_price=? WHERE id=? LIMIT 1', $xml_order->Сумма, $order->id);
		
	}
	

	print "success";
	$simpla->settings->last_1c_orders_export_date = date("Y-m-d H:i:s");

}

if($simpla->request->get('type') == 'sale' && $simpla->request->get('mode') == 'query')
{
		$no_spaces = '<?xml version="1.0" encoding="utf-8"?>
							<КоммерческаяИнформация ВерсияСхемы="2.04" ДатаФормирования="' . date ( 'Y-m-d' )  . '"></КоммерческаяИнформация>';
		$xml = new SimpleXMLElement ( $no_spaces );

		$orders = $simpla->orders->get_orders(array('modified_since'=>$simpla->settings->last_1c_orders_export_date));
		foreach($orders as $order)
		{
			$date = new DateTime($order->date);
			
			$doc = $xml->addChild ("Документ");
			$doc->addChild ( "Ид", $order->id);
			$doc->addChild ( "Номер", $order->id);
			$doc->addChild ( "Дата", $date->format('Y-m-d'));
			$doc->addChild ( "ХозОперация", "Заказ товара" );
			$doc->addChild ( "Роль", "Продавец" );
			$doc->addChild ( "Курс", "1" );
			$doc->addChild ( "Сумма", $order->total_price);
			$doc->addChild ( "Время",  $date->format('H:i:s'));
			$doc->addChild ( "Комментарий", $order->comment);
			

			// Контрагенты
			$k1 = $doc->addChild ( 'Контрагенты' );
			$k1_1 = $k1->addChild ( 'Контрагент' );
			$k1_2 = $k1_1->addChild ( "Ид", $order->name);
			$k1_2 = $k1_1->addChild ( "Наименование", $order->name);
			$k1_2 = $k1_1->addChild ( "Роль", "Покупатель" );
			$k1_2 = $k1_1->addChild ( "ПолноеНаименование", $order->name );
			
			// Доп параметры
			$addr = $k1_1->addChild ('АдресРегистрации');
			$addr->addChild ( 'Представление', $order->address );
			$addrField = $addr->addChild ( 'АдресноеПоле' );
			$addrField->addChild ( 'Тип', 'Страна' );
			$addrField->addChild ( 'Значение', 'RU' );
			$addrField = $addr->addChild ( 'АдресноеПоле' );
			$addrField->addChild ( 'Тип', 'Регион' );
			$addrField->addChild ( 'Значение', $order->address );

			$contacts = $k1_1->addChild ( 'Контакты' );
			$cont = $contacts->addChild ( 'Контакт' );
			$cont->addChild ( 'Тип', 'Телефон' );
			$cont->addChild ( 'Значение', $order->phone );
			$cont = $contacts->addChild ( 'Контакт' );
			$cont->addChild ( 'Тип', 'Почта' );
			$cont->addChild ( 'Значение', $order->email );


			$purchases = $simpla->orders->get_purchases(array('order_id'=>intval($order->id)));

			$t1 = $doc->addChild ( 'Товары' );
			foreach($purchases as $purchase)
			{
				if(!empty($purchase->product_id) && !empty($purchase->variant_id))
				{
					$simpla->db->query('SELECT external_id FROM __products WHERE id=?', $purchase->product_id);
					$id_p = $simpla->db->result('external_id');
					$simpla->db->query('SELECT external_id FROM __variants WHERE id=?', $purchase->variant_id);
					$id_v = $simpla->db->result('external_id');
					
					// Если нет внешнего ключа товара - указываем наш id
					if(!empty($id_p))
					{
						$id = $id_p;
					}
					else
					{
						$simpla->db->query('UPDATE __products SET external_id=id WHERE id=?', $purchase->product_id);
						$id = $purchase->product_id;
					}
					
					// Если нет внешнего ключа варианта - указываем наш id
					if(!empty($id_v))
					{
						$id = $id.'#'.$id_v;
					}
					else
					{
						$simpla->db->query('UPDATE __variants SET external_id=id WHERE id=?', $purchase->variant_id);
						$id = $id.'#'.$purchase->variant_id;
					}
						
					$t1_1 = $t1->addChild ( 'Товар' );
					
					if($id)
						$t1_2 = $t1_1->addChild ( "Ид", $id);
					
					$t1_2 = $t1_1->addChild ( "Артикул", $purchase->sku);
					
					$name = $purchase->product_name;
					if($purchase->variant_name)
						$name .= " $purchase->variant_name $id";
					$t1_2 = $t1_1->addChild ( "Наименование", $name);
					$t1_2 = $t1_1->addChild ( "ЦенаЗаЕдиницу", $purchase->price*(100-$order->discount)/100);
					$t1_2 = $t1_1->addChild ( "Количество", $purchase->amount );
					$t1_2 = $t1_1->addChild ( "Сумма", $purchase->amount*$purchase->price*(100-$order->discount)/100);
					
					/*
					$t1_2 = $t1_1->addChild ( "Скидки" );
					$t1_3 = $t1_2->addChild ( "Скидка" );
					$t1_4 = $t1_3->addChild ( "Сумма", $purchase->amount*$purchase->price*(100-$order->discount)/100);
					$t1_4 = $t1_3->addChild ( "УчтеноВСумме", "true" );
					*/
					
					$t1_2 = $t1_1->addChild ( "ЗначенияРеквизитов" );
					$t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
					$t1_4 = $t1_3->addChild ( "Наименование", "ВидНоменклатуры" );
					$t1_4 = $t1_3->addChild ( "Значение", "Товар" );
	
					$t1_2 = $t1_1->addChild ( "ЗначенияРеквизитов" );
					$t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
					$t1_4 = $t1_3->addChild ( "Наименование", "ТипНоменклатуры" );
					$t1_4 = $t1_3->addChild ( "Значение", "Товар" );
				}
			}
			
			// Доставка
			if($order->delivery_price>0 && !$order->separate_delivery)
			{
				$t1 = $t1->addChild ( 'Товар' );
				$t1->addChild ( "Ид", 'ORDER_DELIVERY');
				$t1->addChild ( "Наименование", 'Доставка');
				$t1->addChild ( "ЦенаЗаЕдиницу", $order->delivery_price);
				$t1->addChild ( "Количество", 1 );
				$t1->addChild ( "Сумма", $order->delivery_price);
				$t1_2 = $t1->addChild ( "ЗначенияРеквизитов" );
				$t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
				$t1_4 = $t1_3->addChild ( "Наименование", "ВидНоменклатуры" );
				$t1_4 = $t1_3->addChild ( "Значение", "Услуга" );

				$t1_2 = $t1->addChild ( "ЗначенияРеквизитов" );
				$t1_3 = $t1_2->addChild ( "ЗначениеРеквизита" );
				$t1_4 = $t1_3->addChild ( "Наименование", "ТипНоменклатуры" );
				$t1_4 = $t1_3->addChild ( "Значение", "Услуга" );
				
			}
			

			// Статус			
			if($order->status == 1)
			{
				$s1_2 = $doc->addChild ( "ЗначенияРеквизитов" );
				$s1_3 = $s1_2->addChild ( "ЗначениеРеквизита" );
				$s1_3->addChild ( "Наименование", "Статус заказа" );
				$s1_3->addChild ( "Значение", "[N] Принят" );
			}
			if($order->status == 2)
			{
				$s1_2 = $doc->addChild ( "ЗначенияРеквизитов" );
				$s1_3 = $s1_2->addChild ( "ЗначениеРеквизита" );
				$s1_3->addChild ( "Наименование", "Статус заказа" );
				$s1_3->addChild ( "Значение", "[F] Доставлен" );
			}
			if($order->status == 3)
			{
				$s1_2 = $doc->addChild ( "ЗначенияРеквизитов" );
				$s1_3 = $s1_2->addChild ( "ЗначениеРеквизита" );
				$s1_3->addChild ( "Наименование", "Отменен" );
				$s1_3->addChild ( "Значение", "true" );
			}			

		}

		header ( "Content-type: text/xml; charset=utf-8" );
		print "\xEF\xBB\xBF";

		print $xml->asXML ();

		$simpla->settings->last_1c_orders_export_date = date("Y-m-d H:i:s");


}

if($simpla->request->get('type') == 'sale' && $simpla->request->get('mode') == 'success')
{
		$simpla->settings->last_1c_orders_export_date = date("Y-m-d H:i:s");
}


if($simpla->request->get('type') == 'catalog' && $simpla->request->get('mode') == 'checkauth')
{
	print "success\n";
	print session_name()."\n";
	print session_id();
}

if($simpla->request->get('type') == 'catalog' && $simpla->request->get('mode') == 'init')
{	
	$tmp_files = glob($dir.'*.*');
	if(is_array($tmp_files))
	foreach($tmp_files as $v)
	{
    	unlink($v);
    }
    unset($_SESSION['last_1c_imported_variant_num']);
    unset($_SESSION['last_1c_imported_product_num']);
    unset($_SESSION['features_mapping']);
    unset($_SESSION['categories_mapping']);
    unset($_SESSION['brand_id_option']);    
   	print "zip=no\n";
	print "file_limit=1000000\n";
}

if($simpla->request->get('type') == 'catalog' && $simpla->request->get('mode') == 'file')
{
	$filename = basename($simpla->request->get('filename'));
	$f = fopen($dir.$filename, 'ab');
	fwrite($f, file_get_contents('php://input'));
	fclose($f);
	print "success\n";
} 
 
if($simpla->request->get('type') == 'catalog' && $simpla->request->get('mode') == 'import')
{
	$filename = basename($simpla->request->get('filename'));
	
	if($filename === 'import.xml')
	{
		// Категории и свойства (только в первом запросе пакетной передачи)
		if(!isset($_SESSION['last_1c_imported_product_num']))
		{
			$z = new XMLReader;
			$z->open($dir.$filename);		
			while ($z->read() && $z->name !== 'Классификатор');
			$xml = new SimpleXMLElement($z->readOuterXML());
			$z->close();
			import_categories($xml);
			import_features($xml);
		}
		
		// Товары 			
		$z = new XMLReader;
		$z->open($dir.$filename);
		
		while ($z->read() && $z->name !== 'Товар');
		
		// Последний товар, на котором остановились
		$last_product_num = 0;
		if(isset($_SESSION['last_1c_imported_product_num']))
			$last_product_num = $_SESSION['last_1c_imported_product_num'];
		
		// Номер текущего товара
		$current_product_num = 0;

		while($z->name === 'Товар')
		{
			if($current_product_num >= $last_product_num)
			{
				$xml = new SimpleXMLElement($z->readOuterXML());

				// Товары
				import_product($xml);
				
				$exec_time = microtime(true) - $start_time;
				if($exec_time+1>=$max_exec_time)
				{
					header ( "Content-type: text/xml; charset=utf-8" );
					print "\xEF\xBB\xBF";
					print "progress\r\n";
					print "Выгружено товаров: $current_product_num\r\n";
					$_SESSION['last_1c_imported_product_num'] = $current_product_num;
					exit();
				}
			}
			$z->next('Товар');
			$current_product_num ++;
		}
		$z->close();
		print "success";
		//unlink($dir.$filename);
		unset($_SESSION['last_1c_imported_product_num']);				
	}
	elseif($filename === 'offers.xml')
	{
		// Варианты			
		$z = new XMLReader;
		$z->open($dir.$filename);
		
		while ($z->read() && $z->name !== 'Предложение');
		
		// Последний вариант, на котором остановились
		$last_variant_num = 0;
		if(isset($_SESSION['last_1c_imported_variant_num']))
			$last_variant_num = $_SESSION['last_1c_imported_variant_num'];
		
		// Номер текущего товара
		$current_variant_num = 0;

		while($z->name === 'Предложение')
		{
			if($current_variant_num >= $last_variant_num)
			{
				$xml = new SimpleXMLElement($z->readOuterXML());
				// Варианты
				import_variant($xml);
				
				$exec_time = microtime(true) - $start_time;
				if($exec_time+1>=$max_exec_time)
				{
					header ( "Content-type: text/xml; charset=utf-8" );
					print "\xEF\xBB\xBF";
					print "progress\r\n";
					print "Выгружено ценовых предложений: $current_variant_num\r\n";
					$_SESSION['last_1c_imported_variant_num'] = $current_variant_num;
					exit();
				}
			}
			$z->next('Предложение');
			$current_variant_num ++;
		}
		$z->close();
		print "success";
		//unlink($dir.$filename);
		unset($_SESSION['last_1c_imported_variant_num']);				

	}
}


function import_categories($xml, $parent_id = 0)
{
	global $simpla;
	global $dir;
	if(isset($xml->Группы->Группа))
	foreach ($xml->Группы->Группа as $xml_group)
	{
		$simpla->db->query('SELECT id FROM __categories WHERE external_id=?', $xml_group->Ид);
		$category_id = $simpla->db->result('id');
		if(empty($category_id))
			$category_id = $simpla->categories->add_category(array('parent_id'=>$parent_id, 'external_id'=>$xml_group->Ид, 'url'=>translit($xml_group->Наименование), 'name'=>$xml_group->Наименование, 'meta_title'=>$xml_group->Наименование, 'meta_keywords'=>$xml_group->Наименование, 'meta_description'=>$xml_group->Наименование ));
		$_SESSION['categories_mapping'][strval($xml_group->Ид)] = $category_id;
		import_categories($xml_group, $category_id);
	}
}


function import_features($xml)
{
	global $simpla;
	global $dir;
	global $brand_option_name;
	
	$property = array();
	if(isset($xml->Свойства->СвойствоНоменклатуры))
		$property = $xml->Свойства->СвойствоНоменклатуры;
		
	if(isset($xml->Свойства->Свойство))
		$property = $xml->Свойства->Свойство;
		
	foreach ($property as $xml_feature)
	{
		// Если свойство содержит производителя товаров
		if($xml_feature->Наименование == $brand_option_name)
		{
			// Запомним в сессии Ид свойства с производителем
			$_SESSION['brand_option_id'] = strval($xml_feature->Ид);		
		}
		// Иначе обрабатываем как обычной свойство товара
		else
		{
			$simpla->db->query('SELECT id FROM __features WHERE name=?', strval($xml_feature->Наименование));
			$feature_id = $simpla->db->result('id');
			if(empty($feature_id))
				$feature_id = $simpla->features->add_feature(array('name'=>strval($xml_feature->Наименование)));
			$_SESSION['features_mapping'][strval($xml_feature->Ид)] = $feature_id;
			if($xml_feature->ТипЗначений == 'Справочник')
			{
				foreach($xml_feature->ВариантыЗначений->Справочник as $val)
				{
					$_SESSION['features_values'][strval($val->ИдЗначения)] = strval($val->Значение);
				}
			}
		}
	}
}


function import_product($xml_product)
{
	global $simpla;
	global $dir;
	global $brand_option_name;
	global $full_update;
	// Товары


	//  Id товара и варианта (если есть) по 1С
	@list($product_1c_id, $variant_1c_id) = explode('#', $xml_product->Ид);
	if(empty($variant_1c_id))
		$variant_1c_id = '';
	
	// Ид категории
	if(isset($xml_product->Группы->Ид))
	$category_id = $_SESSION['categories_mapping'][strval($xml_product->Группы->Ид)];
	
	
	// Подгатавливаем вариант
	$variant_id = null;
	$variant = new stdClass;
	$values = array();
	if(isset($xml_product->ХарактеристикиТовара->ХарактеристикаТовара))
	foreach($xml_product->ХарактеристикиТовара->ХарактеристикаТовара as $xml_property)
		$values[] = $xml_property->Значение;
	if(!empty($values))
		$variant->name = implode(', ', $values);
	$variant->sku = (string)$xml_product->Артикул;
	$variant->external_id = $variant_1c_id;
	
	// Ищем товар
	$simpla->db->query('SELECT id FROM __products WHERE external_id=?', $product_1c_id);
	$product_id = $simpla->db->result('id');
	if(empty($product_id) && !empty($variant->sku))
	{
		$simpla->db->query('SELECT product_id, id FROM __variants WHERE sku=?', $variant->sku);
		$res = $simpla->db->result();
		if(!empty($res))
		{
			$product_id = $res->product_id;
			$variant_id = $res->id;
		}
	}
	
	// Если такого товара не нашлось		
	if(empty($product_id))
	{
		// Добавляем товар
		$description = '';
		if(!empty($xml_product->Описание))
			$description = $xml_product->Описание;
		$product_id = $simpla->products->add_product(array('external_id'=>$product_1c_id, 'url'=>translit($xml_product->Наименование), 'name'=>$xml_product->Наименование, 'meta_title'=>$xml_product->Наименование, 'meta_keywords'=>$xml_product->Наименование, 'meta_description'=>$xml_product->$description,  'annotation'=>$description, 'body'=>$description));
		
		// Добавляем товар в категории
		if(isset($category_id))
		$simpla->categories->add_product_category($product_id, $category_id);

	
		// Добавляем изображение товара
		if(isset($xml_product->Картинка))
		{
			foreach($xml_product->Картинка as $img)
			{
				$image = basename($xml_product->Картинка);
				if(!empty($image) && is_file($dir.$image) && is_writable($simpla->config->original_images_dir))
				{
					rename($dir.$image, $simpla->config->original_images_dir.$image);
					$simpla->products->add_image($product_id, $image);
				}
			}
		}

	}
	//Если нашелся товар
	else
	{
		if(empty($variant_id) && !empty($variant_1c_id))
		{
			$simpla->db->query('SELECT id FROM __variants WHERE external_id=? AND product_id=?', $variant_1c_id, $product_id);
			$variant_id = $simpla->db->result('id');
		}
		elseif(empty($variant_id) && empty($variant_1c_id))
		{
			$simpla->db->query('SELECT id FROM __variants WHERE product_id=?', $product_id);
			$variant_id = $simpla->db->result('id');		
		}
		
		// Обновляем товар
		if($full_update)
		{
			$p = new stdClass();
			if(!empty($xml_product->Описание))
			{
				$description = strval($xml_product->Описание);
				$p->meta_description = $description;
				$p->meta_description = $description;
				$p->annotation = $description;
				$p->body = $description;
			}
			$p->external_id = $product_1c_id;
			$p->url = translit($xml_product->Наименование);
			$p->name = $xml_product->Наименование;
			$p->meta_title = $xml_product->Наименование;
			$p->meta_keywords = $xml_product->Наименование;

			$product_id = $simpla->products->update_product($product_id, $p);
			
			// Обновляем категорию товара
			if(isset($category_id) && !empty($product_id))
			{
   	    		$query = $simpla->db->placehold('DELETE FROM __products_categories WHERE product_id=?', $product_id);
   	    		$simpla->db->query($query);
				$simpla->categories->add_product_category($product_id, $category_id);
			}
			
		}
		
		// Обновляем изображение товара
		if(isset($xml_product->Картинка))
		{
			foreach($xml_product->Картинка as $img)
			{
				$image = basename($img);
				if(!empty($image) && is_file($dir.$image) && is_writable($simpla->config->original_images_dir))
				{
					$simpla->db->query('SELECT id FROM __images WHERE product_id=? ORDER BY position LIMIT 1', $product_id);
					$img_id = $simpla->db->result('id');
					if(!empty($img_id))
						$simpla->products->delete_image($img_id);
					rename($dir.$image, $simpla->config->original_images_dir.$image);
					$simpla->products->add_image($product_id, $image);
				}
			}
		}
		
	}
	
	// Если не найден вариант, добавляем вариант один к товару
	if(empty($variant_id))
	{
		$variant->product_id = $product_id;
		$variant->stock = 0;
		$variant_id = $simpla->variants->add_variant($variant);
	}
	elseif(!empty($variant_id))
	{
		$simpla->variants->update_variant($variant_id, $variant);
	}
	// Свойства товара
	if(isset($xml_product->ЗначенияСвойств->ЗначенияСвойства))
	{
		foreach ($xml_product->ЗначенияСвойств->ЗначенияСвойства as $xml_option)
		{
			if(isset($_SESSION['features_mapping'][strval($xml_option->Ид)]))
			{
				$feature_id = $_SESSION['features_mapping'][strval($xml_option->Ид)];
				if(isset($category_id) && !empty($feature_id))
				{
					$simpla->features->add_feature_category($feature_id, $category_id);
					$values = array();
					foreach($xml_option->Значение as $xml_value)
					{
						if(isset($_SESSION['features_values'][strval($xml_value)]))
							$values[] = strval($_SESSION['features_values'][strval($xml_value)]);
						else
							$values[] = strval($xml_value);
					}
					$simpla->features->update_option($product_id, $feature_id, implode(' ,', $values));
				}
			}
			// Если свойство оказалось названием бренда
			elseif(isset($_SESSION['brand_option_id']) && !empty($xml_option->Значение))
			{
				$brand_name = strval($xml_option->Значение);
				// Добавим бренд
				// Найдем его по имени
				$simpla->db->query('SELECT id FROM __brands WHERE name=?', $brand_name);
				if(!$brand_id = $simpla->db->result('id'))
					// Создадим, если не найден
					$brand_id = $simpla->brands->add_brand(array('name'=>$brand_name, 'meta_title'=>$brand_name, 'meta_keywords'=>$brand_name, 'meta_description'=>$brand_name, 'url'=>translit($brand_name)));	
				if(!empty($brand_id))
					$simpla->products->update_product($product_id, array('brand_id'=>$brand_id));
			}
		}		
	}
	
	
	// Если нужно - удаляем вариант или весь товар
	if($xml_product->Статус == 'Удален')
	{
		$simpla->variants->delete_variant($variant_id);
		$simpla->db->query('SELECT count(id) as variants_num FROM __variants WHERE product_id=?', $product_id);
		if($simpla->db->result('variants_num') == 0)
			$simpla->products->delete_product($product_id);

	}
}

function import_variant($xml_variant)
{
	global $simpla;
	global $dir;
	$variant = new stdClass;
	//  Id товара и варианта (если есть) по 1С
	@list($product_1c_id, $variant_1c_id) = explode('#', $xml_variant->Ид);
	if(empty($variant_1c_id))
		$variant_1c_id = '';
	if(empty($product_1c_id))
		return false;

	$simpla->db->query('SELECT v.id FROM __variants v WHERE v.external_id=? AND product_id=(SELECT p.id FROM __products p WHERE p.external_id=? LIMIT 1)', $variant_1c_id, $product_1c_id);
	$variant_id = $simpla->db->result('id');
	
	$simpla->db->query('SELECT p.id FROM __products p WHERE p.external_id=?', $product_1c_id);
	$variant->external_id = $variant_1c_id;
	$variant->product_id = $simpla->db->result('id');
	if(empty($variant->product_id))
		return false;

	$variant->price = $xml_variant->Цены->Цена->ЦенаЗаЕдиницу;	
	
	if(isset($xml_variant->ХарактеристикиТовара->ХарактеристикаТовара))
	foreach($xml_variant->ХарактеристикиТовара->ХарактеристикаТовара as $xml_property)
		$values[] = $xml_property->Значение;
	if(!empty($values))
		$variant->name = implode(', ', $values);
	$sku = (string)$xml_variant->Артикул;
	if(!empty($sku))
		$variant->sku = $sku;
	
	
	// Конвертируем цену из валюты 1С в базовую валюту магазина
	if(!empty($xml_variant->Цены->Цена->Валюта))
	{
		// Ищем валюту по коду
		$simpla->db->query("SELECT id, rate_from, rate_to FROM __currencies WHERE code like ?", $xml_variant->Цены->Цена->Валюта);
		$variant_currency = $simpla->db->result();
		// Если не нашли - ищем по обозначению
		if(empty($variant_currency))
		{
			$simpla->db->query("SELECT id, rate_from, rate_to FROM __currencies WHERE sign like ?", $xml_variant->Цены->Цена->Валюта);
			$variant_currency = $simpla->db->result();
		}
		// Если нашли валюту - конвертируем из нее в базовую
		if($variant_currency && $variant_currency->rate_from>0 && $variant_currency->rate_to>0)
		{
			$variant->price = floatval($variant->price)*$variant_currency->rate_to/$variant_currency->rate_from;
		}	
	}
	
	$variant->stock = $xml_variant->Количество;

	if(empty($variant_id))
		$simpla->variants->add_variant($variant);
	else	
		$simpla->variants->update_variant($variant_id, $variant);
}

function translit($text)
{
	$ru = explode('-', "А-а-Б-б-В-в-Ґ-ґ-Г-г-Д-д-Е-е-Ё-ё-Є-є-Ж-ж-З-з-И-и-І-і-Ї-ї-Й-й-К-к-Л-л-М-м-Н-н-О-о-П-п-Р-р-С-с-Т-т-У-у-Ф-ф-Х-х-Ц-ц-Ч-ч-Ш-ш-Щ-щ-Ъ-ъ-Ы-ы-Ь-ь-Э-э-Ю-ю-Я-я"); 
	$en = explode('-', "A-a-B-b-V-v-G-g-G-g-D-d-E-e-E-e-E-e-ZH-zh-Z-z-I-i-I-i-I-i-J-j-K-k-L-l-M-m-N-n-O-o-P-p-R-r-S-s-T-t-U-u-F-f-H-h-TS-ts-CH-ch-SH-sh-SCH-sch---Y-y---E-e-YU-yu-YA-ya");

 	$res = str_replace($ru, $en, $text);
	$res = preg_replace("/[\s]+/ui", '-', $res);
	$res = strtolower(preg_replace("/[^0-9a-zа-я\-]+/ui", '', $res));
 	
    return $res;  
}
	