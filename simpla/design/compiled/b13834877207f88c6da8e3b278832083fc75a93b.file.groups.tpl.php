<?php /* Smarty version Smarty-3.0.7, created on 2011-10-28 18:27:47
         compiled from "simpla/design/html/groups.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19767799394eaac9f3b04789-88052725%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b13834877207f88c6da8e3b278832083fc75a93b' => 
    array (
      0 => 'simpla/design/html/groups.tpl',
      1 => 1319815665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19767799394eaac9f3b04789-88052725',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<?php ob_start(); ?>
	<li><a href="index.php?module=UsersAdmin">Покупатели</a></li>
	<li class="active"><a href="index.php?module=GroupsAdmin">Группы</a></li>		
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Группы пользователей', null, 1);?>
<div id="header">
	<h1>Группы пользователей</h1> 
	<a class="add" href="index.php?module=GroupAdmin">Добавить группу</a>
</div>	


<!-- Основная часть -->
<div id="main_list">

	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
	<div id="list" class="groups">
		
		<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('groups')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
?>
		<div class="row">
		 	<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="<?php echo $_smarty_tpl->getVariable('group')->value->id;?>
"/>				
			</div>
			<div class="group_name cell">
				<a href="index.php?module=GroupAdmin&id=<?php echo $_smarty_tpl->getVariable('group')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('group')->value->name;?>
</a>
			</div>
			<div class="group_discount cell">
				<?php echo $_smarty_tpl->getVariable('group')->value->discount;?>
 %
			</div>
			<div class="icons cell">
				<a class="delete" title="Удалить" href="#"></a>
			</div>
			<div class="clear"></div>
		</div>
		<?php }} ?>
	</div>

	<div id="action">
	<label id="check_all" class="dash_link">Выбрать все</label>

	<span id=select>
	<select name="action">
		<option value="delete">Удалить</option>
	</select>
	</span>

	<input id="apply_action" class="button_green" type="submit" value="Применить">
	</div>


	</form>

</div>



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
	$("form").submit(function() {
		if($('#list input[type="checkbox"][name*="check"]:checked').length>0)
			if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
				return false;	
	});
	
});

</script>

