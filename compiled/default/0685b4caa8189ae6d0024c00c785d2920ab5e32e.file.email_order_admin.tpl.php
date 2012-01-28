<?php /* Smarty version Smarty-3.0.7, created on 2012-01-18 15:28:08
         compiled from "/Users/denispikusov/Sites/simpla/simpla/design/html/email_order_admin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6963832284f16c8e8c9b878-33369032%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0685b4caa8189ae6d0024c00c785d2920ab5e32e' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla/simpla/design/html/email_order_admin.tpl',
      1 => 1321659147,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6963832284f16c8e8c9b878-33369032',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php if ($_smarty_tpl->getVariable('order')->value->paid){?>
<?php $_smarty_tpl->tpl_vars['subject'] = new Smarty_variable("Заказ №".($_smarty_tpl->getVariable('order')->value->id)." оплачен", null, 1);?>
<?php }else{ ?>
<?php $_smarty_tpl->tpl_vars['subject'] = new Smarty_variable("Новый заказ №".($_smarty_tpl->getVariable('order')->value->id), null, 1);?>
<?php }?>
<h1 style="font-weight:normal;font-family:arial;">
	<a href="<?php echo $_smarty_tpl->getVariable('config')->value->root_url;?>
/simpla/index.php?module=OrderAdmin&id=<?php echo $_smarty_tpl->getVariable('order')->value->id;?>
">Заказ №<?php echo $_smarty_tpl->getVariable('order')->value->id;?>
</a>
	на сумму <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('order')->value->total_price,$_smarty_tpl->getVariable('main_currency')->value->id);?>
&nbsp;<?php echo $_smarty_tpl->getVariable('main_currency')->value->sign;?>

	<?php if ($_smarty_tpl->getVariable('order')->value->paid==1){?>оплачен<?php }else{ ?>еще не оплачен<?php }?>,
	<?php if ($_smarty_tpl->getVariable('order')->value->status==0){?>ждет обработки<?php }elseif($_smarty_tpl->getVariable('order')->value->status==1){?>в обработке<?php }elseif($_smarty_tpl->getVariable('order')->value->status==2){?>выполнен<?php }?>	
</h1>
<table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
	<tr>
		<td style="padding:6px; width:170; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">
			Статус
		</td>
		<td style="padding:6px; width:330; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php if ($_smarty_tpl->getVariable('order')->value->status==0){?>
				ждет обработки      
			<?php }elseif($_smarty_tpl->getVariable('order')->value->status==1){?>
				в обработке
			<?php }elseif($_smarty_tpl->getVariable('order')->value->status==2){?>
				выполнен
			<?php }?>
		</td>
	</tr>
	<tr>
		<td style="padding:6px; width:170; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">
			Оплата
		</td>
		<td style="padding:6px; width:330; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php if ($_smarty_tpl->getVariable('order')->value->paid==1){?>
			<font color="green">оплачен</font>
			<?php }else{ ?>
			не оплачен
			<?php }?>
		</td>
	</tr>
	<?php if ($_smarty_tpl->getVariable('order')->value->name){?>
	<tr>
		<td style="padding:6px; width:170; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">
			Имя, фамилия
		</td>
		<td style="padding:6px; width:330; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->name);?>

			<?php if ($_smarty_tpl->getVariable('user')->value){?>(<a href="<?php echo $_smarty_tpl->getVariable('config')->value->root_url;?>
/simpla/index.php?module=UserAdmin&id=<?php echo $_smarty_tpl->getVariable('user')->value->id;?>
">зарегистрированный пользователь</a>)<?php }?>
		</td>
	</tr>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('order')->value->email){?>
	<tr>
		<td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">
			Email
		</td>
		<td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->email);?>

		</td>
	</tr>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('order')->value->phone){?>
	<tr>
		<td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">
			Телефон
		</td>
		<td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->phone);?>

		</td>
	</tr>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('order')->value->address){?>
	<tr>
		<td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">
			Адрес доставки
		</td>
		<td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->address);?>

		</td>
	</tr>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('order')->value->comment){?>
	<tr>
		<td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">
			Комментарий
		</td>
		<td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php echo nl2br(smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->comment));?>

		</td>
	</tr>
	<?php }?>
	<tr>
		<td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">
			Дата
		</td>
		<td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->getVariable('order')->value->date);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->getVariable('order')->value->date);?>

		</td>
	</tr>
</table>

<h1 style="font-weight:normal;font-family:arial;">Покупатель заказал:</h1>

<table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">

	<?php  $_smarty_tpl->tpl_vars['purchase'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('purchases')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['purchase']->key => $_smarty_tpl->tpl_vars['purchase']->value){
?>
	<tr>
		<td align="center" style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php $_smarty_tpl->tpl_vars['image'] = new Smarty_variable($_smarty_tpl->getVariable('purchase')->value->product->images[0], null, null);?>
			<a href="<?php echo $_smarty_tpl->getVariable('config')->value->root_url;?>
/products/<?php echo $_smarty_tpl->getVariable('purchase')->value->product->url;?>
"><img border="0" src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('image')->value->filename,50,50);?>
"></a>
		</td>
		<td style="padding:6px; width:250; padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">
			<a href="<?php echo $_smarty_tpl->getVariable('config')->value->root_url;?>
/products/<?php echo $_smarty_tpl->getVariable('purchase')->value->product->url;?>
"><?php echo $_smarty_tpl->getVariable('purchase')->value->product_name;?>
</a>
			<?php echo $_smarty_tpl->getVariable('purchase')->value->variant_name;?>

		</td>
		<td align=right style="padding:6px; text-align:right; width:150; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php echo $_smarty_tpl->getVariable('purchase')->value->amount;?>
 <?php echo $_smarty_tpl->getVariable('settings')->value->units;?>
 &times; <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('purchase')->value->price,$_smarty_tpl->getVariable('main_currency')->value->id);?>
&nbsp;<?php echo $_smarty_tpl->getVariable('main_currency')->value->sign;?>

		</td>
	</tr>
	<?php }} ?>
	
	<?php if ($_smarty_tpl->getVariable('order')->value->discount){?>
	<tr>
		<td style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;"></td>
		<td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">
			Скидка
		</td>
		<td align=right style="padding:6px; text-align:right; width:170; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php echo $_smarty_tpl->getVariable('order')->value->discount;?>
&nbsp;%
		</td>
	</tr>
	<?php }?>

	<?php if ($_smarty_tpl->getVariable('delivery')->value&&!$_smarty_tpl->getVariable('order')->value->separate_delivery){?>
	<tr>
		<td style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;"></td>
		<td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">
			<?php echo $_smarty_tpl->getVariable('delivery')->value->name;?>

		</td>
		<td align="right" style="padding:6px; text-align:right; width:170; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('order')->value->delivery_price,$_smarty_tpl->getVariable('main_currency')->value->id);?>
&nbsp;<?php echo $_smarty_tpl->getVariable('main_currency')->value->sign;?>

		</td>
	</tr>
	<?php }?>
	
	<tr>
		<td style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;"></td>
		<td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;font-weight:bold;">
			Итого
		</td>
		<td align="right" style="padding:6px; text-align:right; width:170; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;font-weight:bold;">
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('order')->value->total_price,$_smarty_tpl->getVariable('main_currency')->value->id);?>
&nbsp;<?php echo $_smarty_tpl->getVariable('main_currency')->value->sign;?>

		</td>
	</tr>
</table>