{capture name=tabs}
		<li class="active"><a href="index.php?module=LicenseAdmin">Лицензия</a></li>
{/capture}

<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="{$smarty.session.id}">
	<!-- Левая колонка свойств товара -->
	<div id="column_left">
 	
	<div class=block>
		{if $license->valid}	
		<h2 style='color:green;'>Лицензия действительна {if $license->expiration != '*'}до {$license->expiration}{/if} для домен{$license->domains|count|plural:'а':'ов'} {foreach $license->domains as $d}{$d}{if !$d@last}, {/if}{/foreach}</h2>
		{else}
		<h2 style='color:red;'>Лицензия недействительна</h2>
		<input type='button_green' value='Продлить' onclick="document.license.license.value='{$testlicense|escape}';">
		{/if}
		<textarea name=license style='width:420px; height:100px;'>{$config->license|escape}</textarea>
		</div>
		<div class=block>	
		<input class="button_green button_save" type="submit" name="" value="Сохранить" />
		<a href='http://simplacms.ru/check?domain={$smarty.server.HTTP_HOST|escape}'>Проверить лицензию</a>
		</div>
	</div>

	<div id="column_right">
		<div class=block>
		<h2>Лицензионное соглашение</h2>

<textarea style='width:420px; height:250px;'>Настоящее пользовательское соглашение (далее — Соглашение) является юридическим соглашением между Пользователем системы управления сайтами «Simpla» (далее — Продуктом) и Пикусовым Д. С. (далее — Автором). 

Соглашение относится ко всем распространяемым версиям или модификациям программного Продукта. 

Все положения Соглашения распространяются как на Продукт в целом, так и на его отдельные компоненты, за исключением компонентов, описанных в п.7 данного Соглашения.

Соглашение вступает в силу непосредственно в момент получения Пользователем копии Продукта посредством электронных средств передачи данных либо на физических носителях.

Соглашение дает Пользователю право использовать Продукт в рамках одного сайта (интернет-магазина), который работает в пределах одного полного доменного имени на протяжении двух недель с момента вступления в силу Соглашения.

Автор не несет ответственность за какие-либо убытки и/или ущерб (в том числе, убытки в связи недополученной коммерческой выгодой, прерыванием коммерческой и производственной деятельности, утратой данных), возникающие в связи с использованием или невозможностью использования Продукта, даже если Автор был уведомлен о возможном возникновении таких убытков и/или ущерба.

Продукт поставляется на условиях «как есть» без предоставления гарантий производительности, покупательной способности, сохранности данных, а также иных явно выраженных или предполагаемых гарантий. Автор не несёт какой-либо ответственности за причинение или возможность причинения вреда Пользователю, его информации или его бизнесу вследствие использования или невозможности использования Продукта. 

Автор не несёт ответственность, связанную с привлечением Пользователя или третьих лиц к административной или уголовной ответственности за использование Продукта в противозаконных целях (включая, но не ограничиваясь, продажей через Интернет магазин объектов, изъятых из оборота или добытых преступным путём, предназначенных для разжигания межрасовой или межнациональной вражды и т.д.).

Продукт содержит компоненты, на которые не распространяется действие настоящего Соглашения. Эти компоненты предоставляются и распространяются в соответствии с собственными лицензиями. Таковыми компонентами являются: 
— Визуальный редактор TinyMCE;
— Файловый менеджер SMExplorer;
— Менеджер изображений SMImage;
— Редактор кода Codemirror;
— Скрипт просмотра изображений EnlargeIt.

Пользователь не имеет права продавать, распространять или использовать Продукт без согласия Автора.

Пользователь имеет право модифицировать Продукт по своему усмотрению. При этом последующее использование Продукта должно осуществляться в соответствии с данным Соглашением и при условии сохранения всех авторских прав.

Автор оставляет за собой право в любое время изменять условия Соглашения без предварительного уведомления.

Получение экземпляра Продукта, его использование и/или хранение автоматически означает
а) осведомленность Пользователя о содержании Соглашения;
б) принятие его положений;
в) выполнение условий данного Соглашения.

Официальный сайт Продукта: simplacms.ru
</textarea>
		</div> 
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
		
</form>
<!-- Основная форма (The End) -->
