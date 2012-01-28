<?php /* Smarty version Smarty-3.0.7, created on 2012-01-19 16:59:11
         compiled from "simpla/design/html/products.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4025764094f182fbfc1e450-58696961%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '29ea9ac8ff03271d57a7c517b21d0b694373e940' => 
    array (
      0 => 'simpla/design/html/products.tpl',
      1 => 1326985136,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4025764094f182fbfc1e450-58696961',
  'function' => 
  array (
    'category_select' => 
    array (
      'parameter' => 
      array (
        'level' => 0,
      ),
      'compiled' => '',
    ),
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
if (!is_callable('smarty_modifier_truncate')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.truncate.php';
?>
<?php ob_start(); ?>
	<li class="active"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ProductsAdmin','keyword'=>null,'category_id'=>null,'brand_id'=>null,'filter'=>null,'page'=>null),$_smarty_tpl);?>
">Товары</a></li>
	<li><a href="index.php?module=CategoriesAdmin">Категории</a></li>
	<li><a href="index.php?module=BrandsAdmin">Бренды</a></li>
	<li><a href="index.php?module=FeaturesAdmin">Свойства</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
<?php if ($_smarty_tpl->getVariable('category')->value){?>
	<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable($_smarty_tpl->getVariable('category')->value->name, null, 1);?>
<?php }else{ ?>
	<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Товары', null, 1);?>
<?php }?>
<form method="get">
<div id="search">
	<input type="hidden" name="module" value="ProductsAdmin">
	<input class="search" type="text" name="keyword" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('keyword')->value);?>
" />
	<input class="search_button" type="submit" value=""/>
</div>
</form>
	
<div id="header">	
	<?php if ($_smarty_tpl->getVariable('products_count')->value){?>
		<?php if ($_smarty_tpl->getVariable('category')->value->name||$_smarty_tpl->getVariable('brand')->value->name){?>
			<h1><?php echo $_smarty_tpl->getVariable('category')->value->name;?>
 <?php echo $_smarty_tpl->getVariable('brand')->value->name;?>
 (<?php echo $_smarty_tpl->getVariable('products_count')->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('products_count')->value,'товар','товаров','товара');?>
)</h1>
		<?php }elseif($_smarty_tpl->getVariable('keyword')->value){?>
			<h1><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('products_count')->value,'Найден','Найдено','Найдено');?>
 <?php echo $_smarty_tpl->getVariable('products_count')->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('products_count')->value,'товар','товаров','товара');?>
</h1>
		<?php }else{ ?>
			<h1><?php echo $_smarty_tpl->getVariable('products_count')->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('products_count')->value,'товар','товаров','товара');?>
</h1>
		<?php }?>		
	<?php }else{ ?>
		<h1>Нет товаров</h1>
	<?php }?>
	<a class="add" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ProductAdmin','return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">Добавить товар</a>
</div>	

<div id="main_list">
	
	<!-- Листалка страниц -->
	<?php $_template = new Smarty_Internal_Template('pagination.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>	
	<!-- Листалка страниц (The End) -->
		
	<?php if ($_smarty_tpl->getVariable('products')->value){?>

	<div id="expand">
	<!-- Свернуть/развернуть варианты -->
	<a href="#" class="dash_link" id="expand_all">Развернуть все варинаты ↓</a>
	<a href="#" class="dash_link" id="roll_up_all" style="display:none;">Свернуть все варинаты ↑</a>
	<!-- Свернуть/развернуть варианты (The End) -->
	</div>
	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
	
		<div id="list">
		<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
?>
		<div class="<?php if (!$_smarty_tpl->getVariable('product')->value->visible){?>invisible<?php }?> <?php if ($_smarty_tpl->getVariable('product')->value->featured){?>featured<?php }?> row">
			<input type="hidden" name="positions[<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('product')->value->position;?>
">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
"/>				
			</div>
			<div class="image cell">
				<?php $_smarty_tpl->tpl_vars['image'] = new Smarty_variable($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['first'][0][0]->first_modifier($_smarty_tpl->getVariable('product')->value->images), null, null);?>
				<?php if ($_smarty_tpl->getVariable('image')->value){?>
				<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ProductAdmin','id'=>$_smarty_tpl->getVariable('product')->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier(smarty_modifier_escape($_smarty_tpl->getVariable('image')->value->filename),35,35);?>
" /></a>
				<?php }?>
			</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
				<?php  $_smarty_tpl->tpl_vars['variant'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('product')->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['variant']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['variant']->key => $_smarty_tpl->tpl_vars['variant']->value){
 $_smarty_tpl->tpl_vars['variant']->index++;
 $_smarty_tpl->tpl_vars['variant']->first = $_smarty_tpl->tpl_vars['variant']->index === 0;
?>
				<li <?php if (!$_smarty_tpl->tpl_vars['variant']->first){?>class="variant" style="display:none;"<?php }?>>
					<i title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('variant')->value->name);?>
"><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('variant')->value->name),30,'…',true,true);?>
</i>
					<input class="price <?php if ($_smarty_tpl->getVariable('variant')->value->compare_price>0){?>compare_price<?php }?>" type="text" name="price[<?php echo $_smarty_tpl->getVariable('variant')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('variant')->value->price;?>
" <?php if ($_smarty_tpl->getVariable('variant')->value->compare_price>0){?>title="Старая цена &mdash; <?php echo $_smarty_tpl->getVariable('variant')->value->compare_price;?>
 <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
"<?php }?> /><?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
  
					<input class="stock" type="text" name="stock[<?php echo $_smarty_tpl->getVariable('variant')->value->id;?>
]" value="<?php if ($_smarty_tpl->getVariable('variant')->value->infinity){?>∞<?php }else{ ?><?php echo $_smarty_tpl->getVariable('variant')->value->stock;?>
<?php }?>" /><?php echo $_smarty_tpl->getVariable('settings')->value->units;?>

				</li>
				<?php }} ?>
				</ul>
	
				<?php $_smarty_tpl->tpl_vars['variants_num'] = new Smarty_variable(count($_smarty_tpl->getVariable('product')->value->variants), null, null);?>
				<?php if ($_smarty_tpl->getVariable('variants_num')->value>1){?>
				<div class="expand_variant">
				<a class="dash_link expand_variant" href="#"><?php echo $_smarty_tpl->getVariable('variants_num')->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('variants_num')->value,'вариант','вариатов','варианта');?>
 ↓</a>
				<a class="dash_link roll_up_variant" style="display:none;" href="#"><?php echo $_smarty_tpl->getVariable('variants_num')->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('variants_num')->value,'вариант','вариатов','варианта');?>
 ↑</a>
				</div>
				<?php }?>
				</div>
				
				<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ProductAdmin','id'=>$_smarty_tpl->getVariable('product')->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/<?php echo $_smarty_tpl->getVariable('product')->value->url;?>
" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="featured"  title="Рекомендуемый"           href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
		<?php }} ?>
		</div>

		<div id="action">
			<label id="check_all" class="dash_link">Выбрать все</label>
		
			<span id="select">
			<select name="action">
				<option value="enable">Сделать видимыми</option>
				<option value="disable">Сделать невидимыми</option>
				<option value="set_featured">Сделать рекомендуемым</option>
				<option value="unset_featured">Отменить рекомендуемый</option>
				<option value="duplicate">Создать дубликат</option>
				<?php if ($_smarty_tpl->getVariable('pages_count')->value>1){?>
				<option value="move_to_page">Переместить на страницу</option>
				<?php }?>
				<?php if (count($_smarty_tpl->getVariable('categories')->value)>1){?>
				<option value="move_to_category">Переместить в категорию</option>
				<?php }?>
				<?php if (count($_smarty_tpl->getVariable('brands')->value)>0){?>
				<option value="move_to_brand">Указать бренд</option>
				<?php }?>
				<option value="delete">Удалить</option>
			</select>
			</span>
		
			<span id="move_to_page">
			<select name="target_page">
				<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['name'] = 'target_page';
$_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('pages_count')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['target_page']['total']);
?>
				<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['target_page']['index']+1;?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['target_page']['index']+1;?>
</option>
				<?php endfor; endif; ?>
			</select> 
			</span>
		
			<span id="move_to_category">
			<select name="target_category">
				<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php if (!function_exists('smarty_template_function_category_select')) {
    function smarty_template_function_category_select($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['category_select']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
				<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('categories')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
?>
						<option value='<?php echo $_smarty_tpl->getVariable('category')->value->id;?>
'><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['name'] = 'sp';
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('level')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total']);
?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endfor; endif; ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('category')->value->name);?>
</option>
						<?php smarty_template_function_category_select($_smarty_tpl,array('categories'=>$_smarty_tpl->getVariable('category')->value->subcategories,'selected_id'=>$_smarty_tpl->getVariable('selected_id')->value,'level'=>$_smarty_tpl->getVariable('level')->value+1));?>

				<?php }} ?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

				<?php smarty_template_function_category_select($_smarty_tpl,array('categories'=>$_smarty_tpl->getVariable('categories')->value));?>

			</select> 
			</span>
			
			<span id="move_to_brand">
			<select name="target_brand">
				<option value="0">Не указан</option>
				<?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('brands')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value){
?>
				<option value="<?php echo $_smarty_tpl->getVariable('b')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('b')->value->name;?>
</option>
				<?php }} ?>
			</select> 
			</span>
		
			<input id="apply_action" class="button_green" type="submit" value="Применить">		
		</div>
		<?php }?>
	</form>

	<!-- Листалка страниц -->
	<?php $_template = new Smarty_Internal_Template('pagination.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>	
	<!-- Листалка страниц (The End) -->		
</div>


<!-- Меню -->
<div id="right_menu">
	
	<!-- Фильтры -->
	<ul>
		<li <?php if (!$_smarty_tpl->getVariable('filter')->value){?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('brand_id'=>null,'category_id'=>null,'keyword'=>null,'page'=>null,'filter'=>null),$_smarty_tpl);?>
">Все товары</a></li>
		<li <?php if ($_smarty_tpl->getVariable('filter')->value=='featured'){?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'category_id'=>null,'page'=>null,'filter'=>'featured'),$_smarty_tpl);?>
">Рекомендуемые</a></li>
		<li <?php if ($_smarty_tpl->getVariable('filter')->value=='discounted'){?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'category_id'=>null,'page'=>null,'filter'=>'discounted'),$_smarty_tpl);?>
">Со скидкой</a></li>
	</ul>
	<!-- Фильтры -->


	<!-- Категории товаров -->
	<?php if (!function_exists('smarty_template_function_categories_tree')) {
    function smarty_template_function_categories_tree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['categories_tree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
	<?php if ($_smarty_tpl->getVariable('categories')->value){?>
	<ul>
		<?php if ($_smarty_tpl->getVariable('categories')->value[0]->parent_id==0){?>
		<li <?php if (!$_smarty_tpl->getVariable('category')->value->id){?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('category_id'=>null,'brand_id'=>null),$_smarty_tpl);?>
">Все категории</a></li>	
		<?php }?>
		<?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('categories')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
?>
		<li category_id="<?php echo $_smarty_tpl->getVariable('c')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('category')->value->id==$_smarty_tpl->getVariable('c')->value->id){?>class="selected"<?php }else{ ?>class="droppable category"<?php }?>><a href='<?php ob_start();?><?php echo $_smarty_tpl->getVariable('c')->value->id;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'brand_id'=>null,'page'=>null,'category_id'=>$_tmp1),$_smarty_tpl);?>
'><?php echo $_smarty_tpl->getVariable('c')->value->name;?>
</a></li>
		<?php smarty_template_function_categories_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->getVariable('c')->value->subcategories));?>

		<?php }} ?>
	</ul>
	<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

	<?php smarty_template_function_categories_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->getVariable('categories')->value));?>

	<!-- Категории товаров (The End)-->
	
	<?php if ($_smarty_tpl->getVariable('brands')->value){?>
	<!-- Бренды -->
	<ul>
		<li <?php if (!$_smarty_tpl->getVariable('brand')->value->id){?>class="selected"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('brand_id'=>null),$_smarty_tpl);?>
">Все бренды</a></li>
		<?php  $_smarty_tpl->tpl_vars['b'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('brands')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['b']->key => $_smarty_tpl->tpl_vars['b']->value){
?>
		<li brand_id="<?php echo $_smarty_tpl->getVariable('b')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('brand')->value->id==$_smarty_tpl->getVariable('b')->value->id){?>class="selected"<?php }else{ ?>class="droppable brand"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('keyword'=>null,'page'=>null,'brand_id'=>$_smarty_tpl->getVariable('b')->value->id),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->getVariable('b')->value->name;?>
</a></li>
		<?php }} ?>
	</ul>
	<!-- Бренды (The End) -->
	<?php }?>
	
</div>
<!-- Меню  (The End) -->

<script>

$(function() {

	// Сортировка списка
	$("#list").sortable({
		items:             ".row",
		tolerance:         "pointer",
		handle:            ".move_zone",
		scrollSensitivity: 40,
		opacity:           0.7, 
		
		helper: function(event, ui){		
			if($('input[type="checkbox"][name*="check"]:checked').size()<1) return ui;
			var helper = $('<div/>');
			$('input[type="checkbox"][name*="check"]:checked').each(function(){
				var item = $(this).closest('.row');
				helper.height(helper.height()+item.innerHeight());
				if(item[0]!=ui[0]) {
					helper.append(item.clone());
					$(this).closest('.row').remove();
				}
				else {
					helper.append(ui.clone());
					item.find('input[type="checkbox"][name*="check"]').attr('checked', false);
				}
			});
			return helper;			
		},	
 		start: function(event, ui) {
  			if(ui.helper.children('.row').size()>0)
				$('.ui-sortable-placeholder').height(ui.helper.height());
		},
		beforeStop:function(event, ui){
			if(ui.helper.children('.row').size()>0){
				ui.helper.children('.row').each(function(){
					$(this).insertBefore(ui.item);
				});
				ui.item.remove();
			}
		},
		update:function(event, ui)
		{
			$("#list_form input[name*='check']").attr('checked', false);
			$("#list_form").ajaxSubmit(function() {
				colorize();
			});
		}
	});
	

	// Перенос товара на другую страницу
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_page')
			$("span#move_to_page").show();
		else
			$("span#move_to_page").hide();
	});
	$("#pagination a.droppable").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_page]').attr("selected", "selected");		
			$(ui.draggable).closest("form").find('select[name=target_page] option[value='+$(this).html()+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;	
		}		
	});


	// Перенос товара в другую категорию
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_category')
			$("span#move_to_category").show();
		else
			$("span#move_to_category").hide();
	});
	$("#right_menu .droppable.category").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_category]').attr("selected", "selected");	
			$(ui.draggable).closest("form").find('select[name=target_category] option[value='+$(this).attr('category_id')+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;			
		}
	});


	// Перенос товара в другой бренд
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_brand')
			$("span#move_to_brand").show();
		else
			$("span#move_to_brand").hide();
	});
	$("#right_menu .droppable.brand").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_brand]').attr("selected", "selected");			
			$(ui.draggable).closest("form").find('select[name=target_brand] option[value='+$(this).attr('brand_id')+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;			
		}
	});


	// Если есть варианты, отображать ссылку на их разворачивание
	if($("li.variant").size()>0)
		$("#expand").show();


	// Раскраска строк
	function colorize()
	{
		$("#list div.row:even").addClass('even');
		$("#list div.row:odd").removeClass('even');
	}
	// Раскрасить строки сразу
	colorize();


	// Показать все варианты
	$("#expand_all").click(function() {
		$("a#expand_all").hide();
		$("a#roll_up_all").show();
		$("a.expand_variant").hide();
		$("a.roll_up_variant").show();
		$(".variants ul li.variant").fadeIn('fast');
		return false;
	});


	// Свернуть все варианты
	$("#roll_up_all").click(function() {
		$("a#roll_up_all").hide();
		$("a#expand_all").show();
		$("a.roll_up_variant").hide();
		$("a.expand_variant").show();
		$(".variants ul li.variant").fadeOut('fast');
		return false;
	});

 
	// Показать вариант
	$("a.expand_variant").click(function() {
		$(this).closest("div.cell").find("li.variant").fadeIn('fast');
		$(this).closest("div.cell").find("a.expand_variant").hide();
		$(this).closest("div.cell").find("a.roll_up_variant").show();
		return false;
	});

	// Свернуть вариант
	$("a.roll_up_variant").click(function() {
		$(this).closest("div.cell").find("li.variant").fadeOut('fast');
		$(this).closest("div.cell").find("a.roll_up_variant").hide();
		$(this).closest("div.cell").find("a.expand_variant").show();
		return false;
	});

	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', 1-$('#list input[type="checkbox"][name*="check"]').attr('checked'));
	});	

	// Удалить товар
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Дублировать товар
	$("a.duplicate").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=duplicate]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Показать товар
	$("a.enable").click(function() {
		var icon        = $(this);
		var line        = icon.closest("div.row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('invisible')?1:0;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'product', 'id': id, 'values': {'visible': state}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
				icon.removeClass('loading_icon');
				if(state)
					line.removeClass('invisible');
				else
					line.addClass('invisible');				
			},
			dataType: 'json'
		});	
		return false;	
	});

	// Сделать хитом
	$("a.featured").click(function() {
		var icon        = $(this);
		var line        = icon.closest("div.row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('featured')?0:1;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'product', 'id': id, 'values': {'featured': state}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
				icon.removeClass('loading_icon');
				if(state)
					line.addClass('featured');				
				else
					line.removeClass('featured');
			},
			dataType: 'json'
		});	
		return false;	
	});


	// Подтверждение удаления
	$("form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
	
	
	// Бесконечность на складе
	$("input[name*=stock]").focus(function() {
		if($(this).val() == '∞')
			$(this).val('');
		return false;
	});
	$("input[name*=stock]").blur(function() {
		if($(this).val() == '')
			$(this).val('∞');
	});
});

</script>
