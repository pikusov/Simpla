<?php /* Smarty version Smarty-3.0.7, created on 2011-12-23 15:55:49
         compiled from "simpla/design/html/payment_method.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18069048334ef488658e6b50-05057448%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ff9029d7196d823fbfdec339de870b4d17e28d9' => 
    array (
      0 => 'simpla/design/html/payment_method.tpl',
      1 => 1324648548,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18069048334ef488658e6b50-05057448',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php ob_start(); ?>
		<li><a href="index.php?module=SettingsAdmin">Настройки</a></li>
		<li><a href="index.php?module=CurrencyAdmin">Валюты</a></li>
		<li><a href="index.php?module=DeliveriesAdmin">Доставка</a></li>
		<li class="active"><a href="index.php?module=PaymentMethodsAdmin">Оплата</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>

<?php if ($_smarty_tpl->getVariable('payment_method')->value->id){?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable($_smarty_tpl->getVariable('payment_method')->value->name, null, 1);?>
<?php }else{ ?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Новый способ оплаты', null, 1);?>
<?php }?>
<?php $_template = new Smarty_Internal_Template('tinymce_init.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<script src="design/js/jquery/jquery.js"></script>
<script src="design/js/jquery/jquery-ui.min.js"></script>

<script>
$(function() {
	$('div#module_settings').filter(':hidden').find("input, select, textarea").attr("disabled", true);

	$('select[name=module]').change(function(){
		$('div#module_settings').hide().find("input, select, textarea").attr("disabled", true);
		$('div#module_settings[module='+$(this).val()+']').show().find("input, select, textarea").attr("disabled", false);
	});
});


</script>






<?php if ($_smarty_tpl->getVariable('message_success')->value){?>
<!-- Системное сообщение -->
<div class="message message_success">
	<span><?php echo $_smarty_tpl->getVariable('message_success')->value;?>
</span>
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
	<a class="button" href="">Вернуться</a>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>


<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
	<div id="name">
		<input class="name" name=name type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('payment_method')->value->name);?>
"/> 
		<input name=id type="hidden" value="<?php echo $_smarty_tpl->getVariable('payment_method')->value->id;?>
"/> 
		<div class="checkbox">
			<input name=enabled value='1' type="checkbox" id="active_checkbox" <?php if ($_smarty_tpl->getVariable('payment_method')->value->enabled){?>checked<?php }?>/> <label for="active_checkbox">Активен</label>
		</div>
	</div> 

	<div id="product_categories">
		<select name="module">
            <option value='null'>Ручная обработка</option>
       		<?php  $_smarty_tpl->tpl_vars['payment_module'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('payment_modules')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['payment_module']->key => $_smarty_tpl->tpl_vars['payment_module']->value){
?>
            	<option value='<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['payment_module']->key);?>
' <?php if ($_smarty_tpl->getVariable('payment_method')->value->module==$_smarty_tpl->tpl_vars['payment_module']->key){?>selected<?php }?> ><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('payment_module')->value->name);?>
</option>
        	<?php }} ?>
		</select>
	</div>
	
	<div id="product_brand">
		<label>Валюта</label>
		<div>
		<select name="currency_id">
			<?php  $_smarty_tpl->tpl_vars['currency'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('currencies')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['currency']->key => $_smarty_tpl->tpl_vars['currency']->value){
?>
            <option value='<?php echo $_smarty_tpl->getVariable('currency')->value->id;?>
' <?php if ($_smarty_tpl->getVariable('currency')->value->id==$_smarty_tpl->getVariable('payment_method')->value->currency_id){?>selected<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('currency')->value->name);?>
</option>
            <?php }} ?>
		</select>
		</div>
	</div>
	
	<!-- Левая колонка свойств товара -->
	<div id="column_left">
	
   		<?php  $_smarty_tpl->tpl_vars['payment_module'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('payment_modules')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['payment_module']->key => $_smarty_tpl->tpl_vars['payment_module']->value){
?>
        	<div class="block layer" <?php if ($_smarty_tpl->tpl_vars['payment_module']->key!=$_smarty_tpl->getVariable('payment_method')->value->module){?>style='display:none;'<?php }?> id=module_settings module='<?php echo $_smarty_tpl->tpl_vars['payment_module']->key;?>
'>
			<h2><?php echo $_smarty_tpl->getVariable('payment_module')->value->name;?>
</h2>
			<ul>
			<?php  $_smarty_tpl->tpl_vars['setting'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('payment_module')->value->settings; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['setting']->key => $_smarty_tpl->tpl_vars['setting']->value){
?>
				<?php $_smarty_tpl->tpl_vars['variable_name'] = new Smarty_variable($_smarty_tpl->getVariable('setting')->value->variable, null, null);?>
				<?php if (count($_smarty_tpl->getVariable('setting')->value->options)>1){?>
				<li><label class=property><?php echo $_smarty_tpl->getVariable('setting')->value->name;?>
</label>
				<select name="payment_settings[<?php echo $_smarty_tpl->getVariable('setting')->value->variable;?>
]">
					<?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('setting')->value->options; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
?>
					<option value='<?php echo $_smarty_tpl->getVariable('option')->value->value;?>
' <?php if ($_smarty_tpl->getVariable('option')->value->value==$_smarty_tpl->getVariable('payment_settings')->value[$_smarty_tpl->getVariable('setting')->value->variable]){?>selected<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('option')->value->name);?>
</option>
					<?php }} ?>
				</select>
				</li>
				<?php }elseif(count($_smarty_tpl->getVariable('setting')->value->options)==1){?>
				<?php $_smarty_tpl->tpl_vars['option'] = new Smarty_variable($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['first'][0][0]->first_modifier($_smarty_tpl->getVariable('setting')->value->options), null, null);?>
				<li><label class=property><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('setting')->value->name);?>
</label><input name="payment_settings[<?php echo $_smarty_tpl->getVariable('setting')->value->variable;?>
]" class="simpla_inp" type="checkbox" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('option')->value->value);?>
" <?php if ($_smarty_tpl->getVariable('option')->value->value==$_smarty_tpl->getVariable('payment_settings')->value[$_smarty_tpl->getVariable('setting')->value->variable]){?>checked<?php }?> id="<?php echo $_smarty_tpl->getVariable('setting')->value->variable;?>
" /> <label for="<?php echo $_smarty_tpl->getVariable('setting')->value->variable;?>
"><?php echo $_smarty_tpl->getVariable('option')->value->name;?>
</label></li>
				<?php }else{ ?>
				<li><label class=property><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('setting')->value->name);?>
</label><input name="payment_settings[<?php echo $_smarty_tpl->getVariable('setting')->value->variable;?>
]" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('payment_settings')->value[$_smarty_tpl->getVariable('setting')->value->variable]);?>
" /></li>
				<?php }?>
			<?php }} ?>
			</ul>
        	
        	</div>
    	<?php }} ?>
    	<div class="block layer" <?php if ($_smarty_tpl->getVariable('payment_method')->value->module!=''){?>style='display:none;'<?php }?> id=module_settings module='null'></div>

	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	<!-- Правая колонка -->
	<div id="column_right">
		<div class="block layer">
		<h2>Возможные способы доставки</h2>
		<ul>
		<?php  $_smarty_tpl->tpl_vars['delivery'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('deliveries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['delivery']->key => $_smarty_tpl->tpl_vars['delivery']->value){
?>
			<li>
			<input type=checkbox name="payment_deliveries[]" id="delivery_<?php echo $_smarty_tpl->getVariable('delivery')->value->id;?>
" value='<?php echo $_smarty_tpl->getVariable('delivery')->value->id;?>
' <?php if (in_array($_smarty_tpl->getVariable('delivery')->value->id,$_smarty_tpl->getVariable('payment_deliveries')->value)){?>checked<?php }?>> <label for="delivery_<?php echo $_smarty_tpl->getVariable('delivery')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('delivery')->value->name;?>
</label><br>
			</li>
		<?php }} ?>
		</ul>		
		</div>
	</div>
	<!-- Правая колонка (The End)--> 
	
	<!-- Описагние товара -->
	<div class="block layer">
		<h2>Описание</h2>
		<textarea name="description" class="editor_small"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('payment_method')->value->description);?>
</textarea>
	</div>
	<!-- Описание товара (The End)-->
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->

