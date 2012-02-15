<?php /* Smarty version Smarty-3.0.7, created on 2012-02-06 15:13:36
         compiled from "simpla/design/html/product.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18897574534f2fe0107f6078-67114273%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b90adbe07b8cb8775992b60a66b5fc21f18942e' => 
    array (
      0 => 'simpla/design/html/product.tpl',
      1 => 1328537482,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18897574534f2fe0107f6078-67114273',
  'function' => 
  array (
    'category_select' => 
    array (
      'parameter' => 
      array (
        'level' => 0,
      ),
      'compiled' => '',
    ),
  ),
  'has_nocache_code' => 0,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
if (!is_callable('smarty_modifier_truncate')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.truncate.php';
?><?php ob_start(); ?>
		<li class="active"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'ProductsAdmin','category_id'=>$_smarty_tpl->getVariable('product')->value->category_id,'return'=>null,'brand_id'=>null,'id'=>null),$_smarty_tpl);?>
">Товары</a></li>
		<li><a href="index.php?module=CategoriesAdmin">Категории</a></li>
		<li><a href="index.php?module=BrandsAdmin">Бренды</a></li>
		<li><a href="index.php?module=FeaturesAdmin">Свойства</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
<?php if ($_smarty_tpl->getVariable('product')->value->id){?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable($_smarty_tpl->getVariable('product')->value->name, null, 1);?>
<?php }else{ ?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Новый товар', null, 1);?>
<?php }?>
<?php $_template = new Smarty_Internal_Template('tinymce_init.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<script src="design/js/autocomplete/jquery.autocomplete-min.js"></script>
<style>
.autocomplete-w1 {position:absolute; top:0px; left:0px; margin:6px 0 0 6px; /* IE6 fix: */ _background:none; _margin:1px 0 0 0; }
.autocomplete { border:1px solid #999; background:#FFF; cursor:default; text-align:left; overflow-x:auto; min-width: 300px; overflow-y: auto; margin:-6px 6px 6px -6px; /* IE6 specific: */ _height:350px;  _margin:0; _overflow-x:hidden; }
.autocomplete .selected { background:#F0F0F0; }
.autocomplete div { padding:2px 5px; white-space:nowrap; }
.autocomplete strong { font-weight:normal; color:#3399FF; }
</style>

<script>
$(function() {

	// Добавление категории
	$('#product_categories .add').click(function() {
		$("#product_categories ul li:last").clone(false).appendTo('#product_categories ul').fadeIn('slow').find("select[name*=categories]:last").focus();
		$("#product_categories ul li:last span.add").hide();
		$("#product_categories ul li:last span.delete").show();
		return false;		
	});

	// Удаление категории
	$("#product_categories .delete").live('click', function() {
		$(this).closest("li").fadeOut(200, function() { $(this).remove(); });
		return false;
	});

	// Сортировка вариантов
	$("#variants_block").sortable({ items: '#variants ul' , axis: 'y',  cancel: '#header', handle: '.move_zone' });
	// Сортировка вариантов
	$("table.related_products").sortable({ items: 'tr' , axis: 'y',  cancel: '#header', handle: '.move_zone' });

	
	// Сортировка связанных товаров
	$(".sortable").sortable({
		items: "div.row",
		tolerance:"pointer",
		scrollSensitivity:40,
		opacity:0.7,
		handle: '.move_zone'
	});
		

	// Сортировка изображений
	$(".images ul").sortable({ tolerance: 'pointer'});

	// Удаление изображений
	$(".images a.delete").live('click', function() {
		 $(this).closest("li").fadeOut(200, function() { $(this).remove(); });
		 return false;
	});
	// Загрузить изображение с компьютера
	$('#upload_image').click(function() {
		$("<input class='upload_image' name=images[] type=file>").appendTo('div#add_image').focus().click();
	});
	// Или с URL
	$('#add_image_url').click(function() {
		$("<input class='remote_image' name=images_urls[] type=text value='http://'>").appendTo('div#add_image').focus().select();
	});
	
 
	// Удаление варианта
	$('a.del_variant').click(function() {
		if($("#variants ul").size()>1)
		{
			$(this).closest("ul").fadeOut(200, function() { $(this).remove(); });
		}
		else
		{
			$('#variants_block .variant_name input[name*=variant][name*=name]').val('');
			$('#variants_block .variant_name').hide('slow');
			$('#variants_block').addClass('single_variant');
		}
		return false;
	});

	// Загрузить файл к варианту
	$('#variants_block a.add_attachment').click(function() {
		$(this).hide();
		$(this).closest('li').find('div.browse_attachment').show('fast');
		$(this).closest('li').find('input[name*=attachment]').attr('disabled', false);
		return false;		
	});
	
	// Удалить файл к варианту
	$('#variants_block a.remove_attachment').click(function() {
		closest_li = $(this).closest('li');
		closest_li.find('.attachment_name').hide('fast');
		$(this).hide('fast');
		closest_li.find('input[name*=delete_attachment]').val('1');
		closest_li.find('a.add_attachment').show('fast');
		return false;		
	});


	// Добавление варианта
	var variant = $('#new_variant').clone(true);
	$('#new_variant').remove().removeAttr('id');
	$('#variants_block span.add').click(function() {
		if(!$('#variants_block').is('.single_variant'))
		{
			$(variant).clone(true).appendTo('#variants').fadeIn('slow').find("input[name*=variant][name*=name]").focus();
		}
		else
		{
			$('#variants_block .variant_name').show('slow');
			$('#variants_block').removeClass('single_variant');		
		}
		return false;		
	});
	
	
	function show_category_features(category_id)
	{
		$('ul.prop_ul li').hide(); 
		if(categories_features[category_id] !== undefined)
		{
			$('ul.prop_ul li').filter(function(){return jQuery.inArray($(this).attr("feature_id"), categories_features[category_id])>-1;}).show();	
		}
	}
	// Изменение набора свойств при изменении категории
	$('select[name="categories[]"]:first').change(function() {
		show_category_features($("option:selected",this).val());
	});
	show_category_features($('select[name="categories[]"]:first option:selected').val());
	
	
	// Добавление нового свойства товара
	var feature = $('#new_feature').clone(true);
	$('#new_feature').remove().removeAttr('id');
	$('#add_new_feature').click(function() {
		$(feature).clone(true).appendTo('ul.new_features').fadeIn('slow').find("input[name*=new_feature_name]").focus();
		return false;		
	});
	
	// Подсказки для свойств
	$('input[name*="options"]').each(function(index) {
		f_id = $(this).closest('li').attr('feature_id');
		ac = $(this).autocomplete({
			serviceUrl:'ajax/options_autocomplete.php',
			minChars:0,
			params: {feature_id:f_id},
			noCache: false
		});
	});
		
	// Удаление связанного товара
	$(".related_products a.delete").live('click', function() {
		 $(this).closest("div.row").fadeOut(200, function() { $(this).remove(); });
		 return false;
	});
 

	// Добавление связанного товара 
	var new_related_product = $('#new_related_product').clone(true);
	$('#new_related_product').remove().removeAttr('id');
 
	$("input#related_products").autocomplete({
		serviceUrl:'ajax/search_products.php',
		minChars:0,
		noCache: false, 
		onSelect:
			function(value, data){
				new_item = new_related_product.clone().appendTo('.related_products');
				new_item.removeAttr('id');
				new_item.find('a.related_product_name').html(data.name);
				new_item.find('a.related_product_name').attr('href', 'index.php?module=ProductAdmin&id='+data.id);
				new_item.find('input[name*="related_products"]').val(data.id);
				if(data.image)
					new_item.find('img.product_icon').attr("src", data.image);
				else
					new_item.find('img.product_icon').remove();
				$("#related_products").val(''); 
				new_item.show();
			},
		fnFormatResult:
			function(value, data, currentValue){
				var reEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
				var pattern = '(' + currentValue.replace(reEscape, '\\$1') + ')';
  				return (data.image?"<img align=absmiddle src='"+data.image+"'> ":'') + value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');
			}

	});
  

	// infinity
	$("input[name*=variant][name*=stock]").focus(function() {
		if($(this).val() == '∞')
			$(this).val('');
		return false;
	});

	$("input[name*=variant][name*=stock]").blur(function() {
		if($(this).val() == '')
			$(this).val('∞');
	});
	
	// Волшебные изображения
	name_changed = false;
	$("input[name=name]").change(function() {
		name_changed = true;
		images_loaded = 0;
	});	
	images_num = 8;
	images_loaded = 0;
	old_wizar_dicon_src = $('#images_wizard img').attr('src');
	$('#images_wizard').click(function() {
		
		$('#images_wizard img').attr('src', 'design/images/loader.gif');
		if(name_changed)
			$('div.images ul li.wizard').remove();
		name_changed = false;
		key = $('input[name=name]').val();
		$.ajax({
 			 url: "ajax/get_images.php",
 			 	data: {keyword: key, start: images_loaded},
 			 	dataType: 'json',
  				success: function(data){
    				for(i=0; i<Math.min(data.length, images_num); i++)
    				{
	    				image_url = data[i];
						$("<li class=wizard><a href='' class='delete'><img src='design/images/cross-circle-frame.png'></a><a href='"+image_url+"' target=_blank><img onerror='$(this).closest(\"li\").remove();' width=100 src='"+image_url+"' /><input name=images_urls[] type=hidden value='"+image_url+"'></a></li>").appendTo('div .images ul');
    				}
					$('#images_wizard img').attr('src', old_wizar_dicon_src);
					images_loaded += images_num;
  				}
		});
		return false;
	});
	
	// Волшебное описание
	name_changed = false;
	$("input[name=name]").change(function() {
		name_changed = true;
	});	
	old_prop_wizard_icon_src = $('#properties_wizard img').attr('src');
	$('#properties_wizard').click(function() {
		
		$('#properties_wizard img').attr('src', 'design/images/loader.gif');
		if(name_changed)
			$('div.images ul li.wizard').remove();
		name_changed = false;
		key = $('input[name=name]').val();
		$.ajax({
 			 url: "ajax/get_info.php",
 			 	data: {keyword: key},
 			 	dataType: 'json',
  				success: function(data){
  					if(data)
  					{
  						$('li#new_feature').remove();
	    				for(i=0; i<data.options.length; i++)
	    				{
	    					option_name = data.options[i].name;
	    					option_value = data.options[i].value;
							// Добавление нового свойства товара
							exists = false;
							if(!$('label.property:visible:contains('+option_name+')').closest('li').find('input[name*=options]').val(option_value).length)
							{
								f = $(feature).clone(true);
								f.find('input[name*=new_features_names]').val(option_name);
								f.find('input[name*=new_features_values]').val(option_value);
								f.appendTo('ul.new_features').fadeIn('slow');
							}
	   					}
	   					
   					}
					$('#properties_wizard img').attr('src', old_prop_wizard_icon_src);
					
				},
				error: function(xhr, textStatus, errorThrown){
                	alert("Error: " +textStatus);
           		}
		});
		return false;
	});
	

	// Автозаполнение мета-тегов
	meta_title_touched = true;
	meta_keywords_touched = true;
	meta_description_touched = true;
	url_touched = true;
	
	if($('input[name="meta_title"]').val() == generate_meta_title() || $('input[name="meta_title"]').val() == '')
		meta_title_touched = false;
	if($('input[name="meta_keywords"]').val() == generate_meta_keywords() || $('input[name="meta_keywords"]').val() == '')
		meta_keywords_touched = false;
	if($('textarea[name="meta_description"]').val() == generate_meta_description() || $('textarea[name="meta_description"]').val() == '')
		meta_description_touched = false;
	if($('input[name="url"]').val() == generate_url() || $('input[name="url"]').val() == '')
		url_touched = false;
		
	$('input[name="meta_title"]').change(function() { meta_title_touched = true; });
	$('input[name="meta_keywords"]').change(function() { meta_keywords_touched = true; });
	$('textarea[name="meta_description"]').change(function() { meta_description_touched = true; });
	$('input[name="url"]').change(function() { url_touched = true; });
	
	$('input[name="name"]').keyup(function() { set_meta(); });
	$('select[name="brand_id"]').change(function() { set_meta(); });
	$('select[name="categories[]"]').change(function() { set_meta(); });
	
});

function set_meta()
{
	if(!meta_title_touched)
		$('input[name="meta_title"]').val(generate_meta_title());
	if(!meta_keywords_touched)
		$('input[name="meta_keywords"]').val(generate_meta_keywords());
	if(!meta_description_touched)
		$('textarea[name="meta_description"]').val(generate_meta_description());
	if(!url_touched)
		$('input[name="url"]').val(generate_url());
}

function generate_meta_title()
{
	name = $('input[name="name"]').val();
	return name;
}

function generate_meta_keywords()
{
	name = $('input[name="name"]').val();
	result = name;
	brand = $('select[name="brand_id"] option:selected').attr('brand_name');
	if(typeof(brand) == 'string' && brand!='')
			result += ', '+brand;
	$('select[name="categories[]"]').each(function(index) {
		c = $(this).find('option:selected').attr('category_name');
		if(typeof(c) == 'string' && c != '')
    		result += ', '+c;
	}); 
	return result;
}

function generate_meta_description()
{
	if(typeof(tinyMCE.get("annotation")) =='object')
	{
		description = tinyMCE.get("annotation").getContent().replace(/(<([^>]+)>)/ig," ").replace(/(\&nbsp;)/ig," ").replace(/^\s+|\s+$/g, '').substr(0, 512);
		return description;
	}
	else
		return $('textarea[name=annotation]').val().replace(/(<([^>]+)>)/ig," ").replace(/(\&nbsp;)/ig," ").replace(/^\s+|\s+$/g, '').substr(0, 512);
}

function generate_url()
{
	url = $('input[name="name"]').val();
	url = url.replace(/[\s]+/gi, '_');
	url = translit(url);
	url = url.replace(/[^0-9a-z_]+/gi, '').toLowerCase();	
	return url;
}

function translit(str)
{
	var ru=("А-а-Б-б-В-в-Ґ-ґ-Г-г-Д-д-Е-е-Ё-ё-Є-є-Ж-ж-З-з-И-и-І-і-Ї-ї-Й-й-К-к-Л-л-М-м-Н-н-О-о-П-п-Р-р-С-с-Т-т-У-у-Ф-ф-Х-х-Ц-ц-Ч-ч-Ш-ш-Щ-щ-Ъ-ъ-Ы-ы-Ь-ь-Э-э-Ю-ю-Я-я").split("-")   
	var en=("A-a-B-b-V-v-G-g-G-g-D-d-E-e-E-e-E-e-ZH-zh-Z-z-I-i-I-i-I-i-J-j-K-k-L-l-M-m-N-n-O-o-P-p-R-r-S-s-T-t-U-u-F-f-H-h-TS-ts-CH-ch-SH-sh-SCH-sch-'-'-Y-y-'-'-E-e-YU-yu-YA-ya").split("-")   
 	var res = '';
	for(var i=0, l=str.length; i<l; i++)
	{ 
		var s = str.charAt(i), n = ru.indexOf(s); 
		if(n >= 0) { res += en[n]; } 
		else { res += s; } 
    } 
    return res;  
}

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




<?php if ($_smarty_tpl->getVariable('message_success')->value){?>
<!-- Системное сообщение -->
<div class="message message_success">
	<span><?php if ($_smarty_tpl->getVariable('message_success')->value=='added'){?>Товар добавлен<?php }elseif($_smarty_tpl->getVariable('message_success')->value=='updated'){?>Товар изменен<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('message_success')->value);?>
<?php }?></span>
	<a class="link" target="_blank" href="../products/<?php echo $_smarty_tpl->getVariable('product')->value->url;?>
">Открыть товар на сайте</a>
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
	<span><?php if ($_smarty_tpl->getVariable('message_error')->value=='url_exists'){?>Товар с таким адресом уже существует<?php }elseif($_smarty_tpl->getVariable('message_error')->value=='empty_name'){?>Введите название<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('message_error')->value);?>
<?php }?></span>
	<?php if ($_GET['return']){?>
	<a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
	<?php }?>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>


<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">

 	<div id="name">
		<input class="name" name=name type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
"/> 
		<input name=id type="hidden" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->id);?>
"/> 
		<div class="checkbox">
			<input name=visible value='1' type="checkbox" id="active_checkbox" <?php if ($_smarty_tpl->getVariable('product')->value->visible){?>checked<?php }?>/> <label for="active_checkbox">Активен</label>
		</div>
		<div class="checkbox">
			<input name=featured value="1" type="checkbox" id="featured_checkbox" <?php if ($_smarty_tpl->getVariable('product')->value->featured){?>checked<?php }?>/> <label for="featured_checkbox">Рекомендуемый</label>
		</div>
	</div> 
	
	<div id="product_brand" <?php if (!$_smarty_tpl->getVariable('brands')->value){?>style='display:none;'<?php }?>>
		<label>Бренд</label>
		<select name="brand_id">
            <option value='0' <?php if (!$_smarty_tpl->getVariable('product')->value->brand_id){?>selected<?php }?> brand_name=''>Не указан</option>
       		<?php  $_smarty_tpl->tpl_vars['brand'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('brands')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['brand']->key => $_smarty_tpl->tpl_vars['brand']->value){
?>
            	<option value='<?php echo $_smarty_tpl->getVariable('brand')->value->id;?>
' <?php if ($_smarty_tpl->getVariable('product')->value->brand_id==$_smarty_tpl->getVariable('brand')->value->id){?>selected<?php }?> brand_name='<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('brand')->value->name);?>
'><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('brand')->value->name);?>
</option>
        	<?php }} ?>
		</select>
	</div>
	
	
	<div id="product_categories" <?php if (!$_smarty_tpl->getVariable('categories')->value){?>style='display:none;'<?php }?>>
		<label>Категория</label>
		<div>
			<ul>
				<?php  $_smarty_tpl->tpl_vars['product_category'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('product_categories')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product_category']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product_category']->key => $_smarty_tpl->tpl_vars['product_category']->value){
 $_smarty_tpl->tpl_vars['product_category']->index++;
 $_smarty_tpl->tpl_vars['product_category']->first = $_smarty_tpl->tpl_vars['product_category']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['categories']['first'] = $_smarty_tpl->tpl_vars['product_category']->first;
?>
				<li>
					<select name="categories[]">
						<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php if (!function_exists('smarty_template_function_category_select')) {
    function smarty_template_function_category_select($_smarty_tpl,$params) {
    $saved_tpl_vars = $_smarty_tpl->tpl_vars;
    foreach ($_smarty_tpl->template_functions['category_select']['parameter'] as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);};
    foreach ($params as $key => $value) {$_smarty_tpl->tpl_vars[$key] = new Smarty_variable($value);}?>
						<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('categories')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
?>
								<option value='<?php echo $_smarty_tpl->getVariable('category')->value->id;?>
' <?php if ($_smarty_tpl->getVariable('category')->value->id==$_smarty_tpl->getVariable('selected_id')->value){?>selected<?php }?> category_name='<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('category')->value->name);?>
'><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['name'] = 'sp';
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('level')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['sp']['total']);
?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endfor; endif; ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('category')->value->name);?>
</option>
								<?php smarty_template_function_category_select($_smarty_tpl,array('categories'=>$_smarty_tpl->getVariable('category')->value->subcategories,'selected_id'=>$_smarty_tpl->getVariable('selected_id')->value,'level'=>$_smarty_tpl->getVariable('level')->value+1));?>

						<?php }} ?><?php $_smarty_tpl->tpl_vars = $saved_tpl_vars;}}?>

						<?php smarty_template_function_category_select($_smarty_tpl,array('categories'=>$_smarty_tpl->getVariable('categories')->value,'selected_id'=>$_smarty_tpl->getVariable('product_category')->value->id));?>

					</select>
					<span <?php if (!$_smarty_tpl->getVariable('smarty')->value['foreach']['categories']['first']){?>style='display:none;'<?php }?> class="add"><i class="dash_link">Дополнительная категория</i></span>
					<span <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['categories']['first']){?>style='display:none;'<?php }?> class="delete"><i class="dash_link">Удалить</i></span>
				</li>
				<?php }} ?>		
			</ul>
		</div>
	</div>


 	<!-- Варианты товара -->
	<div id="variants_block" <?php $_smarty_tpl->tpl_vars['first_variant'] = new Smarty_variable($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['first'][0][0]->first_modifier($_smarty_tpl->getVariable('product_variants')->value), null, null);?><?php if (count($_smarty_tpl->getVariable('product_variants')->value)<=1&&!$_smarty_tpl->getVariable('first_variant')->value->name){?>class=single_variant<?php }?>>
		<ul id="header">
			<li class="variant_move"></li>
			<li class="variant_name">Название варианта</li>	
			<li class="variant_sku">Артикул</li>	
			<li class="variant_price">Цена, <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
</li>	
			<li class="variant_discount">Старая, <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
</li>	
			<li class="variant_amount">Кол-во</li>
		</ul>
		<div id="variants">
		<?php  $_smarty_tpl->tpl_vars['variant'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('product_variants')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['variant']->key => $_smarty_tpl->tpl_vars['variant']->value){
?>
		<ul>
			<li class="variant_move"><div class="move_zone"></div></li>
			<li class="variant_name">      <input name="variants[id][<?php echo $_smarty_tpl->getVariable('variant')->value->id;?>
]"            type="hidden" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('variant')->value->id);?>
" /><input name="variants[name][<?php echo $_smarty_tpl->getVariable('variant')->value->id;?>
]" type="" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('variant')->value->name);?>
" /> <a class="del_variant" href=""><img src="design/images/cross-circle-frame.png" alt="" /></a></li>
			<li class="variant_sku">       <input name="variants[sku][<?php echo $_smarty_tpl->getVariable('variant')->value->id;?>
]"           type="text"   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('variant')->value->sku);?>
" /></li>
			<li class="variant_price">     <input name="variants[price][<?php echo $_smarty_tpl->getVariable('variant')->value->id;?>
]"         type="text"   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('variant')->value->price);?>
" /></li>
			<li class="variant_discount">  <input name="variants[compare_price][<?php echo $_smarty_tpl->getVariable('variant')->value->id;?>
]" type="text"   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('variant')->value->compare_price);?>
" /></li>
			<li class="variant_amount">    <input name="variants[stock][<?php echo $_smarty_tpl->getVariable('variant')->value->id;?>
]"         type="text"   value="<?php if ($_smarty_tpl->getVariable('variant')->value->infinity||$_smarty_tpl->getVariable('variant')->value->stock==''){?>∞<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('variant')->value->stock);?>
<?php }?>" /><?php echo $_smarty_tpl->getVariable('settings')->value->units;?>
</li>
			<li class="variant_download">
			
				<?php if ($_smarty_tpl->getVariable('variant')->value->attachment){?>
					<span class=attachment_name><?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('variant')->value->attachment,25,'...',false,true);?>
</span>
					<a href='#' class=remove_attachment><img src='design/images/bullet_delete.png'  title="Удалить цифровой товар"></a>
					<input type=hidden name="delete_attachment[<?php echo $_smarty_tpl->getVariable('variant')->value->id;?>
]" value=''>
					<a href='#' class=add_attachment style='display:none;'><img src="design/images/cd_add.png" title="Добавить цифровой товар" /></a>
				<?php }else{ ?>
					<a href='#' class=add_attachment><img src="design/images/cd_add.png"  title="Добавить цифровой товар" /></a>
				<?php }?>
				<div class=browse_attachment style='display:none;'>
					<input disabled type=file name=attachment[<?php echo $_smarty_tpl->getVariable('variant')->value->id;?>
]>
				</div>
			
			</li>
		</ul>
		<?php }} ?>		
		</div>
		<ul id=new_variant style='display:none;'>
			<li class="variant_move"><div class="move_zone"></div></li>
			<li class="variant_name"><input name="variants[id][]" type="hidden" value="" /><input name="variants[name][]" type="" value="" /><a class="del_variant" href=""><img src="design/images/cross-circle-frame.png" alt="" /></a></li>
			<li class="variant_sku"><input name="variants[sku][]" type="" value="" /></li>
			<li class="variant_price"><input  name="variants[price][]" type="" value="" /></li>
			<li class="variant_discount"><input name="variants[compare_price][]" type="" value="" /></li>
			<li class="variant_amount"><input name="variants[stock][]" type="" value="∞" /><?php echo $_smarty_tpl->getVariable('settings')->value->units;?>
</li>
			<li class="variant_download">
				<a href='#' class=add_attachment><img src="design/images/cd_add.png" alt="" /></a>
				<div class=browse_attachment style='display:none;'>
					<input type=file name=attachment[]>
				</div>
			</li>
		</ul>

		<input class="button_green button_save" type="submit" name="" value="Сохранить" />
		<span class="add" id="add_variant"><i class="dash_link">Добавить вариант</i></span>
 	</div>
	<!-- Варианты товара (The End)--> 
	
 	<!-- Левая колонка свойств товара -->
	<div id="column_left">
			
		<!-- Параметры страницы -->
		<div class="block layer">
			<h2>Параметры страницы</h2>
			<ul>
				<li><label class=property>Адрес</label><div class="page_url"> /products/</div><input name="url" class="page_url" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->url);?>
" /></li>
				<li><label class=property>Заголовок</label><input name="meta_title" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->meta_title);?>
" /></li>
				<li><label class=property>Ключевые слова</label><input name="meta_keywords" class="simpla_inp" type="text" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->meta_keywords);?>
" /></li>
				<li><label class=property>Описание</label><textarea name="meta_description" class="simpla_inp" /><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->meta_description);?>
</textarea></li>
			</ul>
		</div>
		<!-- Параметры страницы (The End)-->
		
		<!-- Свойства товара -->
		<script>
		var categories_features = new Array();
		<?php  $_smarty_tpl->tpl_vars['fs'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('categories_features')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['fs']->key => $_smarty_tpl->tpl_vars['fs']->value){
 $_smarty_tpl->tpl_vars['c']->value = $_smarty_tpl->tpl_vars['fs']->key;
?>
		categories_features[<?php echo $_smarty_tpl->tpl_vars['c']->value;?>
]  = Array(<?php  $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['f']->key => $_smarty_tpl->tpl_vars['f']->value){
?>'<?php echo $_smarty_tpl->tpl_vars['f']->value;?>
', <?php }} ?>0);
		<?php }} ?>
		</script>
		
		<div class="block layer" <?php if (!$_smarty_tpl->getVariable('categories')->value){?>style='display:none;'<?php }?>>
			<h2>Свойства товара
			<a href="#" id=properties_wizard><img src="design/images/wand.png" alt="Подобрать автоматически" title="Подобрать автоматически"/></a>
			</h2>
			
			<ul class="prop_ul">
				<?php  $_smarty_tpl->tpl_vars['feature'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('features')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['feature']->key => $_smarty_tpl->tpl_vars['feature']->value){
?>
					<?php $_smarty_tpl->tpl_vars['feature_id'] = new Smarty_variable($_smarty_tpl->getVariable('feature')->value->id, null, null);?>
					<li feature_id=<?php echo $_smarty_tpl->getVariable('feature_id')->value;?>
 style='display:none;'><label class=property><?php echo $_smarty_tpl->getVariable('feature')->value->name;?>
</label><input class="simpla_inp" type="text" name=options[<?php echo $_smarty_tpl->getVariable('feature_id')->value;?>
] value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('options')->value[$_smarty_tpl->getVariable('feature_id')->value]->value);?>
" /></li>
				<?php }} ?>
			</ul>
			<!-- Новые свойства -->
			<ul class=new_features>
				<li id=new_feature><label class=property><input type=text name=new_features_names[]></label><input class="simpla_inp" type="text" name=new_features_values[] /></li>
			</ul>
			<span class="add"><i class="dash_link" id="add_new_feature">Добавить новое свойство</i></span>
			<input class="button_green button_save" type="submit" name="" value="Сохранить" />			
		</div>
		
		<!-- Свойства товара (The End)-->
		
			
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	<!-- Правая колонка свойств товара -->	
	<div id="column_right">
		
		<!-- Изображения товара -->	
		<div class="block layer images">
			<h2>Изображения товара
			<a href="#" id=images_wizard><img src="design/images/wand.png" alt="Подобрать автоматически" title="Подобрать автоматически"/></a>
			
			</h2>
			<ul><?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('product_images')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
?><li>
					<a href='#' class="delete"><img src='design/images/cross-circle-frame.png'></a>
					<img src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('image')->value->filename,100,100);?>
" alt="" />
					<input type=hidden name='images[]' value='<?php echo $_smarty_tpl->getVariable('image')->value->id;?>
'>
				</li><?php }} ?></ul>
			<span class=upload_image><i class="dash_link" id="upload_image">Добавить изображение</i></span> или <span class=add_image_url><i class="dash_link" id="add_image_url">загрузить из интернета</i></span>
			<div id=add_image></div>
			
		</div>
		

		<div class="block layer">
			<h2>Связанные товары</h2>
			<div id=list class="sortable related_products">
				<?php  $_smarty_tpl->tpl_vars['related_product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('related_products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['related_product']->key => $_smarty_tpl->tpl_vars['related_product']->value){
?>
				<div class="row">
					<div class="move cell">
						<div class="move_zone"></div>
					</div>
					<div class="image cell">
					<input type=hidden name=related_products[] value='<?php echo $_smarty_tpl->getVariable('related_product')->value->id;?>
'>
					<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('id'=>$_smarty_tpl->getVariable('related_product')->value->id),$_smarty_tpl);?>
">
					<img class=product_icon src='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['resize'][0][0]->resize_modifier($_smarty_tpl->getVariable('related_product')->value->images[0]->filename,35,35);?>
'>
					</a>
					</div>
					<div class="name cell">
					<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('id'=>$_smarty_tpl->getVariable('related_product')->value->id),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->getVariable('related_product')->value->name;?>
</a>
					</div>
					<div class="icons cell">
					<a href='#' class="delete"></a>
					</div>
					<div class="clear"></div>
				</div>
				<?php }} ?>
				<div id="new_related_product" class="row" style='display:none;'>
					<div class="move cell">
						<div class="move_zone"></div>
					</div>
					<div class="image cell">
					<input type=hidden name=related_products[] value=''>
					<img class=product_icon src=''>
					</div>
					<div class="name cell">
					<a class="related_product_name" href=""></a>
					</div>
					<div class="icons cell">
					<a href='#' class="delete"></a>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<input type=text name=related id='related_products' class="input_autocomplete" placeholder='Выберите товар чтобы добавить его'>
		</div>

		<input class="button_green button_save" type="submit" name="" value="Сохранить" />
		
	</div>
	<!-- Правая колонка свойств товара (The End)--> 

	<!-- Описагние товара -->
	<div class="block layer">
		<h2>Краткое описание</h2>
		<textarea name="annotation" class="editor_small"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->annotation);?>
</textarea>
	</div>
		
	<div class="block">		
		<h2>Полное  описание</h2>
		<textarea name="body" class="editor_large"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->body);?>
</textarea>
	</div>
	<!-- Описание товара (The End)-->
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->

