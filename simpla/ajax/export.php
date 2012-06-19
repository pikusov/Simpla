<?php

chdir('../..');
require_once('api/Simpla.php');

class ExportAjax extends Simpla
{	
	private $columns_names = array(
			'category'=>         'Категория',
			'name'=>             'Товар',
			'price'=>            'Цена',
			'url'=>              'Адрес',
			'visible'=>          'Видим',
			'featured'=>         'Рекомендуемый',
			'brand'=>            'Бренд',
			'variant'=>          'Вариант',
			'compare_price'=>    'Старая цена',
			'sku'=>              'Артикул',
			'stock'=>            'Склад',
			'meta_title'=>       'Заголовок страницы',
			'meta_keywords'=>    'Ключевые слова',
			'meta_description'=> 'Описание страницы',
			'annotation'=>       'Аннотация',
			'body'=>             'Описание',
			'images'=>           'Изображения'
			);
			
	private $column_delimiter = ';';
	private $subcategory_delimiter = '/';
	private $products_count = 5;
	private $export_files_dir = 'simpla/files/export/';
	private $filename = 'export.csv';

	public function fetch()
	{
		// Эксель кушает только 1251
		setlocale(LC_ALL, 'ru_RU.1251');
		$this->db->query('SET NAMES cp1251');
	
		// Страница, которую экспортируем
		$page = $this->request->get('page');
		if(empty($page) || $page==1)
		{
			$page = 1;
			// Если начали сначала - удалим старый файл экспорта
			if(is_writable($this->export_files_dir.$this->filename))
				unlink($this->export_files_dir.$this->filename);
		}
		
		// Открываем файл экспорта на добавление
		$f = fopen($this->export_files_dir.$this->filename, 'ab');
		
		// Добавим в список колонок свойства товаров
		$features = $this->features->get_features();
		foreach($features as $feature)
			$this->columns_names[$feature->name] = $feature->name;
		
		// Если начали сначала - добавим в первую строку названия колонок
		if($page == 1)
		{
			fputcsv($f, $this->columns_names, $this->column_delimiter);
		}
		
		// Все товары
		$products = array();
 		foreach($this->products->get_products(array('page'=>$page, 'limit'=>$this->products_count)) as $p)
 		{
 			$products[$p->id] = (array)$p;
 			
	 		// Свойства товаров
	 		$options = $this->features->get_product_options($p->id);
	 		foreach($options as $option)
	 		{
	 			if(!isset($products[$option->product_id][$option->name]))
					$products[$option->product_id][$option->name] = $option->value;
	 		}

 			
 		}
 		
 		if(empty($products))
 			return false;
 		
 		// Категории товаров
 		$categories = $this->categories->get_product_categories(array_keys($products));
 		foreach($categories as $category)
 		{
 			// Если категория у товара уже есть - не добавляем (то есть, экспортируется только первая)
 			if(isset($products[$category->product_id]) && empty($products[$category->product_id]['category']))
 			{
 				$path = array();
 				$cat = $this->categories->get_category((int)$category->category_id);
 				if(!empty($cat))
 				{
	 				// Вычисляем составляющие категории
	 				foreach($cat->path as $p)
	 					$path[] = str_replace($this->subcategory_delimiter, '\\'.$this->subcategory_delimiter, $p->name);
	 				// Добавляем категорию к товару 
	 				$products[$category->product_id]['category'] = implode('/', $path);
 				}
 			}
 		}
 		
 		// Изображения товаров
 		$images = $this->products->get_images(array('product_id'=>array_keys($products)));
 		foreach($images as $image)
 		{
 			// Добавляем изображения к товару чезер запятую
 			if(empty($products[$image->product_id]['images']))
 				$products[$image->product_id]['images'] = $image->filename;
 			else
 				$products[$image->product_id]['images'] .= ', '.$image->filename;
 		}
 
 		$variants = $this->variants->get_variants(array('product_id'=>array_keys($products)));

		foreach($variants as $variant)
 		{
 			$result = null;
 			if(isset($products[$variant->product_id]))
 			{
	 			$p                    = $products[$variant->product_id];
	 			$p['variant']         = $variant->name;
	 			$p['price']           = $variant->price;
	 			$p['compare_price']   = $variant->compare_price;
	 			$p['sku']             = $variant->sku;
	 			$p['stock']           = $variant->stock;
	 			if($variant->infinity)
	 				$p['stock']           = '';
	 			
	 			foreach($this->columns_names as $internal_name=>$column_name)
	 			{
	 				if(isset($p[$internal_name]))
		 				$result[$internal_name] = $p[$internal_name];
		 			else
		 				$result[$internal_name] = '';
	 			}
	 			fputcsv($f, $result, $this->column_delimiter);
	 		}
		}
		
		$total_products = $this->products->count_products();
		
		if($this->products_count*$page < $total_products)
			return array('end'=>false, 'page'=>$page, 'totalpages'=>$total_products/$this->products_count);
		else
			return array('end'=>true, 'page'=>$page, 'totalpages'=>$total_products/$this->products_count);		

		fclose($f);

	}
	
}

$export_ajax = new ExportAjax();
$json = json_encode($export_ajax->fetch());
header("Content-type: application/json; charset=utf-8");
header("Cache-Control: must-revalidate");
header("Pragma: no-cache");
header("Expires: -1");		
print $json;