<h1>{$user->name|escape}</h1>

{if $error}
<div class="message_error">
	{if $error == 'empty_name'}Введите имя
	{elseif $error == 'empty_email'}Введите email
	{elseif $error == 'empty_password'}Введите пароль
	{elseif $error == 'user_exists'}Пользователь с таким email уже зарегистрирован
	{else}{$error}{/if}
</div>
{/if}

<form class="form" method="post">
	<label>Имя, фамилия</label>
	<input format=".+" notice="Введите имя" value="{$name|escape}" name="name" maxlength="255" type="text"/>
 
	<label>Email</label>
	<input format="email" notice="Введите email" value="{$email|escape}" name="email" maxlength="255" type="text"/></td>
	
	<label> <a href='#' onclick="$('#password').show();return false;">Изменить пароль</a></label>
	<input id="password" value="" name="password" type="password" style="display:none;"/>
	<input type="submit" class="button_submit" value="Сохранить">
</form>

{if $orders}
<h2>Ваши заказы</h2>
<ul id="orders_history">
{foreach name=orders item=order from=$orders}
	<li>
	{$order->date|date} <a href='order/{$order->url}'>Заказ №{$order->id}</a>
	{if $order->paid == 1}оплачен,{/if} 
	{if $order->status == 0}ждет обработки{elseif $order->status == 1}в обработке{elseif $order->status == 2}выполнен{/if}
	</li>
{/foreach}
</ul>
{/if}