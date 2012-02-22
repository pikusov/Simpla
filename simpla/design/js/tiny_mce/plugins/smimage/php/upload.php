<?php

$UPLOAD_RESULT = true;

// Bilddatei speichern
if (isset($_GET["action"]) && $_GET["action"] == "upload") {

	// Dateierweiterung prüfen
	if (strtolower($_POST["edit2"]) == ".jpg" || strtolower($_POST["edit2"]) == ".jpeg" || strtolower($_POST["edit2"]) == ".gif" || strtolower($_POST["edit2"]) == ".png") {

		// Dateinamen formatieren
		$_POST["edit1"] = FormatFileName($_POST["edit1"]); 

		// Bild verkleinern und speichern
		if (is_numeric($_POST["edit3"])) { Image_Resize($_FILES['input1']['tmp_name'], $_POST["edit3"], $SESSION["jpg_quality"]); }

		// Filter auf das Bild anwenden
		if (is_numeric($_POST["select1"])) { Image_Filter($_FILES['input1']['tmp_name'], $SESSION["jpg_quality"], $_POST["select1"]); }

		// Prüfen ob die Bilddatei bereits existiert, wenn ja den Dateinamen anpassen
		while (file_exists(GetDocumentRoot().$SESSION["dir"].$_POST["edit1"].$_POST["edit2"])) {
			$_POST["edit1"] = "_".$_POST["edit1"];
		}

		// Bilddatei kopieren
		if ($SESSION["upload_filesize"] != "") {
			if (filesize($_FILES['input1']['tmp_name']) / 1024 <= $SESSION["upload_filesize"]) {
				$UPLOAD_RESULT = @move_uploaded_file($_FILES['input1']['tmp_name'], GetDocumentRoot().$SESSION["dir"].$_POST["edit1"].$_POST["edit2"]);
			}
			else { $UPLOAD_RESULT = false; }
		}
		else {
			$UPLOAD_RESULT = @move_uploaded_file($_FILES['input1']['tmp_name'], GetDocumentRoot().$SESSION["dir"].$_POST["edit1"].$_POST["edit2"]);
		}

		// Dateirechte anpassen
		if ($UPLOAD_RESULT) { @chmod(GetDocumentRoot().$SESSION["dir"].$_POST["edit1"].$_POST["edit2"], $CONFIG["chmod_file"]); }
	}
	else { $UPLOAD_RESULT = false; }
}

?>

<div id="upload">
	<form name="form1" action="" method="post" enctype="multipart/form-data">
		<div style="margin-bottom:2px;"><b><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smimage.upload_label_1', '?'));</script>:</b>&nbsp;<span style="color:#8a95a2;">(<script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smimage.upload_info_1', '?'));</script>:&nbsp;<?php if ($SESSION["upload_filesize"] != "") { echo $SESSION["upload_filesize"]."&nbsp;KB"; } else { echo (str_replace("M", "", ini_get('post_max_size')) * 1024)."&nbsp;KB"; } ?>)</span></div>
		<div><input style="margin-bottom:8px;" type="file" name="input1" size="82" onchange="Upload_ShowFileName();" onfocus="Input_OnFocus(this);" onblur="Input_OnBlur(this);"></div>
		
		<div style="float:left;">
			<div style="margin-bottom:2px;"><b><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smimage.upload_label_2', '?'));</script>:</b></div>
			<div><input style="margin-bottom:8px; width:200px;" type="text" name="edit1" maxlength="50" onfocus="Input_OnFocus(this);" onblur="Input_OnBlur(this);"><input style="width:40px; border-left:0px; font-weight:bold; background-color:#f6f9fb; margin-bottom:8px;" type="text" name="edit2" readonly></div>
		</div>

		<div style="float:left; margin-left:25px;">
			<div style="margin-bottom:2px;"><b><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smimage.upload_label_3', '?'));</script>:</b></div>
			<div><input style="width:60px;" type="text" name="edit3" value="<?php if (isset($_POST["edit3"])) { echo $_POST["edit3"]; } ?>" maxlength="4" onchange="SMImage_CheckFormIsNaN(this);" onfocus="Input_OnFocus(this);" onblur="Input_OnBlur(this);"><b style="margin-left:5px;">px</b></div>
		</div>

		<?php
		if (GetPHPVersion_Major() >= 5) {
			echo "<div style=\"float:left; margin-left:25px; margin-right:25px;\"><div style=\"margin-bottom:2px;\"><b><script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.upload_label_4', '?'));</script>:</b></div><div><select style=\"width:120px;\" name=\"select1\" size=\"1\" ><option selected value=\"\"></option><option value=\"1\"><script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.upload_filter_select_1', '?'));</script></option><option value=\"2\"><script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.upload_filter_select_2', '?'));</script></option><option value=\"3\"><script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.upload_filter_select_3', '?'));</script></option></select></div></div>";
		}
		?>

		<div style="margin-top:12px; margin-bottom:50px;">
			<script language="javascript" type="text/javascript">
			/* <![CDATA[ */
			var jSMB = new jSMButton();
			jSMB.SetStyle('float:left;');
			jSMB.Paint('jSMB', tinyMCEPopup.getLang('smimage.button_save_caption', '?'), 'SMImage_Upload(\'<?php echo bin2hex(RC4("id=2&".$GET)); ?>\', document.form1.edit1.value + document.form1.edit2.value);');
			/* ]]> */
			</script>
		</div>
	</form>
</div>

<div id="main_upload" style="overflow:scroll; margin-left:4px; background-color:#e9edf2;">
	<?php
	if (isset($_GET["action"]) && $_GET["action"] == "upload" && $UPLOAD_RESULT) {
		echo "<img style=\"border:1px solid #616A74;\"src=\"".$SESSION["dir"].$_POST["edit1"].$_POST["edit2"]."\" border=\"0\" alt=\"\">";
	}
	else if (isset($_GET["action"]) && $_GET["action"] == "upload" && !$UPLOAD_RESULT) { echo "<div class=\"alert alert_error\"><script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smimage.message_upload_1', '?'));</script></div>"; }
	?>
</div>

<div style="height:4px; background-color:#ffffff; font-size:0px";></div>