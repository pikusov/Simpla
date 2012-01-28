<?php /* Smarty version Smarty-3.0.7, created on 2012-01-20 13:04:42
         compiled from "/Users/denispikusov/Sites/simpla//design/default/html/post.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13429474224f194a4a6af962-69793891%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c4cac6e66efd488164d233c798b85a5aaa051a3f' => 
    array (
      0 => '/Users/denispikusov/Sites/simpla//design/default/html/post.tpl',
      1 => 1325159676,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13429474224f194a4a6af962-69793891',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
if (!is_callable('smarty_function_math')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/function.math.php';
?><!-- Заголовок /-->
<h1 data-post="<?php echo $_smarty_tpl->getVariable('post')->value->id;?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('post')->value->name);?>
</h1>
<p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->getVariable('post')->value->date);?>
</p>

<!-- Тело поста /-->
<?php echo $_smarty_tpl->getVariable('post')->value->text;?>


<!-- Соседние записи /-->
<div id="back_forward">
	<?php if ($_smarty_tpl->getVariable('prev_post')->value){?>
		←&nbsp;<a class="back" id="PrevLink" href="blog/<?php echo $_smarty_tpl->getVariable('prev_post')->value->url;?>
"><?php echo $_smarty_tpl->getVariable('prev_post')->value->name;?>
</a>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('next_post')->value){?>
		<a class="forward" id="NextLink" href="blog/<?php echo $_smarty_tpl->getVariable('next_post')->value->url;?>
"><?php echo $_smarty_tpl->getVariable('next_post')->value->name;?>
</a>&nbsp;→
	<?php }?>
</div>

<!-- Комментарии -->
<div id="comments">

	<h2>Комментарии</h2>
	
	<?php if ($_smarty_tpl->getVariable('comments')->value){?>
	<!-- Список с комментариями -->
	<ul class="comment_list">
		<?php  $_smarty_tpl->tpl_vars['comment'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('comments')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['comment']->key => $_smarty_tpl->tpl_vars['comment']->value){
?>
		<a name="comment_<?php echo $_smarty_tpl->getVariable('comment')->value->id;?>
"></a>
		<li>
			<!-- Имя и дата комментария-->
			<div class="comment_header">	
				<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('comment')->value->name);?>
 <i><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['date'][0][0]->date_modifier($_smarty_tpl->getVariable('comment')->value->date);?>
, <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['time'][0][0]->time_modifier($_smarty_tpl->getVariable('comment')->value->date);?>
</i>
				<?php if (!$_smarty_tpl->getVariable('comment')->value->approved){?>ожидает модерации</b><?php }?>
			</div>
			<!-- Имя и дата комментария (The End)-->
			
			<!-- Комментарий -->
			<?php echo nl2br(smarty_modifier_escape($_smarty_tpl->getVariable('comment')->value->text));?>

			<!-- Комментарий (The End)-->
		</li>
		<?php }} ?>
	</ul>
	<!-- Список с комментариями (The End)-->
	<?php }else{ ?>
	<p>
		Пока нет комментариев
	</p>
	<?php }?>
	
	<!--Форма отправления комментария-->

	<!--Подключаем js-проверку формы -->
	<script src="/js/baloon/js/default.js" language="JavaScript" type="text/javascript"></script>
	<script src="/js/baloon/js/validate.js" language="JavaScript" type="text/javascript"></script>
	<script src="/js/baloon/js/baloon.js" language="JavaScript" type="text/javascript"></script>
	<link href="/js/baloon/css/baloon.css" rel="stylesheet" type="text/css" /> 
	
	<form class="comment_form" method="post" action="">
		<h2>Написать комментарий</h2>
		<?php if ($_smarty_tpl->getVariable('error')->value){?>
		<div class="message_error">
			<?php if ($_smarty_tpl->getVariable('error')->value=='captcha'){?>
			Неверно введена капча
			<?php }elseif($_smarty_tpl->getVariable('error')->value=='empty_name'){?>
			Введите имя
			<?php }elseif($_smarty_tpl->getVariable('error')->value=='empty_comment'){?>
			Введите комментарий
			<?php }?>
		</div>
		<?php }?>
		<textarea class="comment_textarea" id="comment_text" name="text" format=".+" notice="Введите комментарий"><?php echo $_smarty_tpl->getVariable('comment_text')->value;?>
</textarea><br />
		<div>
		<label for="comment_name">Имя</label>
		<input class="input_name" type="text" id="comment_name" name="name" value="<?php echo $_smarty_tpl->getVariable('comment_name')->value;?>
" format=".+" notice="Введите имя"/><br />
		
		<label for="comment_captcha">Число</label>
		<div class="captcha"><img src="captcha/image.php?<?php echo smarty_function_math(array('equation'=>'rand(10,10000)'),$_smarty_tpl);?>
"/></div> 
		<input class="input_captcha" id="comment_captcha" type="text" name="captcha_code" value="" format="\d\d\d\d" notice="Введите капчу"/>
		
		<input class="button_send" type="submit" name="comment" value="Отправить" />
		</div>
	</form>
	<!--Форма отправления комментария (The End)-->
	
</div>
<!-- Комментарии (The End) -->
<script type="text/javascript" src="js/ctrlnavigate.js"></script>           
