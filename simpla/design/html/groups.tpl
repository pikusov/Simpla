{* Вкладки *}
{capture name=tabs}
	<li><a href="index.php?module=UsersAdmin">Покупатели</a></li>
	<li class="active"><a href="index.php?module=GroupsAdmin">Группы</a></li>		
{/capture}

{* Title *}
{$meta_title='Группы пользователей' scope=parent}

{* Заголовок *}
<div id="header">
	<h1>Группы пользователей</h1> 
	<a class="add" href="index.php?module=GroupAdmin">Добавить группу</a>
</div>	


<!-- Основная часть -->
<div id="main_list">

	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="{$smarty.session.id}">
	<div id="list" class="groups">
		
		{foreach $groups as $group}
		<div class="row">
		 	<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="{$group->id}"/>				
			</div>
			<div class="group_name cell">
				<a href="index.php?module=GroupAdmin&id={$group->id}">{$group->name}</a>
			</div>
			<div class="group_discount cell">
				{$group->discount} %
			</div>
			<div class="icons cell">
				<a class="delete" title="Удалить" href="#"></a>
			</div>
			<div class="clear"></div>
		</div>
		{/foreach}
	</div>

	<div id="action">
	<label id="check_all" class="dash_link">Выбрать все</label>

	<span id=select>
	<select name="action">
		<option value="delete">Удалить</option>
	</select>
	</span>

	<input id="apply_action" class="button_green" type="submit" value="Применить">
	</div>


	</form>

</div>


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
		
	// Подтверждение удаления
	$("form").submit(function() {
		if($('#list input[type="checkbox"][name*="check"]:checked').length>0)
			if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
				return false;	
	});
	
});

</script>
{/literal}
