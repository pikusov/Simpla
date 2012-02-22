<?php
error_reporting(0);
include("php/tools.php");
include("php/config.php");
include("php/session.php");
include("php/image.php");

// Verzeichnispfad
$IMAGE_PATH = GetDocumentRoot().$SESSION["dir"];
$IMAGE_PATH_2 = $SESSION["dir"];

include("php/action.php");

// Verzeichnis lesen
if ($SESSION["id"] == 1) {
	$FOLDERS = GetFolders($IMAGE_PATH);
	$FILES = GetFiles($IMAGE_PATH, $SESSION["orderby"]);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>SMImage</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta name="author" content="Jens Stolinski" />
<meta name="publisher" content="Jens Stolinski" />
<meta name="company" content="SYNASYS MEDIA" />

<?php
// Webbrowser-Cache löschen
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
<!-- <script language="javascript" type="text/javascript" src="js/error.js"></script> -->
<script language="javascript" type="text/javascript" src="../../tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="js/smimage.js"></script>
<script language="javascript" type="text/javascript" src="js/prompt/prompt.js"></script>
<?php
if ($SESSION["id"] == 1 && $SESSION["show_thumbnail"] == 1) {
	echo "<script language=\"javascript\" type=\"text/javascript\" src=\"js/tooltip.js\"></script>\n";
}
if ($SESSION["id"] == 1 && $SESSION["show_thumbnail"] == 0) {
	echo "<script language=\"javascript\" type=\"text/javascript\" src=\"js/smpreview.js\"></script>\n";
	echo "<script language=\"javascript\" type=\"text/javascript\" src=\"js/smtable.js\"></script>\n";

	echo "<script language=\"javascript\" type=\"text/javascript\">\n";
	echo "/* <![CDATA[ */\n";
	echo "var SMP = new SMPreview();\n";
	echo "SMP.SetThumbnailSize('".$CONFIG["preview_thumbnail_size"]."');\n";
	echo "/* ]]> */\n";
	echo "</script>\n";
}
?>
<script language="javascript" type="text/javascript" src="js/jsmbutton.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="css/jsmbutton.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/smimage.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/menu.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/toolbar.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/statusbar.css" type="text/css" media="screen" />
<?php
if ($SESSION["id"] == 1 && $SESSION["show_thumbnail"] == 1) {
	echo "<link rel=\"stylesheet\" href=\"css/tooltip.css\" type=\"text/css\" media=\"screen\" />\n";
}
if ($SESSION["id"] == 1 && $SESSION["show_thumbnail"] == 0) {
	echo "<link rel=\"stylesheet\" href=\"css/table.css\" type=\"text/css\" media=\"screen\" />\n";
	echo "<link rel=\"stylesheet\" href=\"css/smpreview.css\" type=\"text/css\" media=\"screen\" />\n";
}
?>
<link rel="stylesheet" href="css/alert.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/window.css" type="text/css" media="screen" />

<?php if ($SESSION["id"] == 1 && $SESSION["show_thumbnail"] == 1) { include("php/style.php"); } ?>

</head>
<body scroll="no">

<div class="toolbar">
	<?php
		switch($SESSION["id"]) {

			// Thumbnails- oder Tabelle-Menü anzeigen
			case 1:
				switch($SESSION["show_thumbnail"]) {
					case 1:
						include("php/menu_thumbnail.php");
						break;
					case 0:
						include("php/menu_table.php");
						break;
				}
				break;

			// Upload-Menü anzeigen
			case 2:
				include("php/menu_upload.php");
				break;
		}
	?>
</div>

<?php
switch ($SESSION["id"]) {
	case 1:

		// Thumbnails anzeigen
		if ($SESSION["show_thumbnail"] == 1) {
			echo "<div id=\"main\">";

			// Zurück-Button anzeigen
			if ($SESSION["back"] == 1) {
				echo "<div class=\"folder\" onmouseout=\"this.style.backgroundColor='#ffcc66'\" onmouseover=\"this.style.backgroundColor='#ff9900'\"><div class=\"image\" onclick=\"SMImage_BackFolder('".bin2hex(RC4("id=1&".$GET))."');\"><img style=\"margin-top:".($SESSION["thumbnail_size"] / 2 - 16)."px;\" src=\"img/icon_folder_back_32x32.gif\" border=\"0\" /></div><div class=\"textbox\">&nbsp;</div></div>";
			}

			$IMENU_ID = 0;

			// Ordner anzeigen
			for ($j = 0; $j < count($FOLDERS); $j++) {
				echo "<div class=\"folder\" onmouseout=\"this.style.backgroundColor='#ffcc66'\" onmouseover=\"this.style.backgroundColor='#ff9900'\"><div class=\"image\" onclick=\"SMImage_OpenFolder('".bin2hex(RC4("id=1&dir=".$IMAGE_PATH_2.$FOLDERS[$j]."/&page=0&back=1&".$GET2))."');\"><img style=\"margin-top:".($SESSION["thumbnail_size"] / 2 - 16)."px;\" src=\"img/icon_folder_32x32.gif\" border=\"0\" /></div><div class=\"textbox\" title=\"".$FOLDERS[$j]."\" onmouseover=\"SMImage_ShowImageMenu('imenu".$IMENU_ID."', 'block');\" onmouseout=\"SMImage_ShowImageMenu('imenu".$IMENU_ID."', 'none');\">".$FOLDERS[$j]."</div>";
				if ($SESSION["show_folder_menu"] == 1) { include("php/folder_menu.php"); }
				echo "</div>";

				$IMENU_ID++;
			}

			$k = 1;

			// Thumbnails anzeigen
			for ($j = $SESSION["page"] * $SESSION["thumbnails_perpage"]; $j < count($FILES); $j++) {

				$image_width = Image_GetWidth($IMAGE_PATH.$FILES[$j]);
				$image_height = Image_GetHeight($IMAGE_PATH.$FILES[$j]);
				$image_title = $image_width."&nbsp;x&nbsp;".$image_height."<br />".number_format(@filesize($IMAGE_PATH.$FILES[$j])/1024 ,2 , ",", ".")."&nbsp;KB<br />".date(GetDateFormat(), @filemtime($IMAGE_PATH.$FILES[$j]))."&nbsp;".date("H:i:s", @filemtime($IMAGE_PATH.$FILES[$j]));

				// Thumbnail anzeigen
				if (!is_dir($IMAGE_PATH.$FILES[$j])) {
					$a = array();
					$a = GetNewImageSize($IMAGE_PATH_2.$FILES[$j], $SESSION["thumbnail_size"]);

					echo "<div id=\"thumbnail".$j."\" class=\"thumbnail\" onmouseout=\"this.style.backgroundColor='#a8adb4'\" onmouseover=\"this.style.backgroundColor='#1c3b51'\"><span class=\"tip\" onmouseover=\"tooltip('".$image_title."');\" onmouseout=\"exit();\"><div class=\"image\" onclick=\"SMImage_Insert('".$SESSION["server"]."', '".$IMAGE_PATH_2.$FILES[$j]."', '".$image_width."', '".$image_height."', '".$CONFIG["style"]."');\"><img id=\"th".$j."\" style=\"margin-top:".round(($SESSION["thumbnail_size"] / 2) - ($a["height"] / 2))."px;\" src=\"img/wait_2.gif\" border=\"0\" /></div></span><div class=\"textbox\" title=\"".$FILES[$j]."\" onmouseover=\"SMImage_ShowImageMenu('imenu".$IMENU_ID."', 'block');\" onmouseout=\"SMImage_ShowImageMenu('imenu".$IMENU_ID."', 'none');\">".str_replace (' ', '&nbsp;', $FILES[$j])."</div>";
					if ($SESSION["show_image_menu"] == 1) { include("php/image_menu.php"); }
					echo "</div>";

					unset($a);

					if (($k % $SESSION["thumbnails_perpage"]) == 0) { break; }
					$k++;
				}

				$IMENU_ID++;
			}

			echo "</div>";
		}

		// Tabelle anzeigen
		if ($SESSION["show_thumbnail"] == 0) {

			// Header-Tabelle
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\"><tr>";
			
			// Header: Dateiname
			if ($SESSION["orderby"] == 1) { $orderby = 2; } else { $orderby = 1; }
			if ($SESSION["orderby"] == 1) { $orderby_icon = "icon_up_9x11.png"; } else if ($SESSION["orderby"] == 2) { $orderby_icon = "icon_down_9x11.png"; } else { $orderby_icon = "icon_none_9x11.png"; }
			echo "<th id=\"smtable_h1\" style=\"text-indent:2px;\" colspan=\"4\" onmouseout=\"SMTable_Header_MouseOut(this);\" onmouseover=\"SMTable_Header_MouseOver(this);\" onmousedown=\"SMTable_Header_MouseDown(this);\" onclick=\"SMTable_Header_Click('".bin2hex(RC4("id=1&orderby=".$orderby."&".$GET3))."');\" title=\"".$orderby."\"><script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.table_column_caption_1', '?'));</script><span style=\"margin-left:4px;\"><img src=\"img/".$orderby_icon."\"></span></th>";

			// Header: Dateigröße
			if ($SESSION["orderby"] == 3) { $orderby = 4; } else { $orderby = 3; }
			if ($SESSION["orderby"] == 3) { $orderby_icon = "icon_up_9x11.png"; } else if ($SESSION["orderby"] == 4) { $orderby_icon = "icon_down_9x11.png"; } else { $orderby_icon = "icon_none_9x11.png"; }
			echo "<th id=\"smtable_h2\" style=\"width:100px; text-align:center;\" onmouseout=\"SMTable_Header_MouseOut(this);\" onmouseover=\"SMTable_Header_MouseOver(this);\" onmousedown=\"SMTable_Header_MouseDown(this);\" onclick=\"SMTable_Header_Click('".bin2hex(RC4("id=1&orderby=".$orderby."&".$GET3))."');\" title=\"".$orderby."\"><script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.table_column_caption_2', '?'));</script><span style=\"margin-left:4px;\"><img src=\"img/".$orderby_icon."\"></span></th>";

			// Header: Bildgröße
			if ($SESSION["orderby"] == 5) { $orderby = 6; } else { $orderby = 5; }
			if ($SESSION["orderby"] == 5) { $orderby_icon = "icon_up_9x11.png"; } else if ($SESSION["orderby"] == 6) { $orderby_icon = "icon_down_9x11.png"; } else { $orderby_icon = "icon_none_9x11.png"; }
			echo "<th id=\"smtable_h3\" style=\"width:100px; text-align:center;\" onmouseout=\"SMTable_Header_MouseOut(this);\" onmouseover=\"SMTable_Header_MouseOver(this);\" onmousedown=\"SMTable_Header_MouseDown(this);\" onclick=\"SMTable_Header_Click('".bin2hex(RC4("id=1&orderby=".$orderby."&".$GET3))."');\" title=\"".$orderby."\"><script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.table_column_caption_3', '?'));</script><span style=\"margin-left:4px;\"><img src=\"img/".$orderby_icon."\"></span></th>";
			
			// Header: Datum
			if ($SESSION["orderby"] == 7) { $orderby = 8; } else { $orderby = 7; }
			if ($SESSION["orderby"] == 7) { $orderby_icon = "icon_up_9x11.png"; } else if ($SESSION["orderby"] == 8  || $SESSION["orderby"] == 0) { $orderby_icon = "icon_down_9x11.png"; } else { $orderby_icon = "icon_none_9x11.png"; }
			echo "<th id=\"smtable_h4\" style=\"width:120px; text-align:center;\" onmouseout=\"SMTable_Header_MouseOut(this);\" onmouseover=\"SMTable_Header_MouseOver(this);\" onmousedown=\"SMTable_Header_MouseDown(this);\" onclick=\"SMTable_Header_Click('".bin2hex(RC4("id=1&orderby=".$orderby."&".$GET3))."');\" title=\"".$orderby."\"><script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.table_column_caption_4', '?'));</script><span style=\"margin-left:4px;\"><img src=\"img/".$orderby_icon."\"></span></th>";
			
			// Header: ScrollBar
			echo "<th id=\"smtable_h5\" style=\"width:10px;\">&nbsp;</th>";
			echo "</tr></table>";

			// Daten-Tabelle
			$i = 0;
			echo "<div id=\"div_table\" style=\"overflow:scroll; overflow-x:hidden; width:100%;\">";
			echo "<table id=\"table\" style=\"width:100%;\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

			// Zurück-Button anzeigen
			if ($SESSION["back"] == 1) {
				if ($i%2) {
					echo "<tr style=\"background-color:#f6f9fb;\" onmouseover=\"this.style.backgroundImage='url(img/table_tr_active_bg.gif)';\" onmouseout=\"this.style.backgroundImage='none';\">";
				}
				else {
					echo "<tr onmouseover=\"this.style.backgroundImage='url(img/table_tr_active_bg.gif)';\" onmouseout=\"this.style.backgroundImage='none';\">";
				}

				echo "<td style=\"width:18px; text-align:center; cursor:pointer;\" onclick=\"SMImage_BackFolder('".bin2hex(RC4("id=1&".$GET))."');\"><img src=\"img/icon_folder_back_16x16.png\" border=\"0\" /></td>";
				echo "<td colspan=\"6\">&nbsp;</td>";
				echo "</tr>";

				$i++;
			}

			// Verzeichnis anzeigen
			for ($j = 0; $j < count($FOLDERS); $j++) {
				if ($i%2) {
					echo "<tr style=\"background-color:#f6f9fb;\" onmouseover=\"this.style.backgroundImage='url(img/table_tr_active_bg.gif)';\" onmouseout=\"this.style.backgroundImage='none';\">";
				}
				else {
					echo "<tr onmouseover=\"this.style.backgroundImage='url(img/table_tr_active_bg.gif)';\" onmouseout=\"this.style.backgroundImage='none';\">";
				}

				// Icon "Verzeichnis" 
				echo "<td style=\"width:18px; text-align:center; cursor:pointer;\" onclick=\"SMImage_OpenFolder('".bin2hex(RC4("id=1&dir=".$IMAGE_PATH_2.$FOLDERS[$j]."/&page=0&back=1&".$GET2))."');\"><img src=\"img/icon_folder_16x16.png\" border=\"0\" /></td>";

				// Verzeichnisname
				if ($SESSION["show_folder_menu"] == 1) {
					echo "<td><input class=\"edit\" style=\"width:98%; font-weight:bold;\" type=\"text\" value=\"".$FOLDERS[$j]."\" title=\"".$FOLDERS[$j]."\" onclick=\"SMImage_InputFolderClick(this);\" onblur=\"SMImage_InputFolderBlur(this, '".$FOLDERS[$j]."');\" onkeypress=\"SMImage_InputFolderEnter(event, this, '".$FOLDERS[$j]."', '".bin2hex(RC4("id=1&".$GET))."')\"></td>";
				}
				else {
					echo "<td><input class=\"edit\" style=\"width:98%; font-weight:bold;\" type=\"text\" value=\"".$FOLDERS[$j]."\" title=\"".$FOLDERS[$j]."\" readonly=\"1\"></td>";
				}

				// Icon "Verzeichnis löschen"
				if ($SESSION["show_folder_menu"] == 1) {
					echo "<td style=\"width:16px;\">&nbsp;</td>";
					echo "<td style=\"width:16px; text-align:center;\"><img id=\"i2".$i."\" style=\"cursor:pointer;\" src=\"img/icon_delete_16x16.png\" border=\"0\" title=\"\" onclick=\"SMImage_DeleteFolder('".bin2hex(RC4("id=1&".$GET))."', '".$FOLDERS[$j]."');\" /></td>";
					echo "<td style=\"width:102px;\">&nbsp;</td>";
					echo "<td style=\"width:102px;\">&nbsp;</td>";
					echo "<td style=\"width:122px;\">&nbsp;</td>";
					echo "<td style=\"width:10px;\">&nbsp;</td>";
				}
				else {
					echo "<td colspan=\"5\">&nbsp;</td>";
				}
				echo "</tr>";
				
				$i++;
			}

			// Tabellen anzeigen
			for ($j = 0; $j < count($FILES); $j++) {

				// Dateien anzeigen
				if ($i%2) {
					echo "<tr style=\"background-color:#f6f9fb;\" onmouseover=\"this.style.backgroundImage='url(img/table_tr_active_bg.gif)';\" onmouseout=\"this.style.backgroundImage='none';\">";
				}
				else {
					echo "<tr onmouseover=\"this.style.backgroundImage='url(img/table_tr_active_bg.gif)';\" onmouseout=\"this.style.backgroundImage='none';\">";
				}

				// Icon mit Thumbnail-Anzeige bei "onmouseover"
				$a = array();
				$a = GetNewImageSize($IMAGE_PATH_2.$FILES[$j], 200);
				
				echo "<td style=\"width:18px; text-align:center;\"><div id=\"smpreview".$j."\" class=\"smpreview\"></div><img style=\"cursor:pointer;\" src=\"img/icon_image_16x16.png\" border=\"0\" onmouseover=\"SMP.Show('smpreview".$j."', '".$IMAGE_PATH_2.$FILES[$j]."', '".$a["width"]."', '".$a["height"]."');\" onmouseout=\"SMP.Close('smpreview".$j."');\" onclick=\"SMImage_Insert('".$SESSION["server"]."', '".$IMAGE_PATH_2.$FILES[$j]."', '".Image_GetWidth($IMAGE_PATH.$FILES[$j])."', '".Image_GetHeight($IMAGE_PATH.$FILES[$j])."', '".$CONFIG["style"]."');\" /></td>";
				
				unset($a);

				// Dateiname
				if ($SESSION["show_image_menu"] == 1) {
					echo "<td><input class=\"edit\" style=\"width:98%;\" type=\"text\" value=\"".$FILES[$j]."\" title=\"".$FILES[$j]."\" onclick=\"SMImage_InputFileClick(this);\" onblur=\"SMImage_InputFileBlur(this, '".$FILES[$j]."');\" onkeypress=\"SMImage_InputFileEnter(event, this, '".$FILES[$j]."', '".bin2hex(RC4("id=1&".$GET))."')\"></td>";
				}
				else {
					echo "<td><input class=\"edit\" style=\"width:98%;\" type=\"text\" value=\"".$FILES[$j]."\" title=\"".$FILES[$j]."\" readonly=\"1\"></td>";
				}

				// Icon "Bild einfügen"
				echo "<td style=\"width:16px; text-align:center;\"><img id=\"i1".$i."\" style=\"cursor:pointer;\" src=\"img/icon_insert_16x16.png\" border=\"0\" title=\"\" onclick=\"SMImage_Insert('".$SESSION["server"]."', '".$IMAGE_PATH_2.$FILES[$j]."', '".Image_GetWidth($IMAGE_PATH.$FILES[$j])."', '".Image_GetHeight($IMAGE_PATH.$FILES[$j])."', '".$CONFIG["style"]."');\" /></td>";

				// Icon "Bilddatei löschen"
				if ($SESSION["show_image_menu"] == 1) {
					echo "<td style=\"width:16px; text-align:center;\"><img id=\"i2".$i."\" style=\"cursor:pointer;\" src=\"img/icon_delete_16x16.png\" border=\"0\" title=\"\" onclick=\"SMImage_DeleteImage('".bin2hex(RC4("id=1&".$GET))."', '".$FILES[$j]."');\" /></td>";
				}

				// Dateigröße
				echo "<td style=\"width:102px; text-align:right;\">".number_format(@filesize($IMAGE_PATH.$FILES[$j])/1024 ,2 , ",", ".")."&nbsp;KB</td>";

				// Bildgröße
				echo "<td style=\"width:102px; text-align:right;\">".Image_GetWidth($IMAGE_PATH.$FILES[$j])."&nbsp;x&nbsp;".Image_GetHeight($IMAGE_PATH.$FILES[$j])."</td>";

				// Datum
				echo "<td style=\"width:122px; text-align:center;\">".date(GetDateFormat().' H:i', @filemtime($IMAGE_PATH.$FILES[$j]))."</td>";

				// ScrollBar
				echo "<td style=\"width:10px;\">&nbsp;</td>";
				echo "</tr>";

				// Hinweis hinzufügen
				echo "<script language=\"javascript\" type=\"text/javascript\">document.getElementById('i1".$i."').title = tinyMCEPopup.getLang('smimage.image_menu_hint_1', '?'); document.getElementById('i2".$i."').title = tinyMCEPopup.getLang('smimage.image_menu_hint_2', '?');</script>";

				$i++;
			}

			echo "</table></div>";
		}
		break;

	case 2:
		include("php/upload.php");
		break;
}
?>

<div id="statusbar" class="statusbar">
	<div style="float:left; margin:2px;"><img src="img/icon_folder_20x20.png" border="0" /></div>
	<div id="statusbar_item1" style="float:left; padding-left:2px;"><?php GetCurrentPath($SESSION["dir_root"], $SESSION["dir"]); ?></div>
	<div id="statusbar_item2" style="float:right; padding-right:3px;"><?php
		if ($SESSION["id"] == 1) {
			if ($SESSION["show_thumbnail"] == 1) {
				$p = ceil(count($FILES)/$SESSION["thumbnails_perpage"]);
				if ($p <= 0) { $p = 1; }
				echo "<script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.statusbar_item2_1', '?'));</script>:&nbsp;".($SESSION["page"]+1)."<span style=\"margin-left:3px; margin-right:3px;\">/</span>".$p." [<script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.statusbar_item2_2', '?'));</script>:&nbsp;".count($FILES)."]";
			}
			else {
				echo "[<script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.statusbar_item2_2', '?'));</script>:&nbsp;".count($FILES)."]";
			}
		}
		?></div>
</div>
<div id="wait"><div id="wait_animation"><img src="img/wait.gif" border="0" alt=""></div></div>
<div id="window_imagedata" class="window"><?php include("php/image_data.php"); ?></div>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */
// Event-Handler: OnFocus
window.onfocus = function() {
	SMImage_WindowResize();
};

// Event-Handler: OnResize
window.onresize = function() {
	SMImage_WindowResize();
};

// Menü: Hinweis hinzufügen
SMImage_MenuIni();

// Event-Handler: OnLoad
<?php
if ($SESSION["id"] == 1 && $SESSION["show_thumbnail"] == 1) {
	echo "onload = function() {\n";
	echo "var a = new Array();\n";
	for ($i=0; $i<count($FILES); $i++) { echo "a.push(\"".$FILES[$i]."\"); "; } echo "\n";

	echo "SMImage_LoadThumbnail(a, '".$IMAGE_PATH_2."', '".$SESSION["thumbnail_size"]."', '".$SESSION["jpg_quality"]."');\n";
	echo "SMImage_WindowResize();\n";
	echo "}\n";
}

// Tabellen Initialisierung
if ($SESSION["id"] == 1 && $SESSION["show_thumbnail"] == 0) {
	echo "SMTableIni();\n";
	echo "SMImage_WindowResize();\n";
}
?>
/* ]]> */
</script>

</body>
</html>