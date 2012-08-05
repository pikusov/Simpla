{* Вкладки *}
{capture name=tabs}
	<li {if $status===0}class="active"{/if}><a href="{url module=OrdersAdmin status=0 keyword=null id=null page=null}">Новые</a></li>
	<li {if $status==1}class="active"{/if}><a href="{url module=OrdersAdmin status=1 keyword=null id=null page=null}">Приняты</a></li>
	<li {if $status==2}class="active"{/if}><a href="{url module=OrdersAdmin status=2 keyword=null id=null page=null}">Выполнены</a></li>
	<li {if $status==3}class="active"{/if}><a href="{url module=OrdersAdmin status=3 keyword=null id=null page=null}">Удалены</a></li>
	{if $keyword}
	<li class="active"><a href="{url module=OrdersAdmin keyword=$keyword id=null}">Поиск</a></li>
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
	 				<a href="{url module=OrderAdmin id=$order->id return=$smarty.server.REQUEST_URI}">Заказ №{$order->id}</a> {$order->name|escape}
	 				{if $order->note}
	 				<div class="note">{$order->note|escape}</div>
	 				{/if} 	 			
				</div>
				<div class="icons cell">
					<a href='#' class=delete></a>
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
			<option value="delete">Удалить</option>
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


{* On document load *}
{literal}
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

	// Подтверждение удаления
	$("form").submit(function() {
		if($('#list input[type="checkbox"][name*="check"]:checked').length>0)
			if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
				return false;	
	});
});

</script>
{/literal}
