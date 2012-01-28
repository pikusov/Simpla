<?php /* Smarty version Smarty-3.0.7, created on 2011-12-23 02:38:41
         compiled from "simpla/design/html/pagination.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9980051234ef3cd919c4993-76383279%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8525564c8d119ad869e403b6d8062e04fc797163' => 
    array (
      0 => 'simpla/design/html/pagination.tpl',
      1 => 1324600719,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9980051234ef3cd919c4993-76383279',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('pages_count')->value>1){?>
<script type="text/javascript" src="design/js/ctrlnavigate.js"></script>           

<!-- Листалка страниц -->
<div id="pagination">
	
	<?php $_smarty_tpl->tpl_vars['visible_pages'] = new Smarty_variable(13, null, null);?>
	<?php $_smarty_tpl->tpl_vars['page_from'] = new Smarty_variable(1, null, null);?>
	
	<?php if ($_smarty_tpl->getVariable('current_page')->value>floor($_smarty_tpl->getVariable('visible_pages')->value/2)){?>
		<?php $_smarty_tpl->tpl_vars['page_from'] = new Smarty_variable(max(1,$_smarty_tpl->getVariable('current_page')->value-floor($_smarty_tpl->getVariable('visible_pages')->value/2)-1), null, null);?>
	<?php }?>	
	
	<?php if ($_smarty_tpl->getVariable('current_page')->value>$_smarty_tpl->getVariable('pages_count')->value-ceil($_smarty_tpl->getVariable('visible_pages')->value/2)){?>
		<?php $_smarty_tpl->tpl_vars['page_from'] = new Smarty_variable(max(1,$_smarty_tpl->getVariable('pages_count')->value-$_smarty_tpl->getVariable('visible_pages')->value-1), null, null);?>
	<?php }?>
	
	<?php $_smarty_tpl->tpl_vars['page_to'] = new Smarty_variable(min($_smarty_tpl->getVariable('page_from')->value+$_smarty_tpl->getVariable('visible_pages')->value,$_smarty_tpl->getVariable('pages_count')->value-1), null, null);?>
	<a class="<?php if ($_smarty_tpl->getVariable('current_page')->value==1){?>selected<?php }else{ ?>droppable<?php }?>" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>1),$_smarty_tpl);?>
">1</a>
		
	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['name'] = 'pages';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('page_to')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] = (int)$_smarty_tpl->getVariable('page_from')->value;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total']);
?>	
		<?php $_smarty_tpl->tpl_vars['p'] = new Smarty_variable($_smarty_tpl->getVariable('smarty')->value['section']['pages']['index']+1, null, null);?>	
		<?php if (($_smarty_tpl->getVariable('p')->value==$_smarty_tpl->getVariable('page_from')->value+1&&$_smarty_tpl->getVariable('p')->value!=2)||($_smarty_tpl->getVariable('p')->value==$_smarty_tpl->getVariable('page_to')->value&&$_smarty_tpl->getVariable('p')->value!=$_smarty_tpl->getVariable('pages_count')->value-1)){?>	
		<a class="<?php if ($_smarty_tpl->getVariable('p')->value==$_smarty_tpl->getVariable('current_page')->value){?>selected<?php }?>" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->getVariable('p')->value),$_smarty_tpl);?>
">...</a>
		<?php }else{ ?>
		<a class="<?php if ($_smarty_tpl->getVariable('p')->value==$_smarty_tpl->getVariable('current_page')->value){?>selected<?php }else{ ?>droppable<?php }?>" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->getVariable('p')->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->getVariable('p')->value;?>
</a>
		<?php }?>
	<?php endfor; endif; ?>
	<a class="<?php if ($_smarty_tpl->getVariable('current_page')->value==$_smarty_tpl->getVariable('pages_count')->value){?>selected<?php }else{ ?>droppable<?php }?>"  href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->getVariable('pages_count')->value),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->getVariable('pages_count')->value;?>
</a>
	
	<?php if ($_smarty_tpl->getVariable('current_page')->value>1){?><a id="PrevLink" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->getVariable('current_page')->value-1),$_smarty_tpl);?>
">←назад</a><?php }?>
	<?php if ($_smarty_tpl->getVariable('current_page')->value<$_smarty_tpl->getVariable('pages_count')->value){?><a id="NextLink" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('page'=>$_smarty_tpl->getVariable('current_page')->value+1),$_smarty_tpl);?>
">вперед→</a><?php }?>
	
</div>
<!-- Листалка страниц (The End) -->
<?php }?>
