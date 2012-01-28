<?php /*%%SmartyHeaderCode:14876757994ea447c0a10939-46360030%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c67705d883d288c64137fd663cc6f4ddb8a2aa3b' => 
    array (
      0 => 'simpla/design/html/theme.tpl',
      1 => 1318758815,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14876757994ea447c0a10939-46360030',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?>
<script>

	
$(function() {

	// Выбрать тему
	$('.set_main_theme').click(function() {
     	$("form input[name=action]").val('set_main_theme');
    	$("form input[name=theme]").val($(this).closest('li').attr('theme'));
    	$("form").submit();
	});	
	
	// Клонировать текущую тему
	$('#header .add').click(function() {
     	$("form input[name=action]").val('clone_theme');
    	$("form").submit();
	});	
	
	// Редактировать название
	$("a.edit").click(function() {
		name = $(this).closest('li').attr('theme');
		inp1 = $('<input type=hidden name="old_name[]">').val(name);
		inp2 = $('<input type=text name="new_name[]">').val(name);
		$(this).closest('li').find("p.name").html('').append(inp1).append(inp2);
		inp2.focus().select();
		return false;
	});
	
	// Удалить тему
	$('.delete').click(function() {
     	$("form input[name=action]").val('delete_theme');
     	$("form input[name=theme]").val($(this).closest('li').attr('theme'));
   		$("form").submit();
	});	

	$("form").submit(function() {
		if($("form input[name=action]").val()=='delete_theme' && !confirm('Подтвердите удаление'))
			return false;	
	});
	
});

</script>

<div id="header">
<h1 class="locked">Текущая тема &mdash; default</h1>
<a class="add" href="#">Создать копию темы default</a>
</div>


<div class="block layer">

<form method="post" enctype="multipart/form-data">
<input type="hidden" name="session_id" value="2b7f56184c93c564e5463bf1f1aa06e7">
<input type=hidden name="action">
<input type=hidden name="theme">

<ul class="themes">
	<li theme='default'>
		<img class="tick" src='design/images/tick.png'> 		<img class="tick" src='design/images/lock_small.png'> 						<p class=name>default</p>
				<img class="preview" src='../design/default/preview.png'>
	</li>
	<li theme='old'>
				<img class="tick" src='design/images/lock_small.png'> 								<p class=name><a href='#' class='set_main_theme'>old</a></p>
				<img class="preview" src='../design/old/preview.png'>
	</li>
</ul>

<div class="block">
<input class="button_green button_save" type="submit" name="save" value="Сохранить" />
</div>
</form>

</div><?php } ?>