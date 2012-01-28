<?php /*%%SmartyHeaderCode:18730977534ea406b10057c3-04653311%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f061660b29c37db128f175952d7a57630d9461f0' => 
    array (
      0 => 'simpla/design/html/backup.tpl',
      1 => 1319372463,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18730977534ea406b10057c3-04653311',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?>
<div id="header">
	<h1>Бекап</h1>
		<a class="add" href="">Создать бекап</a>
	<form id="hidden" method="post">
		<input type="hidden" name="session_id" value="2b7f56184c93c564e5463bf1f1aa06e7">
		<input type="hidden" name="action" value="">
		<input type="hidden" name="name" value="">
	</form>
	</div>	

<!-- Системное сообщение -->
<div class="message message_success">
	<span>Бекап создан</span>
	</div>
<!-- Системное сообщение (The End)-->


<div id="main_list">

	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="2b7f56184c93c564e5463bf1f1aa06e7">

		<div id="list">			
						<div class="row">
						 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="simpla_2011_10_23_20:39:11.zip"/>				
				</div>
								<div class="name cell">
	 				<a href="files/backup/simpla_2011_10_23_20:39:11.zip">simpla_2011_10_23_20:39:11.zip</a>
					(14.07 МБ)
				</div>
				<div class="icons cell">
										<a class="delete" title="Удалить" href="#"></a>
							 		</div>
				<div class="icons cell">
					<a class="restore" title="Восстановить этот бекап" href="#"></a>
				</div>
		 		<div class="clear"></div>
			</div>
						<div class="row">
						 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="empty.zip"/>				
				</div>
								<div class="name cell">
	 				<a href="files/backup/empty.zip">empty.zip</a>
					(10.23 КБ)
				</div>
				<div class="icons cell">
										<a class="delete" title="Удалить" href="#"></a>
							 		</div>
				<div class="icons cell">
					<a class="restore" title="Восстановить этот бекап" href="#"></a>
				</div>
		 		<div class="clear"></div>
			</div>
					</div>
		
				<div id="action">
		<label id="check_all" class="dash_link">Выбрать все</label>
	
		<span id="select">
		<select name="action">
			<option value="delete">Удалить</option>
		</select>
		</span>
	
		<input id="apply_action" class="button_green" type="submit" value="Применить">
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

	// Восстановить 
	$("a.restore").click(function() {
		file = $(this).closest(".row").find('[name*="check"]').val();
		$('form#hidden input[name="action"]').val('restore');
		$('form#hidden input[name="name"]').val(file);
		$('form#hidden').submit();
		return false;
	});

	// Создать бекап 
	$("a.add").click(function() {
		$('form#hidden input[name="action"]').val('create');
		$('form#hidden').submit();
		return false;
	});

	$("form#hidden").submit(function() {
		if($('input[name="action"]').val()=='restore' && !confirm('Текущие данные будут потеряны. Подтвердите восстановление'))
			return false;	
	});
	
	$("form#list_form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
	

});

</script>
<?php } ?>