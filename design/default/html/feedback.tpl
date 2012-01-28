<h1>{$page->name|escape}</h1>

{$page->body}

<h2>Обратная связь</h2>

{if $message_sent}
	{$name|escape}, ваше сообщение отправлено.
{else}
<form class="form feedback_form" method="post">
	{if $error}
	<div class="message_error">
		{if $error=='captcha'}
		Неверно введена капча
		{elseif $error=='empty_name'}
		Введите имя
		{elseif $error=='empty_email'}
		Введите email
		{elseif $error=='empty_text'}
		Введите сообщение
		{/if}
	</div>
	{/if}
	<label>Имя</label>
	<input data-format=".+" data-notice="Введите имя" value="{$name|escape}" name="name" maxlength="255" type="text"/>
 
	<label>Email</label>
	<input data-format="email" data-notice="Введите email" value="{$email|escape}" name="email" maxlength="255" type="text"/></td>
	
	<label>Сообщение</label>
	<textarea data-format=".+" data-notice="Введите сообщение" value="{$message|escape}" name="message">{$message|escape}</textarea></td>

	<div class="captcha"><img src="captcha/image.php?{math equation='rand(10,10000)'}"/></div> 
	<input class="input_captcha" id="comment_captcha" type="text" name="captcha_code" value="" format="\d\d\d\d" notice="Введите капчу"/>
	
	<input class="button_send" type="submit" name="feedback" value="Отправить" />
</form>
{/if}