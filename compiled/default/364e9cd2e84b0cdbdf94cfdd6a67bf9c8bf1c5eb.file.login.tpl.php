<?php /* Smarty version Smarty-3.0.7, created on 2012-01-08 19:31:57
         compiled from "/Users/denispikusov/Sites/simpla//design/default/html/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20376070264f09d30d3174b2-13228292%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '20376070264f09d30d3174b2-13228292',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?>
<script src="/js/baloon/js/default.js" language="JavaScript" type="text/javascript"></script>
<script src="/js/baloon/js/validate.js" language="JavaScript" type="text/javascript"></script>
<script src="/js/baloon/js/baloon.js" language="JavaScript" type="text/javascript"></script>
<link  href="/js/baloon/css/baloon.css" rel="stylesheet" type="text/css" /> 

    
<h1>Вход</h1>

<?php if ($_smarty_tpl->getVariable('error')->value){?>
<div class="message_error">
	<?php if ($_smarty_tpl->getVariable('error')->value=='login_incorrect'){?>Неверный логин или пароль
	<?php }elseif($_smarty_tpl->getVariable('error')->value=='user_disabled'){?>Ваш аккаунт еще не активирован.
	<?php }else{ ?><?php echo $_smarty_tpl->getVariable('error')->value;?>
<?php }?>
</div>
<?php }?>

<form class="form" method="post">
	<label>Email</label>
	<input type="text" name="email" format="email" notice="Введите email" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('email')->value);?>
" maxlength="255" />

    <label>Пароль (<a href="user/password_remind">напомнить</a>)</label>
    <input type="password" name="password" format=".+" notice="Введите пароль" value="" />

	<input type="submit" class="button_submit" name="login" value="Войти">
</form>