<?php /*%%SmartyHeaderCode:2930962074ea2c7f2d222d9-27387784%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '80e3002ab4bca0dbaac685bf310e3907aa8069f4' => 
    array (
      0 => 'simpla/design/html/feature.tpl',
      1 => 1306773922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2930962074ea2c7f2d222d9-27387784',
  'has_nocache_code' => 0,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?>
<script>
$(function() {

 
});
</script>


<!-- Системное сообщение -->
<div class="message message_success">
	<span>Свойство обновлено</span>
		<a class="button" href="/simpla/index.php?module=FeaturesAdmin">Вернуться</a>
	</div>
<!-- Системное сообщение (The End)-->


<!-- Основная форма -->
<form method=post id=product>

	<div id="name">
		<input class="name" name=name type="text" value="Тип"/> 
		<input name=id type="hidden" value="2"/> 
	</div> 

	<!-- Левая колонка свойств товара -->
	<div id="column_left">
			
		<!-- Категории -->	
		<div class="block">
			<h2>Использовать в категориях</h2>
					<select class=multiple_categories multiple name="feature_categories[]">
																				<option value='1' selected category_name=''>Мобильные телефоны</option>
														
														<option value='2'  category_name=''>Бытовая техника</option>
																						<option value='3' selected category_name=''>&nbsp;&nbsp;&nbsp;&nbsp;Пылесосы</option>
														
						
						
					</select>
		</div>
 
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	<!-- Правая колонка свойств товара -->	
	<div id="column_right">
		
		<!-- Параметры страницы -->
		<div class="block">
			<h2>Настройки свойства</h2>
			<ul>
				<li><input type=checkbox name=in_filter id=in_filter checked value="1"> <label for=in_filter>Использовать в фильтре</label></li>
			</ul>
		</div>
		<!-- Параметры страницы (The End)-->
		<input type=hidden name='session_id' value='2b7f56184c93c564e5463bf1f1aa06e7'>
		<input class="button_green" type="submit" name="" value="Сохранить" />
		
	</div>
	<!-- Правая колонка свойств товара (The End)--> 
	

</form>
<!-- Основная форма (The End) -->

<?php } ?>