<?php /* Smarty version Smarty-3.0.7, created on 2011-10-23 16:09:23
         compiled from "simpla/design/html/currency.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9656074654ea41203e920f8-72831465%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54e53e862570aa2ff8337b325b2dec7706a010f0' => 
    array (
      0 => 'simpla/design/html/currency.tpl',
      1 => 1317210665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9656074654ea41203e920f8-72831465',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php ob_start(); ?>
		<li><a href="index.php?module=SettingsAdmin">Настройки</a></li>
		<li class="active"><a href="index.php?module=CurrencyAdmin">Валюты</a></li>
		<li><a href="index.php?module=DeliveriesAdmin">Доставка</a></li>
		<li><a href="index.php?module=PaymentMethodsAdmin">Оплата</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>

<script src="design/js/jquery/jquery.js"></script>
<script src="design/js/jquery/jquery-ui.min.js"></script>

<script>
$(function() {

	// Сортировка списка
	// Сортировка вариантов
	$("#currencies_block").sortable({ items: 'ul' , axis: 'y',  cancel: '#header', handle: '.move_zone' });

	// Добавление валюты
	var curr = $('#new_currency').clone(true);
	$('#new_currency').remove().removeAttr('id');
	$('a#add_currency').click(function() {
		if(!$('#currencies_block').is('.single_variant'))
		{
			$(curr).clone(true).appendTo('#currencies').fadeIn('slow').find("input[name*=currency][name*=name]").focus();
		}
		else
		{
			$('#currencies_block .variant_name').show('slow');
			$('#currencies_block').removeClass('single_variant');		
		}
		return false;		
	});	
 

	// Скрыт/Видим
	$("a.enable").click(function() {
		var icon        = $(this);
		var line        = icon.closest("ul");
		var id          = line.find('input[name*="currency[id]"]').val();
		var state       = line.hasClass('invisible')?1:0;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'currency', 'id': id, 'values': {'enabled': state}, 'session_id': '<?php echo $_SESSION['id'];?>
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
	
	// Центы
	$("a.cents").click(function() {
		var icon        = $(this);
		var line        = icon.closest("ul");
		var id          = line.find('input[name*="currency[id]"]').val();
		var state       = line.hasClass('cents')?0:2;
		icon.addClass('loading_icon');

		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'currency', 'id': id, 'values': {'cents': state}, 'session_id': '<?php echo $_SESSION['id'];?>
'},
			success: function(data){
				icon.removeClass('loading_icon');
				if(!state)
					line.removeClass('cents');
				else
					line.addClass('cents');				
			},
			error: function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
            },
			dataType: 'json'
		});	
		return false;	
	});
	
	// Показать центы
	$("a.delete").click(function() {
		$('input[type="hidden"][name="action"]').val('delete');
		$('input[type="hidden"][name="action_id"]').val($(this).closest("ul").find('input[type="hidden"][name*="currency[id]"]').val());
		$(this).closest("form").submit();
	});
	
	
	$("form").submit(function() {
		if($('input[type="hidden"][name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});


});

</script>


		
	<!-- Заголовок -->
	<div id="header">
		<h1>Валюты</h1>
		<a class="add" id="add_currency" href="#">Добавить</a>
	<!-- Заголовок (The End) -->	
	</div>	


	
 
	<form method=post>
	<input type="hidden" name="session_id" value="<?php echo $_SESSION['id'];?>
">
	
	
	<!-- Валюты -->
	<div id="currencies_block">
		<ul id="header">
			<li class="move"></li>
			<li class="name">Название валюты</li>	
			<li class="icons"></li>	
			<li class="sign">Знак</li>	
			<li class="iso">Код ISO</li>	
		</ul>
		<div id="currencies">
		<?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('currencies')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['c']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
 $_smarty_tpl->tpl_vars['c']->index++;
 $_smarty_tpl->tpl_vars['c']->first = $_smarty_tpl->tpl_vars['c']->index === 0;
?>
		<ul class="sortable <?php if (!$_smarty_tpl->getVariable('c')->value->enabled){?>invisible<?php }?> <?php if ($_smarty_tpl->getVariable('c')->value->cents==2){?>cents<?php }?>">
			<li class="move"><div class="move_zone"></div></li>
			<li class="name">
				<input name="currency[id][<?php echo $_smarty_tpl->getVariable('c')->value->id;?>
]" type="hidden" 	value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('c')->value->id);?>
" /><input name="currency[name][<?php echo $_smarty_tpl->getVariable('c')->value->id;?>
]" type="" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('c')->value->name);?>
" />
			</li>
			<li class="icons">
				<a class="cents" href="#" title="Выводить копейки"></a>
				<a class="enable" href="#" title="Активна"></a>
			</li>
			<li class="sign">		<input name="currency[sign][<?php echo $_smarty_tpl->getVariable('c')->value->id;?>
]" type="text" 	value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('c')->value->sign);?>
" /></li>
			<li class="iso">		<input name="currency[code][<?php echo $_smarty_tpl->getVariable('c')->value->id;?>
]" type="text" 	value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('c')->value->code);?>
" /></li>
			<li class="rate">
				<?php if (!$_smarty_tpl->tpl_vars['c']->first){?>
				<div class=rate_from><input name="currency[rate_from][<?php echo $_smarty_tpl->getVariable('c')->value->id;?>
]" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('c')->value->rate_from);?>
" /> <?php echo $_smarty_tpl->getVariable('c')->value->sign;?>
</div>
				<div class=rate_to>= <input name="currency[rate_to][<?php echo $_smarty_tpl->getVariable('c')->value->id;?>
]" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('c')->value->rate_to);?>
" /> <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
</div>
				<?php }else{ ?>
				<input name="currency[rate_from][<?php echo $_smarty_tpl->getVariable('c')->value->id;?>
]" type="hidden" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('c')->value->rate_from);?>
" />
				<input name="currency[rate_to][<?php echo $_smarty_tpl->getVariable('c')->value->id;?>
]" type="hidden" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('c')->value->rate_to);?>
" />
				<?php }?>
			</li>
			<li class="icons">
			<?php if (!$_smarty_tpl->tpl_vars['c']->first){?>
				<a class="delete" href="#" title="Удалить"></a>				
			<?php }?>
			</li>
		</ul>
		<?php }} ?>		
		</div>
		<ul id=new_currency style='display:none;'>
			<li class="move"><div class="move_zone"></div></li>
			<li class="name"><input name="currency[id][]" type="hidden" value="" /><input name="currency[name][]" type="" value="" /></li>
			<li class="sign"><input name="currency[sign][]" type="" value="" /></li>
			<li class="iso"><input  name="currency[code][]" type="" value="" /></li>
			<li class="rate">
				<div class=rate_from><input name="currency[rate_from][]" type="text" value="1" /> </div>
				<div class=rate_to>= <input name="currency[rate_to][]" type="text" value="1" /> <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('currency')->value->sign);?>
</div>			
			</li>
			<li class="icons">
			
			</li>
		</ul>

	</div>
	<!-- Валюты (The End)--> 


	<div id="action">

	<input type=hidden name=action value=''>
	<input type=hidden name=action_id value=''>
	<input id='apply_action' class="button_green" type=submit value="Применить">

	
	</div>
	</form>
	
 
