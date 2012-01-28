<?php /*%%SmartyHeaderCode:10377721794ea44b4f986726-57676700%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e708a0e4da6568d8b25dbb51e095efe2970ed110' => 
    array (
      0 => 'simpla/design/html/blog.tpl',
      1 => 1317850191,
      2 => 'file',
    ),
    '8525564c8d119ad869e403b6d8062e04fc797163' => 
    array (
      0 => 'simpla/design/html/pagination.tpl',
      1 => 1304778449,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10377721794ea44b4f986726-57676700',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><form method="get">
<div id="search">
	<input type="hidden" name="module" value='BlogAdmin'>
	<input class="search" type="text" name="keyword" value="" />
	<input class="search_button" type="submit" value=""/>
</div>
</form>
		
<div id="header">
		<h1>1 запись в блоге</h1>
		<a class="add" href="/simpla/index.php?module=PostAdmin&return=%2Fsimpla%2Findex.php%3Fmodule%3DBlogAdmin">Добавить запись</a>
</div>	

<div id="main_list">
	
	<!-- Листалка страниц -->
		<!-- Листалка страниц -->
		<!-- Листалка страниц (The End) -->
	
	<!-- Листалка страниц (The End) -->

	<form id="form_list" method="post">
	<input type="hidden" name="session_id" value="2b7f56184c93c564e5463bf1f1aa06e7">
	
		<div id="list">
						<div class="invisible row">
				<input type="hidden" name="positions[1]" value="">
		 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="1" />				
				</div>
				<div class="name cell">		
					<a href="/simpla/index.php?module=PostAdmin&id=1&return=%2Fsimpla%2Findex.php%3Fmodule%3DBlogAdmin">Что нового в этой версии симплы</a>
					<br>
					23.10.2011
				</div>
				<div class="icons cell">
					<a class="preview" title="Предосмотр в новом окне" href="../blog/chto_novogo_v_etoj_versii_simply" target="_blank"></a>
					<a class="enable" title="Активна" href="#"></a>
					<a class="delete" title="Удалить" href="#"></a>
				</div>
				<div class="clear"></div>
			</div>
					</div>
		
	
		<div id="action">
		<label id="check_all" class="dash_link">Выбрать все</label>
	
		<span id="select">
		<select name="action">
			<option value="enable">Сделать видимыми</option>
			<option value="disable">Сделать невидимыми</option>
			<option value="delete">Удалить</option>
		</select>
		</span>
	
		<input id="apply_action" class="button_green" type="submit" value="Применить">
		
		</div>
				
	</form>	

	<!-- Листалка страниц -->
		<!-- Листалка страниц -->
		<!-- Листалка страниц (The End) -->
	
	<!-- Листалка страниц (The End) -->
	
</div>


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
	
	// Скрыт/Видим
	$("a.enable").click(function() {
		var icon        = $(this);
		var line        = icon.closest(".row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('invisible')?1:0;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'blog', 'id': id, 'values': {'visible': state}, 'session_id': '2b7f56184c93c564e5463bf1f1aa06e7'},
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
	
	// Подтверждение удаления
	$("form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
});

</script>
<?php } ?>