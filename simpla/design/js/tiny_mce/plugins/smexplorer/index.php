<?php
error_reporting(0);
$UPLOAD_RESULT = true;

include("php/tools.php");
include("php/image.php");
include("php/config.php");
include("php/session.php");

$ROOT_FOLDER = explode(",", $SESSION["dir_root"]);

include("php/action.php");

$tmp = explode ('/', $SESSION["dir"]);
$FOLDER = $tmp[count($tmp)-2];
unset($tmp);

$FILES = array();
$FILES = GetFiles($SESSION["dir"], $SESSION["orderby"], explode(",", $SESSION["hidden_filetype"]));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SMExplorer</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta name="author" content="Jens Stolinski" />
<meta name="publisher" content="Jens Stolinski" />
<meta name="company" content="SYNASYS MEDIA" />

<?php
if ($CONFIG["no_cache"] == 1) {
	echo "<meta http-equiv=\"cache-control\" content=\"no-cache\" />\n";
	echo "<meta http-equiv=\"cache-control\" content=\"no-store\" />\n";
	echo "<meta http-equiv=\"cache-control\" content=\"max-age=0\" />\n";
	echo "<meta http-equiv=\"cache-control\" content=\"must-revalidate\" />\n";
	echo "<meta http-equiv=\"expires\" content=\"0\" />\n";
	echo "<meta http-equiv=\"pragma\" content=\"no-cache\" />\n";
}
?>

<!-- JavaScript -->
<script language="javascript" type="text/javascript" src="js/error.js"></script>
<script language="javascript" type="text/javascript" src="../../tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="js/smexplorer.js"></script>
<script language="javascript" type="text/javascript" src="js/tooltip.js"></script>
<script language="javascript" type="text/javascript" src="js/prompt/prompt.js"></script>

<script language="javascript" type="text/javascript" src="js/jsmbutton.js"></script>
<script language="javascript" type="text/javascript" src="js/jsmpreview.js"></script>
<script language="javascript" type="text/javascript" src="js/jsmtable.js"></script>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
// "jSMPreview" Objekt erzeugen
var jSMP = new jSMPreview();

// jSMPreview: Vorschaubildgröße setzen
jSMP.SetThumbnailSize('<?php echo $CONFIG["preview_thumbnail_size"]; ?>');
/* ]]> */
</script>

<!-- CSS -->
<link rel="stylesheet" href="css/jsmpreview.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/jsmbutton.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/jsmtable.css" type="text/css" media="screen" />

<link rel="stylesheet" href="css/alert.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/panel.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/splitter.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/statusbar.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/toolbar.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/tooltip.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/treemenu.css" type="text/css" media="screen" />

<link rel="stylesheet" href="css/smexplorer.css" type="text/css" media="screen" />

</head>
<body scroll="no">

<div class="toolbar">
	<ul>
		<?php
		if ($SESSION["show_upload"] == 1) {
			echo "<li><a id=\"m1\" href=\"javascript:;\" title=\"\" onclick=\"SMExplorer_Upload_Show(); if (window.event) { window.event.returnValue = false; }\"><img src=\"img/icon_upload_24x24.png\" border=\"0\" /></a></li>";
			echo "<li><img class=\"separator\" src=\"img/icon_separator.png\" border=\"0\" /></li>";
		}
		
		if ($SESSION["show_folder_menu"] == 1) {
			echo "<li><a id=\"m2\" href=\"javascript:;\" title=\"\" onclick=\"SMExplorer_NewFolder('".bin2hex(RC4("id=1&".$GET))."'); if (window.event) { window.event.returnValue = false; }\"><img src=\"img/icon_new_folder_24x24.png\" border=\"0\" /></a></li>";
			echo "<li><a id=\"m3\" href=\"javascript:;\" title=\"\" onclick=\"SMExplorer_RenameFolder('".bin2hex(RC4("id=1&".$GET))."', '".$FOLDER."'); if (window.event) { window.event.returnValue = false; }\"><img src=\"img/icon_rename_folder_24x24.png\" border=\"0\" /></a></li>";
			echo "<li><a id=\"m4\" href=\"javascript:;\" title=\"\" onclick=\"SMExplorer_DeleteFolder('".bin2hex(RC4("id=1&".$GET))."', '".$FOLDER."'); if (window.event) { window.event.returnValue = false; }\"><img src=\"img/icon_delete_folder_24x24.png\" border=\"0\" /></a></li>";
			echo "<li><img class=\"separator\" src=\"img/icon_separator.png\" border=\"0\" /></li>";
		}
		?>
		<li><a id="m5" style="display:none;" href="javascript:;" title="" onclick="SMExplorer_DeleteFiles('<?php echo bin2hex(RC4("id=1&".$GET)); ?>', '<?php echo count($FILES); ?>'); if (window.event) { window.event.returnValue = false; }"><img src="img/icon_delete_file_24x24.png" border="0" /></a></li>
		<li><a id="m6" style="display:none;" href="javascript:;" title="" onclick="SMExplorer_View_Close(); if (window.event) { window.event.returnValue = false; }"><img src="img/icon_view_24x24.png" border="0" /></a></li>
		<li><a id="m7" href="javascript:;" title="" onclick="SMExplorer_PageReload('<?php echo bin2hex(RC4("id=1&".$GET)); ?>'); if (window.event){ window.event.returnValue = false; }"><img src="img/icon_reload_24x24.png" border="0" /></a></li>
	</ul>
</div>

<div id="main_left">
	<div id="panel1" class="panel">
		<div class="text"><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smexplorer.panel_folder_caption', '?'));</script></div>
	</div>

	<?php include("php/folder.php"); ?>
</div>

<div id="splitter_vertical" class="splitter_vertical"></div>

<div id="main_right">
	<div id="upload"><?php include("php/upload_form.php"); ?></div>
	<div id="view" onclick="SMExplorer_View_Close();">
		<iframe src="" id="view_iframe" name="view_iframe" width="100%" height="100%" align="left" scrolling="auto" marginheight="0" marginwidth="0" frameborder="0"></iframe>
	</div>

	<form name="form_files" action="" method="post" onsubmit="return false;">
		<script language="javascript" type="text/javascript">
		/* <![CDATA[ */
		var jSMT = new jSMTable();
		
		<?php
		$orderby = array(array());
		
		// Sortieren nach: Dateiname
		if ($SESSION["orderby"] == 1) { $orderby[0]["status"] = 2; } else { $orderby[0]["status"] = 1; }
		if ($SESSION["orderby"] == 1) { $orderby[0]["icon"] = "icon_up_9x11.png"; } else if ($SESSION["orderby"] == 2) { $orderby[0]["icon"] = "icon_down_9x11.png"; } else { $orderby[0]["icon"] = "icon_none_9x11.png"; }

		// Sortieren nach: Dateigröße
		if ($SESSION["orderby"] == 3) { $orderby[1]["status"] = 4; } else { $orderby[1]["status"] = 3; }
		if ($SESSION["orderby"] == 3) { $orderby[1]["icon"] = "icon_up_9x11.png"; } else if ($SESSION["orderby"] == 4) { $orderby[1]["icon"] = "icon_down_9x11.png"; } else { $orderby[1]["icon"] = "icon_none_9x11.png"; }

		// Sortieren nach: Datum
		if ($SESSION["orderby"] == 5) { $orderby[2]["status"] = 6; } else { $orderby[2]["status"] = 5; }
		if ($SESSION["orderby"] == 5) { $orderby[2]["icon"] = "icon_up_9x11.png"; } else if ($SESSION["orderby"] == 6  || $SESSION["orderby"] == 0) { $orderby[2]["icon"] = "icon_down_9x11.png"; } else { $orderby[2]["icon"] = "icon_none_9x11.png"; }

		if ($SESSION["show_file_menu"] == 1) {
			echo "jSMT.SetHeader(Array('<input id=\"th_checkbox\" name=\"th_checkbox\" class=\"checkbox\" type=\"checkbox\" value=\"0\" onclick=\"SMExplorer_CheckAll(".count($FILES).");\" />', tinyMCEPopup.getLang('smexplorer.table_column_caption_1', '?') + '<span style=\"margin-left:4px;\"><img src=\"img/jsmtable/".$orderby[0]["icon"]."\"></span>', tinyMCEPopup.getLang('smexplorer.table_column_caption_2', '?') + '<span style=\"margin-left:4px;\"><img src=\"img/jsmtable/".$orderby[1]["icon"]."\"></span>', tinyMCEPopup.getLang('smexplorer.table_column_caption_3', '?') + '<span style=\"margin-left:4px;\"><img src=\"img/jsmtable/".$orderby[2]["icon"]."\"></span>'), Array('width:18px; text-align:center;', 'text-indent:2px;', 'width:100px; text-align:center;', 'width:120px; text-align:center;'));";
		}
		else {
			echo "jSMT.SetHeader(Array(tinyMCEPopup.getLang('smexplorer.table_column_caption_1', '?'), tinyMCEPopup.getLang('smexplorer.table_column_caption_2', '?'), tinyMCEPopup.getLang('smexplorer.table_column_caption_3', '?')), Array('text-indent:2px;', 'width:100px; text-align:center;', 'width:120px; text-align:center;'));";
		}
		?>
		
		// Tabellenkopf: Titel setzen
		var title = Array('', '', '', '');
		if ((<?php echo $orderby[0]["status"]; ?> % 2) == 0) { title[0] = tinyMCEPopup.getLang('smexplorer.table_sort_hint_2', '?'); }
		else { title[0] = tinyMCEPopup.getLang('smexplorer.table_sort_hint_1', '?'); }
		if ((<?php echo $orderby[1]["status"]; ?> % 2) == 0) { title[1] = tinyMCEPopup.getLang('smexplorer.table_sort_hint_2', '?'); }
		else { title[1] = tinyMCEPopup.getLang('smexplorer.table_sort_hint_1', '?'); }
		if ((<?php echo $orderby[2]["status"]; ?> % 2) == 0) { title[2] = tinyMCEPopup.getLang('smexplorer.table_sort_hint_2', '?'); }
		else { title[2] = tinyMCEPopup.getLang('smexplorer.table_sort_hint_1', '?'); }
		jSMT.SetHeaderTitle(Array('', title[0], title[1], title[2]));

		// Tabellenkopf: OnClick-Ereignis setzen
		jSMT.SetHeaderOnClick(Array('', 'SMExplorer_Orderby(\'<?php echo bin2hex(RC4("id=1&orderby=".$orderby[0]["status"]."&".$GET3)); ?>\');', 'SMExplorer_Orderby(\'<?php echo bin2hex(RC4("id=1&orderby=".$orderby[1]["status"]."&".$GET3)); ?>\');', 'SMExplorer_Orderby(\'<?php echo bin2hex(RC4("id=1&orderby=".$orderby[2]["status"]."&".$GET3)); ?>\');'));
		
		// Tabellenzeile(n) hinzufügen
		<?php
		for ($i = 0; $i < count($FILES); $i++) {
			$icon = "";

			// Datei-Icon
			if (IsFileExt($FILES[$i], "jpg") || IsFileExt($FILES[$i], "jpeg") || IsFileExt($FILES[$i], "gif") || IsFileExt($FILES[$i], "png") || IsFileExt($FILES[$i], "bmp") || IsFileExt($FILES[$i], "tif") || IsFileExt($FILES[$i], "ico")) {

				if ($CONFIG["show_preview"] == 1) {
					$a = array();
					$a = GetNewImageSize($SESSION["dir"].$FILES[$i], 200);

					// Bilddatei mit Thumbnail-Anzeige
					$icon = "<div id=\"th".$i."\" class=\"jsmpreview\"></div><img style=\"cursor:pointer;\" src=\"img/icon_image_16x16.png\" border=\"0\" onmouseover=\"jSMP.Show(\'th".$i."\', \'".$SESSION["dir"].$FILES[$i]."\', \'".$a["width"]."\', \'".$a["height"]."\');\" onmouseout=\"jSMP.Close(\'th".$i."\');\" onclick=\"SMExplorer_Insert(\'".$SESSION["server"]."\', \'".$SESSION["dir"].$FILES[$i]."\', \'".$SESSION["link_target"]."\');\" />";

					unset($a);
				}
				else {
					// Bilddatei ohne Thumbnail-Anzeige
					$icon = "<img style=\"cursor:pointer;\" src=\"img/icon_image_16x16.png\" border=\"0\" onclick=\"SMExplorer_Insert(\'".$SESSION["server"]."\', \'".$SESSION["dir"].$FILES[$i]."\', \'".$SESSION["link_target"]."\');\" />";
				}
			}
			else {
				// Keine Bilddatei
				$icon = "<img style=\"cursor:pointer;\" src=\"img/icon_file_16x16.png\" border=\"0\" onclick=\"SMExplorer_Insert(\'".$SESSION["server"]."\', \'".$SESSION["dir"].$FILES[$i]."\', \'".$SESSION["link_target"]."\');\" />";
			}

			if ($SESSION["show_file_menu"] == 1) {
				echo "jSMT.AddData(Array('<input id=\"td_checkbox".$i."\" name=\"td_checkbox".$i."\" class=\"checkbox\" type=\"checkbox\" value=\"0\" onclick=\"SMExplorer_Check(".count($FILES).");\" />', '".$icon."', '<input id=\"fn_input".$i."\" name=\"fn_input".$i."\" class=\"edit\" style=\"width:98%;\" type=\"text\" value=\"".$FILES[$i]."\" title=\"".$FILES[$i]."\" onclick=\"SMExplorer_InputClick(this, ".$CONFIG["rename_file_ext"].");\" onblur=\"SMExplorer_InputBlur(this, \'".$FILES[$i]."\');\" onkeypress=\"SMExplorer_InputEnter(event, this, \'".$FILES[$i]."\', \'".bin2hex(RC4("id=1&".$GET))."\');\">', '<img id=\"i1".$i."\" style=\"cursor:pointer;\" src=\"img/icon_insert_16x16.png\" border=\"0\" title=\"\" onclick=\"SMExplorer_Insert(\'".$SESSION["server"]."\', \'".$SESSION["dir"].$FILES[$i]."\', \'".$SESSION["link_target"]."\');\" />', '<img id=\"i3".$i."\" style=\"cursor:pointer;\" src=\"img/icon_show_16x16.png\" border=\"0\" title=\"\" onclick=\"SMExplorer_View_Show(\'".$SESSION["dir"].$FILES[$i]."\');\" />', '<img id=\"i2".$i."\" style=\"cursor:pointer;\" src=\"img/icon_delete_16x16.png\" border=\"0\" title=\"\" onclick=\"SMExplorer_DeleteFile(\'".bin2hex(RC4("id=1&".$GET))."\', \'".$FILES[$i]."\');\" />', '".number_format(@filesize(GetDocumentRoot().$SESSION["dir"].$FILES[$i])/1024 ,2 , ",", ".")."&nbsp;KB', '".date(GetDateFormat().' H:i', @filemtime(GetDocumentRoot().$SESSION["dir"].$FILES[$i]))."'), Array('width:18px; text-align:center;', 'width:18px; text-align:center;', '', 'width:16px; text-align:center;', 'width:16px; text-align:center;', 'width:16px; text-align:center;', 'width:102px; text-align:right;', 'width:122px; text-align:center;'));";
			}
			else {
				echo "jSMT.AddData(Array('".$icon."', '<input id=\"fn_input".$i."\" name=\"fn_input".$i."\" class=\"edit\" style=\"width:98%;\" type=\"text\" value=\"".$FILES[$i]."\" title=\"".$FILES[$i]."\" readonly=\"1\">', '".number_format(@filesize(GetDocumentRoot().$SESSION["dir"].$FILES[$i])/1024 ,2 , ",", ".")."&nbsp;KB', '".date(GetDateFormat().' H:i', @filemtime(GetDocumentRoot().$SESSION["dir"].$FILES[$i]))."'), Array('width:18px; text-align:center;', '', 'width:16px; text-align:center;', 'width:102px; text-align:right;', 'width:122px; text-align:center;'));";
			}
		}
		?>

		// Tabelle zeichnen
		jSMT.Paint();

		<?php
		// Hinweis hinzufügen
		for ($i = 0; $i < count($FILES); $i++) {
			echo "document.getElementById('i1".$i."').title = tinyMCEPopup.getLang('smexplorer.file_menu_hint_1', '?'); document.getElementById('i2".$i."').title = tinyMCEPopup.getLang('smexplorer.file_menu_hint_2', '?'); document.getElementById('i3".$i."').title = tinyMCEPopup.getLang('smexplorer.file_menu_hint_3', '?');";
		}
		?>
		/* ]]> */
		</script>
	</form>
</div>

<div id="statusbar" class="statusbar">
	<div style="float:left; margin:2px;"><img src="img/icon_folder_20x20.png" border="0" /></div>
	<div id="statusbar_item1" style="float:left; padding-left:2px;"><?php GetCurrentPath($ROOT_FOLDER[$SESSION["treemenu"]], $SESSION["dir"]); ?></div><div id="statusbar_item2" style="float:right; padding-right:3px;"><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smexplorer.statusbar_item2_1', '?'));</script>:&nbsp;<?php echo count($FILES); ?></div>
</div>

<?php
// Speicher freigeben
unset($FILES);
?>

<?php
// Message-Box: Upload nicht erfolgreich
if (!$UPLOAD_RESULT) {
	echo "<div id=\"msg\" class=\"alert alert_error\"><script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smexplorer.message_upload_2', '?'));</script>";
	echo "<div class=\"button\" style=\"margin-top:10px; margin-left:190px;\" onmouseout=\"this.style.backgroundImage='url(img/button_bg.png)';\" onmouseover=\"this.style.backgroundImage='url(img/button_active_bg.png)';\" onclick=\"document.getElementById('msg').style.display = 'none';\"><b>OK</b></div>";
	echo "</div>";
}
?>

<div id="wait" style="display:none; position:absolute; top:0px; left:0px; background-color:#616a74; filter:alpha(opacity=50); -moz-opacity:0.5; opacity:0.5;">
	<div id="wait_animation" style="position:absolute;"><img src="img/wait.gif" border="0" alt=""></div>
</div>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */
// Event-Handler: OnFocus
window.onfocus = function() {
	SMExplorer_SetFolderTreeWidth(<?php echo $CONFIG["folder_tree_width"]; ?>);
	SMExplorer_WindowResize();
};

// Event-Handler: OnResize
window.onresize = function() {
	SMExplorer_SetFolderTreeWidth(<?php echo $CONFIG["folder_tree_width"]; ?>);
	SMExplorer_WindowResize();
};

// Event-Handler: OnLoad
window.onload = function() {
	SMExplorer_SetFolderTreeWidth(<?php echo $CONFIG["folder_tree_width"]; ?>);
	SMExplorer_WindowResize();
};

// Menü
var s1 = '<?php echo $ROOT_FOLDER[$SESSION["treemenu"]]; ?>';
var s2 = '<?php echo $SESSION["dir"]; ?>';
if(s1 == s2) {
	if (document.getElementById('m3') != null) { document.getElementById('m3').style.display = 'none'; }
	if (document.getElementById('m4') != null) { document.getElementById('m4').style.display = 'none'; }
}

// Menü: Hinweis hinzufügen
SMExplorer_MenuIni();
/* ]]> */
</script>

</body>
</html>