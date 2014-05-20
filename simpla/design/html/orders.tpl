{* Вкладки *}
{capture name=tabs}
	{if in_array('orders', $manager->permissions)}
	<li {if $status===0}class="active"{/if}><a href="{url module=OrdersAdmin status=0 keyword=null id=null page=null label=null}">Новые</a></li>
	<li {if $status==1}class="active"{/if}><a href="{url module=OrdersAdmin status=1 keyword=null id=null page=null label=null}">Приняты</a></li>
	<li {if $status==2}class="active"{/if}><a href="{url module=OrdersAdmin status=2 keyword=null id=null page=null label=null}">Выполнены</a></li>
	<li {if $status==3}class="active"{/if}><a href="{url module=OrdersAdmin status=3 keyword=null id=null page=null label=null}">Удалены</a></li>
	{if $keyword}
	<li class="active"><a href="{url module=OrdersAdmin keyword=$keyword id=null label=null}">Поиск</a></li>
	{/if}
	{/if}
	{if in_array('labels', $manager->permissions)}
	<li><a href="{url module=OrdersLabelsAdmin keyword=null id=null page=null label=null}">Метки</a></li>
	{/if}
{/capture}

{* Title *}
{$meta_title='Заказы' scope=parent}

{* Поиск *}
<form method="get">
<div id="search">
	<input type="hidden" name="module" value="OrdersAdmin">
	<input class="search" type="text" name="keyword" value="{$keyword|escape}"/>
	<input class="search_button" type="submit" value=""/>
</div>
</form>
	
{* Заголовок *}
<div id="header">
	<h1>{if $orders_count}{$orders_count}{else}Нет{/if} заказ{$orders_count|plural:'':'ов':'а'}</h1>		
	<a class="add" href="{url module=OrderAdmin}">Добавить заказ</a>
</div>	

{if $message_error}
<!-- Системное сообщение -->
<div class="message message_error">
	<span>{if $message_error=='error_closing'}Нехватка некоторых товаров на складе{else}{$message_error|escape}{/if}</span>
	{if $smarty.get.return}
	<a class="button" href="{$smarty.get.return}">Вернуться</a>
	{/if}
</div>
{/if}

{if $orders}
<div id="main_list">
	
	<!-- Листалка страниц -->
	{include file='pagination.tpl'}	
	<!-- Листалка страниц (The End) -->
	
	<form id="form_list" method="post">
	<input type="hidden" name="session_id" value="{$smarty.session.id}">

		<div id="list">		
			{foreach $orders as $order}
			<div class="{if $order->paid}green{/if} row">
		 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="{$order->id}"/>				
				</div>
				<div class="order_date cell">				 	
	 				{$order->date|date} в {$order->date|time}
				</div>
				<div class="order_name cell">
					{foreach $order->labels as $l}
					<span class="order_label" style="background-color:#{$l->color};" title="{$l->name}"></span>
					{/foreach}
	 				<a href="{url module=OrderAdmin id=$order->id return=$smarty.server.REQUEST_URI}">Заказ №{$order->id}</a> {$order->name|escape}
	 				{if $order->note}
	 				<div class="note">{$order->note|escape}</div>
	 				{/if} 	 			
				</div>
				<div class="icons cell">
					<a href='{url module=OrderAdmin id=$order->id view=print}'  target="_blank" class="print" title="Печать заказа"></a>
					<a href='#' class=delete title="Удалить"></a>
				</div>
				<div class="name cell" style='white-space:nowrap;'>
	 				{$order->total_price|escape} {$currency->sign}
				</div>
				<div class="icons cell">
					{if $order->paid}
						<img src='design/images/cash_stack.png' alt='Оплачен' title='Оплачен'>
					{else}
						<img src='design/images/cash_stack_gray.png' alt='Не оплачен' title='Не оплачен'>				
					{/if}			 	
				</div>
				{if $keyword}
				<div class="icons cell">
						{if $order->status == 0}
						<img src='design/images/new.png' alt='Новый' title='Новый'>
						{/if}
						{if $order->status == 1}
						<img src='design/images/time.png' alt='Принят' title='Принят'>
						{/if}
						{if $order->status == 2}
						<img src='design/images/tick.png' alt='Выполнен' title='Выполнен'>
						{/if}
						{if $order->status == 3}
						<img src='design/images/cross.png' alt='Удалён' title='Удалён'>
						{/if}
				</div>
				{/if}
				<div class="clear"></div>
			</div>
			{/foreach}
		</div>
	
		<div id="action">
		<label id='check_all' class="dash_link">Выбрать все</label>
	
		<span id="select">
		<select name="action">
			{if $status!==0}<option value="set_status_0">В новые</option>{/if}
			{if $status!==1}<option value="set_status_1">В принятые</option>{/if}
			{if $status!==2}<option value="set_status_2">В выполненные</option>{/if}
			{foreach $labels as $l}
			<option value="set_label_{$l->id}">Отметить &laquo;{$l->name}&raquo;</option>
			{/foreach}
			{foreach $labels as $l}
			<option value="unset_label_{$l->id}">Снять &laquo;{$l->name}&raquo;</option>
			{/foreach}
			<option value="delete">Удалить выбранные заказы</option>
		</select>
		</span>
	
		<input id="apply_action" class="button_green" type="submit" value="Применить">
		
		</div>
	</form>
	
	<!-- Листалка страниц -->
	{include file='pagination.tpl'}	
	<!-- Листалка страниц (The End) -->
		
</div>
{/if}

<!-- Меню -->
<div id="right_menu">
	
	{if $labels}
	<!-- Метки -->
	<ul id="labels">
		<li {if !$label}class="selected"{/if}><span class="label"></span> <a href="{url label=null}">Все заказы</a></li>
		{foreach $labels as $l}
		<li data-label-id="{$l->id}" {if $label->id==$l->id}class="selected"{/if}>
		<span style="background-color:#{$l->color};" class="order_label"></span>
		<a href="{url label=$l->id}">{$l->name}</a></li>
		{/foreach}
	</ul>
	<!-- Метки -->
	{/if}
	
</div>
<!-- Меню  (The End) -->



{* On document load *}
{literal}
<script>

$(function() {

	// Сортировка списка
	$("#labels").sortable({
		items:             "li",
		tolerance:         "pointer",
		scrollSensitivity: 40,
		opacity:           0.7
	});
	

	$("#main_list #list .row").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			label_id = $(ui.helper).attr('data-label-id');
			$(this).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(this).closest("form").find('select[name="action"] option[value=set_label_'+label_id+']').attr("selected", "selected");		
			$(this).closest("form").submit();
			return false;	
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
		$('#list input[type="checkbox"][name*="check"]').attr('checked', $('#list input[type="checkbox"][name*="check"]:not(:checked)').length>0);
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
{/literal}
