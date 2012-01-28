<?php /* Smarty version Smarty-3.0.7, created on 2012-01-03 19:48:42
         compiled from "/Users/denispikusov/Sites/simpla//design/default/html/product.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6991190164f033f7a474d86-95215651%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '254cd18f2612436c70c3b27689b554711c90803d' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/product.tpl',
      1 => 1325167484,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6991190164f033f7a474d86-95215651',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
if (!is_callable('smarty_function_math')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/function.math.php';
?>
  <!-- Хлебные крошки /-->
  <div id="path">
    <a href="./">Главная</a>
    <?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('category')->value->path; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value){
?>
    → <a href="catalog/<?php echo $_smarty_tpl->getVariable('cat')->value->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('cat')->value->name);?>
</a>
    <?php }} ?>
    <?php if ($_smarty_tpl->getVariable('brand')->value){?>
    → <a href="catalog/<?php echo $_smarty_tpl->getVariable('cat')->value->url;?>
/<?php echo $_smarty_tpl->getVariable('brand')->value->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('brand')->value->name);?>
</a>
    <?php }?>
    →  <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
                
  </div>
<!-- Хлебные крошки #End /-->

<h1 data-product="<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
</h1>

<div class="product">

	<!-- Большое фото -->
	<?php if ($_smarty_tpl->getVariable('product')->value->image){?>
	<div class="image">
		<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('product')->value->image->filename,800,600,'w');?>
" class="zoom" data-rel="group"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('product')->value->image->filename,300,300);?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->product->name);?>
" /></a>
	</div>
	<?php }?>
	<!-- Большое фото (The End)-->

	<!-- Описание товара -->
	<div class="description">
	
		<?php echo $_smarty_tpl->getVariable('product')->value->body;?>

		
		<?php if (count($_smarty_tpl->getVariable('product')->value->variants)>0){?>
		<!-- Выбор варианта товара -->
		<form class="variants" action="/cart">
			<table>
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('product')->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['v']->index++;
 $_smarty_tpl->tpl_vars['v']->first = $_smarty_tpl->tpl_vars['v']->index === 0;
?>
			<tr class="variant">
				<td>
					<input id="product_<?php echo $_smarty_tpl->getVariable('v')->value->id;?>
" name="variant" value="<?php echo $_smarty_tpl->getVariable('v')->value->id;?>
" type="radio" class="variant_radiobutton" <?php if ($_smarty_tpl->tpl_vars['v']->first){?>checked<?php }?> <?php if (count($_smarty_tpl->getVariable('product')->value->variants)<2){?>style="display:none;"<?php }?>/>
				</td>
				<td>
					<?php if ($_smarty_tpl->getVariable('v')->value->name){?><label class="variant_name" for="product_<?php echo $_smarty_tpl->getVariable('v')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('v')->value->name;?>
</label><?php }?>
				</td>
				<td>
					<?php if ($_smarty_tpl->getVariable('v')->value->compare_price>0){?><span class="compare_price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('v')->value->compare_price);?>
</span><?php }?>
					<span class="price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('v')->value->price);?>
 <span class="currency"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('currency')->value->sign);?>
</span></span>
				</td>
			</tr>
			<?php }} ?>
			</table>
			<input type="submit" class="myButton" value="в корзину" data-result-text="добавлено"/>
		</form>
		<!-- Выбор варианта товара (The End) -->
		<?php }else{ ?>
			Нет в наличии
		<?php }?>
			
	</div>
	<!-- Описание товара (The End)-->

	<!-- Дополнительные фото продукта -->
	<?php if (count($_smarty_tpl->getVariable('product')->value->images)>1){?>
	<div class="images">
		<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['cut'][0][0]->cut_modifier($_smarty_tpl->getVariable('product')->value->images); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['image']->key;
?>
			<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('image')->value->filename,800,600,'w');?>
" class="zoom" data-rel="group"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('image')->value->filename,95,95);?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
" /></a>
		<?php }} ?>
	</div>
	<?php }?>
	<!-- Дополнительные фото продукта (The End)-->

	
	<?php if ($_smarty_tpl->getVariable('product')->value->features){?>
	<!-- Характеристики товара -->
	<h2>Характеристики</h2>
	<ul class="features">
	<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('product')->value->features; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
?>
	<li>
		<label><?php echo $_smarty_tpl->getVariable('f')->value->name;?>
</label>
		<span><?php echo $_smarty_tpl->getVariable('f')->value->value;?>
</span>
	</li>
	<?php }} ?>
	</ul>
	<!-- Характеристики товара (The End)-->
	<?php }?>

	<!-- Соседние товары /-->
	<div id="back_forward">
		<?php if ($_smarty_tpl->getVariable('prev_product')->value){?>
			←&nbsp;<a class="prev_page_link" href="products/<?php echo $_smarty_tpl->getVariable('prev_product')->value->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('prev_product')->value->name);?>
</a>
		<?php }?>
		<?php if ($_smarty_tpl->getVariable('next_product')->value){?>
			<a class="next_page_link" href="products/<?php echo $_smarty_tpl->getVariable('next_product')->value->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('next_product')->value->name);?>
</a>&nbsp;→
		<?php }?>
	</div>
	
</div>
<!-- Описание товара (The End)-->
<?php if ($_smarty_tpl->getVariable('related_products')->value){?>
<h2>Так же советуем посмотреть</h2>
<!-- Список каталога товаров-->
<ul class="tiny_products">
	<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('related_products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
?>
	<!-- Товар-->
	<li class="product">
		
		<!-- Фото товара -->
		<?php if ($_smarty_tpl->getVariable('product')->value->image){?>
		<div class="image">
			<a href="products/<?php echo $_smarty_tpl->getVariable('product')->value->url;?>
"><img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('product')->value->image->filename,200,200);?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
"/></a>
		</div>
		<?php }?>
		<!-- Фото товара (The End) -->

		<!-- Название товара -->
		<h3><a data-product="<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
" href="products/<?php echo $_smarty_tpl->getVariable('product')->value->url;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
</a></h3>
		<!-- Название товара (The End) -->

		<?php if (count($_smarty_tpl->getVariable('product')->value->variants)>0){?>
		<!-- Выбор варианта товара -->
		<form class="variants" action="/cart">
			<table>
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('product')->value->variants; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['v']->index++;
 $_smarty_tpl->tpl_vars['v']->first = $_smarty_tpl->tpl_vars['v']->index === 0;
?>
			<tr class="variant">
				<td>
					<input id="related_<?php echo $_smarty_tpl->getVariable('v')->value->id;?>
" name="variant" value="<?php echo $_smarty_tpl->getVariable('v')->value->id;?>
" type="radio" class="variant_radiobutton" <?php if (count($_smarty_tpl->getVariable('product')->value->variants)<2){?>checked style="display:none;"<?php }?>/>
				</td>
				<td>
					<?php if ($_smarty_tpl->getVariable('v')->value->name){?><label class="variant_name" for="related_<?php echo $_smarty_tpl->getVariable('v')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('v')->value->name;?>
</label><?php }?>
				</td>
				<td>
					<?php if ($_smarty_tpl->getVariable('v')->value->compare_price>0){?><span class="compare_price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('v')->value->compare_price);?>
</span><?php }?>
					<span class="price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['convert'][0][0]->convert($_smarty_tpl->getVariable('v')->value->price);?>
 <span class="currency"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('currency')->value->sign);?>
</span></span>
				</td>
			</tr>
			<?php }} ?>
			</table>
			<input type="submit" class="myButton" value="в корзину" data-result-text="добавлено"/>
		</form>
		<!-- Выбор варианта товара (The End) -->
		<?php }else{ ?>
			Нет в наличии
		<?php }?>


	</li>
	<!-- Товар (The End)-->
	<?php }} ?>
</ul>
<?php }?>

<!-- Комментарии -->
<div id="comments">

	<h2>Комментарии</h2>
	
	<?php if ($_smarty_tpl->getVariable('comments')->value){?>
	<!-- Список с комментариями -->
	<ul class="comment_list">
		<?php  $_smarty_tpl->tpl_vars['comment'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('comments')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['comment']->key => $_smarty_tpl->tpl_vars['comment']->value){
?>
		<a name="comment_<?php echo $_smarty_tpl->getVariable('comment')->value->id;?>
"></a>
		<li>
			<!-- Имя и дата комментария-->
			<div class="comment_header">	
				<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('comment')->value->name);?>
 <i><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->getVariable('comment')->value->date);?>
, <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->getVariable('comment')->value->date);?>
</i>
				<?php if (!$_smarty_tpl->getVariable('comment')->value->approved){?>ожидает модерации</b><?php }?>
			</div>
			<!-- Имя и дата комментария (The End)-->
			
			<!-- Комментарий -->
			<?php echo nl2br(smarty_modifier_escape($_smarty_tpl->getVariable('comment')->value->text));?>

			<!-- Комментарий (The End)-->
		</li>
		<?php }} ?>
	</ul>
	<!-- Список с комментариями (The End)-->
	<?php }else{ ?>
	<p>
		Пока нет комментариев
	</p>
	<?php }?>
	
	<!--Форма отправления комментария-->	
	<form class="comment_form" method="post">
		<h2>Написать комментарий</h2>
		<?php if ($_smarty_tpl->getVariable('error')->value){?>
		<div class="message_error">
			<?php if ($_smarty_tpl->getVariable('error')->value=='captcha'){?>
			Неверно введена капча
			<?php }elseif($_smarty_tpl->getVariable('error')->value=='empty_name'){?>
			Введите имя
			<?php }elseif($_smarty_tpl->getVariable('error')->value=='empty_comment'){?>
			Введите комментарий
			<?php }?>
		</div>
		<?php }?>
		<textarea class="comment_textarea" id="comment_text" name="text" data-format=".+" data-notice="Введите комментарий"><?php echo $_smarty_tpl->getVariable('comment_text')->value;?>
</textarea><br />
		<div>
		<label for="comment_name">Имя</label>
		<input class="input_name" type="text" id="comment_name" name="name" value="<?php echo $_smarty_tpl->getVariable('comment_name')->value;?>
" data-format=".+" data-notice="Введите имя"/><br />
		
		<label for="comment_captcha">Число</label>
		<div class="captcha"><img src="captcha/image.php?<?php echo smarty_function_math(array('equation'=>'rand(10,10000)'),$_smarty_tpl);?>
" alt='captcha'/></div> 
		<input class="input_captcha" id="comment_captcha" type="text" name="captcha_code" value="" data-format="\d\d\d\d" data-notice="Введите капчу"/>
		
		<input class="button_send" type="submit" name="comment" value="Отправить" />
		</div>
	</form>
	<!--Форма отправления комментария (The End)-->
	
</div>
<!-- Комментарии (The End) -->


<script>
$(function() {
	// Раскраска строк характеристик
	$(".features li:even").addClass('even');

	// Зум картинок
	$("a.zoom").fancybox({ 'hideOnContentClick' : true });
});
</script>

