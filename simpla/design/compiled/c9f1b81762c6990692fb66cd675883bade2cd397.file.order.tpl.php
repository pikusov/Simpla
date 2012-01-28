<?php /* Smarty version Smarty-3.0.7, created on 2011-12-21 18:54:46
         compiled from "simpla/design/html/order.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14020757714ef20f56d82358-49661552%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c9f1b81762c6990692fb66cd675883bade2cd397' => 
    array (
      0 => 'simpla/design/html/order.tpl',
      1 => 1324226881,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14020757714ef20f56d82358-49661552',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
if (!is_callable('smarty_function_math')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/function.math.php';
?><?php ob_start(); ?>
		<li <?php if ($_smarty_tpl->getVariable('order')->value->status==0){?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrdersAdmin','status'=>0,'id'=>null),$_smarty_tpl);?>
">Новые</a></li>
		<li <?php if ($_smarty_tpl->getVariable('order')->value->status==1){?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrdersAdmin','status'=>1,'id'=>null),$_smarty_tpl);?>
">Приняты</a></li>
		<li <?php if ($_smarty_tpl->getVariable('order')->value->status==2){?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrdersAdmin','status'=>2,'id'=>null),$_smarty_tpl);?>
">Выполнены</a></li>
		<li <?php if ($_smarty_tpl->getVariable('order')->value->status==3){?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'OrdersAdmin','status'=>3,'id'=>null),$_smarty_tpl);?>
">Удалены</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>

<?php if ($_smarty_tpl->getVariable('order')->value->id){?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable("Заказ №".($_smarty_tpl->getVariable('order')->value->id), null, 1);?>
<?php }else{ ?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Новый заказ', null, 1);?>
<?php }?>

<!-- Основная форма -->
<form method=post id=order enctype="multipart/form-data">
<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">

<div id="name">
	<input name=id type="hidden" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->id);?>
"/> 
	<h1><?php if ($_smarty_tpl->getVariable('order')->value->id){?>Заказ №<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->id);?>
<?php }else{ ?>Новый заказ<?php }?>
	<select class=status name="status">
		<option value='0' <?php if ($_smarty_tpl->getVariable('order')->value->status==0){?>selected<?php }?>>Новый</option>
		<option value='1' <?php if ($_smarty_tpl->getVariable('order')->value->status==1){?>selected<?php }?>>Принят</option>
		<option value='2' <?php if ($_smarty_tpl->getVariable('order')->value->status==2){?>selected<?php }?>>Выполнен</option>
		<option value='3' <?php if ($_smarty_tpl->getVariable('order')->value->status==3){?>selected<?php }?>>Удален</option>
	</select>
	</h1>


	<div id=next_order>
		<?php if ($_smarty_tpl->getVariable('prev_order')->value){?>
		<a class=prev_order href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('id'=>$_smarty_tpl->getVariable('prev_order')->value->id),$_smarty_tpl);?>
">←</a>
		<?php }?>
		<?php if ($_smarty_tpl->getVariable('next_order')->value){?>
		<a class=next_order href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('id'=>$_smarty_tpl->getVariable('next_order')->value->id),$_smarty_tpl);?>
">→</a>
		<?php }?>
	</div>
		
</div> 


<?php if ($_smarty_tpl->getVariable('message_error')->value){?>
<!-- Системное сообщение -->
<div class="message message_error">
	<span><?php if ($_smarty_tpl->getVariable('message_error')->value=='error_closing'){?>Нехватка товара на складе<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('message_error')->value);?>
<?php }?></span>
	<?php if ($_GET['return']){?>
	<a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
	<?php }?>
</div>
<!-- Системное сообщение (The End)-->
<?php }elseif($_smarty_tpl->getVariable('message_success')->value){?>
<!-- Системное сообщение -->
<div class="message message_success">
	<span><?php if ($_smarty_tpl->getVariable('message_success')->value=='updated'){?>Заказ обновлен<?php }elseif($_smarty_tpl->getVariable('message_success')->value=='added'){?>Заказ добавлен<?php }else{ ?><?php echo $_smarty_tpl->getVariable('message_success')->value;?>
<?php }?></span>
	<?php if ($_GET['return']){?>
	<a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
	<?php }?>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>



<div id="order_details">
	<h2>Детали заказа <a href='#' class="edit_order_details"><img src='design/images/pencil.png' alt='Редактировать' title='Редактировать'></a></h2>
	
	<div id="user">
	<ul class="order_details">
		<li>
			<label class=property>Дата</label>
			<div class="edit_order_detail view_order_detail">
			<?php echo $_smarty_tpl->getVariable('order')->value->date;?>
 <?php echo $_smarty_tpl->getVariable('order')->value->time;?>

			</div>
		</li>
		<li>
			<label class=property>Имя</label> 
			<div class="edit_order_detail" style='display:none;'>
				<input name="name" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->name);?>
" />
			</div>
			<div class="view_order_detail">
				<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->name);?>

			</div>
		</li>
		<li>
			<label class=property>Email</label>
			<div class="edit_order_detail" style='display:none;'>
				<input name="email" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->email);?>
" />
			</div>
			<div class="view_order_detail">
				<a href="mailto:<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->email);?>
?subject=Заказ%20№<?php echo $_smarty_tpl->getVariable('order')->value->id;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->email);?>
</a>
			</div>
		</li>
		<li>
			<label class=property>Телефон</label>
			<div class="edit_order_detail" style='display:none;'>
				<input name="phone" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->phone);?>
" />
			</div>
			<div class="view_order_detail">
				<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->phone);?>

			</div>
		</li>
		<li>
			<label class=property>Адрес <a href='http://maps.yandex.ru/' id=address_link target=_blank><img align=absmiddle src='design/images/map.png' alt='Карта в новом окне' title='Карта в новом окне'></a></label>
			<div class="edit_order_detail" style='display:none;'>
				<textarea name="address"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->address);?>
</textarea>
			</div>
			<div class="view_order_detail">
				<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->address);?>

			</div>
		</li>
		<li>
			<label class=property>Комментарий пользователя</label>
			<div class="edit_order_detail" style='display:none;'>
			<textarea name="comment"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->comment);?>
</textarea>
			</div>
			<div class="view_order_detail">
				<?php echo nl2br(smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->comment));?>

			</div>
		</li>
	</ul>
	</div>

	
	<div class='layer'>
	<h2>Пользователь <a href='#' class="edit_user"><img src='design/images/pencil.png' alt='Редактировать' title='Редактировать'></a> <?php if ($_smarty_tpl->getVariable('user')->value){?><a href="#" class='delete_user'><img src='design/images/delete.png' alt='Удалить' title='Удалить'></a><?php }?></h2>
		<div class='view_user'>
		<?php if (!$_smarty_tpl->getVariable('user')->value){?>
			Не зарегистрирован
		<?php }else{ ?>
			<a href='index.php?module=UserAdmin&id=<?php echo $_smarty_tpl->getVariable('user')->value->id;?>
' target=_blank><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->name);?>
</a> (<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value->email);?>
)
		<?php }?>
		</div>
		<div class='edit_user' style='display:none;'>
		<input type=hidden name=user_id value='<?php echo $_smarty_tpl->getVariable('user')->value->id;?>
'>
		<input type=text id='user' class="input_autocomplete" placeholder="Выберите пользователя">
		</div>
	</div>
	

	
	<div class='layer'>
	<h2>Примечание <a href='#' class="edit_note"><img src='design/images/pencil.png' alt='Редактировать' title='Редактировать'></a></h2>
	<ul class="order_details">
		<li>
			<div class="edit_note" style='display:none;'>
				<label class=property>Ваше примечание (не видно пользователю)</label>
				<textarea name="note"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->note);?>
</textarea>
			</div>
			<div class="view_note" <?php if (!$_smarty_tpl->getVariable('order')->value->note){?>style='display:none;'<?php }?>>
				<label class=property>Ваше примечание (не видно пользователю)</label>
				<div class="note_text"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('order')->value->note);?>
</div>
			</div>
		</li>
	</ul>
	</div>
</div>


<div id="purchases">
 
	<div id="list" class="purchases">
		<?php  $_smarty_tpl->tpl_vars['purchase'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('purchases')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['purchase']->key => $_smarty_tpl->tpl_vars['purchase']->value){
?>
		<div class="row">
			<div class="image cell">
				<input type=hidden name=purchases[id][<?php echo $_smarty_tpl->getVariable('purchase')->value->id;?>
] value='<?php echo $_smarty_tpl->getVariable('purchase')->value->id;?>
'>
				<?php $_smarty_tpl->tpl_vars['image'] = new Smarty_variable($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['first'][0][0]->first_modifier($_smarty_tpl->getVariable('purchase')->value->product->images), null, null);?>
				<?php if ($_smarty_tpl->getVariable('image')->value){?>
				<img class=product_icon src='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('image')->value->filename,35,35);?>
'>
				<?php }?>
			</div>
			<div class="purchase_name cell">
			
				<div class='purchase_variant'>				
				<span class=edit_purchase style='display:none;'>
				<select name=purchases[variant_id][<?php echo $_smarty_tpl->getVariable('purchase')->value->id;?>
] <?php if (count($_smarty_tpl->getVariable('purchase')->value->product->variants)==1&&$_smarty_tpl->getVariable('purchase')->value->variant_name==''&&$_smarty_tpl->getVariable('purchase')->value->variant->sku==''){?>style='display:none;'<?php }?>>					
		    	<?php if (!$_smarty_tpl->getVariable('purchase')->value->variant){?><option price='<?php echo $_smarty_tpl->getVariable('purchase')->value->price;?>
' amount='<?php echo $_smarty_tpl->getVariable('purchase')->value->amount;?>
' value=''><?php echo $_smarty_tpl->getVariable('purchase')->value->variant_name;?>
</option><?php }?>
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('purchase')->value->product->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
?>
					<?php if ($_smarty_tpl->getVariable('v')->value->stock>0||$_smarty_tpl->getVariable('v')->value->id==$_smarty_tpl->getVariable('purchase')->value->variant->id){?>
					<option price='<?php echo $_smarty_tpl->getVariable('v')->value->price;?>
' amount='<?php echo $_smarty_tpl->getVariable('v')->value->stock;?>
' value='<?php echo $_smarty_tpl->getVariable('v')->value->id;?>
' <?php if ($_smarty_tpl->getVariable('v')->value->id==$_smarty_tpl->getVariable('purchase')->value->variant_id){?>selected<?php }?> >
					<?php echo $_smarty_tpl->getVariable('v')->value->name;?>

					<?php if ($_smarty_tpl->getVariable('v')->value->sku){?>(арт. <?php echo $_smarty_tpl->getVariable('v')->value->sku;?>
)<?php }?>
					</option>
					<?php }?>
				<?php }} ?>
				</select>
				</span>
				<span class=view_purchase>
					<?php echo $_smarty_tpl->getVariable('purchase')->value->variant_name;?>
 <?php if ($_smarty_tpl->getVariable('purchase')->value->variant->sku){?>(арт. <?php echo $_smarty_tpl->getVariable('purchase')->value->variant->sku;?>
)<?php }?>			
				</span>
				</div>
		
				<?php if ($_smarty_tpl->getVariable('purchase')->value->product){?>
				<a class="related_product_name" href="index.php?module=ProductAdmin&id=<?php echo $_smarty_tpl->getVariable('purchase')->value->product->id;?>
&return=<?php echo urlencode($_SERVER['REQUEST_URI']);?>
"><?php echo $_smarty_tpl->getVariable('purchase')->value->product_name;?>
</a>
				<?php }else{ ?>
				<?php echo $_smarty_tpl->getVariable('purchase')->value->product_name;?>
				
				<?php }?>
			</div>
			<div class="price cell">
				<span class=view_purchase><?php echo $_smarty_tpl->getVariable('purchase')->value->price;?>
</span>
				<span class=edit_purchase style='display:none;'>
				<input type=text name=purchases[price][<?php echo $_smarty_tpl->getVariable('purchase')->value->id;?>
] value='<?php echo $_smarty_tpl->getVariable('purchase')->value->price;?>
' size=5>
				</span>
				<?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

			</div>
			<div class="amount cell">			
				<span class=view_purchase>
					<?php echo $_smarty_tpl->getVariable('purchase')->value->amount;?>
 <?php echo $_smarty_tpl->getVariable('settings')->value->units;?>

				</span>
				<span class=edit_purchase style='display:none;'>
					<?php if ($_smarty_tpl->getVariable('purchase')->value->variant){?>
					<?php echo smarty_function_math(array('equation'=>"max(x,y)",'x'=>$_smarty_tpl->getVariable('purchase')->value->variant->stock,'y'=>$_smarty_tpl->getVariable('purchase')->value->amount,'assign'=>"loop"),$_smarty_tpl);?>

					<?php }else{ ?>
					<?php echo smarty_function_math(array('equation'=>"x",'x'=>$_smarty_tpl->getVariable('purchase')->value->amount,'assign'=>"loop"),$_smarty_tpl);?>

					<?php }?>
			        <select name=purchases[amount][<?php echo $_smarty_tpl->getVariable('purchase')->value->id;?>
]>
						<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['name'] = 'amounts';
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('loop')->value+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['max'] = (int)100;
$_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['show'] = true;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['amounts']['max'] < 0)
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
				</span>			
			</div>
			<div class="icons cell">		
				<?php if (!$_smarty_tpl->getVariable('order')->value->closed){?>
					<?php if (!$_smarty_tpl->getVariable('purchase')->value->product){?>
					<img src='design/images/error.png' alt='Товар был удалён' title='Товар был удалён' >
					<?php }elseif(!$_smarty_tpl->getVariable('purchase')->value->variant){?>
					<img src='design/images/error.png' alt='Вариант товара был удалён' title='Вариант товара был удалён' >
					<?php }elseif($_smarty_tpl->getVariable('purchase')->value->variant->stock<$_smarty_tpl->getVariable('purchase')->value->amount){?>
					<img src='design/images/error.png' alt='На складе остал<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('purchase')->value->variant->stock,'ся','ось');?>
 <?php echo $_smarty_tpl->getVariable('purchase')->value->variant->stock;?>
 товар<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('purchase')->value->variant->stock,'','ов','а');?>
' title='На складе остал<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('purchase')->value->variant->stock,'ся','ось');?>
 <?php echo $_smarty_tpl->getVariable('purchase')->value->variant->stock;?>
 товар<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier($_smarty_tpl->getVariable('purchase')->value->variant->stock,'','ов','а');?>
'  >
					<?php }?>
				<?php }?>
				<a href='#' class="delete" title="Удалить"></a>		
			</div>
			<div class="clear"></div>
		</div>
		<?php }} ?>
		<div id="new_purchase" class="row" style='display:none;'>
			<div class="image cell">
				<input type=hidden name=purchases[id][] value=''>
				<img class=product_icon src=''>
			</div>
			<div class="purchase_name cell">
				<div class='purchase_variant'>				
					<select name=purchases[variant_id][] style='display:none;'></select>
				</div>
				<a class="purchase_name" href=""></a>
			</div>
			<div class="price cell">
				<input type=text name=purchases[price][] value='' size=5> <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>

			</div>
			<div class="amount cell">
	        	<select name=purchases[amount][]></select>
			</div>
			<div class="icons cell">
				<a href='#' class="delete" title="Удалить"></a>	
			</div>
			<div class="clear"></div>
		</div>
	</div>

 	<div id="add_purchase" <?php if ($_smarty_tpl->getVariable('purchases')->value){?>style='display:none;'<?php }?>>
 		<input type=text name=related id='add_purchase' class="input_autocomplete" placeholder='Выберите товар чтобы добавить его'>
 	</div>
	<?php if ($_smarty_tpl->getVariable('purchases')->value){?>
	<a href='#' class="dash_link edit_purchases">редактировать покупки</a>
	<?php }?>


	<?php if ($_smarty_tpl->getVariable('purchases')->value){?>
	<div class="subtotal">
	Всего<b> <?php echo $_smarty_tpl->getVariable('subtotal')->value;?>
 <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
</b>
	</div>
	<?php }?>

	<div class="block discount layer">
		<h2>Скидка</h2>
		<input type=text name=discount value='<?php echo $_smarty_tpl->getVariable('order')->value->discount;?>
'> <span class=currency>%</span>		
	</div>

	<div class="subtotal layer">
	С учетом скидки<b> <?php echo $_smarty_tpl->getVariable('subtotal')->value-$_smarty_tpl->getVariable('subtotal')->value*$_smarty_tpl->getVariable('order')->value->discount/100;?>
 <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
</b>
	</div> 
	
	<div class="block delivery">
		<h2>Доставка</h2>
				<select name="delivery_id">
				<option value="0">Не выбрана</option>
				<?php  $_smarty_tpl->tpl_vars['d'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('deliveries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['d']->key => $_smarty_tpl->tpl_vars['d']->value){
?>
				<option value="<?php echo $_smarty_tpl->getVariable('d')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('d')->value->id==$_smarty_tpl->getVariable('delivery')->value->id){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('d')->value->name;?>
</option>
				<?php }} ?>
				</select>	
				<input type=text name=delivery_price value='<?php echo $_smarty_tpl->getVariable('order')->value->delivery_price;?>
'> <span class=currency><?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
</span>
				<div class="separate_delivery">
					<input type=checkbox id="separate_delivery" name=separate_delivery value='1' <?php if ($_smarty_tpl->getVariable('order')->value->separate_delivery){?>checked<?php }?>> <label  for="separate_delivery">оплачивается отдельно</label>
				</div>
	</div>

	<div class="total layer">
	Итого<b> <?php echo $_smarty_tpl->getVariable('order')->value->total_price;?>
 <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
</b>
	</div>
		
		
	<div class="block payment">
		<h2>Оплата</h2>
				<select name="payment_method_id">
				<option value="0">Не выбрана</option>
				<?php  $_smarty_tpl->tpl_vars['pm'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('payment_methods')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pm']->key => $_smarty_tpl->tpl_vars['pm']->value){
?>
				<option value="<?php echo $_smarty_tpl->getVariable('pm')->value->id;?>
" <?php if ($_smarty_tpl->getVariable('pm')->value->id==$_smarty_tpl->getVariable('payment_method')->value->id){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('pm')->value->name;?>
</option>
				<?php }} ?>
				</select>
		
		<input type=checkbox name="paid" id="paid" value="1" <?php if ($_smarty_tpl->getVariable('order')->value->paid){?>checked<?php }?>> <label for="paid" <?php if ($_smarty_tpl->getVariable('order')->value->paid){?>class="green"<?php }?>>Заказ оплачен</label>		
	</div>

 
	<?php if ($_smarty_tpl->getVariable('payment_method')->value){?>
	<div class="subtotal layer">
	К оплате<b> <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('order')->value->total_price,$_smarty_tpl->getVariable('payment_currency')->value->id);?>
 <?php echo $_smarty_tpl->getVariable('payment_currency')->value->sign;?>
</b>
	</div>
	<?php }?>


	<div class="block_save">
	<input type="checkbox" value="1" id="notify_user" name="notify_user">
	<label for="notify_user">Уведомить покупателя о состоянии заказа</label>

	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	</div>


</div>


</form>
<!-- Основная форма (The End) -->

<script src="design/js/autocomplete/jquery.autocomplete-min.js"></script>
<style>
.autocomplete-w1 { background:url(img/shadow.png) no-repeat bottom right; position:absolute; top:0px; left:0px; margin:6px 0 0 6px; /* IE6 fix: */ _background:none; _margin:1px 0 0 0; }
.autocomplete { border:1px solid #999; background:#FFF; cursor:default; text-align:left; overflow-x:auto; min-width: 300px; overflow-y: auto; margin:-6px 6px 6px -6px; /* IE6 specific: */ _height:350px;  _margin:0; _overflow-x:hidden; }
.autocomplete .selected { background:#F0F0F0; }
.autocomplete div { padding:2px 5px; white-space:nowrap; }
.autocomplete strong { font-weight:normal; color:#3399FF; }
</style>

<script>
$(function() {

	// Раскраска строк
	function colorize()
	{
		$("#list div.row:even").addClass('even');
		$("#list div.row:odd").removeClass('even');
	}
	// Раскрасить строки сразу
	colorize();
	
	// Удаление товара
	$(".purchases a.delete").live('click', function() {
		 $(this).closest(".row").fadeOut(200, function() { $(this).remove(); });
		 return false;
	});
 

	// Добавление товара 
	var new_purchase = $('.purchases #new_purchase').clone(true);
	$('.purchases #new_purchase').remove().removeAttr('id');

	$("input#add_purchase").autocomplete({
  	serviceUrl:'ajax/add_order_product.php',
  	minChars:0,
  	noCache: false, 
  	onSelect:
  		function(value, data){
  			new_item = new_purchase.clone().appendTo('.purchases');
  			new_item.removeAttr('id');
  			new_item.find('a.purchase_name').html(data.name);
  			new_item.find('a.purchase_name').attr('href', 'index.php?module=ProductAdmin&id='+data.id);
  			
  			// Добавляем варианты нового товара
  			var variants_select = new_item.find('select[name*=purchases][name*=variant_id]');
			for(var i in data.variants)
  				variants_select.append("<option value='"+data.variants[i].id+"' price='"+data.variants[i].price+"' amount='"+data.variants[i].stock+"'>"+data.variants[i].name+"</option>");
  			
  			if(data.variants.length>1 || data.variants[0].name != '')
  				variants_select.show();
  				  				
			variants_select.bind('change', function(){change_variant(variants_select);});
				change_variant(variants_select);
  			
  			if(data.image)
  				new_item.find('img.product_icon').attr("src", data.image);
  			else
  				new_item.find('img.product_icon').remove();

			$("input#add_purchase").val(''); 
  			new_item.show();
  		},
		fnFormatResult:
			function(value, data, currentValue){
				var reEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
				var pattern = '(' + currentValue.replace(reEscape, '\\$1') + ')';
  				return (data.image?"<img align=absmiddle src='"+data.image+"'> ":'') + value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');
			}
  		
  });
  
  // Изменение цены и макс количества при изменении варианта
  function change_variant(element)
  {
		price = element.find('option:selected').attr('price');
		amount = element.find('option:selected').attr('amount');
		element.closest('.row').find('input[name*=purchases][name*=price]').val(price);
		
		// 
		amount_select = element.closest('.row').find('select[name*=purchases][name*=amount]');
		selected_amount = amount_select.val();
		amount_select.html('');
		for(i=1; i<=amount; i++)
			amount_select.append("<option value='"+i+"'>"+i+" <?php echo $_smarty_tpl->getVariable('settings')->value->units;?>
</option>");
		amount_select.val(Math.min(selected_amount, amount));


		return false;
  }
  
  
	// Редактировать покупки
	$("a.edit_purchases").click( function() {
		 $(".purchases span.view_purchase").hide();
		 $(".purchases span.edit_purchase").show();
		 $(".edit_purchases").hide();
		 $("div#add_purchase").show();
		 return false;
	});
  
	// Редактировать получателя
	$("div#order_details a.edit_order_details").click(function() {
		 $("ul.order_details .view_order_detail").hide();
		 $("ul.order_details .edit_order_detail").show();
		 return false;
	});
  
	// Редактировать примечание
	$("div#order_details a.edit_note").click(function() {
		 $("div.view_note").hide();
		 $("div.edit_note").show();
		 return false;
	});
  
	// Редактировать пользователя
	$("div#order_details a.edit_user").click(function() {
		 $("div.view_user").hide();
		 $("div.edit_user").show();
		 return false;
	});
	$("input#user").autocomplete({
		serviceUrl:'ajax/search_users.php',
		minChars:0,
		noCache: false, 
		onSelect:
			function(value, data){
				$('input[name="user_id"]').val(data.id);
			}
	});
  
	// Удалить пользователя
	$("div#order_details a.delete_user").click(function() {
		$('input[name="user_id"]').val(0);
		$('div.view_user').hide();
		$('div.edit_user').hide();
		return false;
	});

	// Посмотреть адрес на карте
	$("a#address_link").attr('href', 'http://maps.yandex.ru/?text='+$('#order_details textarea[name="address"]').val());
  
	// Подтверждение удаления
	$('select[name*=purchases][name*=variant_id]').bind('change', function(){change_variant($(this));});
	$("input[name='status_deleted']").click(function() {
		if(!confirm('Подтвердите удаление'))
			return false;	
	});

});

</script>

<style>
.ui-autocomplete{
background-color: #ffffff; width: 100px; overflow: hidden;
border: 1px solid #e0e0e0;
padding: 5px;
}
.ui-autocomplete li.ui-menu-item{
overflow: hidden;
white-space:nowrap;
display: block;
}
.ui-autocomplete a.ui-corner-all{
overflow: hidden;
white-space:nowrap;
display: block;
}
</style>


