<?php /*%%SmartyHeaderCode:17966043274ea44e598c83f5-80216228%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0a9bb6efee2b7231a70c27c6d3d7441cd14fdee' => 
    array (
      0 => 'simpla/design/html/comments.tpl',
      1 => 1316616303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17966043274ea44e598c83f5-80216228',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><div id="header">
		<h1>0 комментариев</h1> 
	</div>	


Нет комментариев

<!-- Меню -->
<div id="right_menu">
	
	<!-- Категории товаров -->
	<ul>
	<li class="selected"><a href="/simpla/index.php?module=CommentsAdmin">Все комментарии</a></li>
	</ul>
	<ul>
		<li ><a href='/simpla/index.php?module=CommentsAdmin&type=product'>К товарам</a></li>
		<li ><a href='/simpla/index.php?module=CommentsAdmin&type=blog'>К блогу</a></li>
	</ul>
	<!-- Категории товаров (The End)-->
	
</div>
<!-- Меню  (The End) -->


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
			data: {'object': 'comment', 'id': id, 'values': {'approved': 1}, 'session_id': '2b7f56184c93c564e5463bf1f1aa06e7'},
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

<?php } ?>