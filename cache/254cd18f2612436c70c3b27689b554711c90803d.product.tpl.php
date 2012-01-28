<?php /*%%SmartyHeaderCode:13700003454ea45dbc1b36b7-82009687%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '254cd18f2612436c70c3b27689b554711c90803d' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/product.tpl',
      1 => 1316006913,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13700003454ea45dbc1b36b7-82009687',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><h1 product_id="13">Nokia C6-00</h1>

<div class="product">

	<!-- Большое фото -->
		<div class="image">
		<a href="http://simpla/files/products/nokiac600.800x600w.jpg?cc0a13a3a343318a7f872adf6bdaf632" class="zoom" rel="group"><img src="http://simpla/files/products/nokiac600.200x300.jpg?4a0a7502d46167dd5942986423e1f509" alt="" /></a>
	</div>
		<!-- Большое фото (The End)-->

	<!-- Дополнительные фото продукта -->
		<!-- Дополнительные фото продукта (The End)-->
	
		<!-- Цена и заказ товара -->
	<form class="cart" action="cart" method="get">
		
		<!-- Выбор варианта товара -->
		<select name="variant" style='display:none;'>
						<option value="21"  price="10 000" selected>
			
			</option>
					</select>
		<!-- Выбор варианта товара (The End) -->
		
		<!-- Цена товара -->
		<div class="price">
			<strike>
						</strike>
			<span>10 000</span>
			<i>руб</i>
		</div>
		<!-- Цена товара  (The End) -->		
	
		<!-- В корзину -->
		<input type="submit" class="add_to_cart" value="В корзину" added_text="Добавлено"/>
		<!-- В корзину (The End) -->
		
	</form>
	<!-- Цена и заказ товара (The End)-->
		
	<!-- Описание товара -->
	<div class="product_description">
		<p>С Nokia C6-00 общение станет еще более простым и удобным, благодаря быстрому доступу к электронной почте, контактам и социальным сетям. Притом, с помощью QWERTY-клавиатуры вы сможете писать сообщения в привычном темпе, не теряя времени на обдумывание, какую клавишу нужно нажать. Кстати, с помощью виджетов можно настроить рабочий стол так, чтобы в режиме реально времени загружались обновления из Facebook и других социальных сетей, также можно добавить ярлыки для быстрого доступа к контактам, чтобы быть ближе к друзьям. Когда решите пообщаться с приятелями лично, то спокойно отправляйтесь туда, куда они позовут, не боясь заблудиться, ведь в вашем смартфоне есть приемник GPS.</p>
	</div>
	<!-- Описание товара (The End)-->

	
	<!-- Соседние товары /-->
	<div id="back_forward">
					←&nbsp;<a class="back" id="PrevLink" href="products/nokia_e7">Nokia E7</a>
							<a class="forward" id="NextLink" href="products/htc_salsa">HTC Salsa</a>&nbsp;→
			</div>

</div>
<!-- Описание продукта (The End)-->

<!-- Комментарии -->
<div id="comments">

	<h2>Комментарии</h2>
	
		<p>
		Пока нет комментариев
	</p>
		
	<!--Форма отправления комментария-->
	<!--Подключаем js-проверку формы -->
	<script src="/js/baloon/js/default.js"   language="JavaScript" type="text/javascript"></script>
	<script src="/js/baloon/js/validate.js"  language="JavaScript" type="text/javascript"></script>
	<script src="/js/baloon/js/baloon.js"    language="JavaScript" type="text/javascript"></script>
	<link   href="/js/baloon/css/baloon.css" rel="stylesheet"      type="text/css" /> 
	
	<form class="comment_form" method="post">
		<h2>Написать комментарий</h2>
				<textarea class="comment_textarea" id="comment_text" name="text" format=".+" notice="Введите комментарий"></textarea><br />
		<div>
		<label for="comment_name">Имя</label>
		<input class="input_name" type="text" id="comment_name" name="name" value="" format=".+" notice="Введите имя"/><br />
		
		<label for="comment_captcha">Число</label>
		<div class="captcha"><img src="captcha/image.php?7092"/></div> 
		<input class="input_captcha" id="comment_captcha" type="text" name="captcha_code" value="" format="\d\d\d\d" notice="Введите капчу"/>
		
		<input class="button_send" type="submit" name="comment" value="Отправить" />
		</div>
	</form>
	<!--Форма отправления комментария (The End)-->
	
</div>
<!-- Комментарии (The End) -->


<!-- Увеличитель картинок -->
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<!-- Аяксовая корзина -->
<script src="js/ajax-cart.js"></script>

<script>

$(function() {
	// Зум картинок
	$("a.zoom").fancybox({
		'hideOnContentClick' : true
	});
	
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

<script type="text/javascript" src="js/ctrlnavigate.js"></script>           

<?php } ?>