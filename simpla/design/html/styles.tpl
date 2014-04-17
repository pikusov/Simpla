{capture name=tabs}
	<li><a href="index.php?module=ThemeAdmin">Тема</a></li>
	<li><a href="index.php?module=TemplatesAdmin">Шаблоны</a></li>		
	<li class="active"><a href="index.php?module=StylesAdmin">Стили</a></li>		
	<li><a href="index.php?module=ImagesAdmin">Изображения</a></li>		
{/capture}

{if $style_file}
{$meta_title = "Стиль $style_file" scope=parent}
{/if}

{* Подключаем редактор кода *}
<link rel="stylesheet" href="design/js/codemirror/lib/codemirror.css">
<script src="design/js/codemirror/lib/codemirror.js"></script>

<script src="design/js/codemirror/mode/css/css.js"></script>
<script src="design/js/codemirror/addon/selection/active-line.js"></script>
 
{literal}
<style type="text/css">

.CodeMirror{
	font-family:'Courier New';
	padding-bottom:20px;
	margin-bottom:10px;
	border:1px solid #c0c0c0;
	background-color: #ffffff;
	height: auto;
	min-height: 300px;
	width:100%;
}
.CodeMirror-scroll
{
	overflow-y: hidden;
	overflow-x: auto;
}
</style>

<script>
$(function() {	
	// Сохранение кода аяксом
	function save()
	{
		$('.CodeMirror').css('background-color','#e0ffe0');
		content = editor.getValue();
		
		$.ajax({
			type: 'POST',
			url: 'ajax/save_style.php',
			data: {'content': content, 'theme':'{/literal}{$theme}{literal}', 'style': '{/literal}{$style_file}{literal}', 'session_id': '{/literal}{$smarty.session.id}{literal}'},
			success: function(data){
			
				$('.CodeMirror').animate({'background-color': '#ffffff'});
			},
			dataType: 'json'
		});
	}

	// Нажали кнопку Сохранить
	$('input[name="save"]').click(function() {
		save();
	});
	
	// Обработка ctrl+s
	var isCtrl = false;
	var isCmd = false;
	$(document).keyup(function (e) {
		if(e.which == 17) isCtrl=false;
		if(e.which == 91) isCmd=false;
	}).keydown(function (e) {
		if(e.which == 17) isCtrl=true;
		if(e.which == 91) isCmd=true;
		if(e.which == 83 && (isCtrl || isCmd)) {
			save();
			e.preventDefault();
		}
	});
});
</script>
{/literal}

<h1>Тема {$theme}, стиль {$style_file}</h1>

{if $message_error}
<!-- Системное сообщение -->
<div class="message message_error">
	<span>
	{if $message_error == 'permissions'}Установите права на запись для файла {$style_file}
	{elseif $message_error == 'theme_locked'}Текущая тема защищена от изменений. Создайте копию темы.
	{else}{$message_error}{/if}
	</span>
</div>
<!-- Системное сообщение (The End)-->
{/if}

<!-- Список файлов для выбора -->
<div class="block layer">
	<div class="templates_names">
		{foreach item=s from=$styles}
			<a {if $style_file == $s}class="selected"{/if} href='index.php?module=StylesAdmin&file={$s}'>{$s}</a>
		{/foreach}
	</div>
</div>

{if $style_file}
<div class="block">
<form>
	<textarea id="content" name="content" style="width:700px;height:500px;">{$style_content|escape}</textarea>
</form>

<input class="button_green button_save" type="button" name="save" value="Сохранить" />
<div class="block">


{* Подключение редактора *}
{literal}
<script>

var editor = CodeMirror.fromTextArea(document.getElementById("content"), {
		mode: "css",		
		lineNumbers: true,
		styleActiveLine: true,
		matchBrackets: false,
		enterMode: 'keep',
		indentWithTabs: false,
		indentUnit: 1,
		tabMode: 'classic'
	});
</script>
{/literal}

{/if}