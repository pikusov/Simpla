{* Подключаем js-проверку формы *}
<script src="/js/baloon/js/default.js" language="JavaScript" type="text/javascript"></script>
<script src="/js/baloon/js/validate.js" language="JavaScript" type="text/javascript"></script>
<script src="/js/baloon/js/baloon.js" language="JavaScript" type="text/javascript"></script>
<link  href="/js/baloon/css/baloon.css" rel="stylesheet" type="text/css" /> 

    
<h1>Вход</h1>

{if $error}
<div class="message_error">
	{if $error == 'login_incorrect'}Неверный логин или пароль
	{elseif $error == 'user_disabled'}Ваш аккаунт еще не активирован.
	{else}{$error}{/if}
</div>
{/if}

<form class="form" method="post">
	<label>Email</label>
	<input type="text" name="email" format="email" notice="Введите email" value="{$email|escape}" maxlength="255" />

    <label>Пароль (<a href="user/password_remind">напомнить</a>)</label>
    <input type="password" name="password" format=".+" notice="Введите пароль" value="" />

	<input type="submit" class="button_submit" name="login" value="Войти">
</form>