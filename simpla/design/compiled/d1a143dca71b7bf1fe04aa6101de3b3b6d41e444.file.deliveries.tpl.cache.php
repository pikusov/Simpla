<?php /* Smarty version Smarty-3.0.7, created on 2011-10-23 15:53:21
         compiled from "simpla/design/html/deliveries.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5926136634ea40e418b3597-02885517%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd1a143dca71b7bf1fe04aa6101de3b3b6d41e444' => 
    array (
      0 => 'simpla/design/html/deliveries.tpl',
      1 => 1316506863,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5926136634ea40e418b3597-02885517',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?>
<?php ob_start(); ?>
	<li><a href="index.php?module=SettingsAdmin">Настройки</a></li>
	<li><a href="index.php?module=CurrencyAdmin">Валюты</a></li>
	<li class="active"><a href="index.php?module=DeliveriesAdmin">Доставка</a></li>
	<li><a href="index.php?module=PaymentMethodsAdmin">Оплата</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Доставка', null, 1);?>
<div id="header">
	<h1>Доставка</h1>
	<a class="add" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'DeliveryAdmin'),$_smarty_tpl);?>
">Добавить способ доставки</a>
</div>	

<div id="main_list">
	
	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">

	<div id="list">
		
		<?php  $_smarty_tpl->tpl_vars['delivery'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('deliveries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['delivery']->key => $_smarty_tpl->tpl_vars['delivery']->value){
?>
		<div class="<?php if (!$_smarty_tpl->getVariable('delivery')->value->enabled){?>invisible<?php }?> row">
			<input type="hidden" name="positions[<?php echo $_smarty_tpl->getVariable('delivery')->value->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('delivery')->value->position;?>
">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="<?php echo $_smarty_tpl->getVariable('delivery')->value->id;?>
" />				
			</div>
			<div class="name cell">
				<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'DeliveryAdmin','id'=>$_smarty_tpl->getVariable('delivery')->value->id,'return'=>$_SERVER['REQUEST_URI']),$_smarty_tpl);?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('delivery')->value->name);?>
</a>
			</div>
			<div class="icons cell">
				<a class="enable" title="Активен" href="#"></a>
				<a class="delete" title="Удалить" href="#"></a>
			</div>
			<div class="clear"></div>
		</div>
		<?php }} ?>
	</div>

	<div id="action">
	<label id="check_all" class='dash_link'>Выбрать все</label>

	<span id="select">
	<select name="action">
		<option value="enable">Включить</option>
		<option value="disable">Выключить</option>
		<option value="delete">Удалить</option>
	</select>
	</span>

	<input id="apply_action" class="button_green" type="submit" value="Применить">
	
	</div>
	</form>

</div>


<script>
$(function() {

	// Сортировка списка
	$("#list").sortable({
		items:             ".row",
		tolerance:         "pointer",
		handle:            ".move_zone",
		scrollSensitivity: 40,
		opacity:           0.7, 
		forcePlaceholderSize: true,
		axis: 'y',
		
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
			data: {'object': 'delivery', 'id': id, 'values': {'enabled': state}, 'session_id': '<?php echo $_SESSION['id'];?>
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
	
	$("form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});


});

</script>

