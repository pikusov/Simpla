<?php /* Smarty version Smarty-3.0.7, created on 2011-10-23 15:48:09
         compiled from "simpla/design/html/settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20208986934ea40d0924e9e9-31584962%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd4e52b127af716ae51bc134a94fc3a2fca59b9e7' => 
    array (
      0 => 'simpla/design/html/settings.tpl',
      1 => 1317053869,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20208986934ea40d0924e9e9-31584962',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
if (!is_callable('smarty_function_math')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/function.math.php';
?><?php ob_start(); ?>
		<li class="active"><a href="index.php?module=SettingsAdmin">Настройки</a></li>
		<li><a href="index.php?module=CurrencyAdmin">Валюты</a></li>
		<li><a href="index.php?module=DeliveriesAdmin">Доставка</a></li>
		<li><a href="index.php?module=PaymentMethodsAdmin">Оплата</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
 

<?php if ($_smarty_tpl->getVariable('message_success')->value){?>
<!-- Системное сообщение -->
<div class="message message_success">
	<span><?php if ($_smarty_tpl->getVariable('message_success')->value=='saved'){?>Настройки сохранены<?php }?></span>
	<?php if ($_GET['return']){?>
	<a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
	<?php }?>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>

<?php if ($_smarty_tpl->getVariable('message_error')->value){?>
<!-- Системное сообщение -->
<div class="message message_error">
	<span><?php if ($_smarty_tpl->getVariable('message_error')->value=='watermark_is_not_writable'){?>Установите права на запись для файла <?php echo $_smarty_tpl->getVariable('config')->value->watermark_file;?>
<?php }?></span>
	<a class="button" href="">Вернуться</a>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>
			

<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
			
		<!-- Параметры -->
		<div class="block">
			<h2>Настройки сайта</h2>
			<ul>
				<li><label class=property>Имя сайта</label><input name="site_name" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->site_name);?>
" /></li>
				<li><label class=property>Имя компании</label><input name="company_name" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->company_name);?>
" /></li>
				<li><label class=property>Формат даты</label><input name="date_format" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->date_format);?>
" /></li>
				<li><label class=property>Email для восстановления пароля</label><input name="admin_email" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->admin_email);?>
" /></li>
			</ul>
		</div>
		<div class="block layer">
			<h2>Оповещения</h2>
			<ul>
				<li><label class=property>Оповещение о заказах</label><input name="order_email" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->order_email);?>
" /></li>
				<li><label class=property>Оповещение о комментариях</label><input name="comment_email" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->comment_email);?>
" /></li>
				<li><label class=property>Обратный адрес оповещений</label><input name="notify_from_email" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->notify_from_email);?>
" /></li>
			</ul>
		</div>
		<!-- Параметры (The End)-->

		<!-- Параметры -->
		<div class="block layer">
			<h2>Формат цены</h2>
			<ul>
				<li><label class=property>Разделитель копеек</label>
					<select name="decimals_point" class="simpla_inp">
						<option value='.' <?php if ($_smarty_tpl->getVariable('settings')->value->decimals_point=='.'){?>selected<?php }?>>точка: 12.45 рублей</option>
						<option value=',' <?php if ($_smarty_tpl->getVariable('settings')->value->decimals_point==','){?>selected<?php }?>>запятая: 12,45 рублей</option>
					</select>
				</li>
				<li><label class=property>Разделитель тысяч</label>
					<select name="thousands_separator" class="simpla_inp">
						<option value='' <?php if ($_smarty_tpl->getVariable('settings')->value->thousands_separator==''){?>selected<?php }?>>без разделителя: 1245678 рублей</option>
						<option value=' ' <?php if ($_smarty_tpl->getVariable('settings')->value->thousands_separator==' '){?>selected<?php }?>>пробел: 1 245 678 рублей</option>
						<option value=',' <?php if ($_smarty_tpl->getVariable('settings')->value->thousands_separator==','){?>selected<?php }?>>запятая: 1,245,678 рублей</option>
					</select>
				
				
				</li>
			</ul>
		</div>
		<!-- Параметры (The End)-->
		
		<!-- Параметры -->
		<div class="block layer">
			<h2>Настройки каталога</h2>
			<ul>
				<li><label class=property>Товаров на странице сайта</label><input name="products_num" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->products_num);?>
" /></li>
				<li><label class=property>Товаров на странице админки</label><input name="products_num_admin" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->products_num_admin);?>
" /></li>
				<li><label class=property>Максимум товаров в заказе</label><input name="max_order_amount" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->max_order_amount);?>
" /></li>
				<li><label class=property>Единицы измерения товаров</label><input name="units" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->units);?>
" /></li>
			</ul>
		</div>
		<!-- Параметры (The End)-->
		
		<!-- Параметры -->
		<div class="block layer">
			<h2>Изображения товаров</h2>
			
			<ul>
				<li><label class=property>Водяной знак</label>
				<input name="watermark_file" class="simpla_inp" type="file" />

				<img style='display:block; border:1px solid #d0d0d0; margin:10px 0 10px 0;' src="<?php echo $_smarty_tpl->getVariable('config')->value->root_url;?>
/<?php echo $_smarty_tpl->getVariable('config')->value->watermark_file;?>
?<?php echo smarty_function_math(array('equation'=>'rand(10,10000)'),$_smarty_tpl);?>
">
				</li>
				<li><label class=property>Горизонтальное положение водяного знака</label><input name="watermark_offset_x" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->watermark_offset_x);?>
" /> %</li>
				<li><label class=property>Вертикальное положение водяного знака</label><input name="watermark_offset_y" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->watermark_offset_y);?>
" /> %</li>
				<li><label class=property>Прозрачность знака (больше &mdash; прозрачней)</label><input name="watermark_transparency" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->watermark_transparency);?>
" /> %</li>
				<li><label class=property>Резкость изображений (рекомендуется 20%)</label><input name="images_sharpen" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->images_sharpen);?>
" /> %</li>
			</ul>
		</div>
		<!-- Параметры (The End)-->
		
		<!-- Параметры -->
		<div class="block layer">
			<h2><a class="dash_link"id="change_password">Изменить пароль администратора</a></h2>
			<ul id="change_password_form">
				<li><label class=property>Новый логин</label><input name="new_login" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('current_login')->value);?>
" /></li>
				<li><label class=property>Новый пароль</label><input name="new_password" class="simpla_inp" type="text" value="" /></li>
			</ul>
		</div>
		<!-- Параметры (The End)-->
		
		<input class="button_green button_save" type="submit" name="save" value="Сохранить" />
			
	<!-- Левая колонка свойств товара (The End)--> 
	
</form>
<!-- Основная форма (The End) -->


<script>
$(function() {
	$('#change_password_form').hide();
	$('#change_password').click(function() {
		$('#change_password_form').show();
	});
});
</script>

