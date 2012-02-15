<?php

chdir('../..');
require_once('api/Simpla.php');

class ImportAjax extends Simpla
{	
	// Соответствие полей в базе и имён колонок в файле
	private $columns_names = array(
			'name'=>             array('product', 'name', 'товар', 'название', 'наименование'),
			'url'=>              array('url', 'адрес'),
			'visible'=>          array('visible', 'видим'),
			'featured'=>         array('featured', 'hit', 'хит', 'рекомендуемый'),
			'category'=>         array('category', 'категория'),
			'brand'=>            array('brand', 'бренд'),
			'variant'=>          array('variant', 'вариант'),
			'price'=>            array('price', 'цена'),
			'compare_price'=>    array('compare_price', 'старая цена'),
			'sku'=>              array('sku', 'артикул'),
			'stock'=>            array('stock', 'склад', 'на складе'),
			'meta_title'=>       array('meta_title', 'заголовок страницы'),
			'meta_keywords'=>    array('meta_keywords', 'ключевые слова'),
			'meta_description'=> array('meta_description', 'описание страницы'),
			'annotation'=>       array('annotation', 'аннотация', 'краткое описание'),
			'description'=>      array('description', 'описание'),
			'images'=>           array('images', 'изображения')
			);
	
	// Соответствие имени колонки и поля в базе
	private $internal_columns_names = array();

	private $import_files_dir      = 'simpla/files/import/'; // Временная папка		
	private $import_file           = 'import.csv';           // Временный файл
	private $subcategory_delimiter = '/';                    // Разделитель каегорий в файле
	private $column_delimiter      = ';';
	private $products_count        = 10;
	private $columns               = array();

	public function import()
	{
		// Для корректной работы установим локаль cp1251
		setlocale(LC_ALL, 'ru_RU.UTF-8');
		
		// Определяем колонки из первой строки файла
		$f = fopen($this->import_files_dir.$this->import_file, 'r');
		$this->columns = fgetcsv($f, null, $this->column_delimiter);

		// Заменяем имена колонок из файла на внутренние имена колонок
		foreach($this->columns as &$column)
		{ 
			if($internal_name = $this->internal_column_name($column))
			{
				$this->internal_columns_names[$column] = $internal_name;
				$column = $internal_name;
			}
		}
		
		// Если нет названия товара - не будем импортировать
		if(!in_array('name', $this->columns))
			return false;
	 	
		// Переходим на заданную позицию, если импортируем не сначала
		if($from = $this->request->get('from'))
			fseek($f, $from);
		
		// Массив импортированных товаров
		$imported_items = array();	
		
		// Проходимся по строкам, пока не конец файла
		// или пока не импортировано достаточно строк для одного запроса
		for($k=0; !feof($f) && $k<$this->products_count; $k++)
		{ 
			// Читаем строку
			$line = fgetcsv($f, 0, $this->column_delimiter);

			$product = null;			

			if(is_array($line))			
			// Проходимся по колонкам строки
			foreach($this->columns as $i=>$col)
			{
				// Создаем массив item[название_колонки]=значение
 				if(isset($line[$i]) && !empty($line) && !empty($col))
					$product[$col] = $line[$i];
			}
			
			// Импортируем этот товар
	 		if($imported_item = $this->import_item($product))
				$imported_items[] = $imported_item;
		}

		/*
		if(count($variants_ids)>0)
		{
			// Для отчета выбираем импортированные товары
	 		$variants = (array)$this->variants->get_variants(array('id'=>$variants_ids));
	 		$products_ids = array();

	 		foreach($variants as $v)
	 			$products_ids[] = $v->product_id;
	 		
	 		$products = array();	
	 		foreach($this->products->get_products(array('id'=>$products_ids)) as $p)
	 			$products[$p->id] = $p;
	 		

	 		foreach($variants as $v)
	 		{
	 			$imported_items[$v->id]->variant_id = $v->id;
	 			$imported_items[$v->id]->product_id = $v->product_id;
	 			$imported_items[$v->id]->variant_name = $v->name;
	 			$imported_items[$v->id]->product_name = $products[$v->product_id]->name;
	 		}
 		}
 		else
 		{
 			$imported_items = null;
 		}
		*/
		
		// Запоминаем на каком месте закончили импорт
 		$from = ftell($f);
 		
 		// И закончили ли полностью весь файл
 		$result->end = feof($f);

		fclose($f);
		$size = filesize($this->import_files_dir.$this->import_file);
		
		// Создаем объект результата
		$result->from = $from;          // На каком месте остановились
		$result->totalsize = $size;     // Размер всего файла
		$result->items = $imported_items;   // Импортированные товары
	
		return $result;
	}
	
	// Импорт одного товара $item[column_name] = value;
	private function import_item($item)
	{
		// Проверим не пустое ли название и артинкул (должно быть хоть что-то из них)
		if(empty($item['name']) && empty($item['sku']))
			return false;

		// Подготовим товар для добавления в базу
		if(isset($item['name']))
			$product['name'] = trim($item['name']);
		else
			return false;

		if(isset($item['meta_title']))
			$product['meta_title'] = trim($item['meta_title']);

		if(isset($item['meta_keywords']))
			$product['meta_keywords'] = trim($item['meta_keywords']);

		if(isset($item['meta_description']))
			$product['meta_description'] = trim($item['meta_description']);

		if(isset($item['annotation']))
			$product['annotation'] = trim($item['annotation']);

		if(isset($item['description']))
			$product['body'] = trim($item['description']);
	
		if(isset($item['visible']))
			$product['visible'] = intval($item['visible']);

		if(isset($item['featured']))
			$product['featured'] = intval($item['featured']);
	
		if(isset($item['url']))
			$product['url'] = trim($item['url']);
	
		// Если задан бренд
		$item['brand'] = trim($item['brand']);	
		if(!empty($item['brand']))
		{
			// Найдем его по имени
			$this->db->query('SELECT id FROM __brands WHERE name=?', $item['brand']);
			if(!$product['brand_id'] = $this->db->result('id'))
				// Создадим, если не найден
				$product['brand_id'] = $this->brands->add_brand(array('name'=>$item['brand'], 'meta_title'=>$item['brand'], 'meta_keywords'=>$item['brand'], 'meta_description'=>$item['brand']));
		}
		
		// Если задана категория
		$category_id = null;
		if(isset($item['category']))
		{
			$category_id = $this->import_category($item['category']);
		}
	
		// Подготовим вариант товара
		if(isset($item['variant']))
			$variant['name'] = trim($item['variant']);
		else
			$variant['name'] = '';
			
		if(isset($item['price']))
			$variant['price'] = trim($item['price']);
			
		if(isset($item['compare_price']))
			$variant['compare_price'] = trim($item['compare_price']);
			
		if(isset($item['stock']))
			if($item['stock'] == '')
				$variant['stock'] = null;
			else
				$variant['stock'] = trim($item['stock']);
			
		if(isset($item['sku']))
			$variant['sku'] = trim($item['sku']);
		
		// Если задан артикул варианта, найдем этот вариант и соответствующий товар
		if(!empty($variant['sku']))
		{ 
			$this->db->query('SELECT id as variant_id, product_id FROM __variants WHERE sku=? LIMIT 1', $variant['sku']);
			$result = $this->db->result();
			if($result)
			{
				// и обновим товар
				$product_id = $this->products->update_product($result->product_id, $product);
				// и вариант
				$variant_id = $this->variants->update_variant($result->variant_id, $variant);
				
				// Обновлен
				$imported_item->status = 'updated';
			}
		}
		
		// Если на прошлом шаге товар не нашелся,
		if(empty($product_id) || empty($variant_id))
		{
			// Ищем его по названию и категории
			//if(!empty($category_id))
			//	$this->db->query('SELECT v.id as variant_id, p.id as product_id FROM __products p LEFT JOIN __variants v ON v.product_id=p.id AND v.name=? LEFT JOIN __products_categories pc ON pc.product_id=p.id WHERE (pc.category_id=? OR pc.category_id is NULL) AND p.name=? LIMIT 1', $item['variant'], $category_id, $item['name']);
			// Или только по названию, если категория не задана
			//else	
				$this->db->query('SELECT v.id as variant_id, p.id as product_id FROM __products p LEFT JOIN __variants v ON v.product_id=p.id AND v.name=? WHERE p.name=? LIMIT 1', $variant['name'], $item['name']);
			
			$r =  $this->db->result();
			$product_id = $r->product_id;
			$variant_id = $r->variant_id;
			// Если товар найден - обноаляем,
			if($variant_id)
			{
				$this->variants->update_variant($variant_id, $variant);
				$this->products->update_product($product_id, $product);				
				$imported_item->status = 'updated';		
			}
			// Иначе - добавляем
			elseif(empty($variant_id))
			{
				if(empty($product_id))
					$product_id = $this->products->add_product($product);
				$variant['product_id'] = $product_id;
				$variant_id = $this->variants->add_variant($variant);
				$imported_item->status = 'added';		
			}
		}
		
		// Нужно вернуть обновленный товар
		$imported_item->variant = $this->variants->get_variant(intval($variant_id));			
		$imported_item->product = $this->products->get_product(intval($product_id));						

		// Добавляем категорию к товару
		if(!empty($category_id))
			$this->categories->add_product_category($product_id, $category_id);

 		// Изображения товаров
 		if(isset($item['images']))
 		{
 			// Изображений может быть несколько, через запятую
 			$images = explode(',', $item['images']);
 			foreach($images as $image)
 			{
 				$image = trim($image);
 				if(!empty($image))
 				{
	 				// Имя файла
					$image_filename = pathinfo($image, PATHINFO_BASENAME);
	 				
	 				// Добавляем изображение только если такого еще нет в этом товаре
					$this->db->query('SELECT filename FROM __images WHERE product_id=? AND (filename=? OR filename=?) LIMIT 1', $product_id, $image_filename, $image);
					if(!$this->db->result('filename'))
					{
						$this->products->add_image($product_id, $image);
					}
				}
 			}
 		}
 		// Характеристики товаров
 		foreach($item as $feature_name=>$feature_value)
 		{
 			// Если нет такого названия колонки, значит это название свойства
 			if(!in_array($feature_name, $this->internal_columns_names))
 			{ 
 				// Свойство добавляем только если для товара указана категория
				if($category_id)
				{
					$this->db->query('SELECT f.id FROM __features f WHERE f.name=? LIMIT 1', $feature_name);
					if(!$feature_id = $this->db->result('id'))
						$feature_id = $this->features->add_feature(array('name'=>$feature_name));
						
					$this->features->add_feature_category($feature_id, $category_id);				
					$this->features->update_option($product_id, $feature_id, $feature_value);
				}
				
 			}
 		} 		
 		return $imported_item;
	}
	
	
	// Отдельная функция для импорта категории
	private function import_category($category)
	{			
		// Поле "категория" может состоять из нескольких имен, разделенных subcategory_delimiter-ом
		// Только неэкранированный subcategory_delimiter может разделять категории
		$delimiter = $this->subcategory_delimiter;
		$regex = "/\\DELIMITER((?:[^\\\\\DELIMITER]|\\\\.)*)/";
		$regex = str_replace('DELIMITER', $delimiter, $regex);
		$names = preg_split($regex, $category, 0, PREG_SPLIT_DELIM_CAPTURE);
		$id = null;   
		$parent = 0; 
		
		// Для каждой категории
		foreach($names as $name)
		{
			// Заменяем \/ на /
			$name = trim(str_replace("\\$delimiter", $delimiter, $name));
			if(!empty($name))
			{
				// Найдем категорию по имени
				$this->db->query('SELECT id FROM __categories WHERE name=? AND parent_id=?', $name, $parent);
				$id = $this->db->result('id');
				
				// Если не найдена - добавим ее
				if(empty($id))
					$id = $this->categories->add_category(array('name'=>$name, 'parent_id'=>$parent, 'meta_title'=>$name,  'meta_keywords'=>$name,  'meta_description'=>$name));

				$parent = $id;
			}	
		}
		return $id;
	}
	
	// Фозвращает внутреннее название колонки по названию колонки в файле
	private function internal_column_name($name)
	{
 		$name = trim($name);
 		$name = str_replace('/', '', $name);
 		$name = str_replace('\/', '', $name);
		foreach($this->columns_names as $i=>$names)
		{
			foreach($names as $n)
				if(!empty($name) && preg_match("/^$name$/ui", $n))
					return $i;
		}
		return false;				
	}
}

$import_ajax = new ImportAjax();
header("Content-type: application/json; charset=UTF-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		
		
$json = json_encode($import_ajax->import());
print $json;