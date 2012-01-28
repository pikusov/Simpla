<?php /* Smarty version Smarty-3.0.7, created on 2012-01-27 13:19:28
         compiled from "/Users/denispikusov/Sites/simpla//design/default/html/register.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1033178664f229650e89086-88979293%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04c0b361af51cfb8fc5fa45aadddb41542e6172c' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/register.tpl',
      1 => 1316029497,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1033178664f229650e89086-88979293',
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
<link   href="/js/baloon/css/baloon.css" rel="stylesheet" type="text/css" /> 

<h1>Регистрация</h1>

<?php if ($_smarty_tpl->getVariable('error')->value){?>
<div class="message_error">
	<?php if ($_smarty_tpl->getVariable('error')->value=='empty_name'){?>Введите имя
	<?php }elseif($_smarty_tpl->getVariable('error')->value=='empty_email'){?>Введите email
	<?php }elseif($_smarty_tpl->getVariable('error')->value=='empty_password'){?>Введите пароль
	<?php }elseif($_smarty_tpl->getVariable('error')->value=='user_exists'){?>Пользователь с таким email уже зарегистрирован
	<?php }else{ ?><?php echo $_smarty_tpl->getVariable('error')->value;?>
<?php }?>
</div>
<?php }?>

<form class="form" method="post">
	<label>Имя</label>
	<input type="text" name="name" format=".+" notice="Введите имя" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('name')->value);?>
" maxlength="255" />
	
	<label>Email</label>
	<input type="text" name="email" format="email" notice="Введите email" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('email')->value);?>
" maxlength="255" />

    <label>Пароль</label>
    <input type="password" name="password" format=".+" notice="Введите пароль" value="" />

	<input type=submit class="button_submit" name="register" value="Зарегистрироваться">
</form>
