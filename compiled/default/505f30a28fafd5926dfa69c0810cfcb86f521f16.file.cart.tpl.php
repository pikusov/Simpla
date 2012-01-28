<?php /* Smarty version Smarty-3.0.7, created on 2012-01-23 14:14:45
         compiled from "/Users/denispikusov/Sites/simpla//design/default/html/cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16181922274f1d5d4585aa85-27408772%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '505f30a28fafd5926dfa69c0810cfcb86f521f16' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/cart.tpl',
      1 => 1327324484,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16181922274f1d5d4585aa85-27408772',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable("Корзина", null, 1);?>

<h1>
<?php if ($_smarty_tpl->getVariable('cart')->value->purchases){?>В корзине <?php echo $_smarty_tpl->getVariable('cart')->value->total_products;?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('cart')->value->total_products,'товар','товаров','товара');?>

<?php }else{ ?>Корзина пуста<?php }?>
</h1>

<?php if ($_smarty_tpl->getVariable('cart')->value->purchases){?>
<form method="post" name="cart">
<table id="purchases">

<?php  $_smarty_tpl->tpl_vars['purchase'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('cart')->value->purchases; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['purchase']->key => $_smarty_tpl->tpl_vars['purchase']->value){
?>
<tr>
	<td class="image">
		<?php $_smarty_tpl->tpl_vars['image'] = new Smarty_variable($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['first'][0][0]->first_modifier($_smarty_tpl->getVariable('purchase')->value->product->images), null, null);?>
		<?php if ($_smarty_tpl->getVariable('image')->value){?>
		<a href="products/<?php echo $_smarty_tpl->getVariable('purchase')->value->product->url;?>
"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('image')->value->filename,50,50);?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
"></a>
		<?php }?>
	</td>
	
	<td class="name">
		<a href="products/<?php echo $_smarty_tpl->getVariable('purchase')->value->product->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('purchase')->value->product->name);?>
</a>
		<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('purchase')->value->variant->name);?>
			
	</td>
	<td class="price">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert(($_smarty_tpl->getVariable('purchase')->value->variant->price));?>
 <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

	</td>
	<td class="amount">
		<select name="amounts[<?php echo $_smarty_tpl->getVariable('purchase')->value->variant->id;?>
]" onchange="document.cart.submit();">
			<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['name'] = 'amounts';
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('purchase')->value->variant->stock+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['total']);
?>
			<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['amounts']['index'];?>
" <?php if ($_smarty_tpl->getVariable('purchase')->value->amount==$_smarty_tpl->getVariable('smarty')->value['section']['amounts']['index']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['amounts']['index'];?>
 <?php echo $_smarty_tpl->getVariable('settings')->value->units;?>
</option>
			<?php endfor; endif; ?>
		</select>
	</td>
	<td class="price">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert(($_smarty_tpl->getVariable('purchase')->value->variant->price*$_smarty_tpl->getVariable('purchase')->value->amount));?>
&nbsp;<?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

	</td>
	
	<td class="remove">
		<a href="cart/remove/<?php echo $_smarty_tpl->getVariable('purchase')->value->variant->id;?>
">
		<img src="design/<?php echo $_smarty_tpl->getVariable('settings')->value->theme;?>
/images/delete.png" title="Удалить из корзины" alt="Удалить из корзины">
		</a>
	</td>
			
</tr>
<?php }} ?>
<?php if ($_smarty_tpl->getVariable('user')->value->discount){?>
<tr>
	<th class="image"></th>
	<th class="name">скидка</th>
	<th class="price"></th>
	<th class="amount"></th>
	<th class="price">
		<?php echo $_smarty_tpl->getVariable('user')->value->discount;?>
&nbsp;%
	</th>
	<th class="remove"></th>
</tr>
<?php }?>
<tr>
	<th class="image"></th>
	<th class="name"></th>
	<th class="price" colspan="4">
		Итого
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('cart')->value->total_price);?>
&nbsp;<?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

	</th>
</tr>
</table>
<?php if ($_smarty_tpl->getVariable('deliveries')->value){?>
<h2>Выберите способ доставки:</h2>
<ul id="deliveries">
	<?php  $_smarty_tpl->tpl_vars['delivery'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('deliveries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['delivery']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['delivery']->key => $_smarty_tpl->tpl_vars['delivery']->value){
 $_smarty_tpl->tpl_vars['delivery']->index++;
 $_smarty_tpl->tpl_vars['delivery']->first = $_smarty_tpl->tpl_vars['delivery']->index === 0;
?>
	<li>
		<div class="checkbox">
			<input type="radio" name="delivery_id" value="<?php echo $_smarty_tpl->getVariable('delivery')->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['delivery']->first){?>checked<?php }?> id="deliveries_<?php echo $_smarty_tpl->getVariable('delivery')->value->id;?>
">
		</div>
		
			<h3>
			<label for="deliveries_<?php echo $_smarty_tpl->getVariable('delivery')->value->id;?>
">
			<?php echo $_smarty_tpl->getVariable('delivery')->value->name;?>

			<?php if ($_smarty_tpl->getVariable('cart')->value->total_price<$_smarty_tpl->getVariable('delivery')->value->free_from&&$_smarty_tpl->getVariable('delivery')->value->price>0){?>
				(<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('delivery')->value->price);?>
&nbsp;<?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
)
			<?php }elseif($_smarty_tpl->getVariable('cart')->value->total_price>=$_smarty_tpl->getVariable('delivery')->value->free_from){?>
				(бесплатно)
			<?php }?>
			</label>
			</h3>
			<div class="description">
			<?php echo $_smarty_tpl->getVariable('delivery')->value->description;?>

			</div>
	</li>
	<?php }} ?>
</ul>
<?php }?>
    
<h2>Адрес получателя</h2>
	
<div class="form cart_form">         
	<?php if ($_smarty_tpl->getVariable('error')->value){?>
	<div class="message_error">
		<?php if ($_smarty_tpl->getVariable('error')->value=='empty_name'){?>Введите имя<?php }?>
		<?php if ($_smarty_tpl->getVariable('error')->value=='empty_email'){?>Введите email<?php }?>
	</div>
	<?php }?>
	<label>Имя, фамилия</label>
	<input name="name" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('name')->value);?>
" data-format=".+" data-notice="Введите имя"/>
	
	<label>Email</label>
	<input name="email" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('email')->value);?>
" data-format="email" data-notice="Введите email" />

	<label>Телефон</label>
	<input name="phone" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('phone')->value);?>
" />
	
	<label>Адрес доставки</label>
	<input name="address" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('address')->value);?>
"/>

	<label>Комментарий к&nbsp;заказу</label>
	<textarea name="comment" id="order_comment"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('comment')->value);?>
</textarea>
	<input type="submit" name="checkout" class="button_submit" value="Оформить заказ">
	</div>
   
</form>
<?php }else{ ?>
  В корзине нет товаров
<?php }?>