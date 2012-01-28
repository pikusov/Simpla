<?php /*%%SmartyHeaderCode:21330280904ea44e53acdd70-20043090%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd8ee2c04631b99172c8e9dfe8b1dee295230e569' => 
    array (
      0 => 'simpla/design/html/orders.tpl',
      1 => 1316925925,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21330280904ea44e53acdd70-20043090',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><form method="get">
<div id="search">
	<input type="hidden" name="module" value="OrdersAdmin">
	<input class="search" type="text" name="keyword" value=""/>
	<input class="search_button" type="submit" value=""/>
</div>
</form>
	
<div id="header">
	<h1>Нет заказов</h1>		
	<a class="add" href="/simpla/index.php?module=OrderAdmin&status=2">Добавить заказ</a>
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

	// Подтверждение удаления
	$("#form_list").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
});

</script>

<?php } ?>