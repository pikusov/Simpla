<?php /* Smarty version Smarty-3.0.7, created on 2011-12-05 13:05:20
         compiled from "simpla/design/html/group.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19650071434edca5702090c9-95619317%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c298b24cf995af83a5bd1693a4c29441e5f360b' => 
    array (
      0 => 'simpla/design/html/group.tpl',
      1 => 1323083119,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19650071434edca5702090c9-95619317',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php ob_start(); ?>
		<li><a href="index.php?module=UsersAdmin">Покупатели</a></li>
		<li class="active"><a href="index.php?module=GroupsAdmin">Группы</a></li>		
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>

<?php if ($_smarty_tpl->getVariable('group')->value->id){?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable($_smarty_tpl->getVariable('group')->value->name, null, 1);?>
<?php }else{ ?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Новая группа', null, 1);?>
<?php }?>

<script src="design/js/jquery/jquery.js"></script>
<script src="design/js/jquery/jquery-ui.min.js"></script>


<script type="text/javascript" src="design/js/autocomplete/jquery.autocomplete-min.js"></script>
<style>
.autocomplete-w1 { background:url(img/shadow.png) no-repeat bottom right; position:absolute; top:0px; left:0px; margin:6px 0 0 6px; /* IE6 fix: */ _background:none; _margin:1px 0 0 0; }
.autocomplete { border:1px solid #999; background:#FFF; cursor:default; text-align:left; overflow-x:auto; min-width: 300px; overflow-y: auto; margin:-6px 6px 6px -6px; /* IE6 specific: */ _height:350px;  _margin:0; _overflow-x:hidden; }
.autocomplete .selected { background:#F0F0F0; }
.autocomplete div { padding:2px 5px; white-space:nowrap; }
.autocomplete strong { font-weight:normal; color:#3399FF; }
</style>

<script>
$(function() {



});


</script>






<?php if ($_smarty_tpl->getVariable('message_success')->value){?>
<!-- Системное сообщение -->
<div class="message message_success">
	<span><?php echo $_smarty_tpl->getVariable('message_success')->value;?>
</span>
	<a class="link" target="_blank" href="../products/<?php echo $_smarty_tpl->getVariable('page')->value->url;?>
">Открыть страницу на сайте</a>
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
	<span><?php echo $_smarty_tpl->getVariable('message_error')->value;?>
</span>
	<a class="link" href="../products/<?php echo $_smarty_tpl->getVariable('product')->value->url;?>
">Открыть товар на сайте</a>
	<a class="button" href="">Вернуться</a>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>


<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
	<div id="name">
		<input class="name" name=name type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('group')->value->name);?>
"/> 
		<input name=id type="hidden" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('group')->value->id);?>
"/> 
	</div> 

	<!-- Левая колонка свойств товара -->
	<div id="column_left">
			
		<!-- Параметры страницы -->
		<div class="block">
			<ul>
				<li><label class=property>Скидка</label><input name="discount" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('group')->value->discount);?>
" />%</li>
			</ul>
		</div>
		<!-- Параметры страницы (The End)-->
		

			
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->
