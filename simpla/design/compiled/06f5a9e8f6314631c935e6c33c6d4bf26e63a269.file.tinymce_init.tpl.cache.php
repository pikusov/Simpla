<?php /* Smarty version Smarty-3.0.7, created on 2011-10-21 20:40:43
         compiled from "simpla/design/html/tinymce_init.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7452629884ea1ae9bc8d7f3-53999298%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06f5a9e8f6314631c935e6c33c6d4bf26e63a269' => 
    array (
      0 => 'simpla/design/html/tinymce_init.tpl',
      1 => 1312802582,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7452629884ea1ae9bc8d7f3-53999298',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script language="javascript" type="text/javascript" src="design/js/tiny_mce/plugins/smimage/smplugins.js"></script>
<script language="javascript" type="text/javascript" src="design/js/tiny_mce/tiny_mce.js"></script>
<script language="javascript">

  tinyMCE.init({
	// General options
	mode : "specific_textareas",
	editor_selector : /editor/,
	theme : "advanced",
	language : "ru",
	theme_advanced_path : false,
	apply_source_formatting : false,
	plugins : "jaretypograph,smimage,smexplorer,safari,spellchecker,style,table,save,advimage,advlink,inlinepopups,media,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
	relative_urls : false,
	remove_script_host : true,
	convert_urls : true,
	verify_html: false,
    remove_linebreaks : false,
    content_css :"../design/<?php echo $_smarty_tpl->getVariable('settings')->value->theme;?>
/css/style.css",
    spellchecker_languages : "+Russian=ru,+English=en",
            
	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,paste,pastetext,pasteword,|,undo,redo,|,bold,italic,underline,strikethrough,|,sub,sup,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,backcolor,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "tablecontrols,|,link,unlink,anchor,smimage,smexplorer,charmap,nonbreaking,|,styleprops,attribs,|,jaretypograph,removeformat,cleanup,spellchecker,|,visualaid,fullscreen,code",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	file_browser_callback : "SMPlugins",
	plugin_smexplorer_directory : "<?php echo $_smarty_tpl->getVariable('config')->value->subfolder;?>
files/uploads",
	plugin_smimage_directory : "<?php echo $_smarty_tpl->getVariable('config')->value->subfolder;?>
files/uploads",
	
	setup : function(ed) {
		if(typeof set_meta == 'function')
		{
			ed.onKeyUp.add(set_meta);
			ed.onChange.add(set_meta);
		}
	}

	});

</script>