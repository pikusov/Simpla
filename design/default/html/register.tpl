{* Страница регистрации *}

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

<form class="form register_form" method="post">
	<label>Имя</label>
	<input type="text" name="name" data-format=".+" data-notice="Введите имя" value="{$name|escape}" maxlength="255" />
	
	<label>Email</label>
	<input type="text" name="email" data-format="email" data-notice="Введите email" value="{$email|escape}" maxlength="255" />

    <label>Пароль</label>
    <input type="password" name="password" data-format=".+" data-notice="Введите пароль" value="" />

	<input type=submit class="button" name="register" value="Зарегистрироваться">
</form>
