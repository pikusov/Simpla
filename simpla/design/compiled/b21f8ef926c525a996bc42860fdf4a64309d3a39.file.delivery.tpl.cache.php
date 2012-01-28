<?php /* Smarty version Smarty-3.0.7, created on 2011-10-23 15:53:23
         compiled from "simpla/design/html/delivery.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13619237484ea40e43558cb5-20032828%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b21f8ef926c525a996bc42860fdf4a64309d3a39' => 
    array (
      0 => 'simpla/design/html/delivery.tpl',
      1 => 1317221000,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13619237484ea40e43558cb5-20032828',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php ob_start(); ?>
	<li><a href="index.php?module=SettingsAdmin">Настройки</a></li>
	<li><a href="index.php?module=CurrencyAdmin">Валюты</a></li>
	<li class="active"><a href="index.php?module=DeliveriesAdmin">Доставка</a></li>
	<li><a href="index.php?module=PaymentMethodsAdmin">Оплата</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
<?php $_template = new Smarty_Internal_Template('tinymce_init.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<script src="design/js/jquery/jquery.js"></script>
<script src="design/js/jquery/jquery-ui.min.js"></script>

<script>
$(function() {

$('select[name=module]').change(function(){
	$('div#module_settings').hide();
	$('div#module_settings[module='+$(this).val()+']').show();
	});
});


</script>






<?php if ($_smarty_tpl->getVariable('message_success')->value){?>
<!-- Системное сообщение -->
<div class="message message_success">
	<span><?php echo $_smarty_tpl->getVariable('message_success')->value;?>
</span>
	<a class="link" target="_blank" href="../products/<?php echo $_smarty_tpl->getVariable('page')->value->url;?>
">Открыть страницу на сайте</a>
	<?php if ($_GET['return']){?>
	<a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
	<?php }?>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>

<?php if ($_smarty_tpl->getVariable('message_error')->value){?>
<!-- Системное сообщение -->
<div class="message message_error">
	<span><?php echo $_smarty_tpl->getVariable('message_error')->value;?>
</span>
	<a class="link" href="../products/<?php echo $_smarty_tpl->getVariable('product')->value->url;?>
">Открыть товар на сайте</a>
	<a class="button" href="">Вернуться</a>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>


<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
	<div id="name">
		<input class="name" name=name type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('delivery')->value->name);?>
"/> 
		<input name=id type="hidden" value="<?php echo $_smarty_tpl->getVariable('delivery')->value->id;?>
"/> 
		<div class="checkbox">
			<input name=enabled value='1' type="checkbox" id="active_checkbox" <?php if ($_smarty_tpl->getVariable('delivery')->value->enabled){?>checked<?php }?>/> <label for="active_checkbox">Активен</label>
		</div>
	</div> 

	<!-- Левая колонка свойств товара -->
	<div id="column_left">
		<!-- Параметры страницы -->
		<div class="block layer">
			<h2>Стоимость доставки</h2>
			<ul>
				<li><label class=property>Стоимость</label><input name="price" class="simpla_small_inp" type="text" value="<?php echo $_smarty_tpl->getVariable('delivery')->value->price;?>
" /> <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
</li>
				<li><label class=property>Бесплатна от</label><input name="free_from" class="simpla_small_inp" type="text" value="<?php echo $_smarty_tpl->getVariable('delivery')->value->free_from;?>
" /> <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
</li>
				<li><label class=property for="separate_payment">Оплачивается отдельно</label><input id="separate_payment" name="separate_payment" type="checkbox" value="1" <?php if ($_smarty_tpl->getVariable('delivery')->value->separate_payment){?>checked<?php }?> /></li>
			</ul>
		</div>
		<!-- Параметры страницы (The End)-->

	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	<!-- Левая колонка свойств товара -->
	<div id="column_right">
		<div class="block layer">
		<h2>Возможные способы оплаты</h2>
		<ul>
		<?php  $_smarty_tpl->tpl_vars['payment_method'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('payment_methods')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['payment_method']->key => $_smarty_tpl->tpl_vars['payment_method']->value){
?>
			<li>
			<input type=checkbox name="delivery_payments[]" id="payment_<?php echo $_smarty_tpl->getVariable('payment_method')->value->id;?>
" value='<?php echo $_smarty_tpl->getVariable('payment_method')->value->id;?>
' <?php if (in_array($_smarty_tpl->getVariable('payment_method')->value->id,$_smarty_tpl->getVariable('delivery_payments')->value)){?>checked<?php }?>> <label for="payment_<?php echo $_smarty_tpl->getVariable('payment_method')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('payment_method')->value->name;?>
</label><br>
			</li>
		<?php }} ?>
		</ul>		
		</div>
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	<!-- Описагние товара -->
	<div class="block layer">
		<h2>Описание</h2>
		<textarea name="description" class="editor_small"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('delivery')->value->description);?>
</textarea>
	</div>
	<!-- Описание товара (The End)-->
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->

