<?php /*%%SmartyHeaderCode:9821986704ea1b348dbfb78-12104465%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '94f12a226f69f1db93dc9417d21fafab407d23a3' => 
    array (
      0 => 'simpla/design/html/brands.tpl',
      1 => 1316429550,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9821986704ea1b348dbfb78-12104465',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><div id="header">
	<h1>Бренды</h1> 
	<a class="add" href="/simpla/index.php?module=BrandAdmin&return=%2Fsimpla%2Findex.php%3Fmodule%3DBrandsAdmin">Добавить бренд</a>
</div>	

Нет брендов


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
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Подтверждение удаления
	$("form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});	
 	
});
</script>

<?php } ?>