<ul>
	<?php
	if ($SESSION["show_upload"] == 1) {
		if ($SESSION["id"] == 1) {
			echo "<li><a id=\"m11\" href=\"javascript:;\" title=\"\" onclick=\"window.location.href='index.php?get=".bin2hex(RC4("id=2&".$GET))."'; if (window.event){ window.event.returnValue = false; }\"><img src=\"img/icon_upload_24x24.png\" border=\"0\" /></a></li>";
			echo "<li><img class=\"separator\" src=\"img/icon_separator.png\" border=\"0\" /></li>";
		}
	}

	if ($SESSION["show_newfolder"] == 1) {
		echo "<li><a id=\"m2\" href=\"javascript:;\" title=\"\" onclick=\"SMImage_NewFolder('".bin2hex(RC4("id=1&".$GET))."');\"><img src=\"img/icon_new_folder_24x24.png\" border=\"0\" /></a></li>";
		echo "<li><img class=\"separator\" src=\"img/icon_separator.png\" border=\"0\" /></li>";
	}
	
	if ($SESSION["id"] == 1 && $SESSION["show_thumbnail"] == 1) {
		if ($SESSION["page"] > 0) {
			echo "<li><a id=\"m3\" href=\"javascript:;\" title=\"\" onclick=\"window.location.href='index.php?get=".bin2hex(RC4("id=1&page=".($SESSION["page"]-1)."&".$GET))."'; if (window.event){ window.event.returnValue = false; }\"><img src=\"img/icon_back_24x24.png\" border=\"0\" /></a></li>";
		}
		else {
			echo "<li><a id=\"m3\" href=\"javascript:;\" title=\"\"><img src=\"img/icon_back_2_24x24.png\" border=\"0\" /></a></li>";
		}

		if ((($SESSION["page"]+1) * $SESSION["thumbnails_perpage"]) < count($FILES)) {
			echo "<li><a id=\"m4\" href=\"javascript:;\" title=\"\" onclick=\"window.location.href='index.php?get=".bin2hex(RC4("id=1&page=".($SESSION["page"]+1)."&".$GET))."'; if (window.event){ window.event.returnValue = false; }\"><img src=\"img/icon_forward_24x24.png\" border=\"0\" /></a></li>";
		}
		else {
			echo "<li><a id=\"m4\" href=\"javascript:;\" title=\"\"><img src=\"img/icon_forward_2_24x24.png\" border=\"0\" /></a></li>";
		}
	}
	?>
	<li><img class="separator" src="img/icon_separator.png" border="0" /></li>
	<li><a id="m5" href="javascript:;" title="" onclick="SMImage_PageReload('<?php echo bin2hex(RC4("id=1&".$GET)); ?>'); if (window.event){ window.event.returnValue = false; }"><img src="img/icon_reload_24x24.png" border="0" /></a></li>
	<li><img class="separator" src="img/icon_separator.png" border="0" /></li>
	<li><select class="select" id="Select1" name="Select1" size="1" onChange="location.href=this.options[this.selectedIndex].value;"><option <?php if($SESSION["show_thumbnail"] == 1) { echo "selected"; } ?> value="index.php?get=<?php echo bin2hex(RC4("id=1&show_thumbnail=1&".str_replace("&show_thumbnail=0", "", $GET))); ?>"><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smimage.menu_view_select_1', '?'));</script></option><option <?php if($SESSION["show_thumbnail"] == 0) { echo "selected"; } ?> value="index.php?get=<?php echo bin2hex(RC4("id=1&show_thumbnail=0&".str_replace("&show_thumbnail=1", "", $GET))); ?>"><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smimage.menu_view_select_2', '?'));</script></option></select></li>
</ul>