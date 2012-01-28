<?php /* Smarty version Smarty-3.0.7, created on 2011-10-23 19:58:40
         compiled from "simpla/design/html/theme.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14876757994ea447c0a10939-46360030%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c67705d883d288c64137fd663cc6f4ddb8a2aa3b' => 
    array (
      0 => 'simpla/design/html/theme.tpl',
      1 => 1318758815,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14876757994ea447c0a10939-46360030',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
if (!is_callable('smarty_modifier_truncate')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.truncate.php';
?><?php ob_start(); ?>
	<li class="active"><a href="index.php?module=ThemeAdmin">Тема</a></li>
	<li><a href="index.php?module=TemplatesAdmin">Шаблоны</a></li>		
	<li><a href="index.php?module=StylesAdmin">Стили</a></li>		
	<li><a href="index.php?module=ImagesAdmin">Изображения</a></li>		
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>

<script>

	
$(function() {

	// Выбрать тему
	$('.set_main_theme').click(function() {
     	$("form input[name=action]").val('set_main_theme');
    	$("form input[name=theme]").val($(this).closest('li').attr('theme'));
    	$("form").submit();
	});	
	
	// Клонировать текущую тему
	$('#header .add').click(function() {
     	$("form input[name=action]").val('clone_theme');
    	$("form").submit();
	});	
	
	// Редактировать название
	$("a.edit").click(function() {
		name = $(this).closest('li').attr('theme');
		inp1 = $('<input type=hidden name="old_name[]">').val(name);
		inp2 = $('<input type=text name="new_name[]">').val(name);
		$(this).closest('li').find("p.name").html('').append(inp1).append(inp2);
		inp2.focus().select();
		return false;
	});
	
	// Удалить тему
	$('.delete').click(function() {
     	$("form input[name=action]").val('delete_theme');
     	$("form input[name=theme]").val($(this).closest('li').attr('theme'));
   		$("form").submit();
	});	

	$("form").submit(function() {
		if($("form input[name=action]").val()=='delete_theme' && !confirm('Подтвердите удаление'))
			return false;	
	});
	
});

</script>

<div id="header">
<h1 class="<?php if ($_smarty_tpl->getVariable('theme')->value->locked){?>locked<?php }?>">Текущая тема &mdash; <?php echo $_smarty_tpl->getVariable('theme')->value->name;?>
</h1>
<a class="add" href="#">Создать копию темы <?php echo $_smarty_tpl->getVariable('settings')->value->theme;?>
</a>
</div>

<?php if ($_smarty_tpl->getVariable('message_error')->value){?>
<!-- Системное сообщение -->
<div class="message message_error">
	<span><?php if ($_smarty_tpl->getVariable('message_error')->value=='permissions'){?>Установите права на запись для папки <?php echo $_smarty_tpl->getVariable('themes_dir')->value;?>

	<?php }elseif($_smarty_tpl->getVariable('message_error')->value=='name_exists'){?>Тема с таким именем уже существует
	<?php }else{ ?><?php echo $_smarty_tpl->getVariable('message_error')->value;?>
<?php }?></span>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>

<div class="block layer">

<form method="post" enctype="multipart/form-data">
<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
<input type=hidden name="action">
<input type=hidden name="theme">

<ul class="themes">
<?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('themes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value){
?>
	<li theme='<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('t')->value->name);?>
'>
		<?php if ($_smarty_tpl->getVariable('theme')->value->name==$_smarty_tpl->getVariable('t')->value->name){?><img class="tick" src='design/images/tick.png'> <?php }?>
		<?php if ($_smarty_tpl->getVariable('t')->value->locked){?><img class="tick" src='design/images/lock_small.png'> <?php }?>
		<?php if ($_smarty_tpl->getVariable('theme')->value->name!=$_smarty_tpl->getVariable('t')->value->name&&!$_smarty_tpl->getVariable('t')->value->locked){?>
		<a href='#' title="Удалить" class='delete'><img src='design/images/delete.png'></a>
		<a href='#' title="Изменить название" class='edit'><img src='design/images/pencil.png'></a>
		<?php }elseif($_smarty_tpl->getVariable('theme')->value->name!=$_smarty_tpl->getVariable('t')->value->name){?>
		<?php }elseif(!$_smarty_tpl->getVariable('t')->value->locked){?>
		<a href='#' title="Удалить" class='delete'><img src='design/images/delete.png'></a>
		<a href='#' title="Изменить название" class='edit'><img src='design/images/pencil.png'></a>
		<?php }?>
		<?php if ($_smarty_tpl->getVariable('theme')->value->name==$_smarty_tpl->getVariable('t')->value->name){?>
		<p class=name><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('t')->value->name),16,'...');?>
</p>
		<?php }else{ ?>
		<p class=name><a href='#' class='set_main_theme'><?php echo smarty_modifier_truncate(smarty_modifier_escape($_smarty_tpl->getVariable('t')->value->name),16,'...');?>
</a></p>
		<?php }?>
		<img class="preview" src='<?php echo $_smarty_tpl->getVariable('root_dir')->value;?>
../design/<?php echo $_smarty_tpl->getVariable('t')->value->name;?>
/preview.png'>
	</li>
<?php }} ?>
</ul>

<div class="block">
<input class="button_green button_save" type="submit" name="save" value="Сохранить" />
</div>
</form>

</div>