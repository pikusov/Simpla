<?php /* Smarty version Smarty-3.0.7, created on 2011-10-21 20:08:12
         compiled from "simpla/design/html/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10332584374ea1a6fc407774-55626109%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed9b81a965719284d5b47a929b4c7464c4e8baa7' => 
    array (
      0 => 'simpla/design/html/index.tpl',
      1 => 1317815362,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10332584374ea1a6fc407774-55626109',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $_smarty_tpl->getVariable('meta_title')->value;?>
</title>
<link rel="icon" href="design/images/favicon.ico" type="image/x-icon">
<link href="design/css/style.css" rel="stylesheet" type="text/css" />

<script src="design/js/jquery/jquery.js"></script>
<script src="design/js/jquery/jquery.form.js"></script>
<script src="design/js/jquery/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="design/js/jquery/jquery-ui.css" media="screen" />

</head>
<body>

<a href='<?php echo $_smarty_tpl->getVariable('config')->value->root_url;?>
' class='admin_bookmark'></a>

<!-- Вся страница --> 
<div id="main">

	<!-- Главное меню -->
	<ul id="main_menu"> 
		<li><a href="index.php?module=ProductsAdmin"><img src="design/images/menu/catalog.png"><b>Каталог</b></a></li>
		<li><a href="index.php?module=OrdersAdmin"><img src="design/images/menu/orders.png"><b>Заказы</b></a>
		<?php if ($_smarty_tpl->getVariable('new_orders_counter')->value){?>
		<div class='counter'><span><?php echo $_smarty_tpl->getVariable('new_orders_counter')->value;?>
</span></div>
		<?php }?>
		</li>
		<li><a href="index.php?module=UsersAdmin"><img src="design/images/menu/users.png"><b>Покупатели</b></a></li>
		<li><a href="index.php?module=PagesAdmin"><img src="design/images/menu/pages.png"><b>Страницы</b></a></li>
		<li><a href="index.php?module=BlogAdmin"><img src="design/images/menu/blog.png"><b>Блог</b></a></li>
		<li>
		<a href="index.php?module=CommentsAdmin"><img src="design/images/menu/comments.png"><b>Комментарии</b></a>
		<?php if ($_smarty_tpl->getVariable('new_comments_counter')->value){?>
		<div class='counter'><span><?php echo $_smarty_tpl->getVariable('new_comments_counter')->value;?>
</span></div>
		<?php }?>
		</li>
		<li><a href="index.php?module=ImportAdmin"><img src="design/images/menu/wizards.png"><b>Автоматизация</b></a></li>
		<li><a href="index.php?module=StatsAdmin"><img src="design/images/menu/statistics.png"><b>Статистика</b></a></li>
		<li><a href="index.php?module=ThemeAdmin"><img src="design/images/menu/design.png"><b>Дизайн</b></a></li>
		<li><a href="index.php?module=SettingsAdmin"><img src="design/images/menu/settings.png"><b>Настройки</b></a></li>
	</ul>
	<!-- Главное меню (The End)-->
	
	
	<!-- Таб меню -->
	<ul id="tab_menu">
		<?php echo Smarty::$_smarty_vars['capture']['tabs'];?>

	</ul>
	<!-- Таб меню (The End)-->
	
 
	
	<!-- Основная часть страницы -->
	<div id="middle">
		<?php echo $_smarty_tpl->getVariable('content')->value;?>

	</div>
	<!-- Основная часть страницы (The End) --> 
	
	<!-- Подвал сайта -->
	<div id="footer">
	&copy; 2011 <a href='http://simplacms.ru'>Simpla <?php echo $_smarty_tpl->getVariable('config')->value->version;?>
</a>
	<?php if ($_smarty_tpl->getVariable('license')->value->valid){?>
	Лицензия действительна <?php if ($_smarty_tpl->getVariable('license')->value->expiration!='*'){?>до <?php echo $_smarty_tpl->getVariable('license')->value->expiration;?>
<?php }?> для домен<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier(count($_smarty_tpl->getVariable('license')->value->domains),'а','ов');?>
 <?php  $_smarty_tpl->tpl_vars['d'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('license')->value->domains; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['d']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['d']->iteration=0;
if ($_smarty_tpl->tpl_vars['d']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['d']->key => $_smarty_tpl->tpl_vars['d']->value){
 $_smarty_tpl->tpl_vars['d']->iteration++;
 $_smarty_tpl->tpl_vars['d']->last = $_smarty_tpl->tpl_vars['d']->iteration === $_smarty_tpl->tpl_vars['d']->total;
?><?php echo $_smarty_tpl->tpl_vars['d']->value;?>
<?php if (!$_smarty_tpl->tpl_vars['d']->last){?>, <?php }?><?php }} ?>.
	<a href='index.php?module=LicenseAdmin'>Управление лицензией</a>
	<?php }else{ ?>
	Лицензия недействительна. <a href='index.php?module=LicenseAdmin'>Управление лицензией</a>
	<?php }?>
	<a href='<?php echo $_smarty_tpl->getVariable('config')->value->root_url;?>
' id='logout'>Выход</a>
	</div>
	<!-- Подвал сайта (The End)--> 
	
</div>
<!-- Вся страница (The End)--> 

</body>
</html>

<script>
$(function() {
	// Logout для IE
	if ($.browser.msie)
	$("#logout").click( function() {
		try{document.execCommand("ClearAuthenticationCache");}
		catch (exception){} 
	});
	else
		$("#logout").hide();
		
});
</script>


