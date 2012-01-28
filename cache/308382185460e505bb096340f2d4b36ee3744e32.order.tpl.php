<?php /*%%SmartyHeaderCode:2545505474ea40e2f03f6c2-68143465%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '308382185460e505bb096340f2d4b36ee3744e32' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/order.tpl',
      1 => 1317991299,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2545505474ea40e2f03f6c2-68143465',
  'has_nocache_code' => false,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?>
<h1>Ваш заказ №4
еще не оплачен,
ждет обработки</h1>
<table id="purchases">

<tr>
	<td class="image>"
						<a href="products/samsung_s5570_galaxy_mini"><img src="http://simpla/files/products/Samsung-Galaxy-Mini-S5570.50x50.jpg?8f82e01f184d4631b04ed61e70bc0504"></a>
			</td>
	
	<td class="name">
		<a href="products/samsung_s5570_galaxy_mini">Samsung S5570 Galaxy Mini</a>
		
			</td>
	<td class="price">
		5,43&nbsp;руб
	</td>
	<td class="amount">
		&times; 1&nbsp;шт
	</td>
	<td class="price">
		5,43&nbsp;руб
	</td>
</tr>
<tr>
	<th class="image"></th>
	<th class="name">итого</th>
	<th class="price"></th>
	<th class="amount"></th>
	<th class="price">
		5,43&nbsp;руб
	</th>
</tr>
<tr>
	<td class="image>"</td>
	<td class="name">Доставка с помощью предприятия &quot;Автотрейдинг&quot;</td>
	<td class="price"></td>
	<td class="amount"></td>
	<td class="price">
		1 020,00&nbsp;руб
	</td>
</tr>

</table>
<h2>Детали заказа</h2>
<table class="order_info">
	<tr>
		<td>
			Дата заказа
		</td>
		<td>
			23.10.2011 в
			16:42
		</td>
	</tr>
		<tr>
		<td>
			Имя
		</td>
		<td>
			qwe
		</td>
	</tr>
			<tr>
		<td>
			Email
		</td>
		<td>
			qwe@qwe.com
		</td>
	</tr>
				</table>


<h2>Способ оплаты &mdash; Робокасса
<form method=post><input type=submit name='reset_payment_method' value='Выбрать другой способ оплаты'></form>	
</h2>
<p>
<p>&nbsp;</p><div><p>ROBOKASSA - это сервис, позволяющий принимать платежи в любой электронной валюте, с помощью sms-сообщений, через систему денежных переводов Contact, и через терминалы мгновенной оплаты.</p></div><p>&nbsp;</p>
</p>
<h2>
К оплате 0,18&nbsp;$
</h2>
<form accept-charset='cp1251' action='https://merchant.roboxchange.com/Index.aspx' method=POST><input type=hidden name=MrchLogin value='pikusov'><input type=hidden name=OutSum value='0.181'><input type=hidden name=InvId value='4'><input type=hidden name=Desc value='Оплата заказа №4'><input type=hidden name=SignatureValue value='7349eb999e2a816634061d498506464e'><input type=hidden name=Shp_item value='3'><input type=hidden name=IncCurrLabel value='PCR'><input type=hidden name=Culture value='ru'><input type=submit class=checkout_button value='Перейти к оплате &#8594;'></form>



 <?php } ?>