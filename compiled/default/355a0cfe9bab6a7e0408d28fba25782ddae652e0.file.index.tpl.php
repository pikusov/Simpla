<?php /* Smarty version Smarty-3.0.7, created on 2012-01-05 03:10:30
         compiled from "/Users/denispikusov/Sites/simpla//design/default/html/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7710462734f04f886855b21-40520976%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '355a0cfe9bab6a7e0408d28fba25782ddae652e0' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/index.tpl',
      1 => 1325690811,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7710462734f04f886855b21-40520976',
  'function' => 
  array (
    'categories_tree' => 
    array (
      'parameter' => 
      array (
      ),
      'compiled' => '',
    ),
  ),
  'has_nocache_code' => 0,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><!DOCTYPE html>
<html>
<head>
	<base href="<?php echo $_smarty_tpl->getVariable('config')->value->root_url;?>
/"/>
	<title><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('meta_title')->value);?>
</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('meta_description')->value);?>
" />
	<meta name="keywords"    content="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('meta_keywords')->value);?>
" />
	<meta name="viewport" content="width=1024"/>
	
	<link href="design/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->theme);?>
/css/style.css" rel="stylesheet" type="text/css" media="screen"/>
	<link href="design/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->theme);?>
/images/favicon.ico" rel="icon"          type="image/x-icon"/>
	<link href="design/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->theme);?>
/images/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
	
	<script src="js/jquery/jquery.js"  type="text/javascript"></script>
	
	<?php if ($_SESSION['admin']=='admin'){?>
	<script src ="js/admintooltip/admintooltip.js" type="text/javascript"></script>
	<link   href="js/admintooltip/css/admintooltip.css" rel="stylesheet" type="text/css" /> 
	<?php }?>
	
	<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
	
	<script type="text/javascript" src="js/ctrlnavigate.js"></script>           
	
	<script src="design/<?php echo $_smarty_tpl->getVariable('settings')->value->theme;?>
/js/jquery-ui.min.js"></script>
	<script src="design/<?php echo $_smarty_tpl->getVariable('settings')->value->theme;?>
/js/ajax_cart.js"></script>
	
	<script src="/js/baloon/js/baloon.js" type="text/javascript"></script>
	<link   href="/js/baloon/css/baloon.css" rel="stylesheet" type="text/css" /> 
	
	
	<script src="js/autocomplete/jquery.autocomplete-min.js" type="text/javascript"></script>
	<style>
	.autocomplete-w1 { position:absolute; top:0px; left:0px; margin:6px 0 0 6px; /* IE6 fix: */ _background:none; _margin:1px 0 0 0; }
	.autocomplete { border:1px solid #999; background:#FFF; cursor:default; text-align:left; overflow-x:auto;  overflow-y: auto; margin:-6px 6px 6px -6px; /* IE6 specific: */ _height:350px;  _margin:0; _overflow-x:hidden; }
	.autocomplete .selected { background:#F0F0F0; }
	.autocomplete div { padding:2px 5px; white-space:nowrap; }
	.autocomplete strong { font-weight:normal; color:#3399FF; }
	</style>	
	<script>
	$(function() {
		//  Автозаполнитель поиска
		$(".input_search").autocomplete({
			serviceUrl:'ajax/search_products.php',
			minChars:1,
			noCache: false, 
			onSelect:
				function(value, data){
					 $(".input_search").closest('form').submit();
				},
			fnFormatResult:
				function(value, data, currentValue){
					var reEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
					var pattern = '(' + currentValue.replace(reEscape, '\\$1') + ')';
	  				return (data.image?"<img align=absmiddle src='"+data.image+"'> ":'') + value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');
				}	
		});
	});
	</script>
	
		
			
</head>
<body>


	<!-- Верхняя строка -->
	<div id="top_background">
	<div id="top">
	
		<!-- Меню -->
		<ul id="menu">
			<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pages')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
?>
				<?php if ($_smarty_tpl->getVariable('p')->value->menu_id==1){?>
				<li <?php if ($_smarty_tpl->getVariable('page')->value&&$_smarty_tpl->getVariable('page')->value->id==$_smarty_tpl->getVariable('p')->value->id){?>class="selected"<?php }?>>
					<a data-page="<?php echo $_smarty_tpl->getVariable('p')->value->id;?>
" href="<?php echo $_smarty_tpl->getVariable('p')->value->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('p')->value->name);?>
</a>
				</li>
				<?php }?>
			<?php }} ?>
		</ul>
		<!-- Меню (The End) -->
	
		<!-- Корзина -->
		<div id="cart_informer">
			<?php $_template = new Smarty_Internal_Template('cart_informer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		</div>
		<!-- Корзина (The End)-->

		<!-- Вход пользователя -->
		<div id="account">
			<?php if ($_smarty_tpl->getVariable('user')->value){?>
				<span id="username">
					<a href="user"><?php echo $_smarty_tpl->getVariable('user')->value->name;?>
</a><?php if ($_smarty_tpl->getVariable('group')->value->discount>0){?>,
					ваша скидка &mdash; <?php echo $_smarty_tpl->getVariable('group')->value->discount;?>
%<?php }?>
				</span>
				<a id="logout" href="user/logout">выйти</a>
			<?php }else{ ?>
				<a id="register" href="user/register">Регистрация</a>
				<a id="login" href="user/login">Вход</a>
			<?php }?>
		</div>
		<!-- Вход пользователя (The End)-->

	</div>
	</div>
	<!-- Верхняя строка (The End)-->
	
	
	<!-- Шапка -->
	<div id="header">
		<div id="logo">
			<a href="/"><img src="design/<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->theme);?>
/images/logo.png" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->site_name);?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('settings')->value->site_name);?>
"/></a>
		</div>	
		<div id="contact">
			(095) <span id="phone">545-54-54</span>
			<div id="address">Москва, шоссе Энтузиастов 45/31, офис 453</div>
		</div>	
	</div>
	<!-- Шапка (The End)--> 


	<!-- Вся страница --> 
	<div id="main">
	
		<!-- Основная часть --> 
		<div id="content">
			<?php echo $_smarty_tpl->getVariable('content')->value;?>

		</div>
		<!-- Основная часть (The End) --> 

		<div id="left">

			<!-- Поиск-->
			<div id="search">
				<form action="products">
					<input class="input_search" type="text" name="keyword" value="<?php echo $_smarty_tpl->getVariable('keyword')->value;?>
" placeholder="Поиск товара"/>
					<input class="button_search" value="" type="submit" />
				</form>
			</div>
			<!-- Поиск (The End)-->

			
			<!-- Меню каталога -->
			<div id="catalog_menu">
					
			<?php if (!function_exists('smarty_template_function_categories_tree')) {
    function smarty_template_function_categories_tree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['categories_tree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
			<?php if ($_smarty_tpl->getVariable('categories')->value){?>
			<ul>
			<?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('categories')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
?>
				<?php if ($_smarty_tpl->getVariable('c')->value->visible){?>
					<li>
						<?php if ($_smarty_tpl->getVariable('c')->value->image){?><img src="<?php echo $_smarty_tpl->getVariable('config')->value->categories_images_dir;?>
<?php echo $_smarty_tpl->getVariable('c')->value->image;?>
" alt="<?php echo $_smarty_tpl->getVariable('c')->value->name;?>
"><?php }?>
						<a <?php if ($_smarty_tpl->getVariable('category')->value->id==$_smarty_tpl->getVariable('c')->value->id){?>class="selected"<?php }?> href="catalog/<?php echo $_smarty_tpl->getVariable('c')->value->url;?>
" data-category="<?php echo $_smarty_tpl->getVariable('c')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('c')->value->name;?>
</a>
						<?php smarty_template_function_categories_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->getVariable('c')->value->subcategories));?>

					</li>
				<?php }?>
			<?php }} ?>
			</ul>
			<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

			<?php smarty_template_function_categories_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->getVariable('categories')->value));?>

			</div>
			<!-- Меню каталога (The End)-->		
	
			
			<!-- Все бренды -->
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['get_brands'][0][0]->get_brands_plugin(array('var'=>'all_brands'),$_smarty_tpl);?>

			<?php if ($_smarty_tpl->getVariable('all_brands')->value){?>
			<div id="all_brands">
				<h2>Все бренды:</h2>
				<?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('all_brands')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value){
?>	
					<?php if ($_smarty_tpl->getVariable('b')->value->image){?>
					<a href="brands/<?php echo $_smarty_tpl->getVariable('b')->value->url;?>
"><img src="<?php echo $_smarty_tpl->getVariable('config')->value->brands_images_dir;?>
<?php echo $_smarty_tpl->getVariable('b')->value->image;?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('b')->value->name);?>
"></a>
					<?php }else{ ?>
					<a href="brands/<?php echo $_smarty_tpl->getVariable('b')->value->url;?>
"><?php echo $_smarty_tpl->getVariable('b')->value->name;?>
</a>
					<?php }?>
				<?php }} ?>
			</div>
			<?php }?>
			<!-- Все бренды (The End)-->

			<!-- Выбор валюты -->
			<?php if (count($_smarty_tpl->getVariable('currencies')->value)>1){?>
			<div id="currencies">
				<h2>Валюта</h2>
				<ul>
					<?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('currencies')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
?>
					<?php if ($_smarty_tpl->getVariable('c')->value->enabled){?> 
					<li class="<?php if ($_smarty_tpl->getVariable('c')->value->id==$_smarty_tpl->getVariable('currency')->value->id){?>selected<?php }?>"><a href='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('currency_id'=>$_smarty_tpl->getVariable('c')->value->id),$_smarty_tpl);?>
'><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('c')->value->name);?>
</a></li>
					<?php }?>
					<?php }} ?>
				</ul>
			</div> 
			<?php }?>
			<!-- Выбор валюты (The End) -->	

			
			<!-- Просмотренные товары -->
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['get_browsed_products'][0][0]->get_browsed_products(array('var'=>'browsed_products','limit'=>20),$_smarty_tpl);?>

			<?php if ($_smarty_tpl->getVariable('browsed_products')->value){?>
			
				<h2>Вы просматривали:</h2>
				<ul id="browsed_products">
				<?php  $_smarty_tpl->tpl_vars['browsed_product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('browsed_products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['browsed_product']->key => $_smarty_tpl->tpl_vars['browsed_product']->value){
?>
					<li>
					<a href="products/<?php echo $_smarty_tpl->getVariable('browsed_product')->value->url;?>
"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('browsed_product')->value->image->filename,50,50);?>
" alt="<?php echo $_smarty_tpl->getVariable('browsed_product')->value->name;?>
" title="<?php echo $_smarty_tpl->getVariable('browsed_product')->value->name;?>
"></a>
					</li>
				<?php }} ?>
				</ul>
			<?php }?>
			<!-- Просмотренные товары (The End)-->
			
			
			<!-- Меню блога -->
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['get_posts'][0][0]->get_posts_plugin(array('var'=>'last_posts','limit'=>5),$_smarty_tpl);?>

			<?php if ($_smarty_tpl->getVariable('last_posts')->value){?>
			<div id="blog_menu">
				<h2>Новые записи в <a href="blog">блоге</a></h2>
				<?php  $_smarty_tpl->tpl_vars['post'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('last_posts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['post']->key => $_smarty_tpl->tpl_vars['post']->value){
?>
				<ul>
					<li data-post="<?php echo $_smarty_tpl->getVariable('post')->value->id;?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->getVariable('post')->value->date);?>
 <a href="blog/<?php echo $_smarty_tpl->getVariable('post')->value->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('post')->value->name);?>
</a></li>
				</ul>
				<?php }} ?>
			</div>
			<?php }?>
			<!-- Просмотренные товары -->
			
		</div>			

	</div>
	<!-- Вся страница (The End)--> 
	
	<!-- Футер -->
	<div id="footer">
		<a href="http://simplacms.ru">Скрипт интернет-магазина Simpla</a>
	</div>
	<!-- Футер (The End)--> 
	
</body>
</html>