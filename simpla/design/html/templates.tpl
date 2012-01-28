{capture name=tabs}
	<li><a href="index.php?module=ThemeAdmin">Тема</a></li>
	<li class="active"><a href="index.php?module=TemplatesAdmin">Шаблоны</a></li>		
	<li><a href="index.php?module=StylesAdmin">Стили</a></li>		
	<li><a href="index.php?module=ImagesAdmin">Изображения</a></li>		
{/capture}

{if $template_file}
{$meta_title = "Шаблон $template_file" scope=parent}
{/if}

{* Подключаем редактор кода *}
<link rel="stylesheet" href="design/js/codemirror/lib/codemirror.css">
<script src="design/js/codemirror/lib/codemirror.js"></script>
<script src="design/js/codemirror/lib/overlay.js"></script>

<link rel="stylesheet" href="design/js/codemirror/mode/xml/xml.css">
<script src="design/js/codemirror/mode/xml/xml.js"></script>
 
{literal}
<style type="text/css">
	.CodeMirror {font-family:'Courier New';padding-bottom:20px; margin-bottom:10px; border:1px solid #c0c0c0; background-color: #ffffff; height: auto; min-height: 300px; width:100%;}
	.activeline {background: #f0fcff !important;}
	.smarty {color: #ff008a;}
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
			url: 'ajax/save_template.php',
			data: {'content': content, 'theme':'{/literal}{$theme}{literal}', 'template': '{/literal}{$template_file}{literal}', 'session_id': '{/literal}{$smarty.session.id}{literal}'},
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

<h1>Тема {$theme}, шаблон {$template_file}</h1>

{if $message_error}
<!-- Системное сообщение -->
<div class="message message_error">
	<span>
	{if $message_error == 'permissions'}Установите права на запись для файла {$template_file}
	{elseif $message_error == 'theme_locked'}Текущая тема защищена от изменений. Создайте копию темы.
	{else}{$message_error}{/if}
	</span>
</div>
<!-- Системное сообщение (The End)-->
{/if}

<!-- Список файлов для выбора -->
<div class="block layer">
	<div class="templates_names">
		{foreach item=t from=$templates}
			<a {if $template_file == $t}class="selected"{/if} href='index.php?module=TemplatesAdmin&file={$t}'>{$t}</a>
		{/foreach}
	</div>
</div>

{if $template_file}
<div class="block">
<form>
	<textarea id="template_content" name="template_content" style="width:700px;height:500px;">{$template_content|escape}</textarea>
</form>

<input class="button_green button_save" type="button" name="save" value="Сохранить" />
</div>

{* Подключение редактора *}
{literal}
<script>
CodeMirror.defineMode("smarty", function(config, parserConfig) {
	var smartyOverlay = {
		token: function(stream, state){

			if (stream.match("{*"))
				return null;
			if (stream.match("{") && (stream.next()!=' ') && stream.next()!= null) {
				while ((ch = stream.next()) != null)
					if (ch == "}") break;
				return "smarty";
			}
			while (stream.next() != null && !stream.match('{', false)) {}
			return null;
		}
	};
	return CodeMirror.overlayParser(CodeMirror.getMode(config, parserConfig.backdrop || "text/html"), smartyOverlay);
});

var editor = CodeMirror.fromTextArea(document.getElementById("template_content"), {
		mode: {name: "smarty", htmlMode: true},
		
		lineNumbers: true,
		matchBrackets: false,
		enterMode: 'keep',
		indentWithTabs: false,
		indentUnit: 1,
		tabMode: 'classic',
		onCursorActivity: function() {
			editor.setLineClass(hlLine, null);
			hlLine = editor.setLineClass(editor.getCursor().line, "activeline");
		}
	});
	var hlLine = editor.setLineClass(0, "activeline");
</script>
{/literal}

{/if}