{capture name=tabs}
	{if in_array('settings', $manager->permissions)}<li><a href="index.php?module=SettingsAdmin">Настройки</a></li>{/if}
	<li class="active"><a href="index.php?module=CurrencyAdmin">Валюты</a></li>
	{if in_array('delivery', $manager->permissions)}<li><a href="index.php?module=DeliveriesAdmin">Доставка</a></li>{/if}
	{if in_array('payment', $manager->permissions)}<li><a href="index.php?module=PaymentMethodsAdmin">Оплата</a></li>{/if}
	{if in_array('managers', $manager->permissions)}<li><a href="index.php?module=ManagersAdmin">Менеджеры</a></li>{/if}
{/capture}

{$meta_title = 'Валюты' scope=parent}

{* On document load *}
{literal}
<script src="design/js/jquery/jquery.js"></script>
<script src="design/js/jquery/jquery-ui.min.js"></script>

<script>
$(function() {

	// Сортировка списка
	// Сортировка вариантов
	$("#currencies_block").sortable({ items: 'ul.sortable' , axis: 'y',  cancel: '#header', handle: '.move_zone' });

	// Добавление валюты
	var curr = $('#new_currency').clone(true);
	$('#new_currency').remove().removeAttr('id');
	$('a#add_currency').click(function() {
		$(curr).clone(true).appendTo('#currencies').fadeIn('slow').find("input[name*=currency][name*=name]").focus();
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
			data: {'object': 'currency', 'id': id, 'values': {'enabled': state}, 'session_id': '{/literal}{$smarty.session.id}{literal}'},
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
			data: {'object': 'currency', 'id': id, 'values': {'cents': state}, 'session_id': '{/literal}{$smarty.session.id}{literal}'},
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
	
	// Запоминаем id первой валюты, чтобы определить изменение базовой валюты
	var base_currency_id = $('input[name*="currency[id]"]').val();
	
	$("form").submit(function() {
		if($('input[type="hidden"][name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
		if(base_currency_id != $('input[name*="currency[id]"]:first').val() && confirm('Пересчитать все цены в '+$('input[name*="name"]:first').val()+' по текущему курсу?', 'msgBox Title'))
			$('input[name="recalculate"]').val(1);
	});


});

</script>
{/literal}

		
	<!-- Заголовок -->
	<div id="header">
		<h1>Валюты</h1>
		<a class="add" id="add_currency" href="#">Добавить</a>
	<!-- Заголовок (The End) -->	
	</div>	


	
 
	<form method=post>
	<input type="hidden" name="session_id" value="{$smarty.session.id}">
	
	
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
		{foreach $currencies as $c}
		<ul class="sortable {if !$c->enabled}invisible{/if} {if $c->cents == 2}cents{/if}">
			<li class="move"><div class="move_zone"></div></li>
			<li class="name">
				<input name="currency[id][{$c->id}]" type="hidden" 	value="{$c->id|escape}" /><input name="currency[name][{$c->id}]" type="" value="{$c->name|escape}" />
			</li>
			<li class="icons">
				<a class="cents" href="#" title="Выводить копейки"></a>
				<a class="enable" href="#" title="Показывать на сайте"></a>
			</li>
			<li class="sign">		<input name="currency[sign][{$c->id}]" type="text" 	value="{$c->sign|escape}" /></li>
			<li class="iso">		<input name="currency[code][{$c->id}]" type="text" 	value="{$c->code|escape}" /></li>
			<li class="rate">
				{if !$c@first}
				<div class=rate_from><input name="currency[rate_from][{$c->id}]" type="text" value="{$c->rate_from|escape}" /> {$c->sign}</div>
				<div class=rate_to>= <input name="currency[rate_to][{$c->id}]" type="text" value="{$c->rate_to|escape}" /> {$currency->sign}</div>
				{else}
				<input name="currency[rate_from][{$c->id}]" type="hidden" value="{$c->rate_from|escape}" />
				<input name="currency[rate_to][{$c->id}]" type="hidden" value="{$c->rate_to|escape}" />
				{/if}
			</li>
			<li class="icons">
			{if !$c@first}
				<a class="delete" href="#" title="Удалить"></a>				
			{/if}
			</li>
		</ul>
		{/foreach}		
		<ul id="new_currency" style='display:none;'>
			<li class="move"><div class="move_zone"></div></li>
			<li class="name"><input name="currency[id][]" type="hidden" value="" /><input name="currency[name][]" type="" value="" /></li>
			<li class="icons">
			</li>
			<li class="sign"><input name="currency[sign][]" type="" value="" /></li>
			<li class="iso"><input  name="currency[code][]" type="" value="" /></li>
			<li class="rate">
				<div class=rate_from><input name="currency[rate_from][]" type="text" value="1" /> </div>
				<div class=rate_to>= <input name="currency[rate_to][]" type="text" value="1" /> {$currency->sign|escape}</div>			
			</li>
			<li class="icons">
			
			</li>
		</ul>
		</div>

	</div>
	<!-- Валюты (The End)--> 


	<div id="action">

	<input type=hidden name=recalculate value='0'>
	<input type=hidden name=action value=''>
	<input type=hidden name=action_id value=''>
	<input id='apply_action' class="button_green" type=submit value="Применить">

	
	</div>
	</form>
	
 
