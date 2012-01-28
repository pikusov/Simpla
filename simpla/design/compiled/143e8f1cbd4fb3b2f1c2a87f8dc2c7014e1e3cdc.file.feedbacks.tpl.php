<?php /* Smarty version Smarty-3.0.7, created on 2011-10-13 01:14:08
         compiled from "simpla/design/html/feedbacks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2874393014e96113007b042-89581194%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '143e8f1cbd4fb3b2f1c2a87f8dc2c7014e1e3cdc' => 
    array (
      0 => 'simpla/design/html/feedbacks.tpl',
      1 => 1318457644,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2874393014e96113007b042-89581194',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?>
<?php ob_start(); ?>
		<li><a href="index.php?module=CommentsAdmin">Комментарии</a></li>
		<li class="active"><a href="index.php?module=FeedbacksAdmin">Обратная связь</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Обратная связь', null, 1);?>
<?php if ($_smarty_tpl->getVariable('feedbacks')->value||$_smarty_tpl->getVariable('keyword')->value){?>
<form method="get">
<div id="search">
	<input type="hidden" name="module" value='FeedbacksAdmin'>
	<input class="search" type="text" name="keyword" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('keyword')->value);?>
" />
	<input class="search_button" type="submit" value=""/>
</div>
</form>
<?php }?>
<div id="header">
	<?php if ($_smarty_tpl->getVariable('feedbacks_count')->value){?>
	<h1><?php echo $_smarty_tpl->getVariable('feedbacks_count')->value;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('feedbacks_count')->value,'сообщение','сообщений','сообщения');?>
</h1> 
	<?php }else{ ?>
	<h1>Нет сообщений</h1> 
	<?php }?>
</div>	

<div id="main_list">
	
	<!-- Листалка страниц -->
	<?php $_template = new Smarty_Internal_Template('pagination.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>	
	<!-- Листалка страниц (The End) -->
		
	<?php if ($_smarty_tpl->getVariable('feedbacks')->value){?>
		<form id="list_form" method="post">
		<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
		
			<div id="list" style="width:100%;">
				
				<?php  $_smarty_tpl->tpl_vars['feedback'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('feedbacks')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['feedback']->key => $_smarty_tpl->tpl_vars['feedback']->value){
?>
				<div class="row">
			 		<div class="checkbox cell">
						<input type="checkbox" name="check[]" value="<?php echo $_smarty_tpl->getVariable('feedback')->value->id;?>
" />				
					</div>
					<div class="name cell">
						<div class='comment_name'>
						<a href="mailto:<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('feedback')->value->name);?>
<<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('feedback')->value->email);?>
>?subject=Вопрос от пользователя <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('feedback')->value->name);?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('feedback')->value->name);?>
</a>
						</div>
						<div class='comment_text'>
						<?php echo nl2br(smarty_modifier_escape($_smarty_tpl->getVariable('feedback')->value->message));?>

						</div>
						<div class='comment_info'>
						Сообщение отправлено <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->getVariable('feedback')->value->date);?>
 в <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->getVariable('feedback')->value->date);?>

						</div>
					</div>
					<div class="icons cell">
						<a href='#' class="delete"></a>
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
		
			<input id='apply_action' class="button_green" type=submit value="Применить">
		
			
		</div>
		</form>
		
	<?php }else{ ?>
	Нет сообщений
	<?php }?>
		
	<!-- Листалка страниц -->
	<?php $_template = new Smarty_Internal_Template('pagination.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>	
	<!-- Листалка страниц (The End) -->
			
</div>

<!-- Меню -->
<div id="right_menu">
	
</div>
<!-- Меню  (The End) -->


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
	
	// Скрыт/Видим
	$("a.enable").click(function() {
		var icon        = $(this);
		var line        = icon.closest(".row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('invisible')?1:0;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'blog', 'id': id, 'values': {'visible': state}, 'session_id': '<?php echo $_SESSION['id'];?>
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
	
	// Подтверждение удаления
	$("form#list_form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});

});

</script>

