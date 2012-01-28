<?php /* Smarty version Smarty-3.0.7, created on 2012-01-18 15:28:36
         compiled from "/Users/denispikusov/Sites/simpla//design/default/html/order.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12876503484f16c904e7b575-24543885%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '308382185460e505bb096340f2d4b36ee3744e32' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/order.tpl',
      1 => 1325159996,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12876503484f16c904e7b575-24543885',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable("Ваш заказ №".($_smarty_tpl->getVariable('order')->value->id), null, 1);?>

<h1>Ваш заказ №<?php echo $_smarty_tpl->getVariable('order')->value->id;?>
 
<?php if ($_smarty_tpl->getVariable('order')->value->status==0){?>принят<?php }?>
<?php if ($_smarty_tpl->getVariable('order')->value->status==1){?>в обработке<?php }elseif($_smarty_tpl->getVariable('order')->value->status==2){?>выполнен<?php }?>
<?php if ($_smarty_tpl->getVariable('order')->value->paid==1){?>, оплачен<?php }else{ ?><?php }?>
</h1>
<table id="purchases">

<?php  $_smarty_tpl->tpl_vars['purchase'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('purchases')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
		<a href="/products/<?php echo $_smarty_tpl->getVariable('purchase')->value->product->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('purchase')->value->product_name);?>
</a>
		<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('purchase')->value->variant_name);?>

		<?php if ($_smarty_tpl->getVariable('order')->value->paid&&$_smarty_tpl->getVariable('purchase')->value->variant->attachment){?>
			<a class="download_attachment" href="order/<?php echo $_smarty_tpl->getVariable('order')->value->url;?>
/<?php echo $_smarty_tpl->getVariable('purchase')->value->variant->attachment;?>
">скачать файл</a>
		<?php }?>
	</td>
	<td class="price">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert(($_smarty_tpl->getVariable('purchase')->value->price));?>
&nbsp;<?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

	</td>
	<td class="amount">
		&times; <?php echo $_smarty_tpl->getVariable('purchase')->value->amount;?>
&nbsp;<?php echo $_smarty_tpl->getVariable('settings')->value->units;?>

	</td>
	<td class="price">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert(($_smarty_tpl->getVariable('purchase')->value->price*$_smarty_tpl->getVariable('purchase')->value->amount));?>
&nbsp;<?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

	</td>
</tr>
<?php }} ?>
<?php if ($_smarty_tpl->getVariable('order')->value->discount>0){?>
<tr>
	<th class="image"></th>
	<th class="name">скидка</th>
	<th class="price"></th>
	<th class="amount"></th>
	<th class="price">
		<?php echo $_smarty_tpl->getVariable('order')->value->discount;?>
&nbsp;%
	</th>
</tr>
<?php }?>
<?php if (!$_smarty_tpl->getVariable('order')->value->separate_delivery&&$_smarty_tpl->getVariable('order')->value->delivery_price>0){?>
<tr>
	<td class="image>"</td>
	<td class="name"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('delivery')->value->name);?>
</td>
	<td class="price"></td>
	<td class="amount"></td>
	<td class="price">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('order')->value->delivery_price);?>
&nbsp;<?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

	</td>
</tr>
<?php }?>
<tr>
	<th class="image"></th>
	<th class="name">итого</th>
	<th class="price"></th>
	<th class="amount"></th>
	<th class="price">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('order')->value->total_price);?>
&nbsp;<?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

	</th>
</tr>
<?php if ($_smarty_tpl->getVariable('order')->value->separate_delivery){?>
<tr>
	<td class="image>"</td>
	<td class="name"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('delivery')->value->name);?>
</td>
	<td class="price"></td>
	<td class="amount"></td>
	<td class="price">
		<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('order')->value->delivery_price);?>
&nbsp;<?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

	</td>
</tr>
<?php }?>

</table>
<h2>Детали заказа</h2>
<table class="order_info">
	<tr>
		<td>
			Дата заказа
		</td>
		<td>
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->getVariable('order')->value->date);?>
 в
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->getVariable('order')->value->date);?>

		</td>
	</tr>
	<?php if ($_smarty_tpl->getVariable('order')->value->name){?>
	<tr>
		<td>
			Имя
		</td>
		<td>
			<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->name);?>

		</td>
	</tr>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('order')->value->email){?>
	<tr>
		<td>
			Email
		</td>
		<td>
			<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->email);?>

		</td>
	</tr>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('order')->value->phone){?>
	<tr>
		<td>
			Телефон
		</td>
		<td>
			<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->phone);?>

		</td>
	</tr>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('order')->value->address){?>
	<tr>
		<td>
			Адрес доставки
		</td>
		<td>
			<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->address);?>

		</td>
	</tr>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('order')->value->comment){?>
	<tr>
		<td>
			Комментарий
		</td>
		<td>
			<?php echo nl2br(smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->comment));?>

		</td>
	</tr>
	<?php }?>
</table>


<?php if (!$_smarty_tpl->getVariable('order')->value->paid){?>
<?php if ($_smarty_tpl->getVariable('payment_methods')->value&&!$_smarty_tpl->getVariable('payment_method')->value){?>
<form method="post">
<h2>Выберите способ оплаты</h2>
<ul id="deliveries">
    <?php  $_smarty_tpl->tpl_vars['payment_method'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('payment_methods')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['payment_method']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['payment_method']->key => $_smarty_tpl->tpl_vars['payment_method']->value){
 $_smarty_tpl->tpl_vars['payment_method']->index++;
 $_smarty_tpl->tpl_vars['payment_method']->first = $_smarty_tpl->tpl_vars['payment_method']->index === 0;
?>
    	<li>
    		<div class="checkbox">
    			<input type=radio name=payment_method_id value='<?php echo $_smarty_tpl->getVariable('payment_method')->value->id;?>
' <?php if ($_smarty_tpl->tpl_vars['payment_method']->first){?>checked<?php }?> id=payment_<?php echo $_smarty_tpl->getVariable('payment_method')->value->id;?>
>
    		</div>			
			<h3><label for=payment_<?php echo $_smarty_tpl->getVariable('payment_method')->value->id;?>
>	<?php echo $_smarty_tpl->getVariable('payment_method')->value->name;?>
, к оплате <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('order')->value->total_price,$_smarty_tpl->getVariable('payment_method')->value->currency_id);?>
&nbsp;<?php echo $_smarty_tpl->getVariable('all_currencies')->value[$_smarty_tpl->getVariable('payment_method')->value->currency_id]->sign;?>
</label></h3>
			<div class="description">
			<?php echo $_smarty_tpl->getVariable('payment_method')->value->description;?>

			</div>
    	</li>
    <?php }} ?>
</ul>
<input type='submit' value='Закончить заказ'>
</form>
<?php }elseif($_smarty_tpl->getVariable('payment_method')->value){?>
<h2>Способ оплаты &mdash; <?php echo $_smarty_tpl->getVariable('payment_method')->value->name;?>

<form method=post><input type=submit name='reset_payment_method' value='Выбрать другой способ оплаты'></form>	
</h2>
<p>
<?php echo $_smarty_tpl->getVariable('payment_method')->value->description;?>

</p>
<h2>
К оплате <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('order')->value->total_price,$_smarty_tpl->getVariable('payment_method')->value->currency_id);?>
&nbsp;<?php echo $_smarty_tpl->getVariable('all_currencies')->value[$_smarty_tpl->getVariable('payment_method')->value->currency_id]->sign;?>

</h2>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['checkout_form'][0][0]->checkout_form(array('order_id'=>$_smarty_tpl->getVariable('order')->value->id,'module'=>$_smarty_tpl->getVariable('payment_method')->value->module),$_smarty_tpl);?>

<?php }?>

<?php }?>


 