{* Вкладки *}
{capture name=tabs}
	<li><a href="index.php?module=ImportAdmin">Импорт</a></li>
	<li><a href="index.php?module=ExportAdmin">Экспорт</a></li>		
	<li class="active"><a href="index.php?module=BackupAdmin">Бекап</a></li>		
{/capture}

{* Title *}
{$meta_title='Бекап' scope=parent}

{* Заголовок *}
<div id="header">
	<h1>Бекап</h1>
	{if $message_error != 'no_permission'}
	<a class="add" href="">Создать бекап</a>
	<form id="hidden" method="post">
		<input type="hidden" name="session_id" value="{$smarty.session.id}">
		<input type="hidden" name="action" value="">
		<input type="hidden" name="name" value="">
	</form>
	{/if}
</div>	

{if $message_success}
<!-- Системное сообщение -->
<div class="message message_success">
	<span>{if $message_success == 'created'}Бекап создан{elseif $message_success == 'restored'}Бекап восстановлен{/if}</span>
	{if $smarty.get.return}
	<a class="button" href="{$smarty.get.return}">Вернуться</a>
	{/if}
</div>
<!-- Системное сообщение (The End)-->
{/if}

{if $message_error}
<!-- Системное сообщение -->
<div class="message message_error">
	<span>
	{if $message_error == 'no_permission'}Установите права на запись в папку {$backup_files_dir}
	{else}{$message_error}{/if}
	</span>
</div>
<!-- Системное сообщение (The End)-->
{/if}

{if $backups}
<div id="main_list">

	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="{$smarty.session.id}">

		<div id="list">			
			{foreach $backups as $backup}
			<div class="row">
				{if $message_error != 'no_permission'}
		 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="{$backup->name}"/>				
				</div>
				{/if}
				<div class="name cell">
	 				<a href="files/backup/{$backup->name}">{$backup->name}</a>
					({if $backup->size>1024*1024}{($backup->size/1024/1024)|round:2} МБ{else}{($backup->size/1024)|round:2} КБ{/if})
				</div>
				<div class="icons cell">
					{if $message_error != 'no_permission'}
					<a class="delete" title="Удалить" href="#"></a>
					{/if}
		 		</div>
				<div class="icons cell">
					<a class="restore" title="Восстановить этот бекап" href="#"></a>
				</div>
		 		<div class="clear"></div>
			</div>
			{/foreach}
		</div>
		
		{if $message_error != 'no_permission'}
		<div id="action">
		<label id="check_all" class="dash_link">Выбрать все</label>
	
		<span id="select">
		<select name="action">
			<option value="delete">Удалить</option>
		</select>
		</span>
	
		<input id="apply_action" class="button_green" type="submit" value="Применить">
		</div>
		{/if}
	
	</form>
</div>
{/if}


{literal}
<script>
$(function() {

	// Раскраска строк
	function colorize()
	{
		$("#list div.row:even").addClass('even');
		$("#list div.row:odd").removeClass('even');
	}
	// Раскрасить строки сразу
	colorize();
	
	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', 1-$('#list input[type="checkbox"][name*="check"]').attr('checked'));
	});	

	// Удалить 
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest(".row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});

	// Восстановить 
	$("a.restore").click(function() {
		file = $(this).closest(".row").find('[name*="check"]').val();
		$('form#hidden input[name="action"]').val('restore');
		$('form#hidden input[name="name"]').val(file);
		$('form#hidden').submit();
		return false;
	});

	// Создать бекап 
	$("a.add").click(function() {
		$('form#hidden input[name="action"]').val('create');
		$('form#hidden').submit();
		return false;
	});

	$("form#hidden").submit(function() {
		if($('input[name="action"]').val()=='restore' && !confirm('Текущие данные будут потеряны. Подтвердите восстановление'))
			return false;	
	});
	
	$("form#list_form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
	

});

</script>
{/literal}