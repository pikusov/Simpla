<?php /* Smarty version Smarty-3.0.7, created on 2011-10-23 20:26:43
         compiled from "simpla/design/html/orders.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21330280904ea44e53acdd70-20043090%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd8ee2c04631b99172c8e9dfe8b1dee295230e569' => 
    array (
      0 => 'simpla/design/html/orders.tpl',
      1 => 1316925925,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21330280904ea44e53acdd70-20043090',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?>
<?php ob_start(); ?>
	<li <?php if ($_smarty_tpl->getVariable('status')->value===0){?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrdersAdmin','status'=>0,'keyword'=>null,'id'=>null,'page'=>null),$_smarty_tpl);?>
">Новые</a></li>
	<li <?php if ($_smarty_tpl->getVariable('status')->value==1){?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrdersAdmin','status'=>1,'keyword'=>null,'id'=>null,'page'=>null),$_smarty_tpl);?>
">Приняты</a></li>
	<li <?php if ($_smarty_tpl->getVariable('status')->value==2){?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrdersAdmin','status'=>2,'keyword'=>null,'id'=>null,'page'=>null),$_smarty_tpl);?>
">Выполнены</a></li>
	<li <?php if ($_smarty_tpl->getVariable('status')->value==3){?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrdersAdmin','status'=>3,'keyword'=>null,'id'=>null,'page'=>null),$_smarty_tpl);?>
">Удалены</a></li>
	<?php if ($_smarty_tpl->getVariable('keyword')->value){?>
	<li class="active"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrdersAdmin','keyword'=>$_smarty_tpl->getVariable('keyword')->value,'id'=>null),$_smarty_tpl);?>
">Поиск</a></li>
	<?php }?>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Заказы', null, 1);?>
<form method="get">
<div id="search">
	<input type="hidden" name="module" value="OrdersAdmin">
	<input class="search" type="text" name="keyword" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('keyword')->value);?>
"/>
	<input class="search_button" type="submit" value=""/>
</div>
</form>
	
<div id="header">
	<h1><?php if ($_smarty_tpl->getVariable('orders_count')->value){?><?php echo $_smarty_tpl->getVariable('orders_count')->value;?>
<?php }else{ ?>Нет<?php }?> заказ<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('orders_count')->value,'','ов','а');?>
</h1>		
	<a class="add" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrderAdmin'),$_smarty_tpl);?>
">Добавить заказ</a>
</div>	

<?php if ($_smarty_tpl->getVariable('orders')->value){?>
<div id="main_list">
	
	<!-- Листалка страниц -->
	<?php $_template = new Smarty_Internal_Template('pagination.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>	
	<!-- Листалка страниц (The End) -->
	
	<form id="form_list" method="post">
	<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">

		<div id="list">		
			<?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('orders')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value){
?>
			<div class="<?php if ($_smarty_tpl->getVariable('order')->value->paid){?>green<?php }?> row">
		 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="<?php echo $_smarty_tpl->getVariable('order')->value->id;?>
"/>				
				</div>
				<div class="order_date cell">				 	
	 				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->getVariable('order')->value->date);?>
 в <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->getVariable('order')->value->date);?>

				</div>
				<?php if ($_smarty_tpl->getVariable('keyword')->value){?>
				<div class="icons cell">
						<?php if ($_smarty_tpl->getVariable('order')->value->status==0){?>
						<img src='design/images/new.png' alt='Новый' title='Новый'>
						<?php }?>
						<?php if ($_smarty_tpl->getVariable('order')->value->status==1){?>
						<img src='design/images/time.png' alt='Принят' title='Принят'>
						<?php }?>
						<?php if ($_smarty_tpl->getVariable('order')->value->status==2){?>
						<img src='design/images/tick.png' alt='Выполнен' title='Выполнен'>
						<?php }?>
						<?php if ($_smarty_tpl->getVariable('order')->value->status==3){?>
						<img src='design/images/cross.png' alt='Удалён' title='Удалён'>
						<?php }?>
				</div>
				<?php }?>
				<div class="order_name cell">			 	
	 				<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrderAdmin','id'=>$_smarty_tpl->getVariable('order')->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">Заказ №<?php echo $_smarty_tpl->getVariable('order')->value->id;?>
</a> <?php echo $_smarty_tpl->getVariable('order')->value->name;?>

	 				<?php if ($_smarty_tpl->getVariable('order')->value->note){?>
	 				<div class="note"><?php echo $_smarty_tpl->getVariable('order')->value->note;?>
</div>
	 				<?php }?> 	 			
				</div>
				<div class="icons cell">
					<?php if ($_smarty_tpl->getVariable('order')->value->paid){?>
						<img src='design/images/cash_stack.png' alt='Оплачен' title='Оплачен'>
					<?php }else{ ?>
						<img src='design/images/cash_stack_gray.png' alt='Не оплачен' title='Не оплачен'>				
					<?php }?>			 	
				</div>
				<div class="name cell" style='white-space:nowrap;'>
	 				<?php echo $_smarty_tpl->getVariable('order')->value->total_price;?>
 <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

				</div>
				<div class="icons cell">
					<a href='#' class=delete></a>
				</div>
				<div class="clear"></div>
			</div>
			<?php }} ?>
		</div>
	
		<div id="action">
		<label id='check_all' class="dash_link">Выбрать все</label>
	
		<span id="select">
		<select name="action">
			<option value="delete">Удалить</option>
		</select>
		</span>
	
		<input id="apply_action" class="button_green" type="submit" value="Применить">
		
		</div>
	</form>
	
	<!-- Листалка страниц -->
	<?php $_template = new Smarty_Internal_Template('pagination.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>	
	<!-- Листалка страниц (The End) -->
		
</div>
<?php }?>

<script>
$(function() {
	
	// Раскраска строк
	function colorize()
	{
		$("#list div.row:even").addClass('even');
		$("#list div.row:odd").removeClass('even');
	}
	// Раскрасить строки сразу
	colorize();

	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', 1-$('#list input[type="checkbox"][name*="check"]').attr('checked'));
	});	

	// Удалить 
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest(".row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});

	// Подтверждение удаления
	$("#form_list").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
});

</script>

