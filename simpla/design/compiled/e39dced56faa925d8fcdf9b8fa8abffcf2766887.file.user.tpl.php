<?php /* Smarty version Smarty-3.0.7, created on 2011-12-05 13:06:16
         compiled from "simpla/design/html/user.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20486614634edca5a8640ae5-45818496%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e39dced56faa925d8fcdf9b8fa8abffcf2766887' => 
    array (
      0 => 'simpla/design/html/user.tpl',
      1 => 1323083175,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20486614634edca5a8640ae5-45818496',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php ob_start(); ?>
		<li class="active"><a href="index.php?module=UsersAdmin">Покупатели</a></li>
		<li><a href="index.php?module=GroupsAdmin">Группы</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>

<?php if ($_smarty_tpl->getVariable('user')->value->id){?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable(smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->name), null, 1);?>
<?php }?>

<?php if ($_smarty_tpl->getVariable('message_success')->value){?>
<!-- Системное сообщение -->
<div class="message message_success">
	<span><?php if ($_smarty_tpl->getVariable('message_success')->value=='updated'){?>Пользователь отредактирован<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('message_success')->value);?>
<?php }?></span>
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
	<span><?php if ($_smarty_tpl->getVariable('message_error')->value=='login_exists'){?>Пользователь с таким email уже зарегистрирован
	<?php }elseif($_smarty_tpl->getVariable('message_error')->value=='empty_name'){?>Введите имя пользователя
	<?php }elseif($_smarty_tpl->getVariable('message_error')->value=='empty_email'){?>Введите email пользователя
	<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('message_error')->value);?>
<?php }?></span>
	<?php if ($_GET['return']){?>
	<a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
	<?php }?>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>



<!-- Основная форма -->
<form method=post id=product>
<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
	<div id="name">
		<input class="name" name=name type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->name);?>
"/> 
		<input name=id type="hidden" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->id);?>
"/> 
		<div class="checkbox">
			<input name="enabled" value='1' type="checkbox" id="active_checkbox" <?php if ($_smarty_tpl->getVariable('user')->value->enabled){?>checked<?php }?>/> <label for="active_checkbox">Активен</label>
		</div>
	</div> 
	

<div id=column_left>
	<!-- Левая колонка свойств товара -->

		<!-- Параметры страницы -->
		<div class="block">
			<ul>
				<?php if ($_smarty_tpl->getVariable('groups')->value){?>
				<li>
					<label class=property>Группа</label>
					<select name="group_id">
						<option value='0'>Не входит в группу</option>
				   		<?php  $_smarty_tpl->tpl_vars['g'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('groups')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['g']->key => $_smarty_tpl->tpl_vars['g']->value){
?>
				        	<option value='<?php echo $_smarty_tpl->getVariable('g')->value->id;?>
' <?php if ($_smarty_tpl->getVariable('user')->value->group_id==$_smarty_tpl->getVariable('g')->value->id){?>selected<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('g')->value->name);?>
</option>
				    	<?php }} ?>
					</select>
				</li>
				<?php }?>
				<li><label class=property>Email</label><input name="email" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->email);?>
" /></li>
			</ul>
		</div>


		
		<!-- Параметры страницы (The End)-->			
		
	<input class="button_green button_save" type="submit" name="user_info" value="Сохранить" />
</div>
		
	 
	<!-- Левая колонка свойств товара (The End)--> 
	
		
</form>
<!-- Основная форма (The End) -->
 

<?php if ($_smarty_tpl->getVariable('orders')->value){?>
<div class="block" id=column_left>
<form id="list" method="post">
	<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
	<h2>Заказы пользователя</h2>

	<div>		
		<?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('orders')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value){
?>
		<div class="<?php if ($_smarty_tpl->getVariable('order')->value->paid){?>green<?php }?> row">
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="<?php echo $_smarty_tpl->getVariable('order')->value->id;?>
" />				
			</div>
			<div class="order_date cell">
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->getVariable('order')->value->date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->getVariable('order')->value->date);?>

			</div>
			<div class="name cell">
				<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrderAdmin','id'=>$_smarty_tpl->getVariable('order')->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
">Заказ №<?php echo $_smarty_tpl->getVariable('order')->value->id;?>
</a>
			</div>
			<div class="name cell">
				<?php echo $_smarty_tpl->getVariable('order')->value->total_price;?>
&nbsp;<?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

			</div>
			<div class="icons cell">
				<?php if ($_smarty_tpl->getVariable('order')->value->paid){?>
					<img src='design/images/cash_stack.png' alt='Оплачен' title='Оплачен'>
				<?php }else{ ?>
					<img src='design/images/cash_stack_gray.png' alt='Не оплачен' title='Не оплачен'>				
				<?php }?>	
			</div>
			<div class="icons cell">
				<a href='#' class=delete></a>		 	
			</div>
			<div class="clear"></div>
		</div>
		<?php }} ?>
	</div>

	<div id="action">
	<label id='check_all' class='dash_link'>Выбрать все</label>

	<span id=select>
	<select name="action">
		<option value="delete">Удалить</option>
	</select>
	</span>


	<input id="apply_action" class="button_green" name="user_orders" type="submit" value="Применить">
	</form>
	</div>
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
		$(this).closest("form#list").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form#list").submit();
	});

	// Подтверждение удаления
	$("#list").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
});

</script>

