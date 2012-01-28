{* Подключаем js-проверку формы *}
<script src="/js/baloon/js/default.js" language="JavaScript" type="text/javascript"></script>
<script src="/js/baloon/js/validate.js" language="JavaScript" type="text/javascript"></script>
<script src="/js/baloon/js/baloon.js" language="JavaScript" type="text/javascript"></script>
<link  href="/js/baloon/css/baloon.css" rel="stylesheet" type="text/css" /> 

    
{if $email_sent}
<h1>Вам отправлено письмо</h1>

<p>На {$email|escape} отправлено письмо для восстановления пароля.</p>
{else}
<h1>Напоминание пароля</h1>

{if $error}
<div class="message_error">
	{if $error == 'user_not_found'}Пользователь не найден
	{else}{$error}{/if}
</div>
{/if}

<form class="form" method="post">
	<label>Введите email, который вы указывали при регистрации</label>
	<input type="text" name="email" format="email" notice="Введите email" value="{$email|escape}"  maxlength="255"/>
	<input type="submit" class="button_submit" value="Вспомнить" />
</form>
{/if}