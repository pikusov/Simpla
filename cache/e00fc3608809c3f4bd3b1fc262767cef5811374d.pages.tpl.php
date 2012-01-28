<?php /*%%SmartyHeaderCode:7449554274ea1b3764b0f88-48685484%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e00fc3608809c3f4bd3b1fc262767cef5811374d' => 
    array (
      0 => 'simpla/design/html/pages.tpl',
      1 => 1316605169,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7449554274ea1b3764b0f88-48685484',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><div id="header">
	<h1>Основное меню</h1>
	<a class="add" href="/simpla/index.php?module=PageAdmin">Добавить страницу</a>
</div>

<div id="main_list">
 
	<form id="list_form" method="post">
		<input type="hidden" name="session_id" value="2b7f56184c93c564e5463bf1f1aa06e7">
		<div id="list">		
						<div class=" row">
				<input type="hidden" name="positions[1]" value="1">
				<div class="move cell"><div class="move_zone"></div></div>
		 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="1" />				
				</div>
				<div class="name cell">
					<a href="/simpla/index.php?module=PageAdmin&id=1&return=%2Fsimpla%2Findex.php%3Fmodule%3DPagesAdmin">Хиты продаж</a>
				</div>
				<div class="icons cell">
					<a class="preview" title="Предосмотр в новом окне" href="../" target="_blank"></a>
					<a class="enable" title="Активна" href="#"></a>
					<a class="delete" title="Удалить" href="#"></a>
				</div>
				<div class="clear"></div>
			</div>
						<div class=" row">
				<input type="hidden" name="positions[4]" value="2">
				<div class="move cell"><div class="move_zone"></div></div>
		 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="4" />				
				</div>
				<div class="name cell">
					<a href="/simpla/index.php?module=PageAdmin&id=4&return=%2Fsimpla%2Findex.php%3Fmodule%3DPagesAdmin">Блог</a>
				</div>
				<div class="icons cell">
					<a class="preview" title="Предосмотр в новом окне" href="../blog" target="_blank"></a>
					<a class="enable" title="Активна" href="#"></a>
					<a class="delete" title="Удалить" href="#"></a>
				</div>
				<div class="clear"></div>
			</div>
						<div class=" row">
				<input type="hidden" name="positions[3]" value="3">
				<div class="move cell"><div class="move_zone"></div></div>
		 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="3" />				
				</div>
				<div class="name cell">
					<a href="/simpla/index.php?module=PageAdmin&id=3&return=%2Fsimpla%2Findex.php%3Fmodule%3DPagesAdmin">Доставка</a>
				</div>
				<div class="icons cell">
					<a class="preview" title="Предосмотр в новом окне" href="../dostavka" target="_blank"></a>
					<a class="enable" title="Активна" href="#"></a>
					<a class="delete" title="Удалить" href="#"></a>
				</div>
				<div class="clear"></div>
			</div>
						<div class=" row">
				<input type="hidden" name="positions[2]" value="4">
				<div class="move cell"><div class="move_zone"></div></div>
		 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="2" />				
				</div>
				<div class="name cell">
					<a href="/simpla/index.php?module=PageAdmin&id=2&return=%2Fsimpla%2Findex.php%3Fmodule%3DPagesAdmin">Оплата</a>
				</div>
				<div class="icons cell">
					<a class="preview" title="Предосмотр в новом окне" href="../oplata" target="_blank"></a>
					<a class="enable" title="Активна" href="#"></a>
					<a class="delete" title="Удалить" href="#"></a>
				</div>
				<div class="clear"></div>
			</div>
						<div class=" row">
				<input type="hidden" name="positions[6]" value="6">
				<div class="move cell"><div class="move_zone"></div></div>
		 		<div class="checkbox cell">
					<input type="checkbox" name="check[]" value="6" />				
				</div>
				<div class="name cell">
					<a href="/simpla/index.php?module=PageAdmin&id=6&return=%2Fsimpla%2Findex.php%3Fmodule%3DPagesAdmin">Контакты</a>
				</div>
				<div class="icons cell">
					<a class="preview" title="Предосмотр в новом окне" href="../contact" target="_blank"></a>
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
</div>

<script>
$(function() {

	// Сортировка списка
	$("#list").sortable({
		items:             ".row",
		tolerance:         "pointer",
		handle:            ".move_zone",
		scrollSensitivity: 40,
		opacity:           0.7, 
		forcePlaceholderSize: true,
		axis: 'y',
		
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

 
	// Раскраска строк
	function colorize()
	{
		$(".row:even").addClass('even');
		$(".row:odd").removeClass('even');
	}
	// Раскрасить строки сразу
	colorize();
 

	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', 1-$('#list input[type="checkbox"][name*="check"]').attr('checked'));
	});	

	// Удалить 
	$("a.delete").click(function() {
		$('#list_form input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest(".row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});
	

	// Показать
	$("a.enable").click(function() {
		var icon        = $(this);
		var line        = icon.closest(".row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('invisible')?1:0;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'page', 'id': id, 'values': {'visible': state}, 'session_id': '2b7f56184c93c564e5463bf1f1aa06e7'},
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


	$("form").submit(function() {
		if($('select[name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});
});
</script>

<?php } ?>