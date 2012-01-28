<?php /* Smarty version Smarty-3.0.7, created on 2012-01-08 19:32:58
         compiled from "/Users/denispikusov/Sites/simpla//design/default/html/password_remind.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6632145784f09d34a4356e5-15381233%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ec787a670b99825856384bb1a5d3167ecccfe84' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/password_remind.tpl',
      1 => 1312902732,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6632145784f09d34a4356e5-15381233',
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

    
<?php if ($_smarty_tpl->getVariable('email_sent')->value){?>
<h1>Вам отправлено письмо</h1>

<p>На <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('email')->value);?>
 отправлено письмо для восстановления пароля.</p>
<?php }else{ ?>
<h1>Напоминание пароля</h1>

<?php if ($_smarty_tpl->getVariable('error')->value){?>
<div class="message_error">
	<?php if ($_smarty_tpl->getVariable('error')->value=='user_not_found'){?>Пользователь не найден
	<?php }else{ ?><?php echo $_smarty_tpl->getVariable('error')->value;?>
<?php }?>
</div>
<?php }?>

<form class="form" method="post">
	<label>Введите email, который вы указывали при регистрации</label>
	<input type="text" name="email" format="email" notice="Введите email" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('email')->value);?>
"  maxlength="255"/>
	<input type="submit" class="button_submit" value="Вспомнить" />
</form>
<?php }?>