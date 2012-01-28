<?php /* Smarty version Smarty-3.0.7, created on 2011-09-22 12:37:55
         compiled from "simpla/design/html/categories.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3042918244e7b01f33c4430-14377907%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '585f2e9ca46dca3c5183343571f47666d8f3db63' => 
    array (
      0 => 'simpla/design/html/categories.tpl',
      1 => 1316636597,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3042918244e7b01f33c4430-14377907',
  'function' => 
  array (
    'categories_tree' => 
    array (
      'parameter' => 
      array (
        'level' => 0,
      ),
      'compiled' => '',
    ),
  ),
  'has_nocache_code' => 0,
)); /*/%%SmartyHeaderCode%%*/?>

<?php ob_start(); ?>
	<li><a href="index.php?module=ProductsAdmin">Товары</a></li>
	<li class="active"><a href="index.php?module=CategoriesAdmin">Категории</a></li>
	<li><a href="index.php?module=BrandsAdmin">Бренды</a></li>
	<li><a href="index.php?module=FeaturesAdmin">Свойства</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Категории', null, 1);?>
<div id="header">
	<h1>Категории товаров</h1>
	<a class="add" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'CategoryAdmin','return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">Добавить категорию</a>
</div>	
<!-- Заголовок (The End) -->

<?php if ($_smarty_tpl->getVariable('categories')->value){?>
<div id="main_list" class="categories">

	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
		
		<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php if (!function_exists('smarty_template_function_categories_tree')) {
    function smarty_template_function_categories_tree($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['categories_tree']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
		<?php if ($_smarty_tpl->getVariable('categories')->value){?>
		<div id="list" class="sortable">
		
			<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('categories')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
?>
			<div class="<?php if (!$_smarty_tpl->getVariable('category')->value->visible){?>invisible<?php }?> row">		
				<div class="tree_row">
					<input type="hidden" name="positions[<?php echo $_smarty_tpl->getVariable('category')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('category')->value->position;?>
">
					<div class="move cell" style="margin-left:<?php echo $_smarty_tpl->getVariable('level')->value*20;?>
px"><div class="move_zone"></div></div>
			 		<div class="checkbox cell">
						<input type="checkbox" name="check[]" value="<?php echo $_smarty_tpl->getVariable('category')->value->id;?>
" />				
					</div>
					<div class="cell">
						<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'CategoryAdmin','id'=>$_smarty_tpl->getVariable('category')->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('category')->value->name);?>
</a> 	 			
					</div>
					<div class="icons cell">
						<a class="preview" title="Предосмотр в новом окне" href="../catalog/<?php echo $_smarty_tpl->getVariable('category')->value->url;?>
" target="_blank"></a>				
						<a class="enable" title="Активна" href="#"></a>
						<a class="delete" title="Удалить" href="#"></a>
					</div>
					<div class="clear"></div>
				</div>
				<?php smarty_template_function_categories_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->getVariable('category')->value->subcategories,'level'=>$_smarty_tpl->getVariable('level')->value+1));?>

			</div>
			<?php }} ?>
	
		</div>
		<?php }?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

		<?php smarty_template_function_categories_tree($_smarty_tpl,array('categories'=>$_smarty_tpl->getVariable('categories')->value));?>

		
		<div id="action">
		<label id="check_all" class="dash_link">Выбрать все</label>
		
		<span id="select">
		<select name="action">
			<option value="enable">Сделать видимыми</option>
			<option value="disable">Сделать невидимыми</option>
			<option value="delete">Удалить</option>
		</select>
		</span>
		
		<input id="apply_action" class="button_green" type="submit" value="Применить">
		
		</div>
	
	</form>
</div>
<?php }else{ ?>
Нет категорий
<?php }?>


<script>
$(function() {

	// Сортировка списка
	$(".sortable").sortable({
		items:".row",
		handle: ".move_zone",
		tolerance:"pointer",
		scrollSensitivity:40,
		opacity:0.7, 
		axis: "y",
		update:function()
		{
			$("#list_form input[name*='check']").attr('checked', false);
			$("#list_form").ajaxSubmit();
		}
	});
 
	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', 1-$('#list input[type="checkbox"][name*="check"]').attr('checked'));
	});	

	// Показать категорию
	$("a.enable").click(function() {
		var icon        = $(this);
		var line        = icon.closest(".row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('invisible')?1:0;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'category', 'id': id, 'values': {'visible': state}, 'session_id': '<?php echo $_SESSION['id'];?>
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

	// Удалить 
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]:first').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});

	
	// Подтвердить удаление
	$("form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});

});
</script>
