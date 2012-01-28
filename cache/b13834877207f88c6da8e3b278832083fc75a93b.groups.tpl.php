<?php /*%%SmartyHeaderCode:17365283074ea44e50cc95a8-71904397%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b13834877207f88c6da8e3b278832083fc75a93b' => 
    array (
      0 => 'simpla/design/html/groups.tpl',
      1 => 1316778279,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17365283074ea44e50cc95a8-71904397',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?>
<div id="header">
	<h1>Группы пользователей</h1> 
	<a class="add" href="index.php?module=GroupAdmin">Добавить группу</a>
</div>	


<!-- Основная часть -->
<div id="main_list">

	<form id="list_form" method="post">
	<div id="list" class="groups">
		
				<div class="row">
			<div class="group_name cell">
				<a href="index.php?module=GroupAdmin&id=1">Постоянный покупатель</a>
			</div>
			<div class="group_discount cell">
				2.00 %
			</div>
			<div class="icons cell">
				<a class="delete" title="Удалить" href="#"></a>
			</div>
			<div class="clear"></div>
		</div>
			</div>

	</form>

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
});

</script>

<?php } ?>