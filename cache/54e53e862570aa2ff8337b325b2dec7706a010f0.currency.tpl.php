<?php /*%%SmartyHeaderCode:9656074654ea41203e920f8-72831465%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54e53e862570aa2ff8337b325b2dec7706a010f0' => 
    array (
      0 => 'simpla/design/html/currency.tpl',
      1 => 1317210665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9656074654ea41203e920f8-72831465',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?>
<script src="design/js/jquery/jquery.js"></script>
<script src="design/js/jquery/jquery-ui.min.js"></script>

<script>
$(function() {

	// Сортировка списка
	// Сортировка вариантов
	$("#currencies_block").sortable({ items: 'ul' , axis: 'y',  cancel: '#header', handle: '.move_zone' });

	// Добавление валюты
	var curr = $('#new_currency').clone(true);
	$('#new_currency').remove().removeAttr('id');
	$('a#add_currency').click(function() {
		if(!$('#currencies_block').is('.single_variant'))
		{
			$(curr).clone(true).appendTo('#currencies').fadeIn('slow').find("input[name*=currency][name*=name]").focus();
		}
		else
		{
			$('#currencies_block .variant_name').show('slow');
			$('#currencies_block').removeClass('single_variant');		
		}
		return false;		
	});	
 

	// Скрыт/Видим
	$("a.enable").click(function() {
		var icon        = $(this);
		var line        = icon.closest("ul");
		var id          = line.find('input[name*="currency[id]"]').val();
		var state       = line.hasClass('invisible')?1:0;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'currency', 'id': id, 'values': {'enabled': state}, 'session_id': '2b7f56184c93c564e5463bf1f1aa06e7'},
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
	
	// Центы
	$("a.cents").click(function() {
		var icon        = $(this);
		var line        = icon.closest("ul");
		var id          = line.find('input[name*="currency[id]"]').val();
		var state       = line.hasClass('cents')?0:2;
		icon.addClass('loading_icon');

		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'currency', 'id': id, 'values': {'cents': state}, 'session_id': '2b7f56184c93c564e5463bf1f1aa06e7'},
			success: function(data){
				icon.removeClass('loading_icon');
				if(!state)
					line.removeClass('cents');
				else
					line.addClass('cents');				
			},
			error: function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
            },
			dataType: 'json'
		});	
		return false;	
	});
	
	// Показать центы
	$("a.delete").click(function() {
		$('input[type="hidden"][name="action"]').val('delete');
		$('input[type="hidden"][name="action_id"]').val($(this).closest("ul").find('input[type="hidden"][name*="currency[id]"]').val());
		$(this).closest("form").submit();
	});
	
	
	$("form").submit(function() {
		if($('input[type="hidden"][name="action"]').val()=='delete' && !confirm('Подтвердите удаление'))
			return false;	
	});


});

</script>


		
	<!-- Заголовок -->
	<div id="header">
		<h1>Валюты</h1>
		<a class="add" id="add_currency" href="#">Добавить</a>
	<!-- Заголовок (The End) -->	
	</div>	


	
 
	<form method=post>
	<input type="hidden" name="session_id" value="2b7f56184c93c564e5463bf1f1aa06e7">
	
	
	<!-- Валюты -->
	<div id="currencies_block">
		<ul id="header">
			<li class="move"></li>
			<li class="name">Название валюты</li>	
			<li class="icons"></li>	
			<li class="sign">Знак</li>	
			<li class="iso">Код ISO</li>	
		</ul>
		<div id="currencies">
				<ul class="sortable  ">
			<li class="move"><div class="move_zone"></div></li>
			<li class="name">
				<input name="currency[id][2]" type="hidden" 	value="2" /><input name="currency[name][2]" type="" value="рубли" />
			</li>
			<li class="icons">
				<a class="cents" href="#" title="Выводить копейки"></a>
				<a class="enable" href="#" title="Активна"></a>
			</li>
			<li class="sign">		<input name="currency[sign][2]" type="text" 	value="руб" /></li>
			<li class="iso">		<input name="currency[code][2]" type="text" 	value="RUR" /></li>
			<li class="rate">
								<input name="currency[rate_from][2]" type="hidden" value="3.75" />
				<input name="currency[rate_to][2]" type="hidden" value="3.75" />
							</li>
			<li class="icons">
						</li>
		</ul>
				<ul class="sortable  cents">
			<li class="move"><div class="move_zone"></div></li>
			<li class="name">
				<input name="currency[id][1]" type="hidden" 	value="1" /><input name="currency[name][1]" type="" value="доллары" />
			</li>
			<li class="icons">
				<a class="cents" href="#" title="Выводить копейки"></a>
				<a class="enable" href="#" title="Активна"></a>
			</li>
			<li class="sign">		<input name="currency[sign][1]" type="text" 	value="$" /></li>
			<li class="iso">		<input name="currency[code][1]" type="text" 	value="USD" /></li>
			<li class="rate">
								<div class=rate_from><input name="currency[rate_from][1]" type="text" value="1.00" /> $</div>
				<div class=rate_to>= <input name="currency[rate_to][1]" type="text" value="30.00" /> руб</div>
							</li>
			<li class="icons">
							<a class="delete" href="#" title="Удалить"></a>				
						</li>
		</ul>
				<ul class="sortable invisible cents">
			<li class="move"><div class="move_zone"></div></li>
			<li class="name">
				<input name="currency[id][3]" type="hidden" 	value="3" /><input name="currency[name][3]" type="" value="вебмани wmz" />
			</li>
			<li class="icons">
				<a class="cents" href="#" title="Выводить копейки"></a>
				<a class="enable" href="#" title="Активна"></a>
			</li>
			<li class="sign">		<input name="currency[sign][3]" type="text" 	value="wmz" /></li>
			<li class="iso">		<input name="currency[code][3]" type="text" 	value="WMZ" /></li>
			<li class="rate">
								<div class=rate_from><input name="currency[rate_from][3]" type="text" value="0.15" /> wmz</div>
				<div class=rate_to>= <input name="currency[rate_to][3]" type="text" value="3.75" /> руб</div>
							</li>
			<li class="icons">
							<a class="delete" href="#" title="Удалить"></a>				
						</li>
		</ul>
				
		</div>
		<ul id=new_currency style='display:none;'>
			<li class="move"><div class="move_zone"></div></li>
			<li class="name"><input name="currency[id][]" type="hidden" value="" /><input name="currency[name][]" type="" value="" /></li>
			<li class="sign"><input name="currency[sign][]" type="" value="" /></li>
			<li class="iso"><input  name="currency[code][]" type="" value="" /></li>
			<li class="rate">
				<div class=rate_from><input name="currency[rate_from][]" type="text" value="1" /> </div>
				<div class=rate_to>= <input name="currency[rate_to][]" type="text" value="1" /> руб</div>			
			</li>
			<li class="icons">
			
			</li>
		</ul>

	</div>
	<!-- Валюты (The End)--> 


	<div id="action">

	<input type=hidden name=action value=''>
	<input type=hidden name=action_id value=''>
	<input id='apply_action' class="button_green" type=submit value="Применить">

	
	</div>
	</form>
	
 
<?php } ?>