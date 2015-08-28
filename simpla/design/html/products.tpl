{* Вкладки *}
{capture name=tabs}
	<li class="active"><a href="{url module=ProductsAdmin keyword=null category_id=null brand_id=null filter=null page=null}">Товары</a></li>
	{if in_array('categories', $manager->permissions)}<li><a href="index.php?module=CategoriesAdmin">Категории</a></li>{/if}
	{if in_array('brands', $manager->permissions)}<li><a href="index.php?module=BrandsAdmin">Бренды</a></li>{/if}
	{if in_array('features', $manager->permissions)}<li><a href="index.php?module=FeaturesAdmin">Свойства</a></li>{/if}
{/capture}

{* Title *}
{if $category}
	{$meta_title=$category->name scope=parent}
{else}
	{$meta_title='Товары' scope=parent}
{/if}

{* Поиск *}
<form method="get">
<div id="search">
	<input type="hidden" name="module" value="ProductsAdmin">
	<input class="search" type="text" name="keyword" value="{$keyword|escape}" />
	<input class="search_button" type="submit" value=""/>
</div>
</form>
	
{* Заголовок *}
<div id="header">	
	{if $products_count}
		{if $category->name || $brand->name}
			<h1>{$category->name} {$brand->name} ({$products_count} {$products_count|plural:'товар':'товаров':'товара'})</h1>
		{elseif $keyword}
			<h1>{$products_count|plural:'Найден':'Найдено':'Найдено'} {$products_count} {$products_count|plural:'товар':'товаров':'товара'}</h1>
		{else}
			<h1>{$products_count} {$products_count|plural:'товар':'товаров':'товара'}</h1>
		{/if}		
	{else}
		<h1>Нет товаров</h1>
	{/if}
	<a class="add" href="{url module=ProductAdmin return=$smarty.server.REQUEST_URI}">Добавить товар</a>
</div>	

<div id="main_list">
	
	<!-- Листалка страниц -->
	{include file='pagination.tpl'}	
	<!-- Листалка страниц (The End) -->
		
	{if $products}

	<div id="expand">
	<!-- Свернуть/развернуть варианты -->
	<a href="#" class="dash_link" id="expand_all">Развернуть все варианты ↓</a>
	<a href="#" class="dash_link" id="roll_up_all" style="display:none;">Свернуть все варианты ↑</a>
	<!-- Свернуть/развернуть варианты (The End) -->
	</div>

	{* Основная форма *}
	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="{$smarty.session.id}">
	
		<div id="list">
		{foreach $products as $product}
		<div class="{if !$product->visible}invisible{/if} {if $product->featured}featured{/if} row">
			<input type="hidden" name="positions[{$product->id}]" value="{$product->position}">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="{$product->id}"/>				
			</div>
			<div class="image cell">
				{$image = $product->images|@first}
				{if $image}
				<a href="{url module=ProductAdmin id=$product->id return=$smarty.server.REQUEST_URI}"><img src="{$image->filename|escape|resize:35:35}" /></a>
				{/if}
			</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
				{foreach $product->variants as $variant}
				<li {if !$variant@first}class="variant" style="display:none;"{/if}>
					<i title="{$variant->name|escape}">{$variant->name|escape|truncate:30:'…':true:true}</i>
					<input class="price {if $variant->compare_price>0}compare_price{/if}" type="text" name="price[{$variant->id}]" value="{$variant->price}" {if $variant->compare_price>0}title="Старая цена &mdash; {$variant->compare_price} {$currency->sign}"{/if} />{$currency->sign}  
					<input class="stock" type="text" name="stock[{$variant->id}]" value="{if $variant->infinity}∞{else}{$variant->stock}{/if}" />{$settings->units}
				</li>
				{/foreach}
				</ul>
	
				{$variants_num = $product->variants|count}
				{if $variants_num>1}
				<div class="expand_variant">
				<a class="dash_link expand_variant" href="#">{$variants_num} {$variants_num|plural:'вариант':'вариантов':'варианта'} ↓</a>
				<a class="dash_link roll_up_variant" style="display:none;" href="#">{$variants_num} {$variants_num|plural:'вариант':'вариантов':'варианта'} ↑</a>
				</div>
				{/if}
				</div>
				
				<a href="{url module=ProductAdmin id=$product->id return=$smarty.server.REQUEST_URI}">{$product->name|escape}</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предпросмотр в новом окне" href="../products/{$product->url}" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="featured"  title="Рекомендуемый"           href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
		{/foreach}
		</div>

		<div id="action">
			<label id="check_all" class="dash_link">Выбрать все</label>
		
			<span id="select">
			<select name="action">
				<option value="enable">Сделать видимыми</option>
				<option value="disable">Сделать невидимыми</option>
				<option value="set_featured">Сделать рекомендуемым</option>
				<option value="unset_featured">Отменить рекомендуемый</option>
				<option value="duplicate">Создать дубликат</option>
				{if $pages_count>1}
				<option value="move_to_page">Переместить на страницу</option>
				{/if}
				{if $categories|count>1}
				<option value="move_to_category">Переместить в категорию</option>
				{/if}
				{if $all_brands|count>0}
				<option value="move_to_brand">Указать бренд</option>
				{/if}
				<option value="delete">Удалить</option>
			</select>
			</span>
		
			<span id="move_to_page">
			<select name="target_page">
				{section target_page $pages_count}
				<option value="{$smarty.section.target_page.index+1}">{$smarty.section.target_page.index+1}</option>
				{/section}
			</select> 
			</span>
		
			<span id="move_to_category">
			<select name="target_category">
				{function name=category_select level=0}
				{foreach $categories as $category}
						<option value='{$category->id}'>{section sp $level}&nbsp;&nbsp;&nbsp;&nbsp;{/section}{$category->name|escape}</option>
						{category_select categories=$category->subcategories selected_id=$selected_id level=$level+1}
				{/foreach}
				{/function}
				{category_select categories=$categories}
			</select> 
			</span>
			
			<span id="move_to_brand">
			<select name="target_brand">
				<option value="0">Не указан</option>
				{foreach $all_brands as $b}
				<option value="{$b->id}">{$b->name}</option>
				{/foreach}
			</select> 
			</span>
		
			<input id="apply_action" class="button_green" type="submit" value="Применить">		
		</div>
		{/if}
	</form>

	<!-- Листалка страниц -->
	{include file='pagination.tpl'}	
	<!-- Листалка страниц (The End) -->		
</div>


<!-- Меню -->
<div id="right_menu">
	
	<!-- Фильтры -->
	<ul>
		<li {if !$filter}class="selected"{/if}><a href="{url brand_id=null category_id=null keyword=null page=null filter=null}">Все товары</a></li>
		<li {if $filter=='featured'}class="selected"{/if}><a href="{url keyword=null brand_id=null category_id=null page=null filter='featured'}">Рекомендуемые</a></li>
		<li {if $filter=='discounted'}class="selected"{/if}><a href="{url keyword=null brand_id=null category_id=null page=null filter='discounted'}">Со скидкой</a></li>
		<li {if $filter=='visible'}class="selected"{/if}><a href="{url keyword=null brand_id=null category_id=null page=null filter='visible'}">Активные</a></li>
		<li {if $filter=='hidden'}class="selected"{/if}><a href="{url keyword=null brand_id=null category_id=null page=null filter='hidden'}">Неактивные</a></li>
		<li {if $filter=='outofstock'}class="selected"{/if}><a href="{url keyword=null brand_id=null category_id=null page=null filter='outofstock'}">Отсутствующие</a></li>
	</ul>
	<!-- Фильтры -->


	<!-- Категории товаров -->
	{function name=categories_tree}
	{if $categories}
	<ul>
		{if $categories[0]->parent_id == 0}
		<li {if !$category->id}class="selected"{/if}><a href="{url category_id=null brand_id=null}">Все категории</a></li>	
		{/if}
		{foreach $categories as $c}
		<li category_id="{$c->id}" {if $category->id == $c->id}class="selected"{else}class="droppable category"{/if}><a href='{url keyword=null brand_id=null page=null category_id={$c->id}}'>{$c->name}</a></li>
		{categories_tree categories=$c->subcategories}
		{/foreach}
	</ul>
	{/if}
	{/function}
	{categories_tree categories=$categories}
	<!-- Категории товаров (The End)-->
	
	{if $brands}
	<!-- Бренды -->
	<ul>
		<li {if !$brand->id}class="selected"{/if}><a href="{url brand_id=null}">Все бренды</a></li>
		{foreach $brands as $b}
		<li brand_id="{$b->id}" {if $brand->id == $b->id}class="selected"{else}class="droppable brand"{/if}><a href="{url keyword=null page=null brand_id=$b->id}">{$b->name}</a></li>
		{/foreach}
	</ul>
	<!-- Бренды (The End) -->
	{/if}
	
</div>
<!-- Меню  (The End) -->


{* On document load *}
{literal}
<script>

$(function() {

	// Сортировка списка
	$("#list").sortable({
		items:             ".row",
		tolerance:         "pointer",
		handle:            ".move_zone",
		scrollSensitivity: 40,
		opacity:           0.7, 
		
		helper: function(event, ui){		
			if($('input[type="checkbox"][name*="check"]:checked').size()<1) return ui;
			var helper = $('<div/>');
			$('input[type="checkbox"][name*="check"]:checked').each(function(){
				var item = $(this).closest('.row');
				helper.height(helper.height()+item.innerHeight());
				if(item[0]!=ui[0]) {
					helper.append(item.clone());
					$(this).closest('.row').remove();
				}
				else {
					helper.append(ui.clone());
					item.find('input[type="checkbox"][name*="check"]').attr('checked', false);
				}
			});
			return helper;			
		},	
 		start: function(event, ui) {
  			if(ui.helper.children('.row').size()>0)
				$('.ui-sortable-placeholder').height(ui.helper.height());
		},
		beforeStop:function(event, ui){
			if(ui.helper.children('.row').size()>0){
				ui.helper.children('.row').each(function(){
					$(this).insertBefore(ui.item);
				});
				ui.item.remove();
			}
		},
		update:function(event, ui)
		{
			$("#list_form input[name*='check']").attr('checked', false);
			$("#list_form").ajaxSubmit(function() {
				colorize();
			});
		}
	});
	

	// Перенос товара на другую страницу
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_page')
			$("span#move_to_page").show();
		else
			$("span#move_to_page").hide();
	});
	$("#pagination a.droppable").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_page]').attr("selected", "selected");		
			$(ui.draggable).closest("form").find('select[name=target_page] option[value='+$(this).html()+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;	
		}		
	});


	// Перенос товара в другую категорию
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_category')
			$("span#move_to_category").show();
		else
			$("span#move_to_category").hide();
	});
	$("#right_menu .droppable.category").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_category]').attr("selected", "selected");	
			$(ui.draggable).closest("form").find('select[name=target_category] option[value='+$(this).attr('category_id')+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;			
		}
	});


	// Перенос товара в другой бренд
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_brand')
			$("span#move_to_brand").show();
		else
			$("span#move_to_brand").hide();
	});
	$("#right_menu .droppable.brand").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_brand]').attr("selected", "selected");			
			$(ui.draggable).closest("form").find('select[name=target_brand] option[value='+$(this).attr('brand_id')+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;			
		}
	});


	// Если есть варианты, отображать ссылку на их разворачивание
	if($("li.variant").size()>0)
		$("#expand").show();


	// Раскраска строк
	function colorize()
	{
		$("#list div.row:even").addClass('even');
		$("#list div.row:odd").removeClass('even');
	}
	// Раскрасить строки сразу
	colorize();


	// Показать все варианты
	$("#expand_all").click(function() {
		$("a#expand_all").hide();
		$("a#roll_up_all").show();
		$("a.expand_variant").hide();
		$("a.roll_up_variant").show();
		$(".variants ul li.variant").fadeIn('fast');
		return false;
	});


	// Свернуть все варианты
	$("#roll_up_all").click(function() {
		$("a#roll_up_all").hide();
		$("a#expand_all").show();
		$("a.roll_up_variant").hide();
		$("a.expand_variant").show();
		$(".variants ul li.variant").fadeOut('fast');
		return false;
	});

 
	// Показать вариант
	$("a.expand_variant").click(function() {
		$(this).closest("div.cell").find("li.variant").fadeIn('fast');
		$(this).closest("div.cell").find("a.expand_variant").hide();
		$(this).closest("div.cell").find("a.roll_up_variant").show();
		return false;
	});

	// Свернуть вариант
	$("a.roll_up_variant").click(function() {
		$(this).closest("div.cell").find("li.variant").fadeOut('fast');
		$(this).closest("div.cell").find("a.roll_up_variant").hide();
		$(this).closest("div.cell").find("a.expand_variant").show();
		return false;
	});

	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', $('#list input[type="checkbox"][name*="check"]:not(:checked)').length>0);
	});	

	// Удалить товар
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Дублировать товар
	$("a.duplicate").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=duplicate]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Показать товар
	$("a.enable").click(function() {
		var icon        = $(this);
		var line        = icon.closest("div.row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('invisible')?1:0;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'product', 'id': id, 'values': {'visible': state}, 'session_id': '{/literal}{$smarty.session.id}{literal}'},
			success: function(data){
				icon.removeClass('loading_icon');
				if(state)
					line.removeClass('invisible');
				else
					line.addClass('invisible');				
			},
			dataType: 'json'
		});	
		return false;	
	});

	// Сделать хитом
	$("a.featured").click(function() {
		var icon        = $(this);
		var line        = icon.closest("div.row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('featured')?0:1;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'product', 'id': id, 'values': {'featured': state}, 'session_id': '{/literal}{$smarty.session.id}{literal}'},
			success: function(data){
				icon.removeClass('loading_icon');
				if(state)
					line.addClass('featured');				
				else
					line.removeClass('featured');
			},
			dataType: 'json'
		});	
		return false;	
	});


	// Подтверждение удаления
	$("form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
	
	
	// Бесконечность на складе
	$("input[name*=stock]").focus(function() {
		if($(this).val() == '∞')
			$(this).val('');
		return false;
	});
	$("input[name*=stock]").blur(function() {
		if($(this).val() == '')
			$(this).val('∞');
	});
});

</script>
{/literal}
