{* Вкладки *}
{capture name=tabs}
	{if in_array('users', $manager->permissions)}<li><a href="index.php?module=UsersAdmin">Покупатели</a></li>{/if}
	<li class="active"><a href="index.php?module=GroupsAdmin">Группы</a></li>		
	{if in_array('coupons', $manager->permissions)}<li><a href="index.php?module=CouponsAdmin">Купоны</a></li>{/if}
{/capture}

{if $group->id}
{$meta_title = $group->name scope=parent}
{else}
{$meta_title = 'Новая группа' scope=parent}
{/if}

{if $message_success}
<!-- Системное сообщение -->
<div class="message message_success">
	<span class="text">{if $message_success=='added'}Группа добавлена{elseif $message_success=='updated'}Группа изменена{else}{$message_success|escape}{/if}</span>
	{if $smarty.get.return}
	<a class="button" href="{$smarty.get.return}">Вернуться</a>
	{/if}
</div>
<!-- Системное сообщение (The End)-->
{/if}

{if $message_error}
<!-- Системное сообщение -->
<div class="message message_error">
	<span class="text">{if $message_error == 'empty_name'}Название группы не может быть пустым{/if}</span>
	<a class="button" href="">Вернуться</a>
</div>
<!-- Системное сообщение (The End)-->
{/if}


<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="{$smarty.session.id}">
	<div id="name">
		<input class="name" name=name type="text" value="{$group->name|escape}"/> 
		<input name=id type="hidden" value="{$group->id|escape}"/> 
	</div> 

	<!-- Левая колонка свойств товара -->
	<div id="column_left">
			
		<!-- Параметры страницы -->
		<div class="block">
			<ul>
				<li><label class=property>Скидка</label><input name="discount" class="simpla_inp" type="text" value="{$group->discount|escape}" />%</li>
			</ul>
		</div>
		<!-- Параметры страницы (The End)-->
		

			
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
	
	<input class="button_green button_save" type="submit" name="" value="Сохранить" />
	
</form>
<!-- Основная форма (The End) -->
