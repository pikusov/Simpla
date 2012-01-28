<?php /*%%SmartyHeaderCode:1122307264ea44cec4fca25-30407899%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c4cac6e66efd488164d233c798b85a5aaa051a3f' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/post.tpl',
      1 => 1316007134,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1122307264ea44cec4fca25-30407899',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><!-- Заголовок /-->
<h1 post_id="1">Что нового в этой версии симплы</h1>
<p>23.10.2011</p>

<!-- Тело поста /-->
<p>&nbsp;</p><div><p>Сортировка товаров и других списков перетаскиванием, в том числе перетаскивание в другую категорию или бренд<br />Указание "бесконечного" количество товара на складе<br />Акционная цена (указание старой цены товара)<br />Авторесайз изображений imagick<br />Поддержка jpg, png и gif, в том сисле с анимацией и прозрачностью<br />Водяной знак для изображений<br />Модерация комментариев к товарам</p><h2>Снаружи</h2><p>Аяксовая корзина<br />Фильтр товаров по характеристикам с учетом существования товаров<br />Сортировка товаров по цене и названию</p><h2>Заказы</h2><p>Полное редактирование заказов<br />Примечания администратора к заказам<br />Возможность не включать в заказ стоимость доставки<br />Статистика заказов по дням</p><h2>Блог</h2><p>Блог вместо статей и новостей<br />Комментарии к записям в блоге<br />Модерация комментариев к записям в блоге</p><h2>Импорт</h2><p>Импорт характеристик товаров<br />Импорт изображений с другого сервера<br />Снято ограничение на объем импортируемого файла (теперь ограничение только в настройках сервера)</p><h2>Экспорт</h2><p>Экспорт характеристик товаров<br />Снято ограничение на объем экспорта</p><h2>Редактирование шаблонов</h2><p>Сохранение изменений без перезагрузки страницы<br />Размер изображений задаётся на месте их вывода в шаблоне</p><h2>Валюты</h2><p>Указание формата валют и возможность округления до рублей</p><h2>1C</h2><p>Синхронизация с 1С (товары и заказы)</p><div></div></div><p>&nbsp;</p>

<!-- Соседние записи /-->
<div id="back_forward">
		</div>

<!-- Комментарии -->
<div id="comments">

	<h2>Комментарии</h2>
	
		<p>
		Пока нет комментариев
	</p>
		
	<!--Форма отправления комментария-->

	<!--Подключаем js-проверку формы -->
	<script src="/js/baloon/js/default.js" language="JavaScript" type="text/javascript"></script>
	<script src="/js/baloon/js/validate.js" language="JavaScript" type="text/javascript"></script>
	<script src="/js/baloon/js/baloon.js" language="JavaScript" type="text/javascript"></script>
	<link href="/js/baloon/css/baloon.css" rel="stylesheet" type="text/css" /> 
	
	<form class="comment_form" method="post" action="">
		<h2>Написать комментарий</h2>
				<textarea class="comment_textarea" id="comment_text" name="text" format=".+" notice="Введите комментарий"></textarea><br />
		<div>
		<label for="comment_name">Имя</label>
		<input class="input_name" type="text" id="comment_name" name="name" value="" format=".+" notice="Введите имя"/><br />
		
		<label for="comment_captcha">Число</label>
		<div class="captcha"><img src="captcha/image.php?4487"/></div> 
		<input class="input_captcha" id="comment_captcha" type="text" name="captcha_code" value="" format="\d\d\d\d" notice="Введите капчу"/>
		
		<input class="button_send" type="submit" name="comment" value="Отправить" />
		</div>
	</form>
	<!--Форма отправления комментария (The End)-->
	
</div>
<!-- Комментарии (The End) -->
<script type="text/javascript" src="js/ctrlnavigate.js"></script>           
<?php } ?>