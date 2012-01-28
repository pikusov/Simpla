<?php /* Smarty version Smarty-3.0.7, created on 2012-01-19 17:34:46
         compiled from "/Users/denispikusov/Sites/simpla//design/default/html/products.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1520425044f183816ce8f76-82363505%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '08feaec6c67d6be063c6ac6a3695f8faa86fb5dd' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/products.tpl',
      1 => 1326530777,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1520425044f183816ce8f76-82363505',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?>
<!-- Хлебные крошки /-->
<div id="path">
  <a href="/">Главная</a>
  <?php if ($_smarty_tpl->getVariable('category')->value){?>
  <?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('category')->value->path; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value){
?>
  → <a href="catalog/<?php echo $_smarty_tpl->getVariable('cat')->value->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('cat')->value->name);?>
</a>
  <?php }} ?>  
  <?php if ($_smarty_tpl->getVariable('brand')->value){?>
  → <a href="catalog/<?php echo $_smarty_tpl->getVariable('cat')->value->url;?>
/<?php echo $_smarty_tpl->getVariable('brand')->value->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('brand')->value->name);?>
</a>
  <?php }?>
  <?php }elseif($_smarty_tpl->getVariable('brand')->value){?>
  → <a href="brands/<?php echo $_smarty_tpl->getVariable('brand')->value->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('brand')->value->name);?>
</a>
  <?php }elseif($_smarty_tpl->getVariable('keyword')->value){?>
  → Поиск
  <?php }?>
</div>
<!-- Хлебные крошки #End /-->
<?php if ($_smarty_tpl->getVariable('keyword')->value){?>
<h1>Поиск <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('keyword')->value);?>
</h1>
<?php }elseif($_smarty_tpl->getVariable('page')->value){?>
<h1><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('page')->value->name);?>
</h1>
<?php }else{ ?>
<h1><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('category')->value->name);?>
 <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('brand')->value->name);?>
 <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('keyword')->value);?>
</h1>
<?php }?>
<?php echo $_smarty_tpl->getVariable('page')->value->body;?>


<?php if ($_smarty_tpl->getVariable('current_page_num')->value==1){?>
<?php echo $_smarty_tpl->getVariable('category')->value->description;?>

<?php }?>
<?php if ($_smarty_tpl->getVariable('category')->value->brands){?>
<div id="brands">
	<a href="catalog/<?php echo $_smarty_tpl->getVariable('category')->value->url;?>
" <?php if (!$_smarty_tpl->getVariable('brand')->value->id){?>class="selected"<?php }?>>Все бренды</a>
	<?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('category')->value->brands; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value){
?>
		<?php if ($_smarty_tpl->getVariable('b')->value->image){?>
		<img src="<?php echo $_smarty_tpl->getVariable('config')->value->brands_images_dir;?>
<?php echo $_smarty_tpl->getVariable('b')->value->image;?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('b')->value->name);?>
">
		<?php }?>
		<a data-brand="<?php echo $_smarty_tpl->getVariable('b')->value->id;?>
" href="catalog/<?php echo $_smarty_tpl->getVariable('category')->value->url;?>
/<?php echo $_smarty_tpl->getVariable('b')->value->url;?>
" <?php if ($_smarty_tpl->getVariable('b')->value->id==$_smarty_tpl->getVariable('brand')->value->id){?>class="selected"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('b')->value->name);?>
</a>
	<?php }} ?>
</div>
<?php }?>
<?php echo $_smarty_tpl->getVariable('brand')->value->description;?>

<?php if ($_smarty_tpl->getVariable('features')->value){?>
<table id="features">
	<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('features')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
?>
	<tr>
	<td class="feature_name" data-feature="<?php echo $_smarty_tpl->getVariable('f')->value->id;?>
">
		<?php echo $_smarty_tpl->getVariable('f')->value->name;?>
:
	</td>
	<td class="feature_values">
		<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('params'=>array($_smarty_tpl->getVariable('f')->value->id=>null,'page'=>null)),$_smarty_tpl);?>
" <?php if (!$_GET[$_smarty_tpl->getVariable('f')->key]){?>class="selected"<?php }?>>Все</a>
		<?php  $_smarty_tpl->tpl_vars['o'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('f')->value->options; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['o']->key => $_smarty_tpl->tpl_vars['o']->value){
?>
		<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('params'=>array($_smarty_tpl->getVariable('f')->value->id=>$_smarty_tpl->getVariable('o')->value->value,'page'=>null)),$_smarty_tpl);?>
" <?php if ($_GET[$_smarty_tpl->getVariable('f')->key]==$_smarty_tpl->getVariable('o')->value->value){?>class="selected"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('o')->value->value);?>
</a>
		<?php }} ?>
	</td>
	</tr>
	<?php }} ?>
</table>
<?php }?>


<!--Каталог товаров-->
<?php if ($_smarty_tpl->getVariable('products')->value){?>
<?php if (count($_smarty_tpl->getVariable('products')->value)>0){?>
<div class="sort">
	Сортировать по 
	<a <?php if ($_smarty_tpl->getVariable('sort')->value=='position'){?> class="selected"<?php }?> href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort'=>'position','page'=>null),$_smarty_tpl);?>
">умолчанию</a>
	<a <?php if ($_smarty_tpl->getVariable('sort')->value=='price'){?>    class="selected"<?php }?> href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort'=>'price','page'=>null),$_smarty_tpl);?>
">цене</a>
	<a <?php if ($_smarty_tpl->getVariable('sort')->value=='name'){?>     class="selected"<?php }?> href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('sort'=>'name','page'=>null),$_smarty_tpl);?>
">названию</a>
</div>
<?php }?>


<?php $_template = new Smarty_Internal_Template('pagination.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>


<!-- Список товаров-->
<ul class="products">

	<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
?>
	<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
		<?php if ($_smarty_tpl->getVariable('product')->value->image){?>
		<div class="image">
			<a href="products/<?php echo $_smarty_tpl->getVariable('product')->value->url;?>
"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('product')->value->image->filename,200,200);?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
"/></a>
		</div>
		<?php }?>
		<!-- Фото товара (The End) -->

		<div class="product_info">
		<!-- Название товара -->
		<h3 class="<?php if ($_smarty_tpl->getVariable('product')->value->featured){?>featured<?php }?>"><a data-product="<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
" href="products/<?php echo $_smarty_tpl->getVariable('product')->value->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
</a></h3>
		<!-- Название товара (The End) -->

		<!-- Описание товара -->
		<div class="annotation"><?php echo $_smarty_tpl->getVariable('product')->value->annotation;?>
</div>
		<!-- Описание товара (The End) -->
		
		<?php if (count($_smarty_tpl->getVariable('product')->value->variants)>0){?>
		<!-- Выбор варианта товара -->
		<form class="variants" action="/cart">
			<table>
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('product')->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['v']->index++;
 $_smarty_tpl->tpl_vars['v']->first = $_smarty_tpl->tpl_vars['v']->index === 0;
?>
			<tr class="variant">
				<td>
					<input id="variants_<?php echo $_smarty_tpl->getVariable('v')->value->id;?>
" name="variant" value="<?php echo $_smarty_tpl->getVariable('v')->value->id;?>
" type="radio" class="variant_radiobutton" <?php if ($_smarty_tpl->tpl_vars['v']->first){?>checked<?php }?> <?php if (count($_smarty_tpl->getVariable('product')->value->variants)<2){?>style="display:none;"<?php }?>/>
				</td>
				<td>
					<?php if ($_smarty_tpl->getVariable('v')->value->name){?><label class="variant_name" for="variants_<?php echo $_smarty_tpl->getVariable('v')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('v')->value->name;?>
</label><?php }?>
				</td>
				<td>
					<?php if ($_smarty_tpl->getVariable('v')->value->compare_price>0){?><span class="compare_price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('v')->value->compare_price);?>
</span><?php }?>
					<span class="price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('v')->value->price);?>
 <span class="currency"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('currency')->value->sign);?>
</span></span>
				</td>
			</tr>
			<?php }} ?>
			</table>
			<input type="submit" class="myButton" value="в корзину" data-result-text="добавлено"/>
		</form>
		<!-- Выбор варианта товара (The End) -->
		<?php }else{ ?>
			Нет в наличии
		<?php }?>

		</div>
		
	</li>
	<!-- Товар (The End)-->
	<?php }} ?>
			
</ul>

<?php $_template = new Smarty_Internal_Template('pagination.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>	
<!-- Список товаров (The End)-->

<?php }else{ ?>
Товары не найдены
<?php }?>	
<!--Каталог товаров (The End)-->