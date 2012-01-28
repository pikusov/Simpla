<?php /*%%SmartyHeaderCode:16573736674ea447bbabcd21-42870567%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '355a0cfe9bab6a7e0408d28fba25782ddae652e0' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/index.tpl',
      1 => 1317900550,
      2 => 'file',
    ),
    'e8f08a32e1254bc7ed363866826a82df3463c911' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/cart_informer.tpl',
      1 => 1311778380,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16573736674ea447bbabcd21-42870567',
  'has_nocache_code' => 0,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><!DOCTYPE html>
<html>
<head>
	<base href="http://simpla/"/>
	<title>Хиты продаж</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<!--meta name="viewport"    content="width=device-width" /-->
	<meta name="description" content="Этот магазин является демонстрацией скрипта интернет-магазина  Simpla . Все материалы на этом сайте присутствуют исключительно в демострационных целях." />
	<meta name="keywords"    content="Хиты продаж" />
	
	<link href="design/default/css/style.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="design/default/images/favicon.ico" rel="icon"          type="image/x-icon">
	<link href="design/default/images/favicon.ico" rel="shortcut icon" type="image/x-icon">
	
	<script src="js/jquery/jquery.js"        language="JavaScript" type="text/javascript"></script>
	<script src="js/jquery/jquery-ui.min.js" language="JavaScript" type="text/javascript"></script>
	
		<script src ="js/admintooltip/admintooltip.js" language="JavaScript" type="text/javascript"></script>
	<link   href="js/admintooltip/css/admintooltip.css" rel="stylesheet" type="text/css" /> 
	        
	
	<script>
	$(function() {
		$('select[name=currency_id]').change(function() {
			$(this).closest('form').submit();
		});
	});
	</script>
	

</head>
<body>

	<!-- Вся страница --> 
	<div id="main">

		<!-- Правая часть страницы-->
		<div id="right_side">
		<div id="right_container">
		
			<!-- Шапка -->
			<div id="header">
				
				<!-- Вход пользователя -->
									<a id="register" href="user/register">Регистрация</a>
					<a id=login href="user/login">Вход</a>
								<!-- Вход пользователя (The End)-->		

				<!-- Выбор валюты -->
								<div id="currency">
				<form name="currency" method="post">
					Валюта:
					<select name="currency_id">
												                       
						<option value="2" selected>
						рубли
						</option>
																		                       
						<option value="1" >
						доллары
						</option>
																													</select>
				</form>
				</div> 
								<!-- Выбор валюты (The End) -->	

				<!-- Главное меню -->
				<ul id="main_menu"> 
														<li class="selected" page_id="1">
						<a href="">Хиты продаж</a>
					</li>
																			<li  page_id="4">
						<a href="blog">Блог</a>
					</li>
																			<li  page_id="3">
						<a href="dostavka">Доставка</a>
					</li>
																			<li  page_id="2">
						<a href="oplata">Оплата</a>
					</li>
																												<li  page_id="6">
						<a href="contact">Контакты</a>
					</li>
													</ul>
				<!-- Главное меню (The End)-->

			</div>
			<!-- Шапка (The End)-->
			
			<!-- Центральный блок, зависящий от текущего модуля -->
			<h1>Хиты продаж</h1>
<p style="font-family: tahoma; font-size:20px; color:#0090FF">Этот магазин является демонстрацией скрипта интернет-магазина <a href="http://simplacms.ru">Simpla</a>. Все материалы на этом сайте присутствуют исключительно в демострационных целях.</p><p>&nbsp;</p>

<!-- Список товаров-->
<ul id="catalog">

		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/samsung_s5570_galaxy_mini"><img src="http://simpla/files/products/Samsung-Galaxy-Mini-S5570.200x200.jpg?121a6d451e08318f814bad31d3f5f4dc" alt="Samsung S5570 Galaxy Mini"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="8" href="products/samsung_s5570_galaxy_mini">Samsung S5570 Galaxy Mini</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="12"  price="7 300">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>7 300</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/samsung_s7070_diva"><img src="http://simpla/files/products/Samsung-Diva-S7070.200x200.jpeg?5c846c52d4ecaa5a030e27bf2d2c2a18" alt="Samsung S7070 Diva"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="17" href="products/samsung_s7070_diva">Samsung S7070 Diva</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="25"  price="8 500">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>8 500</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/htc_incredible_s"><img src="http://simpla/files/products/HTC-Incredible-S_D.200x200.jpeg?1b83f692c26c7410fda66678759b0429" alt="HTC Incredible S"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="3" href="products/htc_incredible_s">HTC Incredible S</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="4"  price="16 000">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>16 000</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/htc_sensation"><img src="http://simpla/files/products/HTC-Sensation-4G-1.200x200.jpeg?2a4e6bf1dae734087c8772b6fcb9b2e3" alt="HTC Sensation"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="4" href="products/htc_sensation">HTC Sensation</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="5"  price="20 300">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>20 300</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/sony_ericsson_xperia_arc"><img src="http://simpla/files/products/Sony-Ericsson-XPERIA-Arc.200x200.jpeg?fa75e8c22871ecd897f9ef7f8ccaceb1" alt="Sony Ericsson Xperia arc"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="7" href="products/sony_ericsson_xperia_arc">Sony Ericsson Xperia arc</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="11"  price="20 000">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>20 000</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/htc_salsa"><img src="http://simpla/files/products/htcsalsa_3.200x200.jpg?daa48a372098129cf8c97aa6b47d6d24" alt="HTC Salsa"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="14" href="products/htc_salsa">HTC Salsa</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="22"  price="12 000">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>12 000</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/htc_legend"><img src="http://simpla/files/products/htc-legend.200x200.jpg?fff9ff32def5cdf3cf308add39b561e8" alt="HTC Legend"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="16" href="products/htc_legend">HTC Legend</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="24"  price="15 700">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>15 700</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/blackberry_bold_9900"><img src="http://simpla/files/products/BlackBerry-Bold-9900-and-9930-Smartphone-2.200x200.jpg?c63a0a006383a24c47c3316ec9128124" alt="BlackBerry Bold 9900"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="18" href="products/blackberry_bold_9900">BlackBerry Bold 9900</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="26"  price="33 000">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>33 000</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/nokia_c203"><img src="http://simpla/files/products/Nokia-C2-031.200x200.jpg?47f32403804496579d6e64c4abaddd6d" alt="Nokia C2-03"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="21" href="products/nokia_c203">Nokia C2-03</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="29"  price="4 000">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>4 000</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/samsung_s3650_corby"><img src="http://simpla/files/products/samsung_s3650_corby_29193d.200x200.jpg?6ff3ee1e8b9100bdcf19568c7d1fab75" alt="Samsung S3650 Corby"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="24" href="products/samsung_s3650_corby">Samsung S3650 Corby</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="32"  price="4 500">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>4 500</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/blackberry_torch_9810"><img src="http://simpla/files/products/Torch_9810_Front2.200x200.jpg?15d7d02ecc1d61a50cf57febf8a7dea9" alt="BlackBerry Torch 9810"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="27" href="products/blackberry_torch_9810">BlackBerry Torch 9810</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="35"  price="29 000">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>29 000</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
		<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
				<div class="image">
			<a href="products/nokia_701"><img src="http://simpla/files/products/nokia701_5.200x200.jpg?e8701023e8c09dc4d40281cc259b32ba" alt="Nokia 701"/></a>
		</div>
				<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a product_id="28" href="products/nokia_701">Nokia 701</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div></div>
		<!-- Описание товара (The End) -->
		
				<!-- Цена и заказ товара -->
		<form class="cart" method="get" action="cart">
			
			<!-- Выбор варианта товара -->
			<select name="variant" style='display:none;'>
								<option value="36"  price="17 000">
				
				</option>
							</select>
			<!-- Выбор варианта товара (The End) -->
			
			<!-- Цена товара -->
			<div class="price">
				<strike>
								</strike>
				<span>17 000</span>
				<i>руб</i>
			</div>
			<!-- Цена товара  (The End) -->			

			<!-- В корзину -->
			<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
			<!-- В корзину (The End) -->
			
		</form>
		<!-- Цена и заказ товара (The End)-->
				
	</li>
	<!-- Товар (The End)-->
				
</ul>
	
<!--Каталог товаров (The End)-->
 
<!-- Аяксовая корзина -->
<script src="js/ajax-cart.js"></script>

<script>

$(function() {
	// Выбор вариантов
	$('select[name=variant]').change(function() {
		price = $(this).find('option:selected').attr('price');
		compare_price = '';
		if(typeof $(this).find('option:selected').attr('compare_price') == 'string')
			compare_price = $(this).find('option:selected').attr('compare_price');
		$(this).find('option:selected').attr('compare_price');
		$(this).closest('form').find('span').html(price);
		$(this).closest('form').find('strike').html(compare_price);
		return false;		
	});
});
</script>

				
		</div>
		</div> 
		<!-- Правая часть страницы (The End)-->
		
		<!-- Левая часть страницы-->
		<div id="left_side">
		
		   	<!-- Логотип -->
			<div id="logo"><a href="."><img src="design/default/images/logo.png" title="Великолепный интернет-магазин" alt="Великолепный интернет-магазин"/></a></div>
			<!-- Логотип (The End) -->

			<!-- Корзина -->
			<div id="cart_informer">
					В <a href="./cart/">корзине</a>
	1 товар
	на 20 000 руб
			</div>
			<!-- Корзина (The End)-->
			
			<!-- Поиск-->
			<div id="search">
				<form action="products">
					<input class="input_search" type="text" name="keyword" value="" />
					<input class="button_search" value="" type="submit" />
				</form>
			</div>
			<!-- Поиск (The End)-->
			
			<!-- Меню каталога -->
			<div id="catalog_menu">
									<ul>
												<li >
												<a href="catalog/mobilnye_telefony" category_id="1">Мобильные телефоны</a>
					</li>
								
																<li >
												<a href="catalog/bytovaya_tehnika" category_id="2">Бытовая техника</a>
					</li>
											<ul>
												<li >
												<a href="catalog/pylesosy" category_id="3">Пылесосы</a>
					</li>
								
																<li >
												<a href="catalog/miksery" category_id="4">Миксеры</a>
					</li>
								
										</ul>
			
																<li >
												<a href="catalog/fotoapparaty" category_id="5">Фотоаппараты</a>
					</li>
								
										</ul>
			
			</div>
			<!-- Меню каталога (The End)-->			

			<!-- Все бренды -->
			
						<div id="all_brands">
				<h2>Все бренды:</h2>
					
										<a href="brands/apple">Apple</a>
										</a>
					
										<a href="brands/blackberry">BlackBerry</a>
										</a>
					
										<a href="brands/canon">Canon</a>
										</a>
					
										<a href="brands/dyson">Dyson</a>
										</a>
					
										<a href="brands/electrolux">Electrolux</a>
										</a>
					
										<a href="brands/htc">HTC</a>
										</a>
					
										<a href="brands/nikon">Nikon</a>
										</a>
					
										<a href="brands/nokia">Nokia</a>
										</a>
					
										<a href="brands/samsung">Samsung</a>
										</a>
					
										<a href="brands/sony_ericsson">Sony Ericsson</a>
										</a>
					
										<a href="brands/zelmer">Zelmer</a>
										</a>
							</div>
						<!-- Все бренды (The End)-->			
			
			<!-- Просмотренные товары -->
			
						<div id="browsed_products">
				<h2>Вы просматривали:</h2>
									<a href="products/nokia_c600"><img src="http://simpla/files/products/nokiac600.50x50.jpg?fe147757bd547929a02ff704a2771deb" alt="Nokia C6-00" title="Nokia C6-00"></a>
									<a href="products/nokia_e7"><img src="http://simpla/files/products/nokia_e7_blue_front_1200x1200.50x50.png?5c1c65712bcff1d619878ef566524819" alt="Nokia E7" title="Nokia E7"></a>
									<a href="products/nokia_x200"><img src="http://simpla/files/products/nokia_X2_front_blue_604x604.50x50.png?f130f5d212756b87590c095e8ef92e94" alt="Nokia X2-00" title="Nokia X2-00"></a>
									<a href="products/nokia_x302"><img src="http://simpla/files/products/1Nokia-X3-02-Touch-and-Type-1.50x50.jpg?458afa0ea34d89f1e7886c7c7c8e6c37" alt="Nokia X3-02" title="Nokia X3-02"></a>
									<a href="products/sony_ericsson_vivaz"><img src="http://simpla/files/products/Vivaz_Front_MoonSilver.50x50.jpg?6e8a01da0d2d9bb027cacded49681bbb" alt="Sony Ericsson Vivaz" title="Sony Ericsson Vivaz"></a>
									<a href="products/sony_ericsson_xperia_arc"><img src="http://simpla/files/products/Sony-Ericsson-XPERIA-Arc.50x50.jpeg?f6d750d8e9e7aee3f74cbc07a4460686" alt="Sony Ericsson Xperia arc" title="Sony Ericsson Xperia arc"></a>
									<a href="products/nokia_e72"><img src="http://simpla/files/products/E72_black_01-300-100.50x50.jpeg?12695d1d893f410183261043bb8bd2f6" alt="Nokia E72" title="Nokia E72"></a>
									<a href="products/nokia_c503"><img src="http://simpla/files/products/210_Nokia_C5_03.50x50.jpeg?d4b1d914d9858d39ca2b1a131903d261" alt="Nokia C5-03" title="Nokia C5-03"></a>
									<a href="products/htc_sensation"><img src="http://simpla/files/products/HTC-Sensation-4G-1.50x50.jpeg?30a0823dce2ddc974a0e791e240187da" alt="HTC Sensation" title="HTC Sensation"></a>
									<a href="products/htc_incredible_s"><img src="http://simpla/files/products/HTC-Incredible-S_D.50x50.jpeg?951113d198d7444a56e09499894a08a0" alt="HTC Incredible S" title="HTC Incredible S"></a>
									<a href="products/samsung_s7070_diva"><img src="http://simpla/files/products/Samsung-Diva-S7070.50x50.jpeg?b2ba0beeabc6b661919bc773b6059c2d" alt="Samsung S7070 Diva" title="Samsung S7070 Diva"></a>
									<a href="products/samsung_galaxy_s_ii"><img src="http://simpla/files/products/Samsung-Galaxy-S-II.50x50.jpg?ec9b9cf6517d1453c2225f645d9c02a4" alt="Samsung Galaxy S II" title="Samsung Galaxy S II"></a>
									<a href="products/apple_iphone_4s_16gb"><img src="http://simpla/files/products/iphone4s-white.50x50.jpeg?db3b25cb2cde418d41862eda2e649578" alt="Apple iPhone 4S 16Gb" title="Apple iPhone 4S 16Gb"></a>
									<a href="products/pylesos_electrolux_zt_3510"><img src="http://simpla/files/products/zt3510uk-lr.50x50.jpeg?1ffff7064dea189739920ddb81974189" alt="Пылесос Electrolux ZT 3510" title="Пылесос Electrolux ZT 3510"></a>
									<a href="products/samsung_s5570_galaxy_mini"><img src="http://simpla/files/products/Samsung-Galaxy-Mini-S5570.50x50.jpg?448ff55ca7fde270e7f1bd73aea85878" alt="Samsung S5570 Galaxy Mini" title="Samsung S5570 Galaxy Mini"></a>
									<a href="products/mikser_zelmer_48164"><img src="http://simpla/files/products/5900215513508F2.50x50.jpg?8f2cb81a0eb1386e1189c7531fe643fe" alt="Миксер Zelmer 481.64" title="Миксер Zelmer 481.64"></a>
									<a href="products/pylesos_dyson_dc23_pink"><img src="http://simpla/files/products/dc23_pink_weis_klein.50x50.jpeg?26cc2c268e6fa5b9672397b31df304b9" alt="Пылесос Dyson DC23 Pink" title="Пылесос Dyson DC23 Pink"></a>
									<a href="products/fotoapparat_canon_digital_ixus_1000_hs"><img src="http://simpla/files/products/IXUS-1000%20HS%20BROWN.50x50.jpg?c53e7a83da5d6999042d8d221d25921e" alt="Фотоаппарат Canon Digital IXUS 1000 HS" title="Фотоаппарат Canon Digital IXUS 1000 HS"></a>
									<a href="products/fotoapparat_nikon_coolpix_l120"><img src="http://simpla/files/products/Nikon-Coolpix-L120_1.50x50.jpg?e7fc16200c8440f6cfa995626971fd9b" alt="Фотоаппарат Nikon Coolpix L120" title="Фотоаппарат Nikon Coolpix L120"></a>
									<a href="products/fotoapparat_canon_powershot_a3200_is"><img src="http://simpla/files/products/Canon-PowerShot-A3200-IS-Orange.50x50.jpg?9a58409afaa9a21c5cae5c3367acc6f0" alt="Фотоаппарат Canon PowerShot A3200 IS" title="Фотоаппарат Canon PowerShot A3200 IS"></a>
							</div>
						<!-- Меню блога (The End)-->

			<!-- Просмотренные товары -->
			
			<!-- Меню блога -->
			
						<div id="blog_menu">
				<h2>Новые записи в <a href="blog">блоге</a></h2>
								<ul>
					<li post_id="1">23.10.2011 <a href="blog/chto_novogo_v_etoj_versii_simply">Что нового в этой версии симплы</a></li>
				</ul>
							</div>
						<!-- Просмотренные товары -->

		</div>
		<!-- Левая часть страницы (The End)-->

		<!-- Подвал сайта -->
		<div id="footer">
			&copy; 2011 <a href="http://simplacms.ru">Скрипт интернет-магазина Simpla</a>
		</div>
		<!-- Подвал сайта (The End)--> 
		
	</div>
	<!-- Вся страница (The End)--> 
	
</body>
</html><?php } ?>