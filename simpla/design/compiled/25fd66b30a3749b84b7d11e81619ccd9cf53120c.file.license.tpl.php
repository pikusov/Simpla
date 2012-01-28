<?php /* Smarty version Smarty-3.0.7, created on 2011-10-02 21:46:59
         compiled from "simpla/design/html/license.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11271689874e88b1a3c93cc2-01578367%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25fd66b30a3749b84b7d11e81619ccd9cf53120c' => 
    array (
      0 => 'simpla/design/html/license.tpl',
      1 => 1310915511,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11271689874e88b1a3c93cc2-01578367',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php ob_start(); ?>
		<li class="active"><a href="index.php?module=LicenseAdmin">Лицензия</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>


<?php if ($_smarty_tpl->getVariable('message_success')->value){?>
<!-- Системное сообщение -->
<div class="message message_success">
	<span><?php echo $_smarty_tpl->getVariable('message_success')->value;?>
</span>
	<a class="link" target="_blank" href="../products/<?php echo $_smarty_tpl->getVariable('page')->value->url;?>
">Открыть страницу на сайте</a>
	<?php if ($_GET['return']){?>
	<a class="button" href="<?php echo $_GET['return'];?>
">Вернуться</a>
	<?php }?>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>

<?php if ($_smarty_tpl->getVariable('message_error')->value){?>
<!-- Системное сообщение -->
<div class="message message_error">
	<span><?php echo $_smarty_tpl->getVariable('message_error')->value;?>
</span>
	<a class="link" href="../products/<?php echo $_smarty_tpl->getVariable('product')->value->url;?>
">Открыть товар на сайте</a>
	<a class="button" href="">Вернуться</a>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>


<!-- Основная форма -->
<form method=post id=product enctype="multipart/form-data">
<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
	<!-- Левая колонка свойств товара -->
	<div id="column_left">
 	
	<div class=block>
		<?php if ($_smarty_tpl->getVariable('license')->value->valid){?>	
		<h2 style='color:green;'>Лицензия действительна <?php if ($_smarty_tpl->getVariable('license')->value->expiration!='*'){?>до <?php echo $_smarty_tpl->getVariable('license')->value->expiration;?>
<?php }?> для домен<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['plural'][0][0]->plural_modifier(count($_smarty_tpl->getVariable('license')->value->domains),'а','ов');?>
 <?php  $_smarty_tpl->tpl_vars['d'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('license')->value->domains; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['d']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['d']->iteration=0;
if ($_smarty_tpl->tpl_vars['d']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['d']->key => $_smarty_tpl->tpl_vars['d']->value){
 $_smarty_tpl->tpl_vars['d']->iteration++;
 $_smarty_tpl->tpl_vars['d']->last = $_smarty_tpl->tpl_vars['d']->iteration === $_smarty_tpl->tpl_vars['d']->total;
?><?php echo $_smarty_tpl->tpl_vars['d']->value;?>
<?php if (!$_smarty_tpl->tpl_vars['d']->last){?>, <?php }?><?php }} ?></h2>
		<?php }else{ ?>
		<h2 style='color:red;'>Лицензия недействительна</h2>
		<?php }?>
		<textarea name=license style='width:420px; height:100px;'><?php echo $_smarty_tpl->getVariable('config')->value->license;?>
</textarea>
		</div>
		<div class=block>	
		<input class="button_green button_save" type="submit" name="" value="Сохранить" />
		<a href='http://simplacms.ru/check?domain=<?php echo smarty_modifier_escape($_SERVER['HTTP_HOST']);?>
'>Проверить лицензию</a>
		</div>
	</div>

	<div id="column_right">
		<div class=block>
		<h2>Лицензионное соглашение</h2>

<textarea style='width:420px; height:250px;'>Настоящее пользовательское соглашение (далее — Соглашение) является юридическим соглашением между Пользователем системы управления сайтами «Simpla» (далее — Продуктом) и Пикусовым Д. С. (далее — Автором). 

Соглашение относится ко всем распространяемым версиям или модификациям программного Продукта. 

Все положения Соглашения распространяются как на Продукт в целом, так и на его отдельные компоненты, за исключением компонентов, описанных в п.7 данного Соглашения.

Соглашение вступает в силу непосредственно в момент получения Пользователем копии Продукта посредством электронных средств передачи данных либо на физических носителях.

Соглашение дает Пользователю право использовать Продукт в рамках одного сайта (интернет-магазина), который работает в пределах одного полного доменного имени на протяжении двух недель с момента вступления в силу Соглашения.

Автор не несет ответственность за какие-либо убытки и/или ущерб (в том числе, убытки в связи недополученной коммерческой выгодой, прерыванием коммерческой и производственной деятельности, утратой данных), возникающие в связи с использованием или невозможностью использования Продукта, даже если Автор был уведомлен о возможном возникновении таких убытков и/или ущерба.

Продукт поставляется на условиях «как есть» без предоставления гарантий производительности, покупательной способности, сохранности данных, а также иных явно выраженных или предполагаемых гарантий. Автор не несёт какой-либо ответственности за причинение или возможность причинения вреда Пользователю, его информации или его бизнесу вследствие использования или невозможности использования Продукта. 

Автор не несёт ответственность, связанную с привлечением Пользователя или третьих лиц к административной или уголовной ответственности за использование Продукта в противозаконных целях (включая, но не ограничиваясь, продажей через Интернет магазин объектов, изъятых из оборота или добытых преступным путём, предназначенных для разжигания межрасовой или межнациональной вражды и т.д.).

Продукт содержит компоненты, на которые не распространяется действие настоящего Соглашения. Эти компоненты предоставляются и распространяются в соответствии с собственными лицензиями. Таковыми компонентами являются: 
— Визуальный редактор TinyMCE;
— Файловый менеджер SMExplorer;
— Менеджер изображений SMImage;
— Редактор кода Codemirror;
— Скрипт просмотра изображений EnlargeIt.

Пользователь не имеет права продавать, распространять или использовать Продукт без согласия Автора.

Пользователь имеет право модифицировать Продукт по своему усмотрению. При этом последующее использование Продукта должно осуществляться в соответствии с данным Соглашением и при условии сохранения всех авторских прав.

Автор оставляет за собой право в любое время изменять условия Соглашения без предварительного уведомления.

Получение экземпляра Продукта, его использование и/или хранение автоматически означает
а) осведомленность Пользователя о содержании Соглашения;
б) принятие его положений;
в) выполнение условий данного Соглашения.

Официальный сайт Продукта: simplacms.ru
</textarea>
		</div> 
	</div>
	<!-- Левая колонка свойств товара (The End)--> 
	
		
</form>
<!-- Основная форма (The End) -->
