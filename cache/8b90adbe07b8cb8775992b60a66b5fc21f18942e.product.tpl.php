<?php /*%%SmartyHeaderCode:2630927084ea40598b7d0d0-52011605%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b90adbe07b8cb8775992b60a66b5fc21f18942e' => 
    array (
      0 => 'simpla/design/html/product.tpl',
      1 => 1319372182,
      2 => 'file',
    ),
    '06f5a9e8f6314631c935e6c33c6d4bf26e63a269' => 
    array (
      0 => 'simpla/design/html/tinymce_init.tpl',
      1 => 1312802582,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2630927084ea40598b7d0d0-52011605',
  'has_nocache_code' => 0,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><script language="javascript" type="text/javascript" src="design/js/tiny_mce/plugins/smimage/smplugins.js"></script>
<script language="javascript" type="text/javascript" src="design/js/tiny_mce/tiny_mce.js"></script>
<script language="javascript">

  tinyMCE.init({
	// General options
	mode : "specific_textareas",
	editor_selector : /editor/,
	theme : "advanced",
	language : "ru",
	theme_advanced_path : false,
	apply_source_formatting : false,
	plugins : "jaretypograph,smimage,smexplorer,safari,spellchecker,style,table,save,advimage,advlink,inlinepopups,media,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
	relative_urls : false,
	remove_script_host : true,
	convert_urls : true,
	verify_html: false,
    remove_linebreaks : false,
    content_css :"../design/default/css/style.css",
    spellchecker_languages : "+Russian=ru,+English=en",
            
	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,paste,pastetext,pasteword,|,undo,redo,|,bold,italic,underline,strikethrough,|,sub,sup,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,backcolor,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "tablecontrols,|,link,unlink,anchor,smimage,smexplorer,charmap,nonbreaking,|,styleprops,attribs,|,jaretypograph,removeformat,cleanup,spellchecker,|,visualaid,fullscreen,code",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	file_browser_callback : "SMPlugins",
	plugin_smexplorer_directory : "/files/uploads",
	plugin_smimage_directory : "/files/uploads",
	
	setup : function(ed) {
		if(typeof set_meta == 'function')
		{
			ed.onKeyUp.add(set_meta);
			ed.onChange.add(set_meta);
		}
	}

	});

</script>
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

	// Добавление категории
	$('#product_categories .add').click(function() {
		$("#product_categories ul li:last").clone(true).appendTo('#product_categories ul').fadeIn('slow').find("select[name*=categories]:last").focus();
		$("#product_categories ul li:last span.add").hide();
		$("#product_categories ul li:last span.delete").show();
		return false;		
	});

	// Удаление категории
	$("#product_categories .delete").click(function() {
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
	$(".images ul").sortable({ tolerance: 'pointer' });

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




<!-- Системное сообщение -->
<div class="message message_success">
	<span>Товар изменен</span>
	<a class="link" target="_blank" href="../products/samsung_s5570_galaxy_mini">Открыть товар на сайте</a>
		<a class="button" href="http://simpla/catalog/mobilnye_telefony">Вернуться</a>
	</div>
<!-- Системное сообщение (The End)-->



<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="2b7f56184c93c564e5463bf1f1aa06e7">

 	<div id="name">
		<input class="name" name=name type="text" value="Samsung S5570 Galaxy Mini"/> 
		<input name=id type="hidden" value="8"/> 
		<div class="checkbox">
			<input name=visible value='1' type="checkbox" id="active_checkbox" checked/> <label for="active_checkbox">Активен</label>
		</div>
		<div class="checkbox">
			<input name=hit value="1" type="checkbox" id="hit_checkbox" checked/> <label for="hit_checkbox">Хит</label>
		</div>
	</div> 
	
	<div id="product_brand" >
		<label>Бренд</label>
		<select name="brand_id">
            <option value='0'  brand_name=''>Не указан</option>
       		            	<option value='1'  brand_name='Apple'>Apple</option>
        	            	<option value='6'  brand_name='BlackBerry'>BlackBerry</option>
        	            	<option value='11'  brand_name='Canon'>Canon</option>
        	            	<option value='7'  brand_name='Dyson'>Dyson</option>
        	            	<option value='8'  brand_name='Electrolux'>Electrolux</option>
        	            	<option value='4'  brand_name='HTC'>HTC</option>
        	            	<option value='10'  brand_name='Nikon'>Nikon</option>
        	            	<option value='3'  brand_name='Nokia'>Nokia</option>
        	            	<option value='2' selected brand_name='Samsung'>Samsung</option>
        	            	<option value='5'  brand_name='Sony Ericsson'>Sony Ericsson</option>
        	            	<option value='9'  brand_name='Zelmer'>Zelmer</option>
        			</select>
	</div>
	
	
	<div id="product_categories" >
		<label>Категория</label>
		<div>
			<ul>
								<li>
					<select name="categories[]">
																				<option value='1' selected category_name='Мобильные телефоны'>Мобильные телефоны</option>
														
														<option value='2'  category_name='Бытовая техника'>Бытовая техника</option>
																						<option value='3'  category_name='Пылесосы'>&nbsp;&nbsp;&nbsp;&nbsp;Пылесосы</option>
														
														<option value='4'  category_name='Миксеры'>&nbsp;&nbsp;&nbsp;&nbsp;Миксеры</option>
														
						
														<option value='5'  category_name='Фотоаппараты'>Фотоаппараты</option>
														
						
					</select>
					<span  class="add"><i class="dash_link">Дополнительная категория</i></span>
					<span style='display:none;' class="delete"><i class="dash_link">Удалить</i></span>
				</li>
						
			</ul>
		</div>
	</div>


 	<!-- Варианты товара -->
	<div id="variants_block" class=single_variant>
		<ul id="header">
			<li class="variant_move"></li>
			<li class="variant_name">Название варианта</li>	
			<li class="variant_sku">Артикул</li>	
			<li class="variant_price">Цена, руб</li>	
			<li class="variant_discount">Старая, руб</li>	
			<li class="variant_amount">Кол-во</li>
		</ul>
		<div id="variants">
				<ul>
			<li class="variant_move"><div class="move_zone"></div></li>
			<li class="variant_name">      <input name="variants[id][12]"            type="hidden" value="12" /><input name="variants[name][12]" type="" value="" /> <a class="del_variant" href=""><img src="design/images/cross-circle-frame.png" alt="" /></a></li>
			<li class="variant_sku">       <input name="variants[sku][12]"           type="text"   value="" /></li>
			<li class="variant_price">     <input name="variants[price][12]"         type="text"   value="5.43" /></li>
			<li class="variant_discount">  <input name="variants[compare_price][12]" type="text"   value="0.00" /></li>
			<li class="variant_amount">    <input name="variants[stock][12]"         type="text"   value="∞" />шт</li>
			<li class="variant_download">
			
									<a href='#' class=add_attachment><img src="design/images/cd_add.png"  title="Добавить цифровой товар" /></a>
								<div class=browse_attachment style='display:none;'>
					<input type=file name=attachment[12]>
				</div>
			
			</li>
		</ul>
				
		</div>
		<ul id=new_variant style='display:none;'>
			<li class="variant_move"><div class="move_zone"></div></li>
			<li class="variant_name"><input name="variants[id][]" type="hidden" value="" /><input name="variants[name][]" type="" value="" /><a class="del_variant" href=""><img src="design/images/cross-circle-frame.png" alt="" /></a></li>
			<li class="variant_sku"><input name="variants[sku][]" type="" value="" /></li>
			<li class="variant_price"><input  name="variants[price][]" type="" value="" /></li>
			<li class="variant_discount"><input name="variants[compare_price][]" type="" value="" /></li>
			<li class="variant_amount"><input name="variants[stock][]" type="" value="∞" />шт</li>
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
				<li><label class=property>Адрес</label><div class="page_url"> /products/</div><input name="url" class="page_url" type="text" value="samsung_s5570_galaxy_mini" /></li>
				<li><label class=property>Заголовок</label><input name="meta_title" class="simpla_inp" type="text" value="Samsung S5570 Galaxy Mini" /></li>
				<li><label class=property>Ключевые слова</label><input name="meta_keywords" class="simpla_inp" type="text" value="Samsung S5570 Galaxy Mini, Samsung, Мобильные телефоны" /></li>
				<li><label class=property>Описание</label><textarea name="meta_description" class="simpla_inp" /></textarea></li>
			</ul>
		</div>
		<!-- Параметры страницы (The End)-->
		
		<!-- Свойства товара -->
		<script>
		var categories_features = new Array();
				categories_features[1]  = Array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '70', '71', '72', 0);
				categories_features[3]  = Array('7', '73', '74', '75', '76', '77', '78', '79', '80', '81', '82', '83', '84', '85', '86', '87', '88', '89', 0);
				categories_features[4]  = Array('2', '6', '7', '83', '90', '91', '92', '93', '94', '95', '96', '97', '98', '99', 0);
				categories_features[5]  = Array('7', '25', '32', '35', '58', '83', '100', '101', '102', '103', '104', '105', '106', '107', '108', '109', '110', '111', '112', '113', '114', '115', '116', '117', '118', '119', '120', '121', '122', '123', '124', '125', '126', '127', '128', '129', '130', '131', '132', '133', '134', '135', '136', '137', '138', '139', '140', '141', '142', '143', '144', '145', '146', '147', '148', 0);
				</script>
		
		<div class="block layer" >
			<h2>Свойства товара
			<a href="#" id=properties_wizard><img src="design/images/wand.png" alt="Подобрать автоматически" title="Подобрать автоматически"/></a>
			</h2>
			
			<ul class="prop_ul">
														<li feature_id=1 style='display:none;'><label class=property>Стандарт</label><input class="simpla_inp" type="text" name=options[1] value="GSM 900/1800/1900, 3G (UMTS)" /></li>
														<li feature_id=2 style='display:none;'><label class=property>Тип</label><input class="simpla_inp" type="text" name=options[2] value="смартфон/коммуникатор" /></li>
														<li feature_id=3 style='display:none;'><label class=property>Платформа</label><input class="simpla_inp" type="text" name=options[3] value="" /></li>
														<li feature_id=4 style='display:none;'><label class=property>Операционная система</label><input class="simpla_inp" type="text" name=options[4] value="Android 2.2" /></li>
														<li feature_id=5 style='display:none;'><label class=property>Тип корпуса</label><input class="simpla_inp" type="text" name=options[5] value="классический" /></li>
														<li feature_id=6 style='display:none;'><label class=property>Материал корпуса</label><input class="simpla_inp" type="text" name=options[6] value="пластик" /></li>
														<li feature_id=7 style='display:none;'><label class=property>Вес</label><input class="simpla_inp" type="text" name=options[7] value="" /></li>
														<li feature_id=8 style='display:none;'><label class=property>Размеры (ШxВxТ)</label><input class="simpla_inp" type="text" name=options[8] value="61x110x12 мм" /></li>
														<li feature_id=9 style='display:none;'><label class=property>Тип экрана</label><input class="simpla_inp" type="text" name=options[9] value="цветной, сенсорный" /></li>
														<li feature_id=10 style='display:none;'><label class=property>Тип сенсорного экрана</label><input class="simpla_inp" type="text" name=options[10] value="смартфон/коммуникатор" /></li>
														<li feature_id=11 style='display:none;'><label class=property>Диагональ</label><input class="simpla_inp" type="text" name=options[11] value="3.14 дюйма" /></li>
														<li feature_id=12 style='display:none;'><label class=property>Размер изображения</label><input class="simpla_inp" type="text" name=options[12] value="240x320 пикс." /></li>
														<li feature_id=13 style='display:none;'><label class=property>Автоматический поворот экрана</label><input class="simpla_inp" type="text" name=options[13] value="есть" /></li>
														<li feature_id=14 style='display:none;'><label class=property>Тип мелодий</label><input class="simpla_inp" type="text" name=options[14] value="полифонические, MP3-мелодии" /></li>
														<li feature_id=15 style='display:none;'><label class=property>Виброзвонок</label><input class="simpla_inp" type="text" name=options[15] value="есть" /></li>
														<li feature_id=16 style='display:none;'><label class=property>Фотокамера</label><input class="simpla_inp" type="text" name=options[16] value="3 млн пикс." /></li>
														<li feature_id=17 style='display:none;'><label class=property>Запись видеороликов</label><input class="simpla_inp" type="text" name=options[17] value="есть" /></li>
														<li feature_id=18 style='display:none;'><label class=property>Макс. частота кадров видео</label><input class="simpla_inp" type="text" name=options[18] value="15 кадров/с" /></li>
														<li feature_id=19 style='display:none;'><label class=property>Воспроизведение видео</label><input class="simpla_inp" type="text" name=options[19] value="" /></li>
														<li feature_id=20 style='display:none;'><label class=property>Аудио</label><input class="simpla_inp" type="text" name=options[20] value="MP3, AAC, FM-радиоприемник" /></li>
														<li feature_id=21 style='display:none;'><label class=property>Диктофон</label><input class="simpla_inp" type="text" name=options[21] value="есть" /></li>
														<li feature_id=22 style='display:none;'><label class=property>Игры</label><input class="simpla_inp" type="text" name=options[22] value="" /></li>
														<li feature_id=23 style='display:none;'><label class=property>Java-приложения</label><input class="simpla_inp" type="text" name=options[23] value="" /></li>
														<li feature_id=24 style='display:none;'><label class=property>Разъем для наушников</label><input class="simpla_inp" type="text" name=options[24] value="3.5 мм" /></li>
														<li feature_id=25 style='display:none;'><label class=property>Интерфейсы</label><input class="simpla_inp" type="text" name=options[25] value="USB, Wi-Fi, Bluetooth 2.1" /></li>
														<li feature_id=26 style='display:none;'><label class=property>Зарядка от USB</label><input class="simpla_inp" type="text" name=options[26] value="" /></li>
														<li feature_id=27 style='display:none;'><label class=property>Встроенный GPS-приемник</label><input class="simpla_inp" type="text" name=options[27] value="есть" /></li>
														<li feature_id=28 style='display:none;'><label class=property>Cистема A-GPS</label><input class="simpla_inp" type="text" name=options[28] value="есть" /></li>
														<li feature_id=29 style='display:none;'><label class=property>Доступ в интернет</label><input class="simpla_inp" type="text" name=options[29] value="WAP, GPRS, EDGE, HSDPA, POP/SMTP-клиент, IMAP4" /></li>
														<li feature_id=30 style='display:none;'><label class=property>Синхронизация с компьютером</label><input class="simpla_inp" type="text" name=options[30] value="есть" /></li>
														<li feature_id=31 style='display:none;'><label class=property>Использование в качестве USB-накопителя</label><input class="simpla_inp" type="text" name=options[31] value="есть" /></li>
														<li feature_id=32 style='display:none;'><label class=property>Объем встроенной памяти</label><input class="simpla_inp" type="text" name=options[32] value="" /></li>
														<li feature_id=33 style='display:none;'><label class=property>MMS</label><input class="simpla_inp" type="text" name=options[33] value="есть" /></li>
														<li feature_id=34 style='display:none;'><label class=property>Тип аккумулятора</label><input class="simpla_inp" type="text" name=options[34] value="Li-Ion" /></li>
														<li feature_id=35 style='display:none;'><label class=property>Емкость аккумулятора</label><input class="simpla_inp" type="text" name=options[35] value="1200 мАч" /></li>
														<li feature_id=36 style='display:none;'><label class=property>Время разговора</label><input class="simpla_inp" type="text" name=options[36] value="9:30 ч:мин" /></li>
														<li feature_id=37 style='display:none;'><label class=property>Время ожидания</label><input class="simpla_inp" type="text" name=options[37] value="570 ч" /></li>
														<li feature_id=38 style='display:none;'><label class=property>Громкая связь (встроенный динамик)</label><input class="simpla_inp" type="text" name=options[38] value="" /></li>
														<li feature_id=39 style='display:none;'><label class=property>Режим полета</label><input class="simpla_inp" type="text" name=options[39] value="" /></li>
														<li feature_id=40 style='display:none;'><label class=property>Датчики</label><input class="simpla_inp" type="text" name=options[40] value="приближения, компас" /></li>
														<li feature_id=41 style='display:none;'><label class=property>Поиск по книжке</label><input class="simpla_inp" type="text" name=options[41] value="есть" /></li>
														<li feature_id=42 style='display:none;'><label class=property>Обмен между SIM-картой и внутренней памятью</label><input class="simpla_inp" type="text" name=options[42] value="есть" /></li>
														<li feature_id=43 style='display:none;'><label class=property>Органайзер</label><input class="simpla_inp" type="text" name=options[43] value="будильник, калькулятор, планировщик задач" /></li>
														<li feature_id=44 style='display:none;'><label class=property>Комплектация</label><input class="simpla_inp" type="text" name=options[44] value="" /></li>
														<li feature_id=45 style='display:none;'><label class=property>Дата анонсирования (г-м-д)</label><input class="simpla_inp" type="text" name=options[45] value="2011-01-26" /></li>
														<li feature_id=46 style='display:none;'><label class=property>Русификация</label><input class="simpla_inp" type="text" name=options[46] value="есть" /></li>
														<li feature_id=47 style='display:none;'><label class=property>Распознавание</label><input class="simpla_inp" type="text" name=options[47] value="улыбок" /></li>
														<li feature_id=48 style='display:none;'><label class=property>Макс. разрешение видео</label><input class="simpla_inp" type="text" name=options[48] value="" /></li>
														<li feature_id=49 style='display:none;'><label class=property>Geo Tagging</label><input class="simpla_inp" type="text" name=options[49] value="" /></li>
														<li feature_id=50 style='display:none;'><label class=property>Фронтальная камера</label><input class="simpla_inp" type="text" name=options[50] value="" /></li>
														<li feature_id=51 style='display:none;'><label class=property>Видеовыход</label><input class="simpla_inp" type="text" name=options[51] value="" /></li>
														<li feature_id=52 style='display:none;'><label class=property>Модем</label><input class="simpla_inp" type="text" name=options[52] value="есть" /></li>
														<li feature_id=53 style='display:none;'><label class=property>Объем постоянной памяти (ROM)</label><input class="simpla_inp" type="text" name=options[53] value="" /></li>
														<li feature_id=54 style='display:none;'><label class=property>Процессор</label><input class="simpla_inp" type="text" name=options[54] value="" /></li>
														<li feature_id=55 style='display:none;'><label class=property>Время работы в режиме прослушивания музыки</label><input class="simpla_inp" type="text" name=options[55] value="" /></li>
														<li feature_id=56 style='display:none;'><label class=property>Управление</label><input class="simpla_inp" type="text" name=options[56] value="" /></li>
														<li feature_id=57 style='display:none;'><label class=property>Автодозвон</label><input class="simpla_inp" type="text" name=options[57] value="" /></li>
														<li feature_id=58 style='display:none;'><label class=property>Особенности</label><input class="simpla_inp" type="text" name=options[58] value="время работы в режиме разговора - до 570 мин. (2G), до 380 мин. (3G); время работы в режиме ожидания - до 570 ч (2G), до 440 ч (3G)" /></li>
														<li feature_id=59 style='display:none;'><label class=property>Поддержка DLNA</label><input class="simpla_inp" type="text" name=options[59] value="есть" /></li>
														<li feature_id=60 style='display:none;'><label class=property>Объем оперативной памяти (RAM)</label><input class="simpla_inp" type="text" name=options[60] value="" /></li>
														<li feature_id=61 style='display:none;'><label class=property>Дополнительные функции SMS</label><input class="simpla_inp" type="text" name=options[61] value="шаблоны сообщений" /></li>
														<li feature_id=62 style='display:none;'><label class=property>Профиль A2DP</label><input class="simpla_inp" type="text" name=options[62] value="" /></li>
														<li feature_id=63 style='display:none;'><label class=property>Дата начала продаж (г-м-д)</label><input class="simpla_inp" type="text" name=options[63] value="" /></li>
														<li feature_id=64 style='display:none;'><label class=property>QWERTY-клавиатура</label><input class="simpla_inp" type="text" name=options[64] value="" /></li>
														<li feature_id=65 style='display:none;'><label class=property>VoIP-клиент</label><input class="simpla_inp" type="text" name=options[65] value="" /></li>
														<li feature_id=66 style='display:none;'><label class=property>Push-To-Talk</label><input class="simpla_inp" type="text" name=options[66] value="" /></li>
														<li feature_id=67 style='display:none;'><label class=property>Режимы кодирования звука HR, FR, EFR</label><input class="simpla_inp" type="text" name=options[67] value="" /></li>
														<li feature_id=68 style='display:none;'><label class=property>Записная книжка в аппарате</label><input class="simpla_inp" type="text" name=options[68] value="" /></li>
														<li feature_id=69 style='display:none;'><label class=property>Уровень SAR</label><input class="simpla_inp" type="text" name=options[69] value="" /></li>
														<li feature_id=70 style='display:none;'><label class=property>Официальная поставка в Россию</label><input class="simpla_inp" type="text" name=options[70] value="" /></li>
														<li feature_id=71 style='display:none;'><label class=property>Mobile Tracker</label><input class="simpla_inp" type="text" name=options[71] value="" /></li>
														<li feature_id=72 style='display:none;'><label class=property>Поддержка двух SIM-карт</label><input class="simpla_inp" type="text" name=options[72] value="" /></li>
														<li feature_id=73 style='display:none;'><label class=property>Уборка</label><input class="simpla_inp" type="text" name=options[73] value="" /></li>
														<li feature_id=74 style='display:none;'><label class=property>Потребляемая мощность</label><input class="simpla_inp" type="text" name=options[74] value="" /></li>
														<li feature_id=75 style='display:none;'><label class=property>Пылесборник</label><input class="simpla_inp" type="text" name=options[75] value="" /></li>
														<li feature_id=76 style='display:none;'><label class=property>Регулятор мощности</label><input class="simpla_inp" type="text" name=options[76] value="" /></li>
														<li feature_id=77 style='display:none;'><label class=property>Фильтр тонкой очистки</label><input class="simpla_inp" type="text" name=options[77] value="" /></li>
														<li feature_id=78 style='display:none;'><label class=property>Источник питания</label><input class="simpla_inp" type="text" name=options[78] value="" /></li>
														<li feature_id=79 style='display:none;'><label class=property>Уровень шума</label><input class="simpla_inp" type="text" name=options[79] value="" /></li>
														<li feature_id=80 style='display:none;'><label class=property>Длина сетевого шнура</label><input class="simpla_inp" type="text" name=options[80] value="" /></li>
														<li feature_id=81 style='display:none;'><label class=property>Функции и возможности</label><input class="simpla_inp" type="text" name=options[81] value="" /></li>
														<li feature_id=82 style='display:none;'><label class=property>Размеры пылесоса (ШxГxВ)</label><input class="simpla_inp" type="text" name=options[82] value="" /></li>
														<li feature_id=83 style='display:none;'><label class=property>Дополнительная информация</label><input class="simpla_inp" type="text" name=options[83] value="" /></li>
														<li feature_id=84 style='display:none;'><label class=property>Труба всасывания</label><input class="simpla_inp" type="text" name=options[84] value="" /></li>
														<li feature_id=85 style='display:none;'><label class=property>Возможность подключения электрощетки</label><input class="simpla_inp" type="text" name=options[85] value="" /></li>
														<li feature_id=86 style='display:none;'><label class=property>Дополнительные насадки в комплекте</label><input class="simpla_inp" type="text" name=options[86] value="" /></li>
														<li feature_id=87 style='display:none;'><label class=property>Турбощетка в комплекте</label><input class="simpla_inp" type="text" name=options[87] value="" /></li>
														<li feature_id=88 style='display:none;'><label class=property>Мощность всасывания</label><input class="simpla_inp" type="text" name=options[88] value="" /></li>
														<li feature_id=89 style='display:none;'><label class=property>Электрощетка в комплекте</label><input class="simpla_inp" type="text" name=options[89] value="" /></li>
														<li feature_id=90 style='display:none;'><label class=property>Чаша</label><input class="simpla_inp" type="text" name=options[90] value="" /></li>
														<li feature_id=91 style='display:none;'><label class=property>Мощность</label><input class="simpla_inp" type="text" name=options[91] value="" /></li>
														<li feature_id=92 style='display:none;'><label class=property>Число скоростей</label><input class="simpla_inp" type="text" name=options[92] value="" /></li>
														<li feature_id=93 style='display:none;'><label class=property>Дополнительные режимы</label><input class="simpla_inp" type="text" name=options[93] value="" /></li>
														<li feature_id=94 style='display:none;'><label class=property>Количество насадок</label><input class="simpla_inp" type="text" name=options[94] value="" /></li>
														<li feature_id=95 style='display:none;'><label class=property>Насадки</label><input class="simpla_inp" type="text" name=options[95] value="" /></li>
														<li feature_id=96 style='display:none;'><label class=property>Кнопка отсоединения насадок</label><input class="simpla_inp" type="text" name=options[96] value="" /></li>
														<li feature_id=97 style='display:none;'><label class=property>Защитная крышка на чашу</label><input class="simpla_inp" type="text" name=options[97] value="" /></li>
														<li feature_id=98 style='display:none;'><label class=property>Прорезиненная ручка</label><input class="simpla_inp" type="text" name=options[98] value="" /></li>
														<li feature_id=99 style='display:none;'><label class=property>Приспособление для хранения насадок</label><input class="simpla_inp" type="text" name=options[99] value="" /></li>
														<li feature_id=100 style='display:none;'><label class=property>Общее число пикселов</label><input class="simpla_inp" type="text" name=options[100] value="" /></li>
														<li feature_id=101 style='display:none;'><label class=property>Число эффективных пикселов</label><input class="simpla_inp" type="text" name=options[101] value="" /></li>
														<li feature_id=102 style='display:none;'><label class=property>Физический размер</label><input class="simpla_inp" type="text" name=options[102] value="" /></li>
														<li feature_id=103 style='display:none;'><label class=property>Кроп-фактор</label><input class="simpla_inp" type="text" name=options[103] value="" /></li>
														<li feature_id=104 style='display:none;'><label class=property>Тип матрицы</label><input class="simpla_inp" type="text" name=options[104] value="" /></li>
														<li feature_id=105 style='display:none;'><label class=property>Чувствительность</label><input class="simpla_inp" type="text" name=options[105] value="" /></li>
														<li feature_id=106 style='display:none;'><label class=property>Баланс белого</label><input class="simpla_inp" type="text" name=options[106] value="" /></li>
														<li feature_id=107 style='display:none;'><label class=property>Вспышка</label><input class="simpla_inp" type="text" name=options[107] value="" /></li>
														<li feature_id=108 style='display:none;'><label class=property>Макросъёмка</label><input class="simpla_inp" type="text" name=options[108] value="" /></li>
														<li feature_id=109 style='display:none;'><label class=property>Таймер</label><input class="simpla_inp" type="text" name=options[109] value="" /></li>
														<li feature_id=110 style='display:none;'><label class=property>Время работы таймера</label><input class="simpla_inp" type="text" name=options[110] value="" /></li>
														<li feature_id=111 style='display:none;'><label class=property>Формат кадра (фотосъемка)</label><input class="simpla_inp" type="text" name=options[111] value="" /></li>
														<li feature_id=112 style='display:none;'><label class=property>Фокусное расстояние (35 мм эквивалент)</label><input class="simpla_inp" type="text" name=options[112] value="" /></li>
														<li feature_id=113 style='display:none;'><label class=property>Оптический Zoom</label><input class="simpla_inp" type="text" name=options[113] value="" /></li>
														<li feature_id=114 style='display:none;'><label class=property>Диафрагма</label><input class="simpla_inp" type="text" name=options[114] value="" /></li>
														<li feature_id=115 style='display:none;'><label class=property>Видоискатель</label><input class="simpla_inp" type="text" name=options[115] value="" /></li>
														<li feature_id=116 style='display:none;'><label class=property>ЖК-экран</label><input class="simpla_inp" type="text" name=options[116] value="" /></li>
														<li feature_id=117 style='display:none;'><label class=property>Тип ЖК-экрана</label><input class="simpla_inp" type="text" name=options[117] value="" /></li>
														<li feature_id=118 style='display:none;'><label class=property>Ручная настройка выдержки и диафрагмы</label><input class="simpla_inp" type="text" name=options[118] value="" /></li>
														<li feature_id=119 style='display:none;'><label class=property>Экспокоррекция </label><input class="simpla_inp" type="text" name=options[119] value="" /></li>
														<li feature_id=120 style='display:none;'><label class=property>Минимальное расстояние съемки</label><input class="simpla_inp" type="text" name=options[120] value="" /></li>
														<li feature_id=121 style='display:none;'><label class=property>Тип карт памяти</label><input class="simpla_inp" type="text" name=options[121] value="" /></li>
														<li feature_id=122 style='display:none;'><label class=property>Форматы изображения</label><input class="simpla_inp" type="text" name=options[122] value="" /></li>
														<li feature_id=123 style='display:none;'><label class=property>Формат аккумуляторов</label><input class="simpla_inp" type="text" name=options[123] value="" /></li>
														<li feature_id=124 style='display:none;'><label class=property>Количество аккумуляторов</label><input class="simpla_inp" type="text" name=options[124] value="" /></li>
														<li feature_id=125 style='display:none;'><label class=property>Запись видео</label><input class="simpla_inp" type="text" name=options[125] value="" /></li>
														<li feature_id=126 style='display:none;'><label class=property>Формат записи видео</label><input class="simpla_inp" type="text" name=options[126] value="" /></li>
														<li feature_id=127 style='display:none;'><label class=property>Максимальное разрешение роликов</label><input class="simpla_inp" type="text" name=options[127] value="" /></li>
														<li feature_id=128 style='display:none;'><label class=property>Цифровой Zoom</label><input class="simpla_inp" type="text" name=options[128] value="" /></li>
														<li feature_id=129 style='display:none;'><label class=property>Дополнительные возможности</label><input class="simpla_inp" type="text" name=options[129] value="" /></li>
														<li feature_id=130 style='display:none;'><label class=property>Дата анонсирования</label><input class="simpla_inp" type="text" name=options[130] value="" /></li>
														<li feature_id=131 style='display:none;'><label class=property>Дата начала продаж</label><input class="simpla_inp" type="text" name=options[131] value="" /></li>
														<li feature_id=132 style='display:none;'><label class=property>Размер</label><input class="simpla_inp" type="text" name=options[132] value="" /></li>
														<li feature_id=133 style='display:none;'><label class=property>Стабилизатор изображения (фотосъемка)</label><input class="simpla_inp" type="text" name=options[133] value="" /></li>
														<li feature_id=134 style='display:none;'><label class=property>Режим серийной съемки</label><input class="simpla_inp" type="text" name=options[134] value="" /></li>
														<li feature_id=135 style='display:none;'><label class=property>Подсветка автофокуса</label><input class="simpla_inp" type="text" name=options[135] value="" /></li>
														<li feature_id=136 style='display:none;'><label class=property>Фокусировка по лицу</label><input class="simpla_inp" type="text" name=options[136] value="" /></li>
														<li feature_id=137 style='display:none;'><label class=property>Разъем питания</label><input class="simpla_inp" type="text" name=options[137] value="" /></li>
														<li feature_id=138 style='display:none;'><label class=property>Запись звука</label><input class="simpla_inp" type="text" name=options[138] value="" /></li>
														<li feature_id=139 style='display:none;'><label class=property>Название объектива</label><input class="simpla_inp" type="text" name=options[139] value="" /></li>
														<li feature_id=140 style='display:none;'><label class=property>Максимальная частота кадров видеоролика</label><input class="simpla_inp" type="text" name=options[140] value="" /></li>
														<li feature_id=141 style='display:none;'><label class=property>Максимальная частота кадров при съемке HD-видео</label><input class="simpla_inp" type="text" name=options[141] value="" /></li>
														<li feature_id=142 style='display:none;'><label class=property>Электронная стабилизация при видеосъемке</label><input class="simpla_inp" type="text" name=options[142] value="" /></li>
														<li feature_id=143 style='display:none;'><label class=property>Скорость съемки</label><input class="simpla_inp" type="text" name=options[143] value="" /></li>
														<li feature_id=144 style='display:none;'><label class=property>Число оптических элементов</label><input class="simpla_inp" type="text" name=options[144] value="" /></li>
														<li feature_id=145 style='display:none;'><label class=property>Число групп оптических элементов</label><input class="simpla_inp" type="text" name=options[145] value="" /></li>
														<li feature_id=146 style='display:none;'><label class=property>Выдержка</label><input class="simpla_inp" type="text" name=options[146] value="" /></li>
														<li feature_id=147 style='display:none;'><label class=property>Замер экспозиции</label><input class="simpla_inp" type="text" name=options[147] value="" /></li>
														<li feature_id=148 style='display:none;'><label class=property>Автоматическая обработка экспозиции</label><input class="simpla_inp" type="text" name=options[148] value="" /></li>
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
			<ul>
								<li>
					<a href='#' class="delete"><img src='design/images/cross-circle-frame.png'></a>
					<img src="http://simpla/files/products/Samsung-Galaxy-Mini-S5570.100x100.jpg?8521dd2e14901f82509af30e3b330094" alt="" />
					<input type=hidden name='images[]' value='29'>
				</li>
								<li>
					<a href='#' class="delete"><img src='design/images/cross-circle-frame.png'></a>
					<img src="http://simpla/files/products/Samsung_Galaxy_Mini_S5570_17.jpga1332ef1-c4d9-41cd-bade-164b5b0f001fLarge.100x100.jpg?98df4e7dd4d687fd73ff8144e61e6ab1" alt="" />
					<input type=hidden name='images[]' value='30'>
				</li>
								<li>
					<a href='#' class="delete"><img src='design/images/cross-circle-frame.png'></a>
					<img src="http://simpla/files/products/samsung_gt_s5570_galaxy_mini.100x100.jpg?a4214eec6e68dd431ae5d9e286fd32cf" alt="" />
					<input type=hidden name='images[]' value='31'>
				</li>
								<li>
					<a href='#' class="delete"><img src='design/images/cross-circle-frame.png'></a>
					<img src="http://simpla/files/products/ACA2DA021F31461C85ED84D6D8267E29.100x100.jpg?c4e50a54d489cd4c7a5ea3cadaabaf7b" alt="" />
					<input type=hidden name='images[]' value='33'>
				</li>
							</ul>
			<span class=upload_image><i class="dash_link" id="upload_image">Добавить изображение</i></span> или <span class=add_image_url><i class="dash_link" id="add_image_url">загрузить из интернета</i></span>
			<div id=add_image></div>
			
		</div>
		

		<div class="block layer">
			<h2>Связанные товары</h2>
			<div id=list class="sortable related_products">
								<div class="row">
					<div class="move cell">
						<div class="move_zone"></div>
					</div>
					<div class="image cell">
					<input type=hidden name=related_products[] value='17'>
					<a href="/simpla/index.php?module=ProductAdmin&id=17&return=http%3A%2F%2Fsimpla%2Fcatalog%2Fmobilnye_telefony">
					<img class=product_icon src='http://simpla/files/products/Samsung-Diva-S7070.35x35.jpeg?e7c54e6aa5d765d0a67406b423d13a94'>
					</a>
					</div>
					<div class="name cell">
					<a href="/simpla/index.php?module=ProductAdmin&id=17&return=http%3A%2F%2Fsimpla%2Fcatalog%2Fmobilnye_telefony">Samsung S7070 Diva</a>
					</div>
					<div class="icons cell">
					<a href='#' class="delete"></a>
					</div>
					<div class="clear"></div>
				</div>
								<div class="row">
					<div class="move cell">
						<div class="move_zone"></div>
					</div>
					<div class="image cell">
					<input type=hidden name=related_products[] value='24'>
					<a href="/simpla/index.php?module=ProductAdmin&id=24&return=http%3A%2F%2Fsimpla%2Fcatalog%2Fmobilnye_telefony">
					<img class=product_icon src='http://simpla/files/products/samsung_s3650_corby_29193d.35x35.jpg?5641e0e3a44fe586edf14c38077e707a'>
					</a>
					</div>
					<div class="name cell">
					<a href="/simpla/index.php?module=ProductAdmin&id=24&return=http%3A%2F%2Fsimpla%2Fcatalog%2Fmobilnye_telefony">Samsung S3650 Corby</a>
					</div>
					<div class="icons cell">
					<a href='#' class="delete"></a>
					</div>
					<div class="clear"></div>
				</div>
								<div class="row">
					<div class="move cell">
						<div class="move_zone"></div>
					</div>
					<div class="image cell">
					<input type=hidden name=related_products[] value='21'>
					<a href="/simpla/index.php?module=ProductAdmin&id=21&return=http%3A%2F%2Fsimpla%2Fcatalog%2Fmobilnye_telefony">
					<img class=product_icon src='http://simpla/files/products/Nokia-C2-031.35x35.jpg?1a0084bb5843c2e27dacc1ae7c2678c4'>
					</a>
					</div>
					<div class="name cell">
					<a href="/simpla/index.php?module=ProductAdmin&id=21&return=http%3A%2F%2Fsimpla%2Fcatalog%2Fmobilnye_telefony">Nokia C2-03</a>
					</div>
					<div class="icons cell">
					<a href='#' class="delete"></a>
					</div>
					<div class="clear"></div>
				</div>
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
		<textarea name="annotation" class="editor_small"></textarea>
	</div>
		
	<div class="block">		
		<h2>Полное  описание</h2>
		<textarea name="body" class="editor_large">&lt;p&gt;Samsung Galaxy Mini GT-S5570 - выполнен в форм-факторе моноблок. Имеет 3.14 дюймовый дисплей с разрешением 240 на 320 пикселей, 3.2 МП камеру, 3.5 мм разъём для подключения гарнитуры, поддержку карт памяти microSD, FM-радио, Bluetooth, Wi-Fi и GPS модули.&lt;/p&gt;</textarea>
	</div>
	<!-- Описание товара (The End)-->
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->

<?php } ?>