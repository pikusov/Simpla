<?php /*%%SmartyHeaderCode:8669042284ea1b431c6e319-08057843%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a3ae23904099efd352223d16f642cb5627b78cf0' => 
    array (
      0 => 'simpla/design/html/users.tpl',
      1 => 1316779826,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8669042284ea1b431c6e319-08057843',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><div id="header">
		<h1>Нет покупателей</h1> 	
	</div>


 <!-- Меню -->
<div id="right_menu">
	<ul>
		<li class="selected"><a href='index.php?module=UsersAdmin'>Все группы</a></li>
	</ul>
	<!-- Группы -->
		<ul>
				<li ><a href="index.php?module=UsersAdmin&group_id=1">Постоянный покупатель</a></li>
			</ul>
		<!-- Группы (The End)-->
		
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
			data: {'object': 'user', 'id': id, 'values': {'enabled': state}, 'session_id': '2b7f56184c93c564e5463bf1f1aa06e7'},
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