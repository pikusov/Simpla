<?php /*%%SmartyHeaderCode:6124769734ea42abda4fda6-68645558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '364e9cd2e84b0cdbdf94cfdd6a67bf9c8bf1c5eb' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/login.tpl',
      1 => 1317399941,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6124769734ea42abda4fda6-68645558',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><script src="/js/baloon/js/default.js" language="JavaScript" type="text/javascript"></script>
<script src="/js/baloon/js/validate.js" language="JavaScript" type="text/javascript"></script>
<script src="/js/baloon/js/baloon.js" language="JavaScript" type="text/javascript"></script>
<link  href="/js/baloon/css/baloon.css" rel="stylesheet" type="text/css" /> 

    
<h1>Вход</h1>

<div class="message_error">
	Неверный логин или пароль
	</div>

<form class="form" method="post">
	<label>Email</label>
	<input type="text" name="email" format="email" notice="Введите email" value="qwe@qwe.com" maxlength="255" />

    <label>Пароль (<a href="user/password_remind">напомнить</a>)</label>
    <input type="password" name="password" format=".+" notice="Введите пароль" value="" />

	<input type="submit" class="button_submit" name="login" value="Войти">
</form><?php } ?>