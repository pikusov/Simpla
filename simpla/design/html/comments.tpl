{* Вкладки *}
{capture name=tabs}
	<li class="active"><a href="index.php?module=CommentsAdmin">Комментарии</a></li>
	<li><a href="index.php?module=FeedbacksAdmin">Обратная связь</a></li>
{/capture}


{* Title *}
{$meta_title='Комментарии' scope=parent}

{* Поиск *}
{if $comments || $keyword}
<form method="get">
<div id="search">
	<input type="hidden" name="module" value='CommentsAdmin'>
	<input class="search" type="text" name="keyword" value="{$keyword|escape}" />
	<input class="search_button" type="submit" value=""/>
</div>
</form>
{/if}


{* Заголовок *}
<div id="header">
	{if $keyword && $comments_count}
	<h1>{$comments_count|plural:'Нашелся':'Нашлось':'Нашлись'} {$comments_count} {$comments_count|plural:'комментарий':'комментариев':'комментария'}</h1> 
	{elseif !$type}
	<h1>{$comments_count} {$comments_count|plural:'комментарий':'комментариев':'комментария'}</h1> 
	{elseif $type=='product'}
	<h1>{$comments_count} {$comments_count|plural:'комментарий':'комментариев':'комментария'} к товарам</h1> 
	{elseif $type=='blog'}
	<h1>{$comments_count} {$comments_count|plural:'комментарий':'комментариев':'комментария'} к записям в блоге</h1> 
	{/if}
</div>	


{if $comments}
<div id="main_list">
	
	<!-- Листалка страниц -->
	{include file='pagination.tpl'}	
	<!-- Листалка страниц (The End) -->
	
	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="{$smarty.session.id}">
	
		<div id="list" class="sortable">
			{foreach $comments as $comment}
			<div class="{if !$comment->approved}unapproved{/if} row">
		 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="{$comment->id}"/>				
				</div>
				<div class="name cell">
					<div class="comment_name">
					{$comment->name|escape}
					<a class="approve" href="#">Одобрить</a>
					</div>
					<div class="comment_text">
					{$comment->text|escape|nl2br}
					</div>
					<div class="comment_info">
					Комментарий оставлен {$comment->date|date} в {$comment->date|time}
					{if $comment->type == 'product'}
					к товару <a target="_blank" href="{$config->root_url}/products/{$comment->product->url}#comment_{$comment->id}">{$comment->product->name}</a>
					{elseif $comment->type == 'blog'}
					к статье <a target="_blank" href="{$config->root_url}/blog/{$comment->post->url}#comment_{$comment->id}">{$comment->post->name}</a>
					{/if}
					</div>
				</div>
				<div class="icons cell">
					<a class="delete" title="Удалить" href="#"></a>
				</div>
				<div class="clear"></div>
			</div>
			{/foreach}
		</div>
	
		<div id="action">
		Выбрать <label id="check_all" class="dash_link">все</label> или <label id="check_unapproved" class="dash_link">ожидающие</label>
	
		<span id="select">
		<select name="action">
			<option value="approve">Одобрить</option>
			<option value="delete">Удалить</option>
		</select>
		</span>
	
		<input id="apply_action" class="button_green" type="submit" value="Применить">

	</div>
	</form>
	
	<!-- Листалка страниц -->
	{include file='pagination.tpl'}	
	<!-- Листалка страниц (The End) -->
		
</div>
{else}
Нет комментариев
{/if}

<!-- Меню -->
<div id="right_menu">
	
	<!-- Категории товаров -->
	<ul>
	<li {if !$type}class="selected"{/if}><a href="{url type=null}">Все комментарии</a></li>
	</ul>
	<ul>
		<li {if $type == 'product'}class="selected"{/if}><a href='{url keyword=null type=product}'>К товарам</a></li>
		<li {if $type == 'blog'}class="selected"{/if}><a href='{url keyword=null type=blog}'>К блогу</a></li>
	</ul>
	<!-- Категории товаров (The End)-->
	
</div>
<!-- Меню  (The End) -->

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

	// Выделить ожидающие
	$("#check_unapproved").click(function() {
		$('#list .unapproved input[type="checkbox"][name*="check"]').attr('checked', 1-$('#list .unapproved input[type="checkbox"][name*="check"]').attr('checked'));
	});	

	// Удалить 
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest(".row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Одобрить
	$("a.approve").click(function() {
		var line        = $(this).closest(".row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'comment', 'id': id, 'values': {'approved': 1}, 'session_id': '{/literal}{$smarty.session.id}{literal}'},
			success: function(data){
				line.removeClass('unapproved');
			},
			dataType: 'json'
		});	
		return false;	
	});
	
	$("form#list_form").submit(function() {
		if($('#list_form select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});	
 	
});

</script>
{/literal}
