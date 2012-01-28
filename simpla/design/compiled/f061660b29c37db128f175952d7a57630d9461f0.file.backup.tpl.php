<?php /* Smarty version Smarty-3.0.7, created on 2011-10-23 23:27:11
         compiled from "simpla/design/html/backup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6021025914ea4789f920982-58255435%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f061660b29c37db128f175952d7a57630d9461f0' => 
    array (
      0 => 'simpla/design/html/backup.tpl',
      1 => 1319372463,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6021025914ea4789f920982-58255435',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<?php ob_start(); ?>
	<li><a href="index.php?module=ImportAdmin">Импорт</a></li>
	<li><a href="index.php?module=ExportAdmin">Экспорт</a></li>		
	<li class="active"><a href="index.php?module=BackupAdmin">Бекап</a></li>		
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Бекап', null, 1);?>
<div id="header">
	<h1>Бекап</h1>
	<?php if ($_smarty_tpl->getVariable('message_error')->value!='no_permission'){?>
	<a class="add" href="">Создать бекап</a>
	<form id="hidden" method="post">
		<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
		<input type="hidden" name="action" value="">
		<input type="hidden" name="name" value="">
	</form>
	<?php }?>
</div>	

<?php if ($_smarty_tpl->getVariable('message_success')->value){?>
<!-- Системное сообщение -->
<div class="message message_success">
	<span><?php if ($_smarty_tpl->getVariable('message_success')->value=='created'){?>Бекап создан<?php }elseif($_smarty_tpl->getVariable('message_success')->value=='restored'){?>Бекап восстановлен<?php }?></span>
	<?php if ($_GET['return']){?>
	<a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
	<?php }?>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>

<?php if ($_smarty_tpl->getVariable('message_error')->value){?>
<!-- Системное сообщение -->
<div class="message message_error">
	<span>
	<?php if ($_smarty_tpl->getVariable('message_error')->value=='no_permission'){?>Установите права на запись в папку <?php echo $_smarty_tpl->getVariable('backup_files_dir')->value;?>

	<?php }else{ ?><?php echo $_smarty_tpl->getVariable('message_error')->value;?>
<?php }?>
	</span>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>

<?php if ($_smarty_tpl->getVariable('backups')->value){?>
<div id="main_list">

	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">

		<div id="list">			
			<?php  $_smarty_tpl->tpl_vars['backup'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('backups')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['backup']->key => $_smarty_tpl->tpl_vars['backup']->value){
?>
			<div class="row">
				<?php if ($_smarty_tpl->getVariable('message_error')->value!='no_permission'){?>
		 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="<?php echo $_smarty_tpl->getVariable('backup')->value->name;?>
"/>				
				</div>
				<?php }?>
				<div class="name cell">
	 				<a href="files/backup/<?php echo $_smarty_tpl->getVariable('backup')->value->name;?>
"><?php echo $_smarty_tpl->getVariable('backup')->value->name;?>
</a>
					(<?php if ($_smarty_tpl->getVariable('backup')->value->size>1024*1024){?><?php echo round(($_smarty_tpl->getVariable('backup')->value->size/1024/1024),2);?>
 МБ<?php }else{ ?><?php echo round(($_smarty_tpl->getVariable('backup')->value->size/1024),2);?>
 КБ<?php }?>)
				</div>
				<div class="icons cell">
					<?php if ($_smarty_tpl->getVariable('message_error')->value!='no_permission'){?>
					<a class="delete" title="Удалить" href="#"></a>
					<?php }?>
		 		</div>
				<div class="icons cell">
					<a class="restore" title="Восстановить этот бекап" href="#"></a>
				</div>
		 		<div class="clear"></div>
			</div>
			<?php }} ?>
		</div>
		
		<?php if ($_smarty_tpl->getVariable('message_error')->value!='no_permission'){?>
		<div id="action">
		<label id="check_all" class="dash_link">Выбрать все</label>
	
		<span id="select">
		<select name="action">
			<option value="delete">Удалить</option>
		</select>
		</span>
	
		<input id="apply_action" class="button_green" type="submit" value="Применить">
		</div>
		<?php }?>
	
	</form>
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

	// Восстановить 
	$("a.restore").click(function() {
		file = $(this).closest(".row").find('[name*="check"]').val();
		$('form#hidden input[name="action"]').val('restore');
		$('form#hidden input[name="name"]').val(file);
		$('form#hidden').submit();
		return false;
	});

	// Создать бекап 
	$("a.add").click(function() {
		$('form#hidden input[name="action"]').val('create');
		$('form#hidden').submit();
		return false;
	});

	$("form#hidden").submit(function() {
		if($('input[name="action"]').val()=='restore' && !confirm('Текущие данные будут потеряны. Подтвердите восстановление'))
			return false;	
	});
	
	$("form#list_form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
	

});

</script>
