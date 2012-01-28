{* Подключаем js-проверку формы *}
<script src="/js/baloon/js/default.js" language="JavaScript" type="text/javascript"></script>
<script src="/js/baloon/js/validate.js" language="JavaScript" type="text/javascript"></script>
<script src="/js/baloon/js/baloon.js" language="JavaScript" type="text/javascript"></script>
<link   href="/js/baloon/css/baloon.css" rel="stylesheet" type="text/css" /> 

<h1>Регистрация</h1>

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
	<label>Имя</label>
	<input type="text" name="name" format=".+" notice="Введите имя" value="{$name|escape}" maxlength="255" />
	
	<label>Email</label>
	<input type="text" name="email" format="email" notice="Введите email" value="{$email|escape}" maxlength="255" />

    <label>Пароль</label>
    <input type="password" name="password" format=".+" notice="Введите пароль" value="" />

	<input type=submit class="button_submit" name="register" value="Зарегистрироваться">
</form>
