<?php

require_once('../../api/Simpla.php');

class ImportAjax extends Simpla
{	
	// Соответствие полей в базе и имён колонок в файле
	private $columns_names = array(
			'name'=>             array('product', 'name', 'товар', 'название', 'наименование'),
			'url'=>              array('url', 'адрес'),
			'visible'=>          array('visible', 'published', 'видим'),
			'featured'=>         array('featured', 'hit', 'хит', 'рекомендуемый'),
			'category'=>         array('category', 'категория'),
			'brand'=>            array('brand', 'бренд'),
			'variant'=>          array('variant', 'вариант'),
			'price'=>            array('price', 'цена'),
			'compare_price'=>    array('compare price', 'старая цена'),
			'sku'=>              array('sku', 'артикул'),
			'stock'=>            array('stock', 'склад', 'на складе'),
			'meta_title'=>       array('meta title', 'заголовок страницы'),
			'meta_keywords'=>    array('meta keywords', 'ключевые слова'),
			'meta_description'=> array('meta description', 'описание страницы'),
			'annotation'=>       array('annotation', 'аннотация', 'краткое описание'),
			'description'=>      array('description', 'описание'),
			'images'=>           array('images', 'изображения')
			);
	
	// Соответствие имени колонки и поля в базе
	private $internal_columns_names = array();

	private $import_files_dir      = '../files/import/'; // Временная папка		
	private $import_file           = 'import.csv';           // Временный файл
	private $category_delimiter = ',';                       // Разделитель каегорий в файле
	private $subcategory_delimiter = '/';                    // Разделитель подкаегорий в файле
	private $column_delimiter      = ';';
	private $products_count        = 10;
	private $columns               = array();

	public function import()
	{
		if(!$this->managers->access('import'))
			return false;

		// Для корректной работы установим локаль UTF-8
		setlocale(LC_ALL, 'ru_RU.UTF-8');
		
		$result = new stdClass;
		
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
		if(!in_array('name', $this->columns) && !in_array('sku', $this->columns))
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
		$imported_item = new stdClass;
		
		// Проверим не пустое ли название и артинкул (должно быть хоть что-то из них)
		if(empty($item['name']) && empty($item['sku']))
			return false;

		// Подготовим товар для добавления в базу
		$product = array();
		
		if(isset($item['name']))
			$product['name'] = trim($item['name']);

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
		elseif(isset($item['name']))
			$product['url'] = $this->translit($item['name']);
	
		// Если задан бренд
		if(!empty($item['brand']))
		{
			$item['brand'] = trim($item['brand']);
			// Найдем его по имени
			$this->db->query('SELECT id FROM __brands WHERE name=?', $item['brand']);
			if(!$product['brand_id'] = $this->db->result('id'))
				// Создадим, если не найден
				$product['brand_id'] = $this->brands->add_brand(array('name'=>$item['brand'], 'meta_title'=>$item['brand'], 'meta_keywords'=>$item['brand'], 'meta_description'=>$item['brand']));
		}
		
		// Если задана категория
		$category_id = null;
		$categories_ids = array();
		if(isset($item['category']))
		{
			foreach(explode($this->category_delimiter, $item['category']) as $c)
				$categories_ids[] = $this->import_category($c);
			$category_id = reset($categories_ids);
		}
	
		// Подготовим вариант товара
		$variant = array();
		
		if(isset($item['variant']))
			$variant['name'] = trim($item['variant']);
			
		if(isset($item['price']))
			$variant['price'] = str_replace(',', '.', trim($item['price']));
			
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
			$this->db->query('SELECT id as variant_id, product_id FROM __variants, __products WHERE sku=? AND __variants.product_id = __products.id LIMIT 1', $variant['sku']);
			$result = $this->db->result();
			if($result)
			{
				// и обновим товар
				if(!empty($product))
					$this->products->update_product($result->product_id, $product);
				// и вариант
				if(!empty($variant))
					$this->variants->update_variant($result->variant_id, $variant);
				
				$product_id = $result->product_id;
				$variant_id = $result->variant_id;
				// Обновлен
				$imported_item->status = 'updated';
			}
		}
		
		// Если на прошлом шаге товар не нашелся, и задано хотя бы название товара
		if((empty($product_id) || empty($variant_id)) && isset($item['name']))
		{
			if(!empty($variant['sku']) && empty($variant['name']))
				$this->db->query('SELECT v.id as variant_id, p.id as product_id FROM __products p LEFT JOIN __variants v ON v.product_id=p.id WHERE v.sku=? LIMIT 1', $variant['sku']);			
			elseif(isset($item['variant']))
				$this->db->query('SELECT v.id as variant_id, p.id as product_id FROM __products p LEFT JOIN __variants v ON v.product_id=p.id AND v.name=? WHERE p.name=? LIMIT 1', $item['variant'], $item['name']);
			else
				$this->db->query('SELECT v.id as variant_id, p.id as product_id FROM __products p LEFT JOIN __variants v ON v.product_id=p.id WHERE p.name=? LIMIT 1', $item['name']);			
			
			$r =  $this->db->result();
			if($r)
			{
				$product_id = $r->product_id;
				$variant_id = $r->variant_id;
			}
			// Если вариант найден - обновляем,
			if(!empty($variant_id))
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

                $this->db->query('SELECT max(v.position) as pos FROM __variants v WHERE v.product_id=? LIMIT 1', $product_id);
                $pos =  $this->db->result('pos');

				$variant['position'] = $pos+1;
				$variant['product_id'] = $product_id;
				$variant_id = $this->variants->add_variant($variant);
				$imported_item->status = 'added';
			}
		}
		
		if(!empty($variant_id) && !empty($product_id))
		{
			// Нужно вернуть обновленный товар
			$imported_item->variant = $this->variants->get_variant(intval($variant_id));			
			$imported_item->product = $this->products->get_product(intval($product_id));						
	
			// Добавляем категории к товару
			if(!empty($categories_ids))
				foreach($categories_ids as $c_id)
					$this->categories->add_product_category($product_id, $c_id);
	
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
					$id = $this->categories->add_category(array('name'=>$name, 'parent_id'=>$parent, 'meta_title'=>$name,  'meta_keywords'=>$name,  'meta_description'=>$name, 'url'=>$this->translit($name)));

				$parent = $id;
			}	
		}
		return $id;
	}

	private function translit($text)
	{
		$ru = explode('-', "А-а-Б-б-В-в-Ґ-ґ-Г-г-Д-д-Е-е-Ё-ё-Є-є-Ж-ж-З-з-И-и-І-і-Ї-ї-Й-й-К-к-Л-л-М-м-Н-н-О-о-П-п-Р-р-С-с-Т-т-У-у-Ф-ф-Х-х-Ц-ц-Ч-ч-Ш-ш-Щ-щ-Ъ-ъ-Ы-ы-Ь-ь-Э-э-Ю-ю-Я-я"); 
		$en = explode('-', "A-a-B-b-V-v-G-g-G-g-D-d-E-e-E-e-E-e-ZH-zh-Z-z-I-i-I-i-I-i-J-j-K-k-L-l-M-m-N-n-O-o-P-p-R-r-S-s-T-t-U-u-F-f-H-h-TS-ts-CH-ch-SH-sh-SCH-sch---Y-y---E-e-YU-yu-YA-ya");

	 	$res = str_replace($ru, $en, $text);
		$res = preg_replace("/[\s]+/ui", '-', $res);
		$res = preg_replace('/[^\p{L}\p{Nd}\d-]/ui', '', $res);
	 	$res = strtolower($res);
	    return $res;  
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
				if(!empty($name) && preg_match("/^".preg_quote($name)."$/ui", $n))
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