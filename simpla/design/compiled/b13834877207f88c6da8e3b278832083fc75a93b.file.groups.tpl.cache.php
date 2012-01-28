<?php /* Smarty version Smarty-3.0.7, created on 2011-10-23 20:26:40
         compiled from "simpla/design/html/groups.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17365283074ea44e50cc95a8-71904397%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b13834877207f88c6da8e3b278832083fc75a93b' => 
    array (
      0 => 'simpla/design/html/groups.tpl',
      1 => 1316778279,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17365283074ea44e50cc95a8-71904397',
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
	<div id="list" class="groups">
		
		<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('groups')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
?>
		<div class="row">
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
});

</script>

