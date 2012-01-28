<?php /* Smarty version Smarty-3.0.7, created on 2012-01-05 03:10:40
         compiled from "/Users/denispikusov/Sites/simpla//design/default/html/page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1587656354f04f890441a38-86834319%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1deadb387c7800a5643584e86602fcabccf77d89' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/page.tpl',
      1 => 1325115329,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1587656354f04f890441a38-86834319',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?>

<!-- Заголовок страницы -->
<h1 data-page="<?php echo $_smarty_tpl->getVariable('page')->value->id;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('page')->value->header);?>
</h1>

<!-- Тело страницы -->
<?php echo $_smarty_tpl->getVariable('page')->value->body;?>

