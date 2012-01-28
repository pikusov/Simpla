<?php /*%%SmartyHeaderCode:20193028614ea1a6fb58e955-17425927%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '29ea9ac8ff03271d57a7c517b21d0b694373e940' => 
    array (
      0 => 'simpla/design/html/products.tpl',
      1 => 1316635462,
      2 => 'file',
    ),
    '8525564c8d119ad869e403b6d8062e04fc797163' => 
    array (
      0 => 'simpla/design/html/pagination.tpl',
      1 => 1304778449,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20193028614ea1a6fb58e955-17425927',
  'has_nocache_code' => 0,
  'cache_lifetime' => '0',
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?>	<form method="get">
<div id="search">
	<input type="hidden" name="module" value="ProductsAdmin">
	<input class="search" type="text" name="keyword" value="" />
	<input class="search_button" type="submit" value=""/>
</div>
</form>
	
<div id="header">	
						<h1>42 товара</h1>
				
		<a class="add" href="/simpla/?module=ProductAdmin&return=%2Fsimpla%2F">Добавить товар</a>
</div>	

<div id="main_list">
	
	<!-- Листалка страниц -->
		<!-- Листалка страниц -->
		<script type="text/javascript" src="design/js/ctrlnavigate.js"></script>           
	<div id="pagination">
							  
									<a class="selected" href="/simpla/?page=1">1</a>
												<a class="droppable" href="/simpla/?page=2">2</a>
												<a class="droppable" href="/simpla/?page=3">3</a>
						
				<a id="NextLink" href="/simpla/?page=2">вперед →</a>		
	</div>
		<!-- Листалка страниц (The End) -->
	
	<!-- Листалка страниц (The End) -->
		
	
	<div id="expand">
	<!-- Свернуть/развернуть варианты -->
	<a href="#" class="dash_link" id="expand_all">Развернуть все варинаты ↓</a>
	<a href="#" class="dash_link" id="roll_up_all" style="display:none;">Свернуть все варинаты ↑</a>
	<!-- Свернуть/развернуть варианты (The End) -->
	</div>
	<form id="list_form" method="post">
	<input type="hidden" name="session_id" value="2b7f56184c93c564e5463bf1f1aa06e7">
	
		<div id="list">
				<div class=" hit row">
			<input type="hidden" name="positions[8]" value="1">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="8"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=8&return=%2Fsimpla%2F"><img src="http://simpla/files/products/Samsung-Galaxy-Mini-S5570.35x35.jpg?f21b621c9bd0a5fba7bbdd4f26d51cb9" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[12]" value="7300.00" />руб  
					<input class="stock" type="text" name="stock[12]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=8&return=%2Fsimpla%2F">Samsung S5570 Galaxy Mini</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/samsung_s5570_galaxy_mini" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[1]" value="2">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="1"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=1&return=%2Fsimpla%2F"><img src="http://simpla/files/products/iphone4s-white.35x35.jpeg?32b57ae1316c42ecc763d7ecaa910e17" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title="Белый">Белый</i>
					<input class="price" type="text" name="price[1]" value="44000.00" />руб  
					<input class="stock" type="text" name="stock[1]" value="∞" />шт
				</li>
								<li class="variant" style="display:none;">
					<i title="Черный">Черный</i>
					<input class="price" type="text" name="price[2]" value="42000.00" />руб  
					<input class="stock" type="text" name="stock[2]" value="∞" />шт
				</li>
								</ul>
	
												<div class="expand_variant">
				<a class="dash_link expand_variant" href="#">2 варианта ↓</a>
				<a class="dash_link roll_up_variant" style="display:none;" href="#">2 варианта ↑</a>
				</div>
								</div>
				
				<a href="/simpla/?module=ProductAdmin&id=1&return=%2Fsimpla%2F">Apple iPhone 4S 16Gb</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/apple_iphone_4s_16gb" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[2]" value="3">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="2"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=2&return=%2Fsimpla%2F"><img src="http://simpla/files/products/Samsung-Galaxy-S-II.35x35.jpg?1958da813f6bc8647639171ffc72f0c2" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[3]" value="19200.00" />руб  
					<input class="stock" type="text" name="stock[3]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=2&return=%2Fsimpla%2F">Samsung Galaxy S II</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/samsung_galaxy_s_ii" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class=" hit row">
			<input type="hidden" name="positions[17]" value="4">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="17"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=17&return=%2Fsimpla%2F"><img src="http://simpla/files/products/Samsung-Diva-S7070.35x35.jpeg?9f1494041a0b631ceb02a75ed1107027" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[25]" value="8500.00" />руб  
					<input class="stock" type="text" name="stock[25]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=17&return=%2Fsimpla%2F">Samsung S7070 Diva</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/samsung_s7070_diva" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class=" hit row">
			<input type="hidden" name="positions[3]" value="5">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="3"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=3&return=%2Fsimpla%2F"><img src="http://simpla/files/products/HTC-Incredible-S_D.35x35.jpeg?88fedc89a62b652fecace9f9254ff49e" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[4]" value="16000.00" />руб  
					<input class="stock" type="text" name="stock[4]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=3&return=%2Fsimpla%2F">HTC Incredible S</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/htc_incredible_s" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class=" hit row">
			<input type="hidden" name="positions[4]" value="6">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="4"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=4&return=%2Fsimpla%2F"><img src="http://simpla/files/products/HTC-Sensation-4G-1.35x35.jpeg?6d2da73abc646f1fbb5d5c84e26763e8" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[5]" value="20300.00" />руб  
					<input class="stock" type="text" name="stock[5]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=4&return=%2Fsimpla%2F">HTC Sensation</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/htc_sensation" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[5]" value="7">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="5"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=5&return=%2Fsimpla%2F"><img src="http://simpla/files/products/210_Nokia_C5_03.35x35.jpeg?1ffa176c67d89d2c4b9de406181e9252" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title="Белая">Белая</i>
					<input class="price" type="text" name="price[6]" value="6900.00" />руб  
					<input class="stock" type="text" name="stock[6]" value="∞" />шт
				</li>
								<li class="variant" style="display:none;">
					<i title="Черная">Черная</i>
					<input class="price" type="text" name="price[7]" value="69000.00" />руб  
					<input class="stock" type="text" name="stock[7]" value="∞" />шт
				</li>
								</ul>
	
												<div class="expand_variant">
				<a class="dash_link expand_variant" href="#">2 варианта ↓</a>
				<a class="dash_link roll_up_variant" style="display:none;" href="#">2 варианта ↑</a>
				</div>
								</div>
				
				<a href="/simpla/?module=ProductAdmin&id=5&return=%2Fsimpla%2F">Nokia C5-03</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/nokia_c503" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[6]" value="8">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="6"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=6&return=%2Fsimpla%2F"><img src="http://simpla/files/products/E72_black_01-300-100.35x35.jpeg?cc02ea8f8f61f51eabf9d059815bcf05" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title="Фиолетовый">Фиолетовый</i>
					<input class="price" type="text" name="price[8]" value="12000.00" />руб  
					<input class="stock" type="text" name="stock[8]" value="∞" />шт
				</li>
								<li class="variant" style="display:none;">
					<i title="Бежевый">Бежевый</i>
					<input class="price" type="text" name="price[9]" value="11000.00" />руб  
					<input class="stock" type="text" name="stock[9]" value="∞" />шт
				</li>
								<li class="variant" style="display:none;">
					<i title="Черный">Черный</i>
					<input class="price" type="text" name="price[10]" value="10000.00" />руб  
					<input class="stock" type="text" name="stock[10]" value="∞" />шт
				</li>
								</ul>
	
												<div class="expand_variant">
				<a class="dash_link expand_variant" href="#">3 варианта ↓</a>
				<a class="dash_link roll_up_variant" style="display:none;" href="#">3 варианта ↑</a>
				</div>
								</div>
				
				<a href="/simpla/?module=ProductAdmin&id=6&return=%2Fsimpla%2F">Nokia E72</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/nokia_e72" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class=" hit row">
			<input type="hidden" name="positions[7]" value="9">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="7"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=7&return=%2Fsimpla%2F"><img src="http://simpla/files/products/Sony-Ericsson-XPERIA-Arc.35x35.jpeg?729e129c378a559b8adbaebde1ac01b6" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[11]" value="20000.00" />руб  
					<input class="stock" type="text" name="stock[11]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=7&return=%2Fsimpla%2F">Sony Ericsson Xperia arc</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/sony_ericsson_xperia_arc" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[9]" value="10">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="9"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=9&return=%2Fsimpla%2F"><img src="http://simpla/files/products/Vivaz_Front_MoonSilver.35x35.jpg?b0627c15d0fdba8cad0ecbf70964e0d3" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[13]" value="10300.00" />руб  
					<input class="stock" type="text" name="stock[13]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=9&return=%2Fsimpla%2F">Sony Ericsson Vivaz</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/sony_ericsson_vivaz" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[10]" value="11">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="10"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=10&return=%2Fsimpla%2F"><img src="http://simpla/files/products/1Nokia-X3-02-Touch-and-Type-1.35x35.jpg?7b33fdae6aa2bf89e99f61026425534d" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title="Малиновый">Малиновый</i>
					<input class="price" type="text" name="price[14]" value="5500.00" />руб  
					<input class="stock" type="text" name="stock[14]" value="∞" />шт
				</li>
								<li class="variant" style="display:none;">
					<i title="Голубой">Голубой</i>
					<input class="price" type="text" name="price[15]" value="5600.00" />руб  
					<input class="stock" type="text" name="stock[15]" value="∞" />шт
				</li>
								<li class="variant" style="display:none;">
					<i title="Черный">Черный</i>
					<input class="price" type="text" name="price[16]" value="5700.00" />руб  
					<input class="stock" type="text" name="stock[16]" value="∞" />шт
				</li>
								<li class="variant" style="display:none;">
					<i title="Белый">Белый</i>
					<input class="price" type="text" name="price[17]" value="5200.00" />руб  
					<input class="stock" type="text" name="stock[17]" value="∞" />шт
				</li>
								<li class="variant" style="display:none;">
					<i title="Фиолетовый">Фиолетовый</i>
					<input class="price" type="text" name="price[18]" value="5300.00" />руб  
					<input class="stock" type="text" name="stock[18]" value="∞" />шт
				</li>
								</ul>
	
												<div class="expand_variant">
				<a class="dash_link expand_variant" href="#">5 вариатов ↓</a>
				<a class="dash_link roll_up_variant" style="display:none;" href="#">5 вариатов ↑</a>
				</div>
								</div>
				
				<a href="/simpla/?module=ProductAdmin&id=10&return=%2Fsimpla%2F">Nokia X3-02</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/nokia_x302" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[11]" value="12">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="11"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=11&return=%2Fsimpla%2F"><img src="http://simpla/files/products/nokia_X2_front_blue_604x604.35x35.png?75dc37b109d39ce9867b6b45c68fe2bb" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[19]" value="5000.00" />руб  
					<input class="stock" type="text" name="stock[19]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=11&return=%2Fsimpla%2F">Nokia X2-00</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/nokia_x200" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[12]" value="13">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="12"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=12&return=%2Fsimpla%2F"><img src="http://simpla/files/products/nokia_e7_blue_front_1200x1200.35x35.png?89f909ec2f2c2da4fc0aa6cced1bf912" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[20]" value="25000.00" />руб  
					<input class="stock" type="text" name="stock[20]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=12&return=%2Fsimpla%2F">Nokia E7</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/nokia_e7" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[13]" value="14">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="13"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=13&return=%2Fsimpla%2F"><img src="http://simpla/files/products/nokiac600.35x35.jpg?78ce0ee2233cad18c2b6b742207bc47e" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[21]" value="10000.00" />руб  
					<input class="stock" type="text" name="stock[21]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=13&return=%2Fsimpla%2F">Nokia C6-00</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/nokia_c600" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class=" hit row">
			<input type="hidden" name="positions[14]" value="15">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="14"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=14&return=%2Fsimpla%2F"><img src="http://simpla/files/products/htcsalsa_3.35x35.jpg?1d81f2d82628d5dbdf8df50b416ffc77" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[22]" value="12000.00" />руб  
					<input class="stock" type="text" name="stock[22]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=14&return=%2Fsimpla%2F">HTC Salsa</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/htc_salsa" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[15]" value="16">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="15"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=15&return=%2Fsimpla%2F"><img src="http://simpla/files/products/White-Blackberry-Torch-98001.35x35.jpg?62d4f038c7af7e7fad3e980f2810b8b0" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[23]" value="27000.00" />руб  
					<input class="stock" type="text" name="stock[23]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=15&return=%2Fsimpla%2F">BlackBerry Torch 9800</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/blackberry_torch_9800" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class=" hit row">
			<input type="hidden" name="positions[16]" value="17">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="16"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=16&return=%2Fsimpla%2F"><img src="http://simpla/files/products/htc-legend.35x35.jpg?2b51f8ec6efa0d7862c9d40a76fc505f" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[24]" value="15700.00" />руб  
					<input class="stock" type="text" name="stock[24]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=16&return=%2Fsimpla%2F">HTC Legend</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/htc_legend" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class=" hit row">
			<input type="hidden" name="positions[18]" value="18">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="18"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=18&return=%2Fsimpla%2F"><img src="http://simpla/files/products/BlackBerry-Bold-9900-and-9930-Smartphone-2.35x35.jpg?8a53ebdc848fbf6117ff32a6b3a13dcc" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[26]" value="33000.00" />руб  
					<input class="stock" type="text" name="stock[26]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=18&return=%2Fsimpla%2F">BlackBerry Bold 9900</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/blackberry_bold_9900" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[19]" value="19">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="19"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=19&return=%2Fsimpla%2F"><img src="http://simpla/files/products/xperia.35x35.jpg?735c92fc2291cee48d34a0c49754856e" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[27]" value="18000.00" />руб  
					<input class="stock" type="text" name="stock[27]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=19&return=%2Fsimpla%2F">Sony Ericsson Xperia X10</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/sony_ericsson_xperia_x10" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				<div class="  row">
			<input type="hidden" name="positions[20]" value="20">
			<div class="move cell"><div class="move_zone"></div></div>
	 		<div class="checkbox cell">
				<input type="checkbox" name="check[]" value="20"/>				
			</div>
			<div class="image cell">
												<a href="/simpla/?module=ProductAdmin&id=20&return=%2Fsimpla%2F"><img src="http://simpla/files/products/a270-e1302938698758.35x35.jpg?e7576a2ddb6fb282a44386c58f39ab31" /></a>
							</div>
			<div class="name product_name cell">
			 	
			 	<div class="variants">
			 	<ul>
								<li >
					<i title=""></i>
					<input class="price" type="text" name="price[28]" value="20000.00" />руб  
					<input class="stock" type="text" name="stock[28]" value="∞" />шт
				</li>
								</ul>
	
												</div>
				
				<a href="/simpla/?module=ProductAdmin&id=20&return=%2Fsimpla%2F">Nokia X7</a>
	 			
			</div>
			<div class="icons cell">
				<a class="preview"   title="Предосмотр в новом окне" href="../products/nokia_x7" target="_blank"></a>			
				<a class="enable"    title="Активен"                 href="#"></a>
				<a class="hit"       title="Хит"                     href="#"></a>
				<a class="duplicate" title="Дублировать"             href="#"></a>
				<a class="delete"    title="Удалить"                 href="#"></a>
			</div>
			
			<div class="clear"></div>
		</div>
				</div>

		<div id="action">
			<label id="check_all" class="dash_link">Выбрать все</label>
		
			<span id="select">
			<select name="action">
				<option value="enable"    >Сделать видимыми</option>
				<option value="disable"   >Сделать невидимыми</option>
				<option value="set_hit"   >Сделать хитом</option>
				<option value="unset_hit" >Отменить хит</option>
				<option value="duplicate" >Создать дубликат</option>
								<option value="move_to_page">Переместить на страницу</option>
												<option value="move_to_category">Переместить в категорию</option>
												<option value="move_to_brand">Указать бренд</option>
								<option value="delete">Удалить</option>
			</select>
			</span>
		
			<span id="move_to_page">
			<select name="target_page">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select> 
			</span>
		
			<span id="move_to_category">
			<select name="target_category">
														<option value='1'>Мобильные телефоны</option>
										
										<option value='2'>Бытовая техника</option>
																<option value='3'>&nbsp;&nbsp;&nbsp;&nbsp;Пылесосы</option>
										
										<option value='4'>&nbsp;&nbsp;&nbsp;&nbsp;Миксеры</option>
										
				
										<option value='5'>Фотоаппараты</option>
										
				
			</select> 
			</span>
			
			<span id="move_to_brand">
			<select name="target_brand">
				<option value="0">Не указан</option>
								<option value="1">Apple</option>
								<option value="6">BlackBerry</option>
								<option value="11">Canon</option>
								<option value="7">Dyson</option>
								<option value="8">Electrolux</option>
								<option value="4">HTC</option>
								<option value="10">Nikon</option>
								<option value="3">Nokia</option>
								<option value="2">Samsung</option>
								<option value="5">Sony Ericsson</option>
								<option value="9">Zelmer</option>
							</select> 
			</span>
		
			<input id="apply_action" class="button_green" type="submit" value="Применить">		
		</div>
			</form>

	<!-- Листалка страниц -->
		<!-- Листалка страниц -->
		<script type="text/javascript" src="design/js/ctrlnavigate.js"></script>           
	<div id="pagination">
							  
									<a class="selected" href="/simpla/?page=1">1</a>
												<a class="droppable" href="/simpla/?page=2">2</a>
												<a class="droppable" href="/simpla/?page=3">3</a>
						
				<a id="NextLink" href="/simpla/?page=2">вперед →</a>		
	</div>
		<!-- Листалка страниц (The End) -->
	
	<!-- Листалка страниц (The End) -->		
</div>


<!-- Меню -->
<div id="right_menu">
	
	<!-- Категории товаров -->
			<ul>
				<li class="selected"><a href="/simpla/?">Все категории</a></li>	
						<li category_id="1" class="droppable category"><a href='/simpla/?category_id=1'>Мобильные телефоны</a></li>
			
				<li category_id="2" class="droppable category"><a href='/simpla/?category_id=2'>Бытовая техника</a></li>
				<ul>
						<li category_id="3" class="droppable category"><a href='/simpla/?category_id=3'>Пылесосы</a></li>
			
				<li category_id="4" class="droppable category"><a href='/simpla/?category_id=4'>Миксеры</a></li>
			
			</ul>
	
				<li category_id="5" class="droppable category"><a href='/simpla/?category_id=5'>Фотоаппараты</a></li>
			
			</ul>
	
	<!-- Категории товаров (The End)-->
	
		<!-- Бренды -->
	<ul>
		<li class="selected"><a href="/simpla/?">Все бренды</a></li>
				<li brand_id="1" class="droppable brand"><a href="/simpla/?brand_id=1">Apple</a></li>
				<li brand_id="6" class="droppable brand"><a href="/simpla/?brand_id=6">BlackBerry</a></li>
				<li brand_id="11" class="droppable brand"><a href="/simpla/?brand_id=11">Canon</a></li>
				<li brand_id="7" class="droppable brand"><a href="/simpla/?brand_id=7">Dyson</a></li>
				<li brand_id="8" class="droppable brand"><a href="/simpla/?brand_id=8">Electrolux</a></li>
				<li brand_id="4" class="droppable brand"><a href="/simpla/?brand_id=4">HTC</a></li>
				<li brand_id="10" class="droppable brand"><a href="/simpla/?brand_id=10">Nikon</a></li>
				<li brand_id="3" class="droppable brand"><a href="/simpla/?brand_id=3">Nokia</a></li>
				<li brand_id="2" class="droppable brand"><a href="/simpla/?brand_id=2">Samsung</a></li>
				<li brand_id="5" class="droppable brand"><a href="/simpla/?brand_id=5">Sony Ericsson</a></li>
				<li brand_id="9" class="droppable brand"><a href="/simpla/?brand_id=9">Zelmer</a></li>
			</ul>
	<!-- Бренды (The End) -->
		
</div>
<!-- Меню  (The End) -->

<script>

$(function() {

	// Сортировка списка
	$("#list").sortable({
		items:             ".row",
		tolerance:         "pointer",
		handle:            ".move_zone",
		scrollSensitivity: 40,
		opacity:           0.7, 
		
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
	

	// Перенос товара на другую страницу
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_page')
			$("span#move_to_page").show();
		else
			$("span#move_to_page").hide();
	});
	$("#pagination a.droppable").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_page]').attr("selected", "selected");		
			$(ui.draggable).closest("form").find('select[name=target_page] option[value='+$(this).html()+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;	
		}		
	});


	// Перенос товара в другую категорию
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_category')
			$("span#move_to_category").show();
		else
			$("span#move_to_category").hide();
	});
	$("#right_menu .droppable.category").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_category]').attr("selected", "selected");	
			$(ui.draggable).closest("form").find('select[name=target_category] option[value='+$(this).attr('category_id')+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;			
		}
	});


	// Перенос товара в другой бренд
	$("#action select[name=action]").change(function() {
		if($(this).val() == 'move_to_brand')
			$("span#move_to_brand").show();
		else
			$("span#move_to_brand").hide();
	});
	$("#right_menu .droppable.brand").droppable({
		activeClass: "drop_active",
		hoverClass: "drop_hover",
		tolerance: "pointer",
		drop: function(event, ui){
			$(ui.helper).find('input[type="checkbox"][name*="check"]').attr('checked', true);
			$(ui.draggable).closest("form").find('select[name="action"] option[value=move_to_brand]').attr("selected", "selected");			
			$(ui.draggable).closest("form").find('select[name=target_brand] option[value='+$(this).attr('brand_id')+']').attr("selected", "selected");
			$(ui.draggable).closest("form").submit();
			return false;			
		}
	});


	// Если есть варианты, отображать ссылку на их разворачивание
	if($("li.variant").size()>0)
		$("#expand").show();


	// Раскраска строк
	function colorize()
	{
		$("#list div.row:even").addClass('even');
		$("#list div.row:odd").removeClass('even');
	}
	// Раскрасить строки сразу
	colorize();


	// Показать все варианты
	$("#expand_all").click(function() {
		$("a#expand_all").hide();
		$("a#roll_up_all").show();
		$("a.expand_variant").hide();
		$("a.roll_up_variant").show();
		$(".variants ul li.variant").fadeIn('fast');
		return false;
	});


	// Свернуть все варианты
	$("#roll_up_all").click(function() {
		$("a#roll_up_all").hide();
		$("a#expand_all").show();
		$("a.roll_up_variant").hide();
		$("a.expand_variant").show();
		$(".variants ul li.variant").fadeOut('fast');
		return false;
	});

 
	// Показать вариант
	$("a.expand_variant").click(function() {
		$(this).closest("div.cell").find("li.variant").fadeIn('fast');
		$(this).closest("div.cell").find("a.expand_variant").hide();
		$(this).closest("div.cell").find("a.roll_up_variant").show();
		return false;
	});

	// Свернуть вариант
	$("a.roll_up_variant").click(function() {
		$(this).closest("div.cell").find("li.variant").fadeOut('fast');
		$(this).closest("div.cell").find("a.roll_up_variant").hide();
		$(this).closest("div.cell").find("a.expand_variant").show();
		return false;
	});

	// Выделить все
	$("#check_all").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', 1-$('#list input[type="checkbox"][name*="check"]').attr('checked'));
	});	

	// Удалить товар
	$("a.delete").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=delete]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Дублировать товар
	$("a.duplicate").click(function() {
		$('#list input[type="checkbox"][name*="check"]').attr('checked', false);
		$(this).closest("div.row").find('input[type="checkbox"][name*="check"]').attr('checked', true);
		$(this).closest("form").find('select[name="action"] option[value=duplicate]').attr('selected', true);
		$(this).closest("form").submit();
	});
	
	// Показать товар
	$("a.enable").click(function() {
		var icon        = $(this);
		var line        = icon.closest("div.row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('invisible')?1:0;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'product', 'id': id, 'values': {'visible': state}, 'session_id': '2b7f56184c93c564e5463bf1f1aa06e7'},
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

	// Сделать хитом
	$("a.hit").click(function() {
		var icon        = $(this);
		var line        = icon.closest("div.row");
		var id          = line.find('input[type="checkbox"][name*="check"]').val();
		var state       = line.hasClass('hit')?0:1;
		icon.addClass('loading_icon');
		$.ajax({
			type: 'POST',
			url: 'ajax/update_object.php',
			data: {'object': 'product', 'id': id, 'values': {'hit': state}, 'session_id': '2b7f56184c93c564e5463bf1f1aa06e7'},
			success: function(data){
				icon.removeClass('loading_icon');
				if(state)
					line.addClass('hit');				
				else
					line.removeClass('hit');
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
	
	
	// Бесконечность на складе
	$("input[name*=stock]").focus(function() {
		if($(this).val() == '∞')
			$(this).val('');
		return false;
	});
	$("input[name*=stock]").blur(function() {
		if($(this).val() == '')
			$(this).val('∞');
	});
});

</script>
<?php } ?>