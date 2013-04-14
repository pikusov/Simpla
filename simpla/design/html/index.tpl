<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<title>{$meta_title}</title>
<link rel="icon" href="design/images/favicon.ico" type="image/x-icon">
<link href="design/css/style.css" rel="stylesheet" type="text/css" />

<script src="design/js/jquery/jquery.js"></script>
<script src="design/js/jquery/jquery.form.js"></script>
<script src="design/js/jquery/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="design/js/jquery/jquery-ui.css" media="screen" />

<meta name="viewport" content="width=1024">

</head>
<body>

<a href='{$config->root_url}' class='admin_bookmark'></a>

<!-- Вся страница --> 
<div id="main">

	<!-- Главное меню -->
	<ul id="main_menu">
		
	{if in_array('products', $manager->permissions)}
		<li><a href="index.php?module=ProductsAdmin"><img src="design/images/menu/catalog.png"><b>Каталог</b></a></li>
	{elseif in_array('categories', $manager->permissions)}
		<li><a href="index.php?module=CategoriesAdmin"><img src="design/images/menu/catalog.png"><b>Каталог</b></a></li>
	{elseif in_array('brands', $manager->permissions)}
		<li><a href="index.php?module=BrandsAdmin"><img src="design/images/menu/catalog.png"><b>Каталог</b></a></li>
	{elseif in_array('features', $manager->permissions)}
		<li><a href="index.php?module=FeaturesAdmin"><img src="design/images/menu/catalog.png"><b>Каталог</b></a></li>
	{/if}
		
	{if in_array('orders', $manager->permissions)}
		<li><a href="index.php?module=OrdersAdmin"><img src="design/images/menu/orders.png"><b>Заказы</b></a>
		{if $new_orders_counter}<div class='counter'><span>{$new_orders_counter}</span></div>{/if}
	{elseif in_array('labels', $manager->permissions)}
		<li><a href="index.php?module=OrdersLabelsAdmin"><img src="design/images/menu/orders.png"><b>Заказы</b></a>
	{/if}
	</li>
		
	{if in_array('users', $manager->permissions)}
		<li><a href="index.php?module=UsersAdmin"><img src="design/images/menu/users.png"><b>Покупатели</b></a></li>
	{elseif in_array('groups', $manager->permissions)}
		<li><a href="index.php?module=GroupsAdmin"><img src="design/images/menu/users.png"><b>Покупатели</b></a></li>
	{elseif in_array('coupons', $manager->permissions)}
		<li><a href="index.php?module=CouponsAdmin"><img src="design/images/menu/users.png"><b>Покупатели</b></a></li>
	{/if}
		
	{if in_array('pages', $manager->permissions)}
		<li><a href="index.php?module=PagesAdmin"><img src="design/images/menu/pages.png"><b>Страницы</b></a></li>
	{/if}
		
	{if in_array('blog', $manager->permissions)}
		<li><a href="index.php?module=BlogAdmin"><img src="design/images/menu/blog.png"><b>Блог</b></a></li>
	{/if}
		
	{if in_array('comments', $manager->permissions)}
		<li><a href="index.php?module=CommentsAdmin"><img src="design/images/menu/comments.png"><b>Комментарии</b></a>
		{if $new_comments_counter}<div class='counter'><span>{$new_comments_counter}</span></div>{/if}</li>
	{elseif in_array('feedbacks', $manager->permissions)}
		<li><a href="index.php?module=FeedbacksAdmin"><img src="design/images/menu/comments.png"><b>Комментарии</b></a>
	{/if}
		
	{if in_array('import', $manager->permissions)}
		<li><a href="index.php?module=ImportAdmin"><img src="design/images/menu/wizards.png"><b>Автоматизация</b></a></li>
	{elseif in_array('export', $manager->permissions)}
		<li><a href="index.php?module=ExportAdmin"><img src="design/images/menu/wizards.png"><b>Автоматизация</b></a></li>
	{elseif in_array('backup', $manager->permissions)}
		<li><a href="index.php?module=BackupAdmin"><img src="design/images/menu/wizards.png"><b>Автоматизация</b></a></li>
	{/if}	
		
	{if in_array('stats', $manager->permissions)}
		<li><a href="index.php?module=StatsAdmin"><img src="design/images/menu/statistics.png"><b>Статистика</b></a></li>
	{/if}
	
	{if in_array('design', $manager->permissions)}
		<li><a href="index.php?module=ThemeAdmin"><img src="design/images/menu/design.png"><b>Дизайн</b></a></li>
	{/if}
	
	{if in_array('settings', $manager->permissions)}
		<li><a href="index.php?module=SettingsAdmin"><img src="design/images/menu/settings.png"><b>Настройки</b></a></li>
	{elseif in_array('delivery', $manager->permissions)}
		<li><a href="index.php?module=DeliveriesAdmin"><img src="design/images/menu/settings.png"><b>Настройки</b></a></li>
	{elseif in_array('payment', $manager->permissions)}
		<li><a href="index.php?module=PaymentMethodsAdmin"><img src="design/images/menu/settings.png"><b>Настройки</b></a></li>
	{elseif in_array('managers', $manager->permissions)}
		<li><a href="index.php?module=ManagersAdmin"><img src="design/images/menu/settings.png"><b>Настройки</b></a></li>
	{/if}
		
	</ul>
	<!-- Главное меню (The End)-->
	
	
	<!-- Таб меню -->
	<ul id="tab_menu">
		{$smarty.capture.tabs}
	</ul>
	<!-- Таб меню (The End)-->
	
 
	
	<!-- Основная часть страницы -->
	<div id="middle">
		{$content}
	</div>
	<!-- Основная часть страницы (The End) --> 
	
	<!-- Подвал сайта -->
	<div id="footer">
	&copy; 2013 <a href='http://simplacms.ru'>Simpla {$config->version}</a>
	{if in_array('license', $manager->permissions)}
		{if $license->valid}
		Лицензия действительна {if $license->expiration != '*'}до {$license->expiration}{/if} для домен{$license->domains|count|plural:'а':'ов'} {foreach $license->domains as $d}{$d}{if !$d@last}, {/if}{/foreach}.
		<a href='index.php?module=LicenseAdmin'>Управление лицензией</a>.
		{else}
		Лицензия недействительна. <a href='index.php?module=LicenseAdmin'>Управление лицензией</a>.
		{/if}
	{/if}
	Вы вошли как {$manager->login}.
	<a href='{$config->root_url}?logout' id="logout">Выход</a>
	</div>
	<!-- Подвал сайта (The End)--> 
	
</div>
<!-- Вся страница (The End)--> 

</body>
</html>

{literal}
<script>


$(function() {
	if($.browser.opera)
		$("#logout").hide();
	
	$("#logout").click( function(event) {
		event.preventDefault();

		if($.browser.msie)
		{
			try{document.execCommand("ClearAuthenticationCache");}
			catch (exception){} 
			window.location.href='/';
		}
		else
		{
			$.ajax({
				url: $(this).attr('href'),
				username: '',
				password: '',
				complete: function () {
					window.location.href='/';
				},
				beforeSend : function(req) {
					req.setRequestHeader('Authorization', 'Basic');
				}
			});
		}
	});
});
</script>
{/literal}
