{* Вкладки *}
{capture name=tabs}
	{if in_array('settings', $manager->permissions)}<li><a href="index.php?module=SettingsAdmin">Настройки</a></li>{/if}
	{if in_array('currency', $manager->permissions)}<li><a href="index.php?module=CurrencyAdmin">Валюты</a></li>{/if}
	{if in_array('delivery', $manager->permissions)}<li><a href="index.php?module=DeliveriesAdmin">Доставка</a></li>{/if}
	{if in_array('payment', $manager->permissions)}<li><a href="index.php?module=PaymentMethodsAdmin">Оплата</a></li>{/if}
	<li class="active"><a href="index.php?module=ManagersAdmin">Менеджеры</a></li>
{/capture}

{if $m->login}
{$meta_title = $m->login scope=parent}
{else}
{$meta_title = 'Новый менеджер' scope=parent}
{/if}

{* On document load *}
<script src="design/js/jquery/jquery.js"></script>
<script src="design/js/jquery/jquery-ui.min.js"></script>
<script>
{literal}
$(function() {
	// Выделить все
	$("#check_all").click(function() {
		$('input[type="checkbox"][name*="permissions"]:not(:disabled)').attr('checked', $('input[type="checkbox"][name*="permissions"]:not(:disabled):not(:checked)').length>0);
	});

	{/literal}{if $m->login}$('#password_input').hide();{/if}{literal}
	$('#change_password').click(function() {
		$('#password_input').show();
	});
		
});
{/literal}
</script>


{if $message_success}
<!-- Системное сообщение -->
<div class="message message_success">
	<span>{if $message_success=='added'}Менеджер добавлен{elseif $message_success=='updated'}Менеджер обновлен{else}{$message_success|escape}{/if}</span>
	{if $smarty.get.return}
	<a class="button" href="{$smarty.get.return}">Вернуться</a>
	{/if}
</div>
<!-- Системное сообщение (The End)-->
{/if}

{if $message_error}
<!-- Системное сообщение -->
<div class="message message_error">
	<span>
	{if $message_error=='login_exists'}Менеджер с таким логином уже существует
	{elseif $message_error=='empty_login'}Введите логин
	{elseif $message_error=='not_writable'}Установите права на запись для файла /simpla/.passwd
	{else}{$message_error|escape}{/if}
	</span>
	<a class="button" href="">Вернуться</a>
</div>
<!-- Системное сообщение (The End)-->
{/if}


<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="{$smarty.session.id}">
	<div id="name">
		Логин:
		<input class="name" name="login" type="text" value="{$m->login|escape}" maxlength="32"/> 
		<input name="old_login" type="hidden" value="{$m->login|escape}"/>
		Пароль:
		{if $m->login}<a class="dash_link"id="change_password">изменить</a>{/if}
		<input id="password_input" class="name" name="password" type="password" value=""/> 
	</div> 

	<!-- Левая колонка -->
	<div id="column_left">
		
		<h2>Права доступа: </h2>
		<div class="block"><label id="check_all" class="dash_link">Выбрать все</label></div>

		<!-- Параметры  -->
		<div class="block">
			<ul>
			
				{$perms = [
					'products'   =>'Товары',
					'categories' =>'Категории',
					'brands'     =>'Бренды',
					'features'   =>'Свойства товаров',
					'orders'     =>'Заказы',
					'labels'     =>'Метки заказов',
					'users'      =>'Покупатели',
					'groups'     =>'Группы покупателей',
					'coupons'    =>'Купоны',
					'pages'      =>'Страницы',
					'blog'       =>'Блог',
					'comments'   =>'Комментарии',
					'feedbacks'  =>'Обратная связь',
					'import'     =>'Импорт',
					'export'     =>'Экспорт',
					'backup'     =>'Бекап',
					'stats'      =>'Статистика',
					'design'     =>'Дизайн',
					'settings'   =>'Настройки',
					'currency'   =>'Валюты',
					'delivery'   =>'Способы доставки',
					'payment'    =>'Способы оплаты',
					'managers'   =>'Менеджеры',
					'license'    =>'Управление лицензией'
				]}
				
				{foreach $perms as $p=>$name}
				<li><label class=property for="{$p}">{$name}</label>
				<input id="{$p}" name="permissions[]" class="simpla_inp" type="checkbox" value="{$p}"
				{if $m->permissions && in_array($p, $m->permissions)}checked{/if} {if $m->login==$manager->login}disabled{/if}/></li>
				{/foreach}
				
			</ul>
			
		</div>
		<!-- Параметры (The End)-->
		

			
	</div>
	<!-- Левая колонка (The End)--> 
	
	
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->
