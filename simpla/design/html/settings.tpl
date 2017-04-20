{capture name=tabs}
	<li class="active"><a href="index.php?module=SettingsAdmin">Настройки</a></li>
	{if in_array('currency', $manager->permissions)}<li><a href="index.php?module=CurrencyAdmin">Валюты</a></li>{/if}
	{if in_array('delivery', $manager->permissions)}<li><a href="index.php?module=DeliveriesAdmin">Доставка</a></li>{/if}
	{if in_array('payment', $manager->permissions)}<li><a href="index.php?module=PaymentMethodsAdmin">Оплата</a></li>{/if}
	{if in_array('managers', $manager->permissions)}<li><a href="index.php?module=ManagersAdmin">Менеджеры</a></li>{/if}
{/capture}
 
{$meta_title = "Настройки" scope=parent}

{if $message_success}
<!-- Системное сообщение -->
<div class="message message_success">
	<span class="text">{if $message_success == 'saved'}Настройки сохранены{/if}</span>
	{if $smarty.get.return}
	<a class="button" href="{$smarty.get.return}">Вернуться</a>
	{/if}
</div>
<!-- Системное сообщение (The End)-->
{/if}

{if $message_error}
<!-- Системное сообщение -->
<div class="message message_error">
	<span class="text">{if $message_error == 'watermark_is_not_writable'}Установите права на запись для файла {$config->watermark_file}{/if}</span>
	<a class="button" href="">Вернуться</a>
</div>
<!-- Системное сообщение (The End)-->
{/if}
			

<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="{$smarty.session.id}">
			
		<!-- Параметры -->
		<div class="block">
			<h2>Настройки сайта</h2>
			<ul>
				<li><label class=property>Имя сайта</label><input name="site_name" class="simpla_inp" type="text" value="{$settings->site_name|escape}" /></li>
				<li><label class=property>Имя компании</label><input name="company_name" class="simpla_inp" type="text" value="{$settings->company_name|escape}" /></li>
				<li><label class=property>Формат даты</label><input name="date_format" class="simpla_inp" type="text" value="{$settings->date_format|escape}" /></li>
				<li><label class=property>Email для восстановления пароля</label><input name="admin_email" class="simpla_inp" type="text" value="{$settings->admin_email|escape}" /></li>
			</ul>
		</div>
		<div class="block layer">
			<h2>Оповещения</h2>
			<ul>
				<li><label class=property>Оповещение о заказах</label><input name="order_email" class="simpla_inp" type="text" value="{$settings->order_email|escape}" /></li>
				<li><label class=property>Оповещение о комментариях</label><input name="comment_email" class="simpla_inp" type="text" value="{$settings->comment_email|escape}" /></li>
				<li><label class=property>Обратный адрес оповещений</label><input name="notify_from_email" class="simpla_inp" type="text" value="{$settings->notify_from_email|escape}" /></li>
			</ul>
		</div>
		<!-- Параметры (The End)-->

		<!-- Параметры -->
		<div class="block layer">
			<h2>Формат цены</h2>
			<ul>
				<li><label class=property>Разделитель копеек</label>
					<select name="decimals_point" class="simpla_inp">
						<option value='.' {if $settings->decimals_point == '.'}selected{/if}>точка: 12.45 {$currency->sign|escape}</option>
						<option value=',' {if $settings->decimals_point == ','}selected{/if}>запятая: 12,45 {$currency->sign|escape}</option>
					</select>
				</li>
				<li><label class=property>Разделитель тысяч</label>
					<select name="thousands_separator" class="simpla_inp">
						<option value='' {if $settings->thousands_separator == ''}selected{/if}>без разделителя: 1245678 {$currency->sign|escape}</option>
						<option value=' ' {if $settings->thousands_separator == ' '}selected{/if}>пробел: 1 245 678 {$currency->sign|escape}</option>
						<option value=',' {if $settings->thousands_separator == ','}selected{/if}>запятая: 1,245,678 {$currency->sign|escape}</option>
					</select>
				
				
				</li>
			</ul>
		</div>
		<!-- Параметры (The End)-->
		
		<!-- Параметры -->
		<div class="block layer">
			<h2>Настройки каталога</h2>
			<ul>
				<li><label class=property>Товаров на странице сайта</label><input name="products_num" class="simpla_inp" type="text" value="{$settings->products_num|escape}" /></li>
				<li><label class=property>Товаров на странице админки</label><input name="products_num_admin" class="simpla_inp" type="text" value="{$settings->products_num_admin|escape}" /></li>
				<li><label class=property>Максимум товаров в заказе</label><input name="max_order_amount" class="simpla_inp" type="text" value="{$settings->max_order_amount|escape}" /></li>
				<li><label class=property>Единицы измерения товаров</label><input name="units" class="simpla_inp" type="text" value="{$settings->units|escape}" /></li>
			</ul>
		</div>
		<!-- Параметры (The End)-->
		
		<!-- Параметры -->
		<div class="block layer">
			<h2>Изображения товаров</h2>
			
			<ul>
				<li><label class=property>Водяной знак</label>
				<input name="watermark_file" class="simpla_inp" type="file" />

				<img style='display:block; border:1px solid #d0d0d0; margin:10px 0 10px 0;' src="{$config->root_url}/{$config->watermark_file}?{math equation='rand(10,10000)'}">
				</li>
				<li><label class=property>Горизонтальное положение водяного знака</label><input name="watermark_offset_x" class="simpla_inp" type="text" value="{$settings->watermark_offset_x|escape}" /> %</li>
				<li><label class=property>Вертикальное положение водяного знака</label><input name="watermark_offset_y" class="simpla_inp" type="text" value="{$settings->watermark_offset_y|escape}" /> %</li>
				<li><label class=property>Прозрачность знака (больше &mdash; прозрачней)</label><input name="watermark_transparency" class="simpla_inp" type="text" value="{$settings->watermark_transparency|escape}" /> %</li>
				<li><label class=property>Резкость изображений (рекомендуется 20%)</label><input name="images_sharpen" class="simpla_inp" type="text" value="{$settings->images_sharpen|escape}" /> %</li>
			</ul>
		</div>
		<!-- Параметры (The End)-->

		
		<!-- Параметры -->
		<div class="block layer">
			<h2>Интеграция с <a href="http://prostiezvonki.ru">простыми звонками</a></h2>
			<ul>
				<li><label class=property>Сервер</label><input name="pz_server" class="simpla_inp" type="text" value="{$settings->pz_server|escape}" /></li>
				<li><label class=property>Пароль</label><input name="pz_password" class="simpla_inp" type="text" value="{$settings->pz_password|escape}" /></li>
				<li><label class=property>Телефоны менеджеров:</label></li>
				{foreach $managers as $manager}
				<li><label class=property>{$manager->login}</label><input name="pz_phones[{$manager->login}]" class="simpla_inp" type="text" value="{$settings->pz_phones[$manager->login]|escape}" /></li>
				{/foreach}
			</ul>
		</div>
		<!-- Параметры (The End)-->
		
		<input class="button_green button_save" type="submit" name="save" value="Сохранить" />
			
	<!-- Левая колонка свойств товара (The End)--> 
	
</form>
<!-- Основная форма (The End) -->
