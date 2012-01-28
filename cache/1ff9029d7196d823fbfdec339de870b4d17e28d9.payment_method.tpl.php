<?php /*%%SmartyHeaderCode:4580682574ea40df4257a01-40179210%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ff9029d7196d823fbfdec339de870b4d17e28d9' => 
    array (
      0 => 'simpla/design/html/payment_method.tpl',
      1 => 1317223703,
      2 => 'file',
    ),
    '06f5a9e8f6314631c935e6c33c6d4bf26e63a269' => 
    array (
      0 => 'simpla/design/html/tinymce_init.tpl',
      1 => 1312802582,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4580682574ea40df4257a01-40179210',
  'has_nocache_code' => false,
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
<script src="design/js/jquery/jquery.js"></script>
<script src="design/js/jquery/jquery-ui.min.js"></script>


<script type="text/javascript" src="design/js/autocomplete/jquery.autocomplete-min.js"></script>
<style>
.autocomplete-w1 { background:url(img/shadow.png) no-repeat bottom right; position:absolute; top:0px; left:0px; margin:6px 0 0 6px; /* IE6 fix: */ _background:none; _margin:1px 0 0 0; }
.autocomplete { border:1px solid #999; background:#FFF; cursor:default; text-align:left; overflow-x:auto; min-width: 300px; overflow-y: auto; margin:-6px 6px 6px -6px; /* IE6 specific: */ _height:350px;  _margin:0; _overflow-x:hidden; }
.autocomplete .selected { background:#F0F0F0; }
.autocomplete div { padding:2px 5px; white-space:nowrap; }
.autocomplete strong { font-weight:normal; color:#3399FF; }
</style>

<script>
$(function() {

$('select[name=module]').change(function(){
	$('div#module_settings').hide();
	$('div#module_settings[module='+$(this).val()+']').show();
	});
});


</script>






<!-- Системное сообщение -->
<div class="message message_success">
	<span>Добавлено</span>
	<a class="link" target="_blank" href="../products/">Открыть страницу на сайте</a>
	</div>
<!-- Системное сообщение (The End)-->



<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="2b7f56184c93c564e5463bf1f1aa06e7">
	<div id="name">
		<input class="name" name=name type="text" value="Робокасса"/> 
		<input name=id type="hidden" value="3"/> 
		<div class="checkbox">
			<input name=enabled value='1' type="checkbox" id="active_checkbox" checked/> <label for="active_checkbox">Активен</label>
		</div>
	</div> 

	<div id="product_categories">
		<select name="module">
            <option value=''>Ручная обработка</option>
       		            	<option value='Receipt'  >
		Квитанция для оплаты в банке
	</option>
        	            	<option value='Robokassa' selected >
		Робокасса
	</option>
        	            	<option value='Webmoney'  >
		Webmoney
	</option>
        			</select>
	</div>
	
	<div id="product_brand">
		<label>Валюта</label>
		<div>
		<select name="currency_id">
			            <option value='2' >рубли</option>
                        <option value='1' >доллары</option>
                        <option value='3' selected>вебмани wmz</option>
            		</select>
		</div>
	</div>
	
	<!-- Левая колонка свойств товара -->
	<div id="column_left">
	
   		        	<div class="block layer" style='display:none;' id=module_settings module='Receipt'>
			<h2>
		Квитанция для оплаты в банке
	</h2>
			<ul>
															<li><label class=property>Получатель</label><input name="payment_settings[recipient]" class="simpla_inp" type="text" value="" /></li>
																			<li><label class=property>ИНН получателя</label><input name="payment_settings[inn]" class="simpla_inp" type="text" value="" /></li>
																			<li><label class=property>Счет получателя</label><input name="payment_settings[account]" class="simpla_inp" type="text" value="" /></li>
																			<li><label class=property>Банк получателя</label><input name="payment_settings[bank]" class="simpla_inp" type="text" value="" /></li>
																			<li><label class=property>БИК</label><input name="payment_settings[bik]" class="simpla_inp" type="text" value="" /></li>
																			<li><label class=property>Кор. счет</label><input name="payment_settings[correspondent_account]" class="simpla_inp" type="text" value="" /></li>
																			<li><label class=property>Обозначение валюты</label><input name="payment_settings[banknote]" class="simpla_inp" type="text" value="" /></li>
																			<li><label class=property>Обозначение копеек</label><input name="payment_settings[pense]" class="simpla_inp" type="text" value="" /></li>
										</ul>
        	
        	</div>
    	        	<div class="block layer"  id=module_settings module='Robokassa'>
			<h2>
		Робокасса
	</h2>
			<ul>
															<li><label class=property>Логин в робокассе</label><input name="payment_settings[login]" class="simpla_inp" type="text" value="" /></li>
																			<li><label class=property>Пароль1</label><input name="payment_settings[password1]" class="simpla_inp" type="text" value="" /></li>
																			<li><label class=property>Пароль2</label><input name="payment_settings[password2]" class="simpla_inp" type="text" value="" /></li>
																			<li><label class=property>Язык шлюза</label>
				<select name="payment_settings[language]">
										<option value='ru' selected>Русский</option>
										<option value='en' >Английский</option>
									</select>
				</li>
										</ul>
        	
        	</div>
    	        	<div class="block layer" style='display:none;' id=module_settings module='Webmoney'>
			<h2>
		Webmoney
	</h2>
			<ul>
															<li><label class=property>Номер кошелька</label><input name="payment_settings[purse]" class="simpla_inp" type="text" value="" /></li>
																			<li><label class=property>Секретный ключ</label><input name="payment_settings[secret_key]" class="simpla_inp" type="text" value="" /></li>
										</ul>
        	
        	</div>
    	

			
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	
	<!-- Описагние товара -->
	<div class="block layer">
		<h2>Описание</h2>
		<textarea name="description" class="editor_small">&lt;p&gt;&lt;span&gt;RBK Money &amp;ndash; это электронная платежная система, с помощью которой Вы сможете совершать платежи с персонального компьютера, коммуникатора или мобильного телефона.&lt;/span&gt;&lt;/p&gt;</textarea>
	</div>
	<!-- Описание товара (The End)-->
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->

<?php } ?>