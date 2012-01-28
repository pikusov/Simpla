{if $pages_count>1}

{* Скрипт для листания через ctrl → *}
{* Ссылки на соседние страницы должны иметь id PrevLink и NextLink *}
<script type="text/javascript" src="design/js/ctrlnavigate.js"></script>           

<!-- Листалка страниц -->
<div id="pagination">
	
	{* Количество выводимых ссылок на страницы *}
	{$visible_pages = 13}

	{* По умолчанию начинаем вывод со страницы 1 *}
	{$page_from = 1}
	
	{* Если выбранная пользователем страница дальше середины "окна" - начинаем вывод уже не с первой *}
	{if $current_page > floor($visible_pages/2)}
		{$page_from = max(1, $current_page-floor($visible_pages/2)-1)}
	{/if}	
	
	{* Если выбранная пользователем страница близка к концу навигации - начинаем с "конца-окно" *}
	{if $current_page > $pages_count-ceil($visible_pages/2)}
		{$page_from = max(1, $pages_count-$visible_pages-1)}
	{/if}
	
	{* До какой страницы выводить - выводим всё окно, но не более ощего количества страниц *}
	{$page_to = min($page_from+$visible_pages, $pages_count-1)}

	{* Ссылка на 1 страницу отображается всегда *}
	<a class="{if $current_page==1}selected{else}droppable{/if}" href="{url page=1}">1</a>
	
	{* Выводим страницы нашего "окна" *}	
	{section name=pages loop=$page_to start=$page_from}
		{* Номер текущей выводимой страницы *}	
		{$p = $smarty.section.pages.index+1}	
		{* Для крайних страниц "окна" выводим троеточие, если окно не возле границы навигации *}	
		{if ($p == $page_from+1 && $p!=2) || ($p == $page_to && $p != $pages_count-1)}	
		<a class="{if $p==$current_page}selected{/if}" href="{url page=$p}">...</a>
		{else}
		<a class="{if $p==$current_page}selected{else}droppable{/if}" href="{url page=$p}">{$p}</a>
		{/if}
	{/section}

	{* Ссылка на последнююю страницу отображается всегда *}
	<a class="{if $current_page==$pages_count}selected{else}droppable{/if}"  href="{url page=$pages_count}">{$pages_count}</a>
	
	{if $current_page>1}<a id="PrevLink" href="{url page=$current_page-1}">←назад</a>{/if}
	{if $current_page<$pages_count}<a id="NextLink" href="{url page=$current_page+1}">вперед→</a>{/if}
	
</div>
<!-- Листалка страниц (The End) -->
{/if}
