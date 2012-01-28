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
    '06f5a9e8f6314631c935e6c33c6d4bf26e63a269' => 
    array (
      0 => 'simpla/design/html/tinymce_init.tpl',
      1 => 1312802582,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13619237484ea40e43558cb5-20032828',
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
	<span>Обновлено</span>
	<a class="link" target="_blank" href="../products/">Открыть страницу на сайте</a>
		<a class="button" href="/simpla/index.php?module=DeliveriesAdmin">Вернуться</a>
	</div>
<!-- Системное сообщение (The End)-->



<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="2b7f56184c93c564e5463bf1f1aa06e7">
	<div id="name">
		<input class="name" name=name type="text" value="Доставка с помощью предприятия &quot;Автотрейдинг&quot;"/> 
		<input name=id type="hidden" value="3"/> 
		<div class="checkbox">
			<input name=enabled value='1' type="checkbox" id="active_checkbox" checked/> <label for="active_checkbox">Активен</label>
		</div>
	</div> 

	<!-- Левая колонка свойств товара -->
	<div id="column_left">
		<!-- Параметры страницы -->
		<div class="block layer">
			<h2>Стоимость доставки</h2>
			<ul>
				<li><label class=property>Стоимость</label><input name="price" class="simpla_small_inp" type="text" value="1020.00" /> руб</li>
				<li><label class=property>Бесплатна от</label><input name="free_from" class="simpla_small_inp" type="text" value="3000.00" /> руб</li>
				<li><label class=property for="separate_payment">Оплачивается отдельно</label><input id="separate_payment" name="separate_payment" type="checkbox" value="1" checked /></li>
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
					<li>
			<input type=checkbox name="delivery_payments[]" id="payment_2" value='2' checked> <label for="payment_2">Webmoney wmz</label><br>
			</li>
					<li>
			<input type=checkbox name="delivery_payments[]" id="payment_1" value='1' checked> <label for="payment_1">Квитанция</label><br>
			</li>
					<li>
			<input type=checkbox name="delivery_payments[]" id="payment_3" value='3' checked> <label for="payment_3">Робокасса</label><br>
			</li>
				</ul>		
		</div>
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	<!-- Описагние товара -->
	<div class="block layer">
		<h2>Описание</h2>
		<textarea name="description" class="editor_small">&lt;p&gt;&lt;span&gt;Удобный и быстрый способ доставки в крупные города России. Посылка доставляется в офис &quot;Автотрейдинг&quot; в Вашем городе. Для получения необходимо предъявить паспорт и номер грузовой декларации (сообщит наш менеджер после отправки). Посылку желательно получить в течение 24 часов с момента прихода груза, иначе компания &quot;Автотрейдинг&quot; может взыскать с Вас дополнительную оплату за хранение. Срок доставки и стоимость Вы можете рассчитать на сайте компании.&lt;/span&gt;&lt;/p&gt;</textarea>
	</div>
	<!-- Описание товара (The End)-->
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->

<?php } ?>