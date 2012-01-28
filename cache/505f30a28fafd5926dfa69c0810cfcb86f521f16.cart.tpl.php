<?php /*%%SmartyHeaderCode:4613103074ea45e17342324-43931349%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '505f30a28fafd5926dfa69c0810cfcb86f521f16' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/cart.tpl',
      1 => 1319381529,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4613103074ea45e17342324-43931349',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?>
<h1>
В корзине 1 товар
</h1>

<form method="post" name="cart">
<table id="purchases">

<tr>
	<td class="image>"
						<a href="products/sony_ericsson_xperia_arc"><img src="http://simpla/files/products/Sony-Ericsson-XPERIA-Arc.50x50.jpeg?f6d750d8e9e7aee3f74cbc07a4460686"></a>
			</td>
	
	<td class="name">
		<a href="products/sony_ericsson_xperia_arc">Sony Ericsson Xperia arc</a>
					
	</td>
	<td class="price">
		20 000&nbsp;руб
	</td>
	<td class="amount">
		<select name="amounts[11]" onchange="document.cart.submit();">
						<option value="1" selected>1 шт</option>
						<option value="2" >2 шт</option>
						<option value="3" >3 шт</option>
						<option value="4" >4 шт</option>
						<option value="5" >5 шт</option>
						<option value="6" >6 шт</option>
						<option value="7" >7 шт</option>
						<option value="8" >8 шт</option>
						<option value="9" >9 шт</option>
						<option value="10" >10 шт</option>
						<option value="11" >11 шт</option>
						<option value="12" >12 шт</option>
						<option value="13" >13 шт</option>
						<option value="14" >14 шт</option>
						<option value="15" >15 шт</option>
						<option value="16" >16 шт</option>
						<option value="17" >17 шт</option>
						<option value="18" >18 шт</option>
						<option value="19" >19 шт</option>
						<option value="20" >20 шт</option>
						<option value="21" >21 шт</option>
						<option value="22" >22 шт</option>
						<option value="23" >23 шт</option>
						<option value="24" >24 шт</option>
						<option value="25" >25 шт</option>
						<option value="26" >26 шт</option>
						<option value="27" >27 шт</option>
						<option value="28" >28 шт</option>
						<option value="29" >29 шт</option>
						<option value="30" >30 шт</option>
						<option value="31" >31 шт</option>
						<option value="32" >32 шт</option>
						<option value="33" >33 шт</option>
						<option value="34" >34 шт</option>
						<option value="35" >35 шт</option>
						<option value="36" >36 шт</option>
						<option value="37" >37 шт</option>
						<option value="38" >38 шт</option>
						<option value="39" >39 шт</option>
						<option value="40" >40 шт</option>
						<option value="41" >41 шт</option>
						<option value="42" >42 шт</option>
						<option value="43" >43 шт</option>
						<option value="44" >44 шт</option>
						<option value="45" >45 шт</option>
						<option value="46" >46 шт</option>
						<option value="47" >47 шт</option>
						<option value="48" >48 шт</option>
						<option value="49" >49 шт</option>
						<option value="50" >50 шт</option>
					</select>
	</td>
	<td class="price">
		20 000&nbsp;руб
	</td>
	
	<td class="remove">
		<a href="cart/remove/11">
		<img src="design/default/images/delete.png" title="Удалить из корзины" alt="Удалить из корзины">
		</a>
	</td>
			
</tr>
<tr>
	<th class="image"></th>
	<th class="name">итого</th>
	<th class="price"></th>
	<th class="amount"></th>
	<th class="price">
		20 000&nbsp;руб
	</th>
	<th class="remove"></th>
</tr>
</table>
<h2>Выберите способ доставки:</h2>
<ul id="deliveries">
		<li>
		<div class="checkbox">
			<input type="radio" name="delivery_id" value="3" checked id="deliveries_3">
		</div>
		<label for="deliveries_3">
			<h3>
			Доставка с помощью предприятия "Автотрейдинг"
							(бесплатно)
						</h3>
			<p><span>Удобный и быстрый способ доставки в крупные города России. Посылка доставляется в офис "Автотрейдинг" в Вашем городе. Для получения необходимо предъявить паспорт и номер грузовой декларации (сообщит наш менеджер после отправки). Посылку желательно получить в течение 24 часов с момента прихода груза, иначе компания "Автотрейдинг" может взыскать с Вас дополнительную оплату за хранение. Срок доставки и стоимость Вы можете рассчитать на сайте компании.</span></p>
		</label>
	</li>
		<li>
		<div class="checkbox">
			<input type="radio" name="delivery_id" value="1"  id="deliveries_1">
		</div>
		<label for="deliveries_1">
			<h3>
			Курьерская доставка по Москве
							(120&nbsp;руб)
						</h3>
			<p><span>Курьерская доставка осуществляется на следующий день после оформления заказа, если товар есть в наличии. Курьерская доставка осуществляется в пределах Томска и Северска ежедневно с 10.00 до 21.00. Заказ на сумму свыше 300 рублей доставляется бесплатно.&nbsp;<br /><br />Стоимость бесплатной доставки раcсчитывается от суммы заказа с учтенной скидкой. В случае если сумма заказа после применения скидки менее 300р, осуществляется платная доставка.&nbsp;<br /><br />При сумме заказа менее 300 рублей стоимость доставки составляет от 50 рублей.</span></p>
		</label>
	</li>
		<li>
		<div class="checkbox">
			<input type="radio" name="delivery_id" value="2"  id="deliveries_2">
		</div>
		<label for="deliveries_2">
			<h3>
			Самовывоз
							(бесплатно)
						</h3>
			<p>Удобный, бесплатный и быстрый способ получения заказа.</p><p>Адрес офиса: Адрес офиса: Москва, ул. Арбат, 1/3, офис 419</p>
		</label>
	</li>
	</ul>
    
<h2>Адрес получателя</h2>
<script src="js/baloon/js/default.js" language="JavaScript" type="text/javascript"></script>
<script src="js/baloon/js/validate.js" language="JavaScript" type="text/javascript"></script>
<script src="js/baloon/js/baloon.js" language="JavaScript" type="text/javascript"></script>
<link   href="js/baloon/css/baloon.css" rel="stylesheet" type="text/css" /> 
	
<div class="form cart_form">         
		<label>Имя, фамилия</label>
	<input name="name" type="text" value="" format=".+" notice="Введите имя"/>
	
	<label>Email</label>
	<input name="email" type="text" value="" format="email" notice="Введите email" />

	<label>Телефон</label>
	<input name="phone" type="text" value="" />
	
	<label>Адрес доставки</label>
	<input name="address" type="text" value=""/>

	<label>Комментарий к&nbsp;заказу</label>
	<textarea name="comment" id="order_comment"></textarea>
	<input type="submit" name="checkout" class="button_submit" value="Оформить заказ">
	</div>
   
</form>
<?php } ?>