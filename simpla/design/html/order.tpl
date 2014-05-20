{* Вкладки *}
{capture name=tabs}
	{if in_array('orders', $manager->permissions)}
		<li {if $order->status==0}class="active"{/if}><a href="index.php?module=OrdersAdmin&status=0">Новые</a></li>
		<li {if $order->status==1}class="active"{/if}><a href="index.php?module=OrdersAdmin&status=1">Приняты</a></li>
		<li {if $order->status==2}class="active"{/if}><a href="index.php?module=OrdersAdmin&status=2">Выполнены</a></li>
		<li {if $order->status==3}class="active"{/if}><a href="index.php?module=OrdersAdmin&status=3">Удалены</a></li>
	{if $keyword}
	<li class="active"><a href="{url module=OrdersAdmin keyword=$keyword id=null label=null}">Поиск</a></li>
	{/if}
	{/if}
	{if in_array('labels', $manager->permissions)}
	<li><a href="{url module=OrdersLabelsAdmin keyword=null id=null page=null label=null}">Метки</a></li>
	{/if}
{/capture}


{if $order->id}
{$meta_title = "Заказ №`$order->id`" scope=parent}
{else}
{$meta_title = 'Новый заказ' scope=parent}
{/if}

<!-- Основная форма -->
<form method=post id=order enctype="multipart/form-data">
<input type=hidden name="session_id" value="{$smarty.session.id}">

<div id="name">
	<input name=id type="hidden" value="{$order->id|escape}"/> 
	<h1>{if $order->id}Заказ №{$order->id|escape}{else}Новый заказ{/if}
	<select class=status name="status">
		<option value='0' {if $order->status == 0}selected{/if}>Новый</option>
		<option value='1' {if $order->status == 1}selected{/if}>Принят</option>
		<option value='2' {if $order->status == 2}selected{/if}>Выполнен</option>
		<option value='3' {if $order->status == 3}selected{/if}>Удален</option>
	</select>
	</h1>
	<a href="{url view=print id=$order->id}" target="_blank"><img src="./design/images/printer.png" name="export" title="Печать заказа"></a>


	<div id=next_order>
		{if $prev_order}
		<a class=prev_order href="{url id=$prev_order->id}">←</a>
		{/if}
		{if $next_order}
		<a class=next_order href="{url id=$next_order->id}">→</a>
		{/if}
	</div>
		
</div> 


{if $message_error}
<!-- Системное сообщение -->
<div class="message message_error">
	<span>{if $message_error=='error_closing'}Нехватка товара на складе{else}{$message_error|escape}{/if}</span>
	{if $smarty.get.return}
	<a class="button" href="{$smarty.get.return}">Вернуться</a>
	{/if}
</div>
<!-- Системное сообщение (The End)-->
{elseif $message_success}
<!-- Системное сообщение -->
<div class="message message_success">
	<span>{if $message_success=='updated'}Заказ обновлен{elseif $message_success=='added'}Заказ добавлен{else}{$message_success}{/if}</span>
	{if $smarty.get.return}
	<a class="button" href="{$smarty.get.return}">Вернуться</a>
	{/if}
</div>
<!-- Системное сообщение (The End)-->
{/if}



<div id="order_details">
	<h2>Детали заказа <a href='#' class="edit_order_details"><img src='design/images/pencil.png' alt='Редактировать' title='Редактировать'></a></h2>
	
	<div id="user">
	<ul class="order_details">
		<li>
			<label class=property>Дата</label>
			<div class="edit_order_detail view_order_detail">
			{$order->date} {$order->time}
			</div>
		</li>
		<li>
			<label class=property>Имя</label> 
			<div class="edit_order_detail" style='display:none;'>
				<input name="name" class="simpla_inp" type="text" value="{$order->name|escape}" />
			</div>
			<div class="view_order_detail">
				{$order->name|escape}
			</div>
		</li>
		<li>
			<label class=property>Email</label>
			<div class="edit_order_detail" style='display:none;'>
				<input name="email" class="simpla_inp" type="text" value="{$order->email|escape}" />
			</div>
			<div class="view_order_detail">
				<a href="mailto:{$order->email|escape}?subject=Заказ%20№{$order->id}">{$order->email|escape}</a>
			</div>
		</li>
		<li>
			<label class=property>Телефон</label>
			<div class="edit_order_detail" style='display:none;'>
				<input name="phone" class="simpla_inp " type="text" value="{$order->phone|escape}" />
			</div>
			<div class="view_order_detail">
				{if $order->phone}
				<span class="ip_call" data-phone="{$order->phone|escape}" target="_blank">{$order->phone|escape}</span>{else}{$order->phone|escape}{/if}
			</div>
		</li>
		<li>
			<label class=property>Адрес <a href='http://maps.yandex.ru/' id=address_link target=_blank><img align=absmiddle src='design/images/map.png' alt='Карта в новом окне' title='Карта в новом окне'></a></label>
			<div class="edit_order_detail" style='display:none;'>
				<textarea name="address">{$order->address|escape}</textarea>
			</div>
			<div class="view_order_detail">
				{$order->address|escape}
			</div>
		</li>
		<li>
			<label class=property>Комментарий пользователя</label>
			<div class="edit_order_detail" style='display:none;'>
			<textarea name="comment">{$order->comment|escape}</textarea>
			</div>
			<div class="view_order_detail">
				{$order->comment|escape|nl2br}
			</div>
		</li>
	</ul>
	</div>

	
	{if $labels}
	<div class='layer'>
	<h2>Метка</h2>
	<!-- Метки -->
	<ul>
		{foreach $labels as $l}
		<li>
		<label for="label_{$l->id}">
		<input id="label_{$l->id}" type="checkbox" name="order_labels[]" value="{$l->id}" {if in_array($l->id, $order_labels)}checked{/if}>
		<span style="background-color:#{$l->color};" class="order_label"></span>
		{$l->name}
		</label>
		</li>
		{/foreach}
	</ul>
	<!-- Метки -->
	</div>
	{/if}

	
	<div class='layer'>
	<h2>Покупатель <a href='#' class="edit_user"><img src='design/images/pencil.png' alt='Редактировать' title='Редактировать'></a> {if $user}<a href="#" class='delete_user'><img src='design/images/delete.png' alt='Удалить' title='Удалить'></a>{/if}</h2>
		<div class='view_user'>
		{if !$user}
			Не зарегистрирован
		{else}
			<a href='index.php?module=UserAdmin&id={$user->id}' target=_blank>{$user->name|escape}</a> ({$user->email|escape})
		{/if}
		</div>
		<div class='edit_user' style='display:none;'>
		<input type=hidden name=user_id value='{$user->id}'>
		<input type=text id='user' class="input_autocomplete" placeholder="Выберите пользователя">
		</div>
	</div>
	

	
	<div class='layer'>
	<h2>Примечание <a href='#' class="edit_note"><img src='design/images/pencil.png' alt='Редактировать' title='Редактировать'></a></h2>
	<ul class="order_details">
		<li>
			<div class="edit_note" style='display:none;'>
				<label class=property>Ваше примечание (не видно пользователю)</label>
				<textarea name="note">{$order->note|escape}</textarea>
			</div>
			<div class="view_note" {if !$order->note}style='display:none;'{/if}>
				<label class=property>Ваше примечание (не видно пользователю)</label>
				<div class="note_text">{$order->note|escape}</div>
			</div>
		</li>
	</ul>
	</div>
		
</div>


<div id="purchases">
 
	<div id="list" class="purchases">
		{foreach from=$purchases item=purchase}
		<div class="row">
			<div class="image cell">
				<input type=hidden name=purchases[id][{$purchase->id}] value='{$purchase->id}'>
				{$image = $purchase->product->images|first}
				{if $image}
				<img class=product_icon src='{$image->filename|resize:35:35}'>
				{/if}
			</div>
			<div class="purchase_name cell">
			
				<div class='purchase_variant'>				
				<span class=edit_purchase style='display:none;'>
				<select name=purchases[variant_id][{$purchase->id}] {if $purchase->product->variants|count==1 && $purchase->variant_name == '' && $purchase->variant->sku == ''}style='display:none;'{/if}>					
		    	{if !$purchase->variant}<option price='{$purchase->price}' amount='{$purchase->amount}' value=''>{$purchase->variant_name|escape} {if $purchase->sku}(арт. {$purchase->sku}){/if}</option>{/if}
				{foreach $purchase->product->variants as $v}
					{if $v->stock>0 || $v->id == $purchase->variant->id}
					<option price='{$v->price}' amount='{$v->stock}' value='{$v->id}' {if $v->id == $purchase->variant_id}selected{/if} >
					{$v->name}
					{if $v->sku}(арт. {$v->sku}){/if}
					</option>
					{/if}
				{/foreach}
				</select>
				</span>
				<span class=view_purchase>
					{$purchase->variant_name} {if $purchase->sku}(арт. {$purchase->sku}){/if}			
				</span>
				</div>
		
				{if $purchase->product}
				<a class="related_product_name" href="index.php?module=ProductAdmin&id={$purchase->product->id}&return={$smarty.server.REQUEST_URI|urlencode}">{$purchase->product_name}</a>
				{else}
				{$purchase->product_name}				
				{/if}
			</div>
			<div class="price cell">
				<span class=view_purchase>{$purchase->price}</span>
				<span class=edit_purchase style='display:none;'>
				<input type=text name=purchases[price][{$purchase->id}] value='{$purchase->price}' size=5>
				</span>
				{$currency->sign}
			</div>
			<div class="amount cell">			
				<span class=view_purchase>
					{$purchase->amount} {$settings->units}
				</span>
				<span class=edit_purchase style='display:none;'>
					{if $purchase->variant}
					{math equation="min(max(x,y),z)" x=$purchase->variant->stock+$purchase->amount*($order->closed) y=$purchase->amount z=$settings->max_order_amount assign="loop"}
					{else}
					{math equation="x" x=$purchase->amount assign="loop"}
					{/if}
			        <select name=purchases[amount][{$purchase->id}]>
						{section name=amounts start=1 loop=$loop+1 step=1}
							<option value="{$smarty.section.amounts.index}" {if $purchase->amount==$smarty.section.amounts.index}selected{/if}>{$smarty.section.amounts.index} {$settings->units}</option>
						{/section}
			        </select>
				</span>			
			</div>
			<div class="icons cell">		
				{if !$order->closed}
					{if !$purchase->product}
					<img src='design/images/error.png' alt='Товар был удалён' title='Товар был удалён' >
					{elseif !$purchase->variant}
					<img src='design/images/error.png' alt='Вариант товара был удалён' title='Вариант товара был удалён' >
					{elseif $purchase->variant->stock < $purchase->amount}
					<img src='design/images/error.png' alt='На складе остал{$purchase->variant->stock|plural:'ся':'ось'} {$purchase->variant->stock} товар{$purchase->variant->stock|plural:'':'ов':'а'}' title='На складе остал{$purchase->variant->stock|plural:'ся':'ось'} {$purchase->variant->stock} товар{$purchase->variant->stock|plural:'':'ов':'а'}'  >
					{/if}
				{/if}
				<a href='#' class="delete" title="Удалить"></a>		
			</div>
			<div class="clear"></div>
		</div>
		{/foreach}
		<div id="new_purchase" class="row" style='display:none;'>
			<div class="image cell">
				<input type=hidden name=purchases[id][] value=''>
				<img class=product_icon src=''>
			</div>
			<div class="purchase_name cell">
				<div class='purchase_variant'>				
					<select name=purchases[variant_id][] style='display:none;'></select>
				</div>
				<a class="purchase_name" href=""></a>
			</div>
			<div class="price cell">
				<input type=text name=purchases[price][] value='' size=5> {$currency->sign}
			</div>
			<div class="amount cell">
	        	<select name=purchases[amount][]></select>
			</div>
			<div class="icons cell">
				<a href='#' class="delete" title="Удалить"></a>	
			</div>
			<div class="clear"></div>
		</div>
	</div>

 	<div id="add_purchase" {if $purchases}style='display:none;'{/if}>
 		<input type=text name=related id='add_purchase' class="input_autocomplete" placeholder='Выберите товар чтобы добавить его'>
 	</div>
	{if $purchases}
	<a href='#' class="dash_link edit_purchases">редактировать покупки</a>
	{/if}


	{if $purchases}
	<div class="subtotal">
	Всего<b> {$subtotal} {$currency->sign}</b>
	</div>
	{/if}

	<div class="block discount layer">
		<h2>Скидка</h2>
		<input type=text name=discount value='{$order->discount}'> <span class=currency>%</span>		
	</div>

	<div class="subtotal layer">
	С учетом скидки<b> {($subtotal-$subtotal*$order->discount/100)|round:2} {$currency->sign}</b>
	</div> 
	
	<div class="block discount layer">
		<h2>Купон{if $order->coupon_code} ({$order->coupon_code}){/if}</h2>
		<input type=text name=coupon_discount value='{$order->coupon_discount}'> <span class=currency>{$currency->sign}</span>		
	</div>

	<div class="subtotal layer">
	С учетом купона<b> {($subtotal-$subtotal*$order->discount/100-$order->coupon_discount)|round:2} {$currency->sign}</b>
	</div> 
	
	<div class="block delivery">
		<h2>Доставка</h2>
				<select name="delivery_id">
				<option value="0">Не выбрана</option>
				{foreach $deliveries as $d}
				<option value="{$d->id}" {if $d->id==$delivery->id}selected{/if}>{$d->name}</option>
				{/foreach}
				</select>	
				<input type=text name=delivery_price value='{$order->delivery_price}'> <span class=currency>{$currency->sign}</span>
				<div class="separate_delivery">
					<input type=checkbox id="separate_delivery" name=separate_delivery value='1' {if $order->separate_delivery}checked{/if}> <label  for="separate_delivery">оплачивается отдельно</label>
				</div>
	</div>

	<div class="total layer">
	Итого<b> {$order->total_price} {$currency->sign}</b>
	</div>
		
		
	<div class="block payment">
		<h2>Оплата</h2>
				<select name="payment_method_id">
				<option value="0">Не выбрана</option>
				{foreach $payment_methods as $pm}
				<option value="{$pm->id}" {if $pm->id==$payment_method->id}selected{/if}>{$pm->name}</option>
				{/foreach}
				</select>
		
		<input type=checkbox name="paid" id="paid" value="1" {if $order->paid}checked{/if}> <label for="paid" {if $order->paid}class="green"{/if}>Заказ оплачен</label>		
	</div>

 
	{if $payment_method}
	<div class="subtotal layer">
	К оплате<b> {$order->total_price|convert:$payment_currency->id} {$payment_currency->sign}</b>
	</div>
	{/if}


	<div class="block_save">
	<input type="checkbox" value="1" id="notify_user" name="notify_user">
	<label for="notify_user">Уведомить покупателя о состоянии заказа</label>

	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	</div>


</div>


</form>
<!-- Основная форма (The End) -->


{* On document load *}
{literal}
<script src="design/js/autocomplete/jquery.autocomplete-min.js"></script>

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
	
	// Удаление товара
	$(".purchases a.delete").live('click', function() {
		 $(this).closest(".row").fadeOut(200, function() { $(this).remove(); });
		 return false;
	});
 

	// Добавление товара 
	var new_purchase = $('.purchases #new_purchase').clone(true);
	$('.purchases #new_purchase').remove().removeAttr('id');

	$("input#add_purchase").autocomplete({
  	serviceUrl:'ajax/add_order_product.php',
  	minChars:0,
  	noCache: false, 
  	onSelect:
  		function(suggestion){
  			new_item = new_purchase.clone().appendTo('.purchases');
  			new_item.removeAttr('id');
  			new_item.find('a.purchase_name').html(suggestion.data.name);
  			new_item.find('a.purchase_name').attr('href', 'index.php?module=ProductAdmin&id='+suggestion.data.id);
  			
  			// Добавляем варианты нового товара
  			var variants_select = new_item.find('select[name*=purchases][name*=variant_id]');
			for(var i in suggestion.data.variants)
  				variants_select.append("<option value='"+suggestion.data.variants[i].id+"' price='"+suggestion.data.variants[i].price+"' amount='"+suggestion.data.variants[i].stock+"'>"+suggestion.data.variants[i].name+"</option>");
  			
  			if(suggestion.data.variants.length>1 || suggestion.data.variants[0].name != '')
  				variants_select.show();
  				  				
			variants_select.bind('change', function(){change_variant(variants_select);});
				change_variant(variants_select);
  			
  			if(suggestion.data.image)
  				new_item.find('img.product_icon').attr("src", suggestion.data.image);
  			else
  				new_item.find('img.product_icon').remove();

			$("input#add_purchase").val('').focus().blur(); 
  			new_item.show();
  		},
		formatResult:
			function(suggestion, currentValue){
				var reEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
				var pattern = '(' + currentValue.replace(reEscape, '\\$1') + ')';
  				return (suggestion.data.image?"<img align=absmiddle src='"+suggestion.data.image+"'> ":'') + suggestion.value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');
			}
  		
  });
  
  // Изменение цены и макс количества при изменении варианта
  function change_variant(element)
  {
		price = element.find('option:selected').attr('price');
		amount = element.find('option:selected').attr('amount');
		element.closest('.row').find('input[name*=purchases][name*=price]').val(price);
		
		// 
		amount_select = element.closest('.row').find('select[name*=purchases][name*=amount]');
		selected_amount = amount_select.val();
		amount_select.html('');
		for(i=1; i<=amount; i++)
			amount_select.append("<option value='"+i+"'>"+i+" {/literal}{$settings->units}{literal}</option>");
		amount_select.val(Math.min(selected_amount, amount));


		return false;
  }
  
  
	// Редактировать покупки
	$("a.edit_purchases").click( function() {
		 $(".purchases span.view_purchase").hide();
		 $(".purchases span.edit_purchase").show();
		 $(".edit_purchases").hide();
		 $("div#add_purchase").show();
		 return false;
	});
  
	// Редактировать получателя
	$("div#order_details a.edit_order_details").click(function() {
		 $("ul.order_details .view_order_detail").hide();
		 $("ul.order_details .edit_order_detail").show();
		 return false;
	});
  
	// Редактировать примечание
	$("div#order_details a.edit_note").click(function() {
		 $("div.view_note").hide();
		 $("div.edit_note").show();
		 return false;
	});
  
	// Редактировать пользователя
	$("div#order_details a.edit_user").click(function() {
		 $("div.view_user").hide();
		 $("div.edit_user").show();
		 return false;
	});
	$("input#user").autocomplete({
		serviceUrl:'ajax/search_users.php',
		minChars:0,
		noCache: false, 
		onSelect:
			function(suggestion){
				$('input[name="user_id"]').val(suggestion.data.id);
			}
	});
  
	// Удалить пользователя
	$("div#order_details a.delete_user").click(function() {
		$('input[name="user_id"]').val(0);
		$('div.view_user').hide();
		$('div.edit_user').hide();
		return false;
	});

	// Посмотреть адрес на карте
	$("a#address_link").attr('href', 'http://maps.yandex.ru/?text='+$('#order_details textarea[name="address"]').val());
  
	// Подтверждение удаления
	$('select[name*=purchases][name*=variant_id]').bind('change', function(){change_variant($(this));});
	$("input[name='status_deleted']").click(function() {
		if(!confirm('Подтвердите удаление'))
			return false;	
	});

});

</script>

<style>
.autocomplete-suggestions{
background-color: #ffffff;
overflow: hidden;
border: 1px solid #e0e0e0;
overflow-y: auto;
}
.autocomplete-suggestions .autocomplete-suggestion{cursor: default;}
.autocomplete-suggestions .selected { background:#F0F0F0; }
.autocomplete-suggestions div { padding:2px 5px; white-space:nowrap; }
.autocomplete-suggestions strong { font-weight:normal; color:#3399FF; }
</style>
{/literal}

