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
		<li>
			<a href="index.php?module=OrdersAdmin"><img src="design/images/menu/orders.png"><b>Заказы</b></a>
			{if $new_orders_counter}<div class='counter'><span>{$new_orders_counter}</span></div>{/if}
		</li>
	{elseif in_array('labels', $manager->permissions)}
		<li><a href="index.php?module=OrdersLabelsAdmin"><img src="design/images/menu/orders.png"><b>Заказы</b></a></li>
	{/if}
		
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
	&copy; 2017 <a href='http://simplacms.ru'>Simpla {$config->version}</a>
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

{* Интеграция с ПростымиЗвонками *}
{if $settings->pz_server && $settings->pz_phones[$manager->login]}
<script src="design/js/prostiezvonki/prostiezvonki.min.js"></script>
<script>
var pz_type = 'simpla';
var pz_password = '{$settings->pz_password}';
var pz_server = '{$settings->pz_server}';
var pz_phone = '{$settings->pz_phones[$manager->login]}';
{literal}
function NotificationBar(message)
{
	ttop = $('body').height()-110;
	var HTMLmessage = "<div class='notification-message' style='  text-align:center; line-height: 40px;'> " + message + " </div>";
	if ($('#notification-bar').size() == 0)
	{
		$('body').prepend("<div id='notification-bar' style='-moz-border-radius: 5px 5px 5px 5px; -webkit-border-radius: 5px 5px 5px 5px; display:none;  height: 40px; padding: 20px; background-color: #fff; position: fixed; top:"+ttop+"px; right:30px; z-index: 100; color: #000;border: 1px solid #cccccc;'>" + HTMLmessage + "</div>");
	}
	else
    {
    	$('#notification-bar').html(HTMLmessage);
    }
    $('#notification-bar').slideDown();
}

$(window).on("blur focus", function (e) {
    if ($(this).data('prevType') !== e.type) {
        $(this).data('prevType', e.type);

        switch (e.type) {
        case 'focus':
            if (!pz.isConnected()) {
				pz.connect({
				            client_id: pz_password,
				            client_type: pz_type,
				            host: pz_server
				});
            }
            break;
        }
    }
});

$(function() {
	// Простые звонки
	pz.setUserPhone(pz_phone);
	pz.connect({
                client_id: pz_password,
                client_type: pz_type,
                host: pz_server
	});
    pz.onConnect(function () {
        $(".ip_call").addClass('phone');
    });
    pz.onDisconnect(function () {
        $(".ip_call").removeClass('phone');
    });
	
    $(".ip_call").click( function() {
        var phone = $(this).attr('data-phone').trim();
        pz.call(phone);
        return false;
    });

    pz.onEvent(function (event) {
        if (event.isIncoming()) {
			$.ajax({
				type: "GET",
				url: "ajax/search_orders.php",
				data: { keyword: event.from, limit:"1"},
				dataType: 'json'
			}).success(function(data){
				if(event.to == pz_phone)
				if(data.length>0)
				{
					NotificationBar('<img src="design/images/phone_sound.png" align=absmiddle> Звонит <a href="index.php?module=OrderAdmin&id='+data[0].id+'">'+data[0].name+'</a>');
				}
				else
				{
					NotificationBar('<img src="design/images/phone_sound.png" align=absmiddle> Звонок с '+event.from+'. <a href="index.php?module=OrderAdmin&phone='+event.from+'">Создать заказ</a>');
				}
			});        	     
        }
    });
{/literal}
});
</script>
{/if}

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
{/literal}

});
</script>
