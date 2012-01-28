<?php /* Smarty version Smarty-3.0.7, created on 2011-12-29 17:59:10
         compiled from "/Users/denispikusov/Sites/simpla//design/default/html/cart_informer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12800176354efc8e4e381855-92765491%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8f08a32e1254bc7ed363866826a82df3463c911' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/cart_informer.tpl',
      1 => 1311778380,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12800176354efc8e4e381855-92765491',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php if ($_smarty_tpl->getVariable('cart')->value->total_products>0){?>
	В <a href="./cart/">корзине</a>
	<?php echo $_smarty_tpl->getVariable('cart')->value->total_products;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('cart')->value->total_products,'товар','товаров','товара');?>

	на <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('cart')->value->total_price);?>
 <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('currency')->value->sign);?>

<?php }else{ ?>
	Корзина пуста
<?php }?>
