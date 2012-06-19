{capture name=tabs}
	<li><a href="index.php?module=ThemeAdmin">Тема</a></li>
	<li><a href="index.php?module=TemplatesAdmin">Шаблоны</a></li>		
	<li><a href="index.php?module=StylesAdmin">Стили</a></li>		
	<li class="active"><a href="index.php?module=ImagesAdmin">Изображения</a></li>		
{/capture}

{$meta_title = "Изображения" scope=parent}

{* On document load *}
{literal}
<script>
$(function() {

	// Редактировать
	$("a.edit").click(function() {
		name = $(this).closest('li').attr('name');
		inp1 = $('<input type=hidden name="old_name[]">').val(name);
		inp2 = $('<input type=text name="new_name[]">').val(name);
		$(this).closest('li').find("p.name").html('').append(inp1).append(inp2);
		inp2.focus().select();
		return false;
	});
 

	// Удалить 
	$("a.delete").click(function() {
		name = $(this).closest('li').attr('name');
		$('input[name=delete_image]').val(name);
		$(this).closest("form").submit();
	});
	
	// Загрузить
	$("#upload_image").click(function() {
		$(this).closest('div').append($('<input type=file name=upload_images[]>'));
	});
	
	$("form").submit(function() {
		if($('input[name="delete_image"]').val()!='' && !confirm('Подтвердите удаление'))
			return false;	
	});

});
</script>
{/literal}

<h1>Изображения темы {$theme}</h1>

{if $message_error}
<!-- Системное сообщение -->
<div class="message message_error">
	<span>{if $message_error == 'permissions'}Установите права на запись для папки {$images_dir}
	{elseif $message_error == 'name_exists'}Файл с таким именем уже существует
	{elseif $message_error == 'theme_locked'}Текущая тема защищена от изменений. Создайте копию темы.
	{else}{$message_error}{/if}</span>
</div>
<!-- Системное сообщение (The End)-->
{/if}

<form method="post" enctype="multipart/form-data">
<input type="hidden" name="session_id" value="{$smarty.session.id}">
<input type="hidden" name="delete_image" value="">
<!-- Список файлов для выбора -->
<div class="block layer">
	<ul class="theme_images">
		{foreach item=image from=$images}
			<li name='{$image->name|escape}'>
			<a href='#' class='delete'><img src='design/images/delete.png'></a>
			<a href='#' class='edit'><img src='design/images/pencil.png'></a>
			<p class="name">{$image->name|escape|truncate:16:'...'}</p>
			<div class="theme_image">
			<a class='preview' href='../{$images_dir}{$image->name|escape}'><img src='../{$images_dir}{$image->name|escape}'></a>
			</div>
			<p class=size>{if $image->size>1024*1024}{$image->size/1024/1024|round:'2'} МБ{elseif $image->size>1024}{$image->size/1024|round:'2'} КБ{else}{$image->size} байт{/if}, {$image->width}&times;{$image->height} px</p>
			</li>
		{/foreach}
	</ul>
</div>


<div class="block upload_image">
<span id="upload_image"><i class="dash_link">Добавить изображение</i></span>
</div>

<div class="block">
<input class="button_green button_save" type="submit" name="save" value="Сохранить" />
</div>
</form>
