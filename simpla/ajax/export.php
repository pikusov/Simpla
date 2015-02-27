<?php

require_once('../../api/Simpla.php');

class ExportAjax extends Simpla
{	
	private $columns_names = array(
			'category'=>         'Êàòåãîðèÿ',
			'name'=>             'Òîâàð',
			'price'=>            'Öåíà',
			'url'=>              'Àäðåñ',
			'visible'=>          'Âèäèì',
			'featured'=>         'Ðåêîìåíäóåìûé',
			'brand'=>            'Áðåíä',
			'variant'=>          'Âàðèàíò',
			'compare_price'=>    'Ñòàðàÿ öåíà',
			'sku'=>              'Àðòèêóë',
			'stock'=>            'Ñêëàä',
			'meta_title'=>       'Çàãîëîâîê ñòðàíèöû',
			'meta_keywords'=>    'Êëþ÷åâûå ñëîâà',
			'meta_description'=> 'Îïèñàíèå ñòðàíèöû',
			'annotation'=>       'Àííîòàöèÿ',
			'body'=>             'Îïèñàíèå',
			'images'=>           'Èçîáðàæåíèÿ'
			);
			
	private $column_delimiter = ';';
	private $subcategory_delimiter = '/';
	private $products_count = 5;
	private $export_files_dir = '../files/export/';
	private $filename = 'export.csv';

	public function fetch()
	{

		if(!$this->managers->access('export'))
			return false;

		// Ýêñåëü êóøàåò òîëüêî 1251
		setlocale(LC_ALL, 'ru_RU.1251');
		$this->db->query('SET NAMES cp1251');
	
		// Ñòðàíèöà, êîòîðóþ ýêñïîðòèðóåì
		$page = $this->request->get('page');
		if(empty($page) || $page==1)
		{
			$page = 1;
			// Åñëè íà÷àëè ñíà÷àëà - óäàëèì ñòàðûé ôàéë ýêñïîðòà
			if(is_writable($this->export_files_dir.$this->filename))
				unlink($this->export_files_dir.$this->filename);
		}
		
		// Îòêðûâàåì ôàéë ýêñïîðòà íà äîáàâëåíèå
		$f = fopen($this->export_files_dir.$this->filename, 'ab');
		
		// Äîáàâèì â ñïèñîê êîëîíîê ñâîéñòâà òîâàðîâ
		$features = $this->features->get_features();
		foreach($features as $feature)
			$this->columns_names[$feature->name] = $feature->name;
		
		// Åñëè íà÷àëè ñíà÷àëà - äîáàâèì â ïåðâóþ ñòðîêó íàçâàíèÿ êîëîíîê
		if($page == 1)
		{
			fputcsv($f, $this->columns_names, $this->column_delimiter);
		}
		
		// Âñå òîâàðû
		$products = array();
 		foreach($this->products->get_products(array('page'=>$page, 'limit'=>$this->products_count)) as $p)
 		{
 			$products[$p->id] = (array)$p;
 			
	 		// Ñâîéñòâà òîâàðîâ
	 		$options = $this->features->get_product_options($p->id);
	 		foreach($options as $option)
	 		{
	 			if(!isset($products[$option->product_id][$option->name]))
					$products[$option->product_id][$option->name] = str_replace(',', '.', trim($option->value));
	 		}

 			
 		}
 		
 		if(empty($products))
 			return false;
 		
 		// Êàòåãîðèè òîâàðîâ
 		foreach($products as $p_id=>&$product)
 		{
	 		$categories = array();
	 		$cats = $this->categories->get_product_categories($p_id);
	 		foreach($cats as $category)
	 		{
	 			$path = array();
	 			$cat = $this->categories->get_category((int)$category->category_id);
	 			if(!empty($cat))
 				{
	 				// Âû÷èñëÿåì ñîñòàâëÿþùèå êàòåãîðèè
	 				foreach($cat->path as $p)
	 					$path[] = str_replace($this->subcategory_delimiter, '\\'.$this->subcategory_delimiter, $p->name);
	 				// Äîáàâëÿåì êàòåãîðèþ ê òîâàðó 
	 				$categories[] = implode('/', $path);
 				}
	 		}
	 		$product['category'] = implode(', ', $categories);
 		}
 		
 		// Èçîáðàæåíèÿ òîâàðîâ
 		$images = $this->products->get_images(array('product_id'=>array_keys($products)));
 		foreach($images as $image)
 		{
 			// Äîáàâëÿåì èçîáðàæåíèÿ ê òîâàðó ÷åçåð çàïÿòóþ
 			if(empty($products[$image->product_id]['images']))
 				$products[$image->product_id]['images'] = $image->filename;
 			else
 				$products[$image->product_id]['images'] .= ', '.$image->filename;
 		}
 
 		$variants = $this->variants->get_variants(array('product_id'=>array_keys($products)));

		foreach($variants as $variant)
 		{
 			if(isset($products[$variant->product_id]))
 			{
	 			$v                    = array();
	 			$v['variant']         = $variant->name;
	 			$v['price']           = $variant->price;
	 			$v['compare_price']   = $variant->compare_price;
	 			$v['sku']             = $variant->sku;
	 			$v['stock']           = $variant->stock;
	 			if($variant->infinity)
	 				$v['stock']           = '';
				$products[$variant->product_id]['variants'][] = $v;
	 		}
		}
		
		foreach($products as &$product)
 		{
 			$variants = $product['variants'];
 			unset($product['variants']);
 			
 			if(isset($variants))
 			foreach($variants as $variant)
 			{
 				$result = array();
 				$result =  $product;
 				foreach($variant as $name=>$value)
 					$result[$name]=$value;

	 			foreach($this->columns_names as $internal_name=>$column_name)
	 			{
	 				if(isset($result[$internal_name]))
		 				$res[$internal_name] = $result[$internal_name];
	 				else
		 				$res[$internal_name] = '';
	 			}
	 			fputcsv($f, $res, $this->column_delimiter);

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
$data = $export_ajax->fetch();
if($data)
{
	header("Content-type: application/json; charset=utf-8");
	header("Cache-Control: must-revalidate");
	header("Pragma: no-cache");
	header("Expires: -1");
	$json = json_encode($data);
	print $json;
}
